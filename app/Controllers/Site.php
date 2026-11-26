<?php

namespace App\Controllers;

use App\Models\ContentModel;
use App\Models\InquiryModel;
use App\Models\PageModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Site extends BaseController
{
    public function page(string $slug): string
    {
        $page = (new PageModel())->where(['slug' => $slug, 'status' => 'published'])->first();
        if (! $page) {
            throw PageNotFoundException::forPageNotFound();
        }
        return view('site/page', compact('page'));
    }

    public function services(): string
    {
        return view('site/listing', ['kind' => 'service', 'title' => 'From seedlings to processing.', 'eyebrow' => 'What we do', 'intro' => 'Practical expertise that delivers value across the palm supply chain — for buyers, farmers and industry.', 'items' => $this->content('service')]);
    }

    public function projects(): string
    {
        return view('site/listing', ['kind' => 'project', 'title' => 'Milestones in the field.', 'eyebrow' => 'Projects', 'intro' => 'The investments and developments behind our nursery, estates and mill.', 'items' => $this->content('project')]);
    }

    public function service(string $slug): string
    {
        return $this->single($slug, 'service');
    }

    public function project(string $slug): string
    {
        return $this->single($slug, 'project');
    }

    public function news(): string
    {
        return view('site/listing', ['kind' => 'post', 'title' => 'Updates from the field.', 'eyebrow' => 'News & insights', 'intro' => 'News from Norsworthy Farms and the wider agricultural value chain.', 'items' => $this->content('post')]);
    }

    public function article(string $slug): string
    {
        return $this->single($slug, 'post');
    }

    public function partnerships(): string
    {
        return view('site/partnerships');
    }

    public function contact(): string
    {
        $page = (new PageModel())->where(['slug' => 'contact', 'status' => 'published'])->first();
        return view('site/contact', compact('page'));
    }

    public function sendContact()
    {
        if (session()->get('contact_submitted_at') && (time() - (int) session()->get('contact_submitted_at')) < 60) {
            return redirect()->back()->withInput()->with('error', 'Please wait a moment before sending another message.');
        }
        $data = [
            'name' => trim((string) $this->request->getPost('name')),
            'email' => trim((string) $this->request->getPost('email')),
            'phone' => trim((string) $this->request->getPost('phone')),
            'company' => trim((string) $this->request->getPost('company')),
            'subject' => trim((string) $this->request->getPost('subject')),
            'message' => trim((string) $this->request->getPost('message')),
        ];
        $rules = ['name' => 'required|max_length[120]', 'email' => 'required|valid_email|max_length[191]', 'phone' => 'permit_empty|max_length[60]', 'company' => 'permit_empty|max_length[150]', 'subject' => 'required|max_length[191]', 'message' => 'required|min_length[10]|max_length[5000]'];
        if (! $this->validateData($data, $rules)) {
            return redirect()->back()->withInput()->with('error', 'Please complete the required fields and include a short message.');
        }
        (new InquiryModel())->insert($data + ['status' => 'new', 'ip_address' => $this->request->getIPAddress()]);
        session()->set('contact_submitted_at', time());
        return redirect()->to(site_url('contact'))->with('success', 'Thank you. Your message has been received and the Norsworthy team will respond shortly.');
    }

    private function content(string $type): array
    {
        return (new ContentModel())->where(['type' => $type, 'status' => 'published'])->orderBy('published_at', 'DESC')->findAll();
    }

    private function single(string $slug, string $type): string
    {
        $item = (new ContentModel())->where(['slug' => $slug, 'type' => $type, 'status' => 'published'])->first();
        if (! $item) {
            throw PageNotFoundException::forPageNotFound();
        }
        $related = array_values(array_filter($this->content($type), static fn ($other) => $other['id'] !== $item['id']));
        return view('site/item', compact('item', 'related'));
    }
}
