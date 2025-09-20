<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CustomerModel;

class Customers extends BaseController
{
    protected $customerModel;

    public function __construct()
    {
        // Check if admin is logged in
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $this->customerModel = new CustomerModel();
    }

    public function index()
    {
        try {
            $db = \Config\Database::connect();
            
            // Get all customers with pagination
            $customers = $db->table('customers')
                ->orderBy('created_at', 'DESC')
                ->get()
                ->getResultArray();

            $data = [
                'title' => 'Customers Management',
                'customers' => $customers
            ];

            return view('admin/customers/index', $data);

        } catch (\Exception $e) {
            log_message('error', 'Customers index error: ' . $e->getMessage());
            
            $data = [
                'title' => 'Customers Management',
                'customers' => []
            ];

            return view('admin/customers/index', $data);
        }
    }

    public function view($id)
    {
        try {
            $db = \Config\Database::connect();
            
            // Get customer details
            $customer = $db->table('customers')
                ->where('id', $id)
                ->get()
                ->getRowArray();

            if (!$customer) {
                throw new \Exception('Customer not found');
            }

            // Get customer orders
            $orders = $db->table('orders')
                ->where('customer_id', $id)
                ->orderBy('created_at', 'DESC')
                ->get()
                ->getResultArray();

            // Get order statistics
            $total_orders = count($orders);
            $total_spent = $db->table('orders')
                ->selectSum('total_amount')
                ->where('customer_id', $id)
                ->where('order_status', 'completed')
                ->get()
                ->getRowArray();

            $data = [
                'title' => 'Customer Details - ' . $customer['name'],
                'customer' => $customer,
                'orders' => $orders,
                'total_orders' => $total_orders,
                'total_spent' => $total_spent['total_amount'] ?? 0
            ];

            return view('admin/customers/view', $data);

        } catch (\Exception $e) {
            log_message('error', 'Customer view error: ' . $e->getMessage());
            
            return redirect()->to('admin/customers')
                ->with('error', 'Customer not found or error occurred.');
        }
    }

    public function edit($id)
    {
        try {
            $db = \Config\Database::connect();
            
            // Get customer details
            $customer = $db->table('customers')
                ->where('id', $id)
                ->get()
                ->getRowArray();

            if (!$customer) {
                throw new \Exception('Customer not found');
            }

            $data = [
                'title' => 'Edit Customer - ' . $customer['name'],
                'customer' => $customer
            ];

            return view('admin/customers/edit', $data);

        } catch (\Exception $e) {
            log_message('error', 'Customer edit error: ' . $e->getMessage());
            
            return redirect()->to('admin/customers')
                ->with('error', 'Customer not found or error occurred.');
        }
    }

    public function update($id)
    {
        try {
            $db = \Config\Database::connect();
            
            // Get customer details
            $customer = $db->table('customers')
                ->where('id', $id)
                ->get()
                ->getRowArray();

            if (!$customer) {
                throw new \Exception('Customer not found');
            }

            $rules = [
                'name' => 'required|max_length[255]',
                'email' => "required|valid_email|is_unique[customers.email,id,{$id}]",
                'phone' => 'required|max_length[20]',
                'address' => 'required',
                'city' => 'required|max_length[100]',
                'country' => 'required|max_length[100]',
                'status' => 'required|in_list[active,inactive,suspended]'
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
                'address' => $this->request->getPost('address'),
                'city' => $this->request->getPost('city'),
                'country' => $this->request->getPost('country'),
                'status' => $this->request->getPost('status'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $db->table('customers')
                ->where('id', $id)
                ->update($data);

            if ($result) {
                return redirect()->to('admin/customers/view/' . $id)
                    ->with('success', 'Customer updated successfully.');
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Failed to update customer. Please try again.');
            }

        } catch (\Exception $e) {
            log_message('error', 'Customer update error: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while updating the customer.');
        }
    }

    public function delete($id)
    {
        try {
            $db = \Config\Database::connect();
            
            // Check if customer has orders
            $orders = $db->table('orders')
                ->where('customer_id', $id)
                ->countAllResults();

            if ($orders > 0) {
                return redirect()->to('admin/customers')
                    ->with('error', 'Cannot delete customer with existing orders.');
            }

            $result = $db->table('customers')
                ->where('id', $id)
                ->delete();

            if ($result) {
                return redirect()->to('admin/customers')
                    ->with('success', 'Customer deleted successfully.');
            } else {
                return redirect()->to('admin/customers')
                    ->with('error', 'Failed to delete customer. Please try again.');
            }

        } catch (\Exception $e) {
            log_message('error', 'Customer delete error: ' . $e->getMessage());
            
            return redirect()->to('admin/customers')
                ->with('error', 'An error occurred while deleting the customer.');
        }
    }
}
