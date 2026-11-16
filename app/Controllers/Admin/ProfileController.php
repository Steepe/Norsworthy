<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    public function edit(): string
    {
        return view('admin/profile', ['title' => 'My account', 'user' => (new UserModel())->find(session()->get('cms_user_id'))]);
    }

    public function password()
    {
        $input = $this->request->getPost();
        if (! $this->validateData($input, ['current_password' => 'required', 'password' => 'required|min_length[12]', 'password_confirmation' => 'required|matches[password]'])) {
            return redirect()->back()->with('error', 'Use your current password and choose a matching new password of at least 12 characters.');
        }
        $model = new UserModel();
        $user = $model->find(session()->get('cms_user_id'));
        if (! $user || ! password_verify((string) $input['current_password'], $user['password_hash'])) {
            return redirect()->back()->with('error', 'Your current password is incorrect.');
        }
        $model->update($user['id'], ['password_hash' => password_hash((string) $input['password'], PASSWORD_DEFAULT)]);
        return redirect()->to(site_url('admin/profile'))->with('success', 'Password updated.');
    }
}
