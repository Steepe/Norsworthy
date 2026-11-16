<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MediaModel;

class MediaController extends BaseController
{
    public function index(): string
    {
        return view('admin/media', ['media' => (new MediaModel())->orderBy('created_at', 'DESC')->findAll()]);
    }

    public function upload()
    {
        if (! $this->validate(['file' => 'uploaded[file]|max_size[file,5120]|is_image[file]'])) {
            return redirect()->back()->with('error', 'Upload a valid image smaller than 5 MB.');
        }
        $file = $this->request->getFile('file');
        $name = $file->getRandomName();
        $directory = FCPATH . 'uploads';
        if (! is_dir($directory)) mkdir($directory, 0755, true);
        $file->move($directory, $name);
        (new MediaModel())->insert([
            'filename' => $file->getClientName(), 'path' => 'uploads/' . $name, 'mime_type' => $file->getMimeType(),
            'alt_text' => trim((string) $this->request->getPost('alt_text')), 'size' => $file->getSize(), 'uploaded_by' => session()->get('cms_user_id'),
        ]);
        return redirect()->to(site_url('admin/media'))->with('success', 'Image uploaded. Copy its path into a page or content item.');
    }

    public function delete(int $id)
    {
        $model = new MediaModel();
        $media = $model->find($id);
        if ($media) {
            $path = FCPATH . $media['path'];
            if (is_file($path)) unlink($path);
            $model->delete($id);
        }
        return redirect()->to(site_url('admin/media'))->with('success', 'Image deleted.');
    }
}
