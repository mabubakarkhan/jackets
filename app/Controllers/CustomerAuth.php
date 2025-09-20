<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerModel;
use App\Models\PasswordResetTokenModel;
use App\Libraries\EmailService;

class CustomerAuth extends BaseController
{
    protected $customerModel;
    protected $passwordResetTokenModel;
    protected $emailService;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        $this->passwordResetTokenModel = new PasswordResetTokenModel();
        $this->emailService = new EmailService();
    }

    public function login()
    {
        // Store redirect URL if provided
        $redirectUrl = $this->request->getGet('redirect');
        if ($redirectUrl) {
            session()->set('redirect_after_login', $redirectUrl);
        }

        $data = [
            'title' => 'Customer Login',
            'meta_title' => 'Login - Jacket Store',
            'meta_description' => 'Login to your account to manage orders and preferences.'
        ];

        return view('customer/login', $this->getViewData($data));
    }

    public function processLogin()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $customer = $this->customerModel->authenticate($email, $password);

        if ($customer) {
            // Set customer session
            session()->set([
                'customer_id' => $customer['id'],
                'customer_name' => $customer['name'],
                'customer_email' => $customer['email'],
                'customer_logged_in' => true
            ]);

            $redirectUrl = session()->get('redirect_after_login') ?? base_url('customer/dashboard');
            session()->remove('redirect_after_login');

            return redirect()->to($redirectUrl)
                ->with('success', 'Welcome back, ' . $customer['name'] . '!');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid email or password');
        }
    }

    public function register()
    {
        $data = [
            'title' => 'Customer Registration',
            'meta_title' => 'Sign Up - Jacket Store',
            'meta_description' => 'Create an account to start shopping and manage your orders.'
        ];

        return view('customer/register', $this->getViewData($data));
    }

    public function processRegister()
    {
        $rules = [
            'name' => 'required|max_length[255]',
            'email' => 'required|valid_email|is_unique[customers.email]',
            'phone' => 'required|max_length[20]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'address' => 'required',
            'city' => 'required|max_length[100]',
            'country' => 'required|max_length[100]',
            'terms' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'password' => $this->request->getPost('password'),
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'country' => $this->request->getPost('country'),
            'status' => 'active'
        ];

        try {
            if ($this->customerModel->insert($data)) {
                // Auto-login after registration
                $customer = $this->customerModel->find($this->customerModel->getInsertID());
                
                session()->set([
                    'customer_id' => $customer['id'],
                    'customer_name' => $customer['name'],
                    'customer_email' => $customer['email'],
                    'customer_logged_in' => true
                ]);

                return redirect()->to('customer/dashboard')
                    ->with('success', 'Account created successfully! Welcome to Jacket Store!');
            } else {
                $errors = $this->customerModel->errors();
                $errorMessage = 'Failed to create account. ';
                if (!empty($errors)) {
                    $errorMessage .= implode(', ', $errors);
                } else {
                    $errorMessage .= 'Please try again.';
                }
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', $errorMessage);
            }
        } catch (\Exception $e) {
            log_message('error', 'Customer registration error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create account: ' . $e->getMessage());
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('customer/login')
            ->with('success', 'You have been logged out successfully.');
    }

    public function dashboard()
    {
        if (!session()->get('customer_logged_in')) {
            return redirect()->to('customer/login');
        }

        $customerId = session()->get('customer_id');
        $customer = $this->customerModel->find($customerId);
        
        // Get customer orders
        $orderModel = new \App\Models\OrderModel();
        $orders = $orderModel->getOrdersByCustomer($customerId);

        $data = [
            'title' => 'Customer Dashboard',
            'meta_title' => 'Dashboard - Jacket Store',
            'meta_description' => 'Manage your account and view your orders.',
            'customer' => $customer,
            'orders' => $orders
        ];

        return view('customer/dashboard', $this->getViewData($data));
    }

    public function profile()
    {
        if (!session()->get('customer_logged_in')) {
            return redirect()->to('customer/login');
        }

        $customerId = session()->get('customer_id');
        $customer = $this->customerModel->find($customerId);

        $data = [
            'title' => 'My Profile',
            'meta_title' => 'Profile - Jacket Store',
            'meta_description' => 'Update your profile information.',
            'customer' => $customer
        ];

        return view('customer/profile', $this->getViewData($data));
    }

    public function updateProfile()
    {
        if (!session()->get('customer_logged_in')) {
            return redirect()->to('customer/login');
        }

        $customerId = session()->get('customer_id');
        $customer = $this->customerModel->find($customerId);

        if (!$customer) {
            return redirect()->to('customer/logout');
        }

        $rules = [
            'name' => 'required|max_length[255]',
            'email' => "required|valid_email|is_unique[customers.email,id,{$customerId}]",
            'phone' => 'required|max_length[20]',
            'address' => 'required',
            'city' => 'required|max_length[100]',
            'country' => 'required|max_length[100]'
        ];

        if (!$this->validate($rules)) {
            log_message('error', 'Profile update validation failed: ' . json_encode($this->validator->getErrors()));
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'country' => $this->request->getPost('country')
        ];

        log_message('debug', 'Updating customer profile with data: ' . json_encode($data));

        try {
            // Use direct database query to bypass model validation issues
            $db = \Config\Database::connect();
            $sql = "UPDATE customers SET name = ?, email = ?, phone = ?, address = ?, city = ?, country = ?, updated_at = NOW() WHERE id = ?";
            
            $result = $db->query($sql, [
                $data['name'],
                $data['email'],
                $data['phone'],
                $data['address'],
                $data['city'],
                $data['country'],
                $customerId
            ]);

            if ($result) {
                // Update session data
                session()->set([
                    'customer_name' => $data['name'],
                    'customer_email' => $data['email']
                ]);

                log_message('debug', 'Profile updated successfully for customer ID: ' . $customerId);
                return redirect()->to('customer/profile')
                    ->with('success', 'Profile updated successfully!');
            } else {
                log_message('error', 'Failed to update profile for customer ID: ' . $customerId);
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Failed to update profile. Please try again.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Profile update exception: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while updating your profile. Please try again.');
        }
    }

    public function changePassword()
    {
        if (!session()->get('customer_logged_in')) {
            return redirect()->to('customer/login');
        }

        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        $customerId = session()->get('customer_id');
        $customer = $this->customerModel->find($customerId);

        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');

        if (!password_verify($currentPassword, $customer['password'])) {
            return redirect()->back()
                ->with('error', 'Current password is incorrect.');
        }

        if ($this->customerModel->update($customerId, ['password' => $newPassword])) {
            return redirect()->to('customer/profile')
                ->with('success', 'Password changed successfully!');
        } else {
            return redirect()->back()
                ->with('error', 'Failed to change password. Please try again.');
        }
    }

    public function forgotPassword()
    {
        $data = [
            'title' => 'Forgot Password',
            'meta_title' => 'Forgot Password - Jacket Store',
            'meta_description' => 'Reset your password by entering your email address.'
        ];

        return view('customer/forgot-password', $this->getViewData($data));
    }

    public function processForgotPassword()
    {
        $rules = [
            'email' => 'required|valid_email'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        $email = $this->request->getPost('email');
        $customer = $this->customerModel->where('email', $email)->first();

        if (!$customer) {
            return redirect()->back()
                ->with('error', 'No account found with that email address.');
        }

        // Generate reset code and token
        $resetCode = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        $resetToken = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        // Create password reset token
        $this->passwordResetTokenModel->createToken($customer['id'], $resetToken, $resetCode, $expiresAt);

        // Send email
        if ($this->emailService->sendPasswordResetEmail($customer['email'], $customer['name'], $resetCode)) {
            return redirect()->to('customer/forgot-password')
                ->with('success', 'Password reset code has been sent to your email address.');
        } else {
            return redirect()->back()
                ->with('error', 'Failed to send password reset email. Please try again.');
        }
    }

    public function resetPassword()
    {
        $data = [
            'title' => 'Reset Password',
            'meta_title' => 'Reset Password - Jacket Store',
            'meta_description' => 'Enter the code sent to your email and set a new password.'
        ];

        return view('customer/reset-password', $this->getViewData($data));
    }

    public function processResetPassword()
    {
        $rules = [
            'code' => 'required|exact_length[6]',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        $code = $this->request->getPost('code');
        $newPassword = $this->request->getPost('new_password');

        // Find valid token
        $token = $this->passwordResetTokenModel->findValidTokenByCode($code);

        if (!$token) {
            return redirect()->back()
                ->with('error', 'Invalid or expired reset code.');
        }

        // Update customer password
        if ($this->customerModel->update($token['customer_id'], ['password' => $newPassword])) {
            // Mark token as used
            $this->passwordResetTokenModel->markAsUsed($token['id']);

            return redirect()->to('customer/login')
                ->with('success', 'Password reset successfully! You can now login with your new password.');
        } else {
            return redirect()->back()
                ->with('error', 'Failed to reset password. Please try again.');
        }
    }
}