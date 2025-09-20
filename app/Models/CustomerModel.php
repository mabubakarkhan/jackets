<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'name', 'email', 'phone', 'password', 'address', 'city', 'country', 
        'photo', 'status', 'email_verified', 'email_verification_token', 
        'password_reset_token', 'password_reset_expires', 'last_login'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'name' => 'required|max_length[255]',
        'email' => 'required|valid_email|max_length[255]|is_unique[customers.email,id,{id}]',
        'phone' => 'required|max_length[20]',
        'password' => 'required|min_length[6]',
        'address' => 'required',
        'city' => 'required|max_length[100]',
        'country' => 'required|max_length[100]',
        'status' => 'in_list[active,inactive,suspended]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Name is required',
            'max_length' => 'Name cannot exceed 255 characters'
        ],
        'email' => [
            'required' => 'Email is required',
            'valid_email' => 'Please enter a valid email address',
            'is_unique' => 'This email is already registered'
        ],
        'phone' => [
            'required' => 'Phone number is required',
            'max_length' => 'Phone number cannot exceed 20 characters'
        ],
        'password' => [
            'required' => 'Password is required',
            'min_length' => 'Password must be at least 6 characters long'
        ],
        'address' => [
            'required' => 'Address is required'
        ],
        'city' => [
            'required' => 'City is required',
            'max_length' => 'City name cannot exceed 100 characters'
        ],
        'country' => [
            'required' => 'Country is required',
            'max_length' => 'Country name cannot exceed 100 characters'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeInsert(array $data)
    {
        $data['data']['created_at'] = date('Y-m-d H:i:s');
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        
        // Hash password
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        
        // Generate email verification token
        $data['data']['email_verification_token'] = bin2hex(random_bytes(32));
        
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        
        // Hash password if it's being updated
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        
        return $data;
    }

    public function authenticate($email, $password)
    {
        $customer = $this->where('email', $email)
                        ->where('status', 'active')
                        ->first();
        
        if ($customer && password_verify($password, $customer['password'])) {
            // Update last login
            $this->update($customer['id'], ['last_login' => date('Y-m-d H:i:s')]);
            return $customer;
        }
        
        return false;
    }

    public function findByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function findByVerificationToken($token)
    {
        return $this->where('email_verification_token', $token)->first();
    }

    public function findByPasswordResetToken($token)
    {
        return $this->where('password_reset_token', $token)
                   ->where('password_reset_expires >', date('Y-m-d H:i:s'))
                   ->first();
    }

    public function generatePasswordResetToken($email)
    {
        $customer = $this->findByEmail($email);
        if (!$customer) {
            return false;
        }

        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $this->update($customer['id'], [
            'password_reset_token' => $token,
            'password_reset_expires' => $expires
        ]);

        return $token;
    }

    public function verifyEmail($token)
    {
        $customer = $this->findByVerificationToken($token);
        if (!$customer) {
            return false;
        }

        return $this->update($customer['id'], [
            'email_verified' => true,
            'email_verification_token' => null
        ]);
    }

    public function resetPassword($token, $newPassword)
    {
        $customer = $this->findByPasswordResetToken($token);
        if (!$customer) {
            return false;
        }

        return $this->update($customer['id'], [
            'password' => $newPassword,
            'password_reset_token' => null,
            'password_reset_expires' => null
        ]);
    }

    public function getCustomerOrders($customerId)
    {
        $orderModel = new \App\Models\OrderModel();
        return $orderModel->where('customer_id', $customerId)
                         ->orderBy('created_at', 'DESC')
                         ->findAll();
    }
}