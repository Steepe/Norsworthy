<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\InquiryModel;

class InquiriesController extends BaseController
{
    public function index(): string
    {
        return view('admin/inquiries', ['title' => 'Enquiries', 'inquiries' => (new InquiryModel())->orderBy('created_at', 'DESC')->findAll()]);
    }

    public function status(int $id)
    {
        $status = (string) $this->request->getPost('status');
        if (! in_array($status, ['new', 'read', 'archived'], true)) {
            return redirect()->back()->with('error', 'Invalid enquiry status.');
        }
        (new InquiryModel())->update($id, ['status' => $status]);
        return redirect()->to(site_url('admin/inquiries'))->with('success', 'Enquiry status updated.');
    }
}
