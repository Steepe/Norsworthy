<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ContentModel;
use App\Models\PageModel;

class PagesController extends BaseController
{
    private PageModel $pages;

    public function __construct()
    {
        $this->pages = new PageModel();
    }

    public function index(): string
    {
        $tab = (string) ($this->request->getGet('tab') ?: 'pages');
        $tabs = ['pages', 'services', 'projects', 'news'];
        if (! in_array($tab, $tabs, true)) {
            $tab = 'pages';
        }

        $contentType = ['services' => 'service', 'projects' => 'project', 'news' => 'post'][$tab] ?? null;
        $items = $contentType ? (new ContentModel())->where('type', $contentType)->orderBy('updated_at', 'DESC')->findAll() : $this->pages->orderBy('updated_at', 'DESC')->findAll();
        $counts = [
            'pages' => $this->pages->countAllResults(),
            'services' => (new ContentModel())->where('type', 'service')->countAllResults(),
            'projects' => (new ContentModel())->where('type', 'project')->countAllResults(),
            'news' => (new ContentModel())->where('type', 'post')->countAllResults(),
        ];

        return view('admin/pages/index', compact('items', 'tab', 'counts', 'contentType'));
    }

    public function form(?int $id = null): string
    {
        $page = $id ? $this->pages->find($id) : null;
        if ($id && ! $page) {
            return redirect()->to(site_url('admin/pages'))->with('error', 'Page not found.');
        }
        return view('admin/pages/form', compact('page'));
    }

    public function save()
    {
        $id = $this->request->getPost('id');
        $data = $this->payload();
        if (! $this->validateData($data, ['title' => 'required|max_length[191]', 'slug' => 'required|alpha_dash|max_length[191]', 'status' => 'required|in_list[draft,published]'])) {
            return redirect()->back()->withInput()->with('error', 'Please fix the highlighted page details.');
        }
        if ($this->slugTaken($data['slug'], $id)) {
            return redirect()->back()->withInput()->with('error', 'That URL slug is already in use.');
        }
        $data['published_at'] = $data['status'] === 'published' ? ($this->request->getPost('published_at') ?: date('Y-m-d H:i:s')) : null;
        $id ? $this->pages->update($id, $data) : $this->pages->insert($data);
        return redirect()->to(site_url('admin/pages'))->with('success', 'Page saved.');
    }

    public function delete(int $id)
    {
        $this->pages->delete($id);
        return redirect()->to(site_url('admin/pages'))->with('success', 'Page deleted.');
    }

    private function payload(): array
    {
        return [
            'title' => trim((string) $this->request->getPost('title')),
            'slug' => url_title((string) $this->request->getPost('slug'), '-', true),
            'excerpt' => trim((string) $this->request->getPost('excerpt')),
            'body' => (string) $this->request->getPost('body'),
            'hero_image' => trim((string) $this->request->getPost('hero_image')),
            'seo_title' => trim((string) $this->request->getPost('seo_title')),
            'seo_description' => trim((string) $this->request->getPost('seo_description')),
            'status' => (string) $this->request->getPost('status'),
        ];
    }

    private function slugTaken(string $slug, ?string $id): bool
    {
        $query = $this->pages->where('slug', $slug);
        if ($id) $query->where('id !=', $id);
        return $query->first() !== null;
    }
}
