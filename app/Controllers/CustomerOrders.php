<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;

class CustomerOrders extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;

    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
    }

    public function index()
    {
        $customer = session()->get('customer');
        if (!$customer) {
            return redirect()->to('customer/login')->with('error', 'Please login to view your orders.');
        }

        $orders = $this->orderModel->getOrdersByCustomer($customer['id']);

        $data = [
            'title' => 'My Orders',
            'meta_title' => 'My Orders - Jacket Store',
            'meta_description' => 'View and track your order history.',
            'orders' => $orders
        ];

        return view('customer/orders', $this->getViewData($data));
    }

    public function view($orderId)
    {
        $customer = session()->get('customer');
        if (!$customer) {
            return redirect()->to('customer/login')->with('error', 'Please login to view order details.');
        }

        $order = $this->orderModel->getOrderWithItems($orderId);

        if (!$order || $order['customer_id'] != $customer['id']) {
            return redirect()->to('customer/orders')->with('error', 'Order not found.');
        }

        $data = [
            'title' => 'Order #' . $order['order_number'],
            'meta_title' => 'Order #' . $order['order_number'] . ' - Jacket Store',
            'meta_description' => 'View details for your order.',
            'order' => $order
        ];

        return view('customer/order-details', $this->getViewData($data));
    }

    public function cancel($orderId)
    {
        $customer = session()->get('customer');
        if (!$customer) {
            return redirect()->to('customer/login')->with('error', 'Please login to cancel orders.');
        }

        $order = $this->orderModel->find($orderId);

        if (!$order || $order['customer_id'] != $customer['id']) {
            return redirect()->to('customer/orders')->with('error', 'Order not found.');
        }

        // Only allow cancellation of pending or confirmed orders
        if (!in_array($order['status'], ['pending', 'confirmed'])) {
            return redirect()->to('customer/orders')->with('error', 'This order cannot be cancelled.');
        }

        if ($this->orderModel->updateStatus($orderId, 'cancelled', 'Cancelled by customer')) {
            return redirect()->to('customer/orders')->with('success', 'Order cancelled successfully.');
        } else {
            return redirect()->to('customer/orders')->with('error', 'Failed to cancel order. Please try again.');
        }
    }

    public function track($orderId)
    {
        $customer = session()->get('customer');
        if (!$customer) {
            return redirect()->to('customer/login')->with('error', 'Please login to track orders.');
        }

        $order = $this->orderModel->find($orderId);

        if (!$order || $order['customer_id'] != $customer['id']) {
            return redirect()->to('customer/orders')->with('error', 'Order not found.');
        }

        $data = [
            'title' => 'Track Order #' . $order['order_number'],
            'meta_title' => 'Track Order #' . $order['order_number'] . ' - Jacket Store',
            'meta_description' => 'Track your order status and shipping information.',
            'order' => $order
        ];

        return view('customer/track-order', $this->getViewData($data));
    }
}
