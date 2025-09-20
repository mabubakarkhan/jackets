<?php

namespace App\Libraries;

use CodeIgniter\Email\Email;

class EmailService
{
    protected $email;
    protected $config;

    public function __construct()
    {
        $this->email = \Config\Services::email();
        $this->config = config('Email');
    }

    /**
     * Send password reset email
     */
    public function sendPasswordResetEmail($customerEmail, $customerName, $resetCode)
    {
        $subject = 'Password Reset Code - ' . ($this->config->fromName ?? 'Jacket Store');
        
        $message = $this->getPasswordResetEmailTemplate($customerName, $resetCode);
        
        $this->email->setFrom($this->config->fromEmail, $this->config->fromName);
        $this->email->setTo($customerEmail);
        $this->email->setSubject($subject);
        $this->email->setMessage($message);
        
        return $this->email->send();
    }

    /**
     * Get password reset email template
     */
    private function getPasswordResetEmailTemplate($customerName, $resetCode)
    {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Password Reset</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #f8f9fa; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
                .content { background: #fff; padding: 30px; border: 1px solid #ddd; }
                .code { background: #f8f9fa; padding: 20px; text-align: center; font-size: 24px; font-weight: bold; color: #007bff; border-radius: 5px; margin: 20px 0; }
                .footer { background: #f8f9fa; padding: 20px; text-align: center; border-radius: 0 0 5px 5px; font-size: 12px; color: #666; }
                .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: #fff; text-decoration: none; border-radius: 5px; margin: 10px 0; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Password Reset Request</h2>
                </div>
                <div class='content'>
                    <p>Hello " . esc($customerName) . ",</p>
                    
                    <p>You have requested to reset your password. Please use the following code to reset your password:</p>
                    
                    <div class='code'>" . $resetCode . "</div>
                    
                    <p>This code will expire in 15 minutes for security reasons.</p>
                    
                    <p>If you did not request this password reset, please ignore this email.</p>
                    
                    <p>Best regards,<br>Jacket Store Team</p>
                </div>
                <div class='footer'>
                    <p>This is an automated message. Please do not reply to this email.</p>
                </div>
            </div>
        </body>
        </html>
        ";
    }

    /**
     * Send welcome email
     */
    public function sendWelcomeEmail($customerEmail, $customerName)
    {
        $subject = 'Welcome to Jacket Store!';
        
        $message = $this->getWelcomeEmailTemplate($customerName);
        
        $this->email->setFrom($this->config->fromEmail, $this->config->fromName);
        $this->email->setTo($customerEmail);
        $this->email->setSubject($subject);
        $this->email->setMessage($message);
        
        return $this->email->send();
    }

    /**
     * Get welcome email template
     */
    private function getWelcomeEmailTemplate($customerName)
    {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Welcome to Jacket Store</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #f8f9fa; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
                .content { background: #fff; padding: 30px; border: 1px solid #ddd; }
                .footer { background: #f8f9fa; padding: 20px; text-align: center; border-radius: 0 0 5px 5px; font-size: 12px; color: #666; }
                .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: #fff; text-decoration: none; border-radius: 5px; margin: 10px 0; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Welcome to Jacket Store!</h2>
                </div>
                <div class='content'>
                    <p>Hello " . esc($customerName) . ",</p>
                    
                    <p>Welcome to Jacket Store! Your account has been successfully created.</p>
                    
                    <p>You can now:</p>
                    <ul>
                        <li>Browse our collection of premium jackets</li>
                        <li>Add items to your cart and checkout</li>
                        <li>Track your orders</li>
                        <li>Manage your profile</li>
                    </ul>
                    
                    <p style='text-align: center;'>
                        <a href='" . base_url('shop') . "' class='btn'>Start Shopping</a>
                    </p>
                    
                    <p>Thank you for choosing Jacket Store!</p>
                    
                    <p>Best regards,<br>Jacket Store Team</p>
                </div>
                <div class='footer'>
                    <p>This is an automated message. Please do not reply to this email.</p>
                </div>
            </div>
        </body>
        </html>
        ";
    }
}
