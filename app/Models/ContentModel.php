<?php

namespace App\Models;

use CodeIgniter\Model;

class ContentModel extends Model
{
    protected $table = 'content_items';
    protected $allowedFields = ['type', 'title', 'slug', 'excerpt', 'body', 'cover_image', 'seo_title', 'seo_description', 'status', 'is_featured', 'published_at'];
    protected $useTimestamps = true;
}
