<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ContentModel;

class ContentController extends BaseController
{
    private ContentModel $content;

    public function __construct()
    {
        $this->content = new ContentModel();
    }

    public function index(): string
    {
        return view('admin/content/index', ['items' => $this->content->orderBy('updated_at', 'DESC')->findAll()]);
    }

    public function form(?int $id = null): string
    {
        $item = $id ? $this->content->find($id) : null;
        if ($id && ! $item) return redirect()->to(site_url('admin/content'))->with('error', 'Content item not found.');
        return view('admin/content/form', compact('item'));
    }

    public function save()
    {
        $id = $this->request->getPost('id');
        $data = [
            'type' => (string) $this->request->getPost('type'), 'title' => trim((string) $this->request->getPost('title')),
            'slug' => url_title((string) $this->request->getPost('slug'), '-', true), 'excerpt' => trim((string) $this->request->getPost('excerpt')),
            'body' => (string) $this->request->getPost('body'), 'cover_image' => trim((string) $this->request->getPost('cover_image')),
            'seo_title' => trim((string) $this->request->getPost('seo_title')), 'seo_description' => trim((string) $this->request->getPost('seo_description')),
            'status' => (string) $this->request->getPost('status'), 'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
        ];
        if (! $this->validateData($data, ['type' => 'required|in_list[service,project,post]', 'title' => 'required|max_length[191]', 'slug' => 'required|alpha_dash|max_length[191]', 'status' => 'required|in_list[draft,published]'])) return redirect()->back()->withInput()->with('error', 'Please fix the highlighted content details.');
        $duplicate = $this->content->where('slug', $data['slug']);
        if ($id) $duplicate->where('id !=', $id);
        if ($duplicate->first()) return redirect()->back()->withInput()->with('error', 'That URL slug is already in use.');
        $data['published_at'] = $data['status'] === 'published' ? ($this->request->getPost('published_at') ?: date('Y-m-d H:i:s')) : null;
        $id ? $this->content->update($id, $data) : $this->content->insert($data);
        return redirect()->to(site_url('admin/content'))->with('success', 'Content saved.');
    }

    public function delete(int $id)
    {
        $this->content->delete($id);
        return redirect()->to(site_url('admin/content'))->with('success', 'Content deleted.');
    }
}
