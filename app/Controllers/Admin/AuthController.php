<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login(): string
    {
        if (session()->get('cms_user_id')) {
            return redirect()->to(site_url('admin'));
        }
        return view('admin/login');
    }

    public function attempt()
    {
        $rules = ['email' => 'required|valid_email', 'password' => 'required'];
        if (! $this->validateData($this->request->getPost(), $rules)) {
            return redirect()->back()->withInput()->with('error', 'Enter a valid email address and password.');
        }
        $user = (new UserModel())->where('email', strtolower((string) $this->request->getPost('email')))->first();
        if (! $user || ! password_verify((string) $this->request->getPost('password'), $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Those credentials are not recognised.');
        }
        (new UserModel())->update($user['id'], ['last_login_at' => date('Y-m-d H:i:s')]);
        session()->regenerate();
        session()->set(['cms_user_id' => $user['id'], 'cms_user_name' => $user['name'], 'cms_user_role' => $user['role']]);
        return redirect()->to(site_url('admin'));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url('admin/login'))->with('success', 'You have been signed out.');
    }
}
