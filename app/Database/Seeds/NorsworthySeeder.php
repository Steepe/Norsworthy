<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NorsworthySeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $email = getenv('CMS_ADMIN_EMAIL') ?: 'admin@norsworthy.local';
        if (! $this->db->table('users')->where('email', $email)->countAllResults()) {
            $this->db->table('users')->insert([
                'name' => 'Site Administrator',
                'email' => $email,
                'password_hash' => password_hash(getenv('CMS_ADMIN_PASSWORD') ?: 'ChangeMe123!', PASSWORD_DEFAULT),
                'role' => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $pages = [
            ['About Norsworthy', 'about', 'A focused agribusiness creating enduring value from oil palm.', '<p>Norsworthy Farms is a Nigerian agribusiness focused on sustainable oil palm cultivation and processing. We combine practical field knowledge, responsible stewardship and efficient operations to supply dependable palm products.</p><h2>Growing with purpose</h2><p>From high-breed seedlings to carefully processed crude palm oil, our work is centred on quality, traceability and long-term relationships.</p>', 'assets/images/about.jpg'],
            ['Contact Us', 'contact', 'Start a conversation with Norsworthy Farms.', '<p>For product enquiries, partnerships or farm visits, please get in touch with the Norsworthy team.</p><p><strong>Email:</strong> info@norsworthy.com.ng<br><strong>Location:</strong> Nigeria</p>', 'assets/images/palm-plantation.jpg'],
        ];
        foreach ($pages as [$title, $slug, $excerpt, $body, $hero]) {
            if (! $this->db->table('pages')->where('slug', $slug)->countAllResults()) {
                $this->db->table('pages')->insert(compact('title', 'slug', 'excerpt', 'body') + ['hero_image' => $hero, 'status' => 'published', 'published_at' => $now, 'created_at' => $now, 'updated_at' => $now]);
            }
        }

        $items = [
            ['project', 'Palm Oil Processing', 'processing-of-crude-palm-oil', 'Comprehensive crude palm oil processing from fruit sterilization to high-quality output.', '<p>Norsworthy Farms offers comprehensive CPO processing services that transform raw palm fruit into valuable products. Our processing combines careful fruit handling, efficient extraction and rigorous quality controls.</p><h2>Our processing services</h2><ul><li>Fruit sterilization and threshing</li><li>Efficient oil extraction</li><li>Oil refining and quality assurance</li><li>Responsible by-product utilization</li></ul>', 'assets/images/BRZ_2919.jpg'],
            ['project', 'High-Breed Oil Palm Seedlings', 'cultivation-of-high-breed-oil-palm-seedlings', 'Premium seedlings cultivated for yield, resilience and early maturity.', '<p>We supply premium oil palm seedlings cultivated with advanced agricultural techniques and current research.</p><ul><li>High yield potential</li><li>Disease resistance</li><li>Early maturity</li><li>Adaptability across suitable growing conditions</li></ul>', 'assets/images/farm.png'],
            ['project', 'Technical Palm Oil', 'technical-palm-oil', 'Reliable technical palm oil for industrial applications.', '<p>Our Technical Palm Oil service provides dependable quality for industrial partners, delivered with an emphasis on consistency and responsible production.</p>', 'assets/images/palm_oil.jpg'],
            ['post', 'Norsworthy Farms: Growing Value Responsibly', 'growing-value-responsibly', 'How our integrated approach supports quality palm products and lasting partnerships.', '<p>At Norsworthy Farms, we believe successful agriculture balances productivity with care for land, people and the customers who depend on us.</p>', 'assets/images/palm-plantation.jpg'],
        ];
        foreach ($items as [$type, $title, $slug, $excerpt, $body, $cover_image]) {
            if (! $this->db->table('content_items')->where('slug', $slug)->countAllResults()) {
                $this->db->table('content_items')->insert(compact('type', 'title', 'slug', 'excerpt', 'body', 'cover_image') + ['status' => 'published', 'is_featured' => 1, 'published_at' => $now, 'created_at' => $now, 'updated_at' => $now]);
            }
        }
    }
}
