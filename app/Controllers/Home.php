<?php

namespace App\Controllers;

use App\Models\ContentModel;

class Home extends BaseController
{
    public function index(): string
    {
        $content = new ContentModel();
        return view('site/home', [
            'projects' => $content->where(['type' => 'project', 'status' => 'published'])->orderBy('published_at', 'DESC')->findAll(3),
            'articles' => $content->where(['type' => 'post', 'status' => 'published'])->orderBy('published_at', 'DESC')->findAll(3),
        ]);
    }
}
