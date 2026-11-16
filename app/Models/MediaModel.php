<?php

namespace App\Models;

use CodeIgniter\Model;

class MediaModel extends Model
{
    protected $table = 'media';
    protected $allowedFields = ['filename', 'path', 'mime_type', 'alt_text', 'size', 'uploaded_by'];
    protected $useTimestamps = true;
}
