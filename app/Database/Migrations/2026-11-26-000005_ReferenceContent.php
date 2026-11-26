<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ReferenceContent extends Migration
{
    public function up()
    {
        // Only replace known starter content; preserve any edits made by CMS users.
        $services = [
            ['processing-of-crude-palm-oil', 'Palm Oil Processing', 'Crude palm oil', 'Careful fruit handling, efficient extraction and rigorous quality control from our own mill.', '<p>Norsworthy Farms transforms fresh palm fruit into dependable, high-quality crude palm oil — processed promptly at our own mill.</p><p>Our processing combines careful fruit handling, efficient extraction and rigorous quality controls. Fruit from our estates is processed quickly to protect oil quality, and every batch is checked before dispatch so buyers receive consistent product, delivery after delivery.</p><h2>What we offer</h2><ul><li>Fruit sterilisation and threshing</li><li>Efficient oil extraction</li><li>Clarification and quality assurance</li><li>Responsible by-product utilisation</li></ul><h2>Who it’s for</h2><p>Edible oil refiners · Food manufacturers · Traders &amp; distributors</p>'],
            ['cultivation-of-high-breed-oil-palm-seedlings', 'High-Breed Oil Palm Seedlings', 'High-breed seedlings', 'Premium seedlings raised for yield, disease resistance and early maturity.', '<p>We supply premium oil palm seedlings cultivated with advanced agricultural techniques and current research.</p><p>Every planting decision lasts decades. Our nursery raises high-breed seedlings under close supervision, so farmers and estates start with stock selected for productivity and resilience — and with practical advice on planting and early care.</p><h2>What we offer</h2><ul><li>High yield potential</li><li>Disease resistance</li><li>Early maturity</li><li>Adaptability across suitable growing conditions</li></ul><h2>Who it’s for</h2><p>Estates · Smallholders &amp; cooperatives · Government &amp; development programmes</p>'],
            ['technical-palm-oil', 'Technical Palm Oil', 'Technical palm oil', 'Consistent technical-grade oil for soap, oleochemical and industrial partners.', '<p>Our technical palm oil gives industrial partners dependable quality, delivered with an emphasis on consistency and responsible production.</p><p>Industrial buyers need predictable supply. We agree volumes and schedules up front, keep quality consistent from one delivery to the next and keep partners informed at every step.</p><h2>What we offer</h2><ul><li>Consistent technical grade</li><li>Bulk supply on contract</li><li>Reliable delivery scheduling</li><li>Responsible production</li></ul><h2>Who it’s for</h2><p>Soap manufacturers · Oleochemical producers · Industrial users</p>'],
        ];
        $originalBodies = [
            'processing-of-crude-palm-oil' => '<p>Norsworthy Farms offers comprehensive CPO processing services that transform raw palm fruit into valuable products. Our processing combines careful fruit handling, efficient extraction and rigorous quality controls.</p><h2>Our processing services</h2><ul><li>Fruit sterilization and threshing</li><li>Efficient oil extraction</li><li>Oil refining and quality assurance</li><li>Responsible by-product utilization</li></ul>',
            'cultivation-of-high-breed-oil-palm-seedlings' => '<p>We supply premium oil palm seedlings cultivated with advanced agricultural techniques and current research.</p><ul><li>High yield potential</li><li>Disease resistance</li><li>Early maturity</li><li>Adaptability across suitable growing conditions</li></ul>',
            'technical-palm-oil' => '<p>Our Technical Palm Oil service provides dependable quality for industrial partners, delivered with an emphasis on consistency and responsible production.</p>',
        ];
        foreach ($services as [$slug, $oldTitle, $title, $excerpt, $body]) {
            $existing = $this->db->table('content_items')->where(['slug' => $slug, 'title' => $oldTitle, 'type' => 'service'])->get()->getRowArray();
            if ($existing && $existing['body'] === $originalBodies[$slug]) {
                $this->db->table('content_items')->where('id', $existing['id'])->update(['title' => $title, 'excerpt' => $excerpt, 'body' => $body, 'updated_at' => date('Y-m-d H:i:s')]);
            }
        }
        $posts = [
            ['quality-control-routine', 'Inside our quality-control routine', 'The checks every batch passes between fresh fruit and finished oil.', '<p>Quality starts in the field. Fruit is harvested at the right stage of ripeness and moved to the mill quickly to protect the oil it contains.</p><p>At the mill, each stage — sterilisation, threshing, extraction and clarification — is monitored, and finished oil is checked before dispatch.</p><p>Buyers can request specification sheets and certificates of analysis for their deliveries.</p>', 'assets/images/BRZ_2919.jpg', '2026-10-28 00:00:00'],
            ['choosing-the-right-seedling', 'Choosing the right seedling', 'What farmers should ask before planting a new block.', '<p>An oil palm planted today will be productive for decades, so the seedling you choose matters.</p><p>Ask about the seedling’s origin and breeding, how it was raised in the nursery and what support is available at planting time.</p><p>Our team is happy to talk through your site and plans before you order.</p>', 'assets/images/farm.png', '2026-10-03 00:00:00'],
            ['mill-commissioned', 'Norsworthy palm oil mill begins operations', 'Our new mill brings processing and quality control closer to our estates.', '<p>Norsworthy Farms has begun operations at its palm oil mill, bringing processing and quality control under one roof.</p><p>The mill strengthens our ability to supply crude and technical palm oil with consistent quality to customers across Nigeria.</p>', 'assets/images/banner1.jpg', '2026-09-14 00:00:00'],
        ];
        foreach ($posts as [$slug, $title, $excerpt, $body, $cover, $published]) {
            if (! $this->db->table('content_items')->where('slug', $slug)->countAllResults()) {
                $this->db->table('content_items')->insert(['type' => 'post', 'slug' => $slug, 'title' => $title, 'excerpt' => $excerpt, 'body' => $body, 'cover_image' => $cover, 'status' => 'published', 'is_featured' => 0, 'published_at' => $published, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            }
        }
    }

    public function down() { /* Preserve CMS content on rollback. */ }
}
