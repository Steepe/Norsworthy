<?php

namespace App\Models;

use CodeIgniter\Model;

class PageModel extends Model
{
    protected $table = 'pages';
    protected $allowedFields = ['title', 'slug', 'excerpt', 'body', 'hero_image', 'seo_title', 'seo_description', 'status', 'published_at'];
    protected $useTimestamps = true;
}
