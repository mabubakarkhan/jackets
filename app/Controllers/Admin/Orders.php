<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\CustomerModel;

class Orders extends BaseController
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

    private function checkAdminLogin()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }
        return null;
    }

    public function index()
    {
        $loginCheck = $this->checkAdminLogin();
        if ($loginCheck) return $loginCheck;

        $status = $this->request->getGet('status');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 10;

        $db = \Config\Database::connect();
        
        $builder = $db->table('orders o')
                     ->select('o.*, c.name as customer_name, c.email as customer_email')
                     ->join('customers c', 'c.id = o.customer_id', 'left')
                     ->orderBy('o.created_at', 'DESC');

        if ($status) {
            $builder->where('o.status', $status);
        }

        $totalOrders = $builder->countAllResults(false);
        $orders = $builder->limit($perPage, ($page - 1) * $perPage)->get()->getResultArray();

        // Get order statistics
        $orderStats = $db->table('orders')
                        ->select('status, COUNT(*) as count')
                        ->groupBy('status')
                        ->get()
                        ->getResultArray();

        $data = [
            'title' => 'Orders Management',
            'orders' => $orders,
            'orderStats' => $orderStats,
            'currentStatus' => $status,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $totalOrders,
                'total_pages' => ceil($totalOrders / $perPage)
            ],
            'getStatusColor' => [$this, 'getStatusColor'],
            'getPaymentStatusColor' => [$this, 'getPaymentStatusColor']
        ];

        return view('admin/orders/index', $data);
    }

    /**
     * Get status color for order status
     */
    public function getStatusColor($status)
    {
        $colors = [
            'pending' => 'warning',
            'confirmed' => 'info',
            'processing' => 'primary',
            'shipped' => 'info',
            'delivered' => 'success',
            'cancelled' => 'danger',
            'refunded' => 'secondary'
        ];

        return $colors[$status] ?? 'secondary';
    }

    /**
     * Get payment status color
     */
    public function getPaymentStatusColor($status)
    {
        $colors = [
            'pending' => 'warning',
            'paid' => 'success',
            'failed' => 'danger',
            'refunded' => 'secondary',
            'cancelled' => 'danger'
        ];

        return $colors[$status] ?? 'secondary';
    }

    public function view($id)
    {
        $loginCheck = $this->checkAdminLogin();
        if ($loginCheck) return $loginCheck;

        $order = $this->orderModel->getOrderWithItems($id);
        
        if (!$order) {
            return redirect()->to('admin/orders')->with('error', 'Order not found');
        }

        $data = [
            'title' => 'Order Details #' . $order['order_number'],
            'order' => $order,
            'getStatusColor' => [$this, 'getStatusColor'],
            'getPaymentStatusColor' => [$this, 'getPaymentStatusColor']
        ];

        return view('admin/orders/view', $data);
    }

    public function updateStatus()
    {
        $loginCheck = $this->checkAdminLogin();
        if ($loginCheck) return $loginCheck;

        $orderId = $this->request->getPost('order_id');
        $status = $this->request->getPost('status');
        $notes = $this->request->getPost('notes');

        if (!$orderId || !$status) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Order ID and status are required'
            ]);
        }

        $updateData = ['status' => $status];
        if ($notes) {
            $updateData['admin_notes'] = $notes;
        }

        if ($this->orderModel->update($orderId, $updateData)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Order status updated successfully'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update order status'
            ]);
        }
    }

    public function delete($id)
    {
        $loginCheck = $this->checkAdminLogin();
        if ($loginCheck) return $loginCheck;

        if ($this->orderModel->delete($id)) {
            return redirect()->to('admin/orders')->with('success', 'Order deleted successfully');
        } else {
            return redirect()->to('admin/orders')->with('error', 'Failed to delete order');
        }
    }

    public function search()
    {
        $loginCheck = $this->checkAdminLogin();
        if ($loginCheck) return $loginCheck;

        $query = $this->request->getGet('q');
        
        if (empty($query) || strlen($query) < 2) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Query too short'
            ]);
        }

        $db = \Config\Database::connect();
        $orders = $db->table('orders o')
                    ->select('o.id, o.order_number, o.status, o.total_amount, o.created_at, c.name as customer_name, c.email as customer_email')
                    ->join('customers c', 'c.id = o.customer_id', 'left')
                    ->like('o.order_number', $query)
                    ->orLike('c.name', $query)
                    ->orLike('c.email', $query)
                    ->limit(10)
                    ->get()
                    ->getResultArray();

        return $this->response->setJSON([
            'success' => true,
            'orders' => $orders
        ]);
    }
}