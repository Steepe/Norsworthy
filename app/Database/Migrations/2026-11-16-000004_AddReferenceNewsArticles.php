<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddReferenceNewsArticles extends Migration
{
    public function up()
    {
        $now = date('Y-m-d H:i:s');
        $articles = [
            ['quality-planting-material', 'The case for quality planting material', 'Why strong harvests begin in the nursery, long before the first bunch is cut.', '<p>Every productive oil-palm estate starts with carefully selected seedlings. We explain what growers should look for when planning a new block.</p>', 'assets/images/farm.png'],
            ['fresh-fruit-to-supply', 'From fresh fruit bunch to dependable supply', 'A close look at the care and timing behind consistent crude palm oil.', '<p>Harvest timing, transport and careful processing all shape the quality of crude palm oil. Our integrated model keeps those steps close together.</p>', 'assets/images/BRZ_2919.jpg'],
        ];

        foreach ($articles as [$slug, $title, $excerpt, $body, $coverImage]) {
            if (! $this->db->table('content_items')->where('slug', $slug)->countAllResults()) {
                $this->db->table('content_items')->insert([
                    'type' => 'post',
                    'title' => $title,
                    'slug' => $slug,
                    'excerpt' => $excerpt,
                    'body' => $body,
                    'cover_image' => $coverImage,
                    'status' => 'published',
                    'is_featured' => 1,
                    'published_at' => $now,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down()
    {
        $this->db->table('content_items')->whereIn('slug', ['quality-planting-material', 'fresh-fruit-to-supply'])->delete();
    }
}
