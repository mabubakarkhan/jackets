<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\CustomerModel;

class Customer extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;
    protected $customerModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->customerModel = new CustomerModel();
    }

    public function dashboard()
    {
        if (!session()->get('customer_logged_in')) {
            return redirect()->to('customer/login?redirect=' . urlencode(current_url()));
        }

        $customerId = session()->get('customer_id');
        $customer = $this->customerModel->find($customerId);
        $orders = $this->orderModel->getOrdersByCustomer($customerId);

        $data = [
            'title' => 'Customer Dashboard',
            'meta_title' => 'Customer Dashboard - Jacket Store',
            'meta_description' => 'Manage your account and view your orders.',
            'customer' => $customer,
            'orders' => array_slice($orders, 0, 5), // Show only recent 5 orders
            'total_orders' => count($orders)
        ];

        return view('customer/dashboard', $this->getViewData($data));
    }

    public function profile()
    {
        if (!session()->get('customer_logged_in')) {
            return redirect()->to('customer/login?redirect=' . urlencode(current_url()));
        }

        $customerId = session()->get('customer_id');
        $customer = $this->customerModel->find($customerId);

        if (!$customer) {
            return redirect()->to('customer/logout');
        }

        $data = [
            'title' => 'My Profile',
            'meta_title' => 'My Profile - Jacket Store',
            'meta_description' => 'Manage your account information and preferences.',
            'customer' => $customer
        ];

        return view('customer/profile', $this->getViewData($data));
    }

    public function orders()
    {
        if (!session()->get('customer_logged_in')) {
            return redirect()->to('customer/login?redirect=' . urlencode(current_url()));
        }

        $customerId = session()->get('customer_id');
        $orders = $this->orderModel->getOrdersByCustomer($customerId);

        $data = [
            'title' => 'My Orders',
            'meta_title' => 'My Orders - Jacket Store',
            'meta_description' => 'View and track your orders.',
            'orders' => $orders
        ];

        return view('customer/orders', $this->getViewData($data));
    }

    public function orderDetail($orderId)
    {
        if (!session()->get('customer_logged_in')) {
            return redirect()->to('customer/login?redirect=' . urlencode(current_url()));
        }

        $customerId = session()->get('customer_id');
        $order = $this->orderModel->where('id', $orderId)
                                 ->where('customer_id', $customerId)
                                 ->first();

        if (!$order) {
            return redirect()->to('customer/orders')
                ->with('error', 'Order not found.');
        }

        // Get order items using direct database query
        $db = \Config\Database::connect();
        $orderItemsQuery = $db->query("SELECT * FROM order_items WHERE order_id = ?", [$orderId]);
        $orderItems = $orderItemsQuery->getResultArray();

        $data = [
            'title' => 'Order Details - ' . $order['order_number'],
            'meta_title' => 'Order Details - Jacket Store',
            'meta_description' => 'View detailed information about your order.',
            'order' => $order,
            'order_items' => $orderItems
        ];

        return view('customer/order_detail', $this->getViewData($data));
    }

    public function cancelOrder($orderId)
    {
        if (!session()->get('customer_logged_in')) {
            return redirect()->to('customer/login?redirect=' . urlencode(current_url()));
        }

        $customerId = session()->get('customer_id');
        $order = $this->orderModel->where('id', $orderId)
                                 ->where('customer_id', $customerId)
                                 ->first();

        if (!$order) {
            return redirect()->to('customer/orders')
                ->with('error', 'Order not found.');
        }

        if (!in_array($order['status'], ['pending', 'confirmed'])) {
            return redirect()->to('customer/orders')
                ->with('error', 'Order cannot be cancelled at this stage.');
        }

        if ($this->orderModel->updateStatus($orderId, 'cancelled')) {
            return redirect()->to('customer/orders')
                ->with('success', 'Order has been cancelled successfully.');
        } else {
            return redirect()->to('customer/orders')
                ->with('error', 'Failed to cancel order. Please try again.');
        }
    }

    public function trackOrder($orderId)
    {
        if (!session()->get('customer_logged_in')) {
            return redirect()->to('customer/login?redirect=' . urlencode(current_url()));
        }

        $customerId = session()->get('customer_id');
        $order = $this->orderModel->where('id', $orderId)
                                 ->where('customer_id', $customerId)
                                 ->first();

        if (!$order) {
            return redirect()->to('customer/orders')
                ->with('error', 'Order not found.');
        }

        $data = [
            'title' => 'Track Order - ' . $order['order_number'],
            'meta_title' => 'Track Order - Jacket Store',
            'meta_description' => 'Track your order status and delivery information.',
            'order' => $order
        ];

        return view('customer/track_order', $this->getViewData($data));
    }

    public function wishlist()
    {
        if (!session()->get('customer_logged_in')) {
            return redirect()->to('customer/login?redirect=' . urlencode(current_url()));
        }

        // TODO: Implement wishlist functionality
        $data = [
            'title' => 'My Wishlist',
            'meta_title' => 'Wishlist - Jacket Store',
            'meta_description' => 'View your saved items.',
            'wishlist' => []
        ];

        return view('customer/wishlist', $this->getViewData($data));
    }

    public function addresses()
    {
        if (!session()->get('customer_logged_in')) {
            return redirect()->to('customer/login?redirect=' . urlencode(current_url()));
        }

        $customerId = session()->get('customer_id');
        $customer = $this->customerModel->find($customerId);

        $data = [
            'title' => 'My Addresses',
            'meta_title' => 'Addresses - Jacket Store',
            'meta_description' => 'Manage your shipping and billing addresses.',
            'customer' => $customer
        ];

        return view('customer/addresses', $this->getViewData($data));
    }

    public function updateAddress()
    {
        if (!session()->get('customer_logged_in')) {
            return redirect()->to('customer/login?redirect=' . urlencode(current_url()));
        }

        $customerId = session()->get('customer_id');

        $rules = [
            'address' => 'required',
            'city' => 'required|max_length[100]',
            'country' => 'required|max_length[100]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        $data = [
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'country' => $this->request->getPost('country')
        ];

        if ($this->customerModel->update($customerId, $data)) {
            return redirect()->to('customer/addresses')
                ->with('success', 'Address updated successfully!');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update address. Please try again.');
        }
    }
}
