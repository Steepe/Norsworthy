<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ContentModel;
use App\Models\MediaModel;
use App\Models\InquiryModel;
use App\Models\PageModel;

class DashboardController extends BaseController
{
    public function index(): string
    {
        $inquiries = new InquiryModel();

        return view('admin/dashboard', [
            'pageCount' => (new PageModel())->countAllResults(),
            'contentCount' => (new ContentModel())->countAllResults(),
            'mediaCount' => (new MediaModel())->countAllResults(),
            'newInquiryCount' => $inquiries->where('status', 'new')->countAllResults(),
            'recent' => (new ContentModel())->orderBy('updated_at', 'DESC')->findAll(5),
            'inquiries' => $inquiries->orderBy('created_at', 'DESC')->findAll(3),
        ]);
    }
}
