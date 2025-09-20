<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Debug: Check if this method is being called
        log_message('info', 'Auth::index method called');
        
        if (session()->get('admin_logged_in')) {
            return redirect()->to('/admin/dashboard');
        }
        
        return view('admin/auth/login');
    }

    public function login()
    {
        // Debug: Check if this method is being called
        log_message('info', 'Auth::login method called');
        log_message('info', 'Request method: ' . $this->request->getMethod());
        log_message('info', 'POST data: ' . json_encode($this->request->getPost()));
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Debug: Log the received data
        log_message('info', 'Username: ' . $username);
        log_message('info', 'Password length: ' . strlen($password));

        $user = $this->userModel->where('username', $username)
                                ->where('role', 'admin')
                                ->where('status', 'active')
                                ->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'admin_id' => $user['id'],
                'admin_username' => $user['username'],
                'admin_email' => $user['email'],
                'admin_logged_in' => true
            ]);

            log_message('info', 'Login successful for user: ' . $username);
            return redirect()->to('/admin/dashboard');
        } else {
            log_message('info', 'Login failed for user: ' . $username);
            session()->setFlashdata('error', 'Invalid username or password');
            return redirect()->back();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login');
    }
}
