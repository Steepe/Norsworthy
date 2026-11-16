<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlignContentWithSiteDesign extends Migration
{
    public function up()
    {
        $now = date('Y-m-d H:i:s');
        $this->db->table('content_items')->whereIn('slug', ['processing-of-crude-palm-oil', 'cultivation-of-high-breed-oil-palm-seedlings', 'technical-palm-oil'])->update(['type' => 'service', 'updated_at' => $now]);
        $projects = [
            ['palm-oil-mill', 'Commissioning the Norsworthy palm oil mill', 'A purpose-built facility bringing sterilisation, extraction and quality control under one roof.', 'assets/images/banner1.jpg', '<p>Owning the processing step lets us control quality from the moment fruit is harvested. The Norsworthy mill brings sterilisation, threshing, extraction and clarification together in a single, purpose-built facility close to our estates.</p><p>Shorter time between harvest and processing protects oil quality. On-site quality checks mean every batch is tested before it leaves, and our team is trained to run and maintain the plant.</p><h2>Project highlights</h2><ul><li>Integrated sterilisation, threshing and extraction line</li><li>On-site quality assurance for every batch</li><li>Local team trained to operate and maintain the plant</li></ul>'],
            ['seedling-nursery', 'Expanding high-breed seedling capacity', 'Growing our nursery to meet demand from estates, smallholders and development programmes.', 'assets/images/farm.png', '<p>Demand for quality planting material is growing. We are expanding our nursery so more farmers can start new blocks with high-breed seedlings selected for yield and resilience.</p><p>The expansion adds nursery space, irrigation and handling capacity, along with the staff to care for seedlings through every stage until they are ready to plant.</p><h2>Project highlights</h2><ul><li>Additional nursery beds and irrigation</li><li>Supply for estates, smallholders and programmes</li><li>Planting advice for every customer</li></ul>'],
            ['plantation-block', 'Developing a new managed plantation block', 'Careful land preparation and planting to secure long-term fruit supply for the mill.', 'assets/images/palm-plantation.jpg', '<p>A dependable mill needs dependable fruit. We are developing a new managed plantation block planted with our own high-breed seedlings.</p><p>The work is planned to protect soil and water, and creates local jobs in land preparation, planting and estate maintenance.</p><h2>Project highlights</h2><ul><li>Planted with Norsworthy high-breed seedlings</li><li>Soil and water protection built into planning</li><li>Local employment across the planting cycle</li></ul>'],
        ];
        foreach ($projects as [$slug, $title, $excerpt, $cover, $body]) {
            if (! $this->db->table('content_items')->where('slug', $slug)->countAllResults()) {
                $this->db->table('content_items')->insert(['type' => 'project', 'title' => $title, 'slug' => $slug, 'excerpt' => $excerpt, 'body' => $body, 'cover_image' => $cover, 'status' => 'published', 'is_featured' => 1, 'published_at' => $now, 'created_at' => $now, 'updated_at' => $now]);
            }
        }
    }

    public function down()
    {
        $this->db->table('content_items')->whereIn('slug', ['palm-oil-mill', 'seedling-nursery', 'plantation-block'])->delete();
        $this->db->table('content_items')->whereIn('slug', ['processing-of-crude-palm-oil', 'cultivation-of-high-breed-oil-palm-seedlings', 'technical-palm-oil'])->update(['type' => 'project']);
    }
}
