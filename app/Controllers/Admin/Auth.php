<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class Auth extends BaseController
{
    public function index()
    {
        return view('admin/auth/login');
    }

    public function login()
    {
        $model = new AdminModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $admin = $model->where('email', $email)->first();

        if ($admin) {

            if (password_verify($password, $admin['password'])) {

                session()->set([
                    'admin_id' => $admin['admin_id'],
                    'full_name' => $admin['full_name'],
                    'isLoggedIn' => true
                ]);

                return redirect()->to('/admin/dashboard');

            } else {

                return redirect()->back()->with('error', 'Wrong Password');

            }

        } else {

            return redirect()->back()->with('error', 'Email Not Found');

        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login');
    }
}

