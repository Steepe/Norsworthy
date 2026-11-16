<?php

namespace App\Models;

use CodeIgniter\Model;

class InquiryModel extends Model
{
    protected $table = 'inquiries';
    protected $allowedFields = ['name', 'email', 'phone', 'company', 'subject', 'message', 'status', 'ip_address'];
    protected $useTimestamps = true;
}
