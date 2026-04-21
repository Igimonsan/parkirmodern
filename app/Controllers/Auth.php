<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper('form');
    }

    public function index()
    {
        // Jika sudah login, redirect ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/admin/dashboard');
        }

        return view('auth/login');
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->verifyLogin($username, $password);

        if ($user) {
            session()->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'nama' => $user['nama'],
                'logged_in' => true
            ]);

            return redirect()->to('/admin/dashboard')->with('success', 'Login berhasil!');
        }

        return redirect()->back()->with('error', 'Username atau password salah!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Logout berhasil!');
    }
}