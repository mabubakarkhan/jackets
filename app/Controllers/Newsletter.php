<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Newsletter extends BaseController
{
    public function subscribe()
    {
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            
            if (empty($email)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Email is required'
                ]);
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Please enter a valid email address'
                ]);
            }
            
            // Here you can save the email to database
            // For now, we'll just return success
            // You can create a newsletter_subscribers table and save the email
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Thank you for subscribing to our newsletter!'
            ]);
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid request method'
        ]);
    }
}
