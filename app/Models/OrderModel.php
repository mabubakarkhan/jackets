<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'customer_id', 'order_number', 'status', 'payment_status', 'payment_method',
        'shipping_address', 'billing_address', 'notes', 'coupon_code', 'discount_amount',
        'shipping_cost', 'tax_amount', 'total_amount', 'created_at', 'updated_at',
        'customer_name', 'customer_email', 'customer_phone', 'customer_address',
        'customer_city', 'customer_state', 'customer_zip', 'customer_country',
        'subtotal', 'order_status'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'customer_id' => 'required|integer',
        'order_number' => 'required|max_length[50]|is_unique[orders.order_number,id,{id}]',
        'status' => 'in_list[pending,confirmed,processing,shipped,delivered,cancelled,refunded]',
        'payment_status' => 'in_list[pending,paid,failed,refunded]',
        'payment_method' => 'max_length[50]',
        'total_amount' => 'required|decimal'
    ];

    protected $validationMessages = [
        'customer_id' => [
            'required' => 'Customer ID is required',
            'integer' => 'Customer ID must be a valid integer'
        ],
        'order_number' => [
            'required' => 'Order number is required',
            'is_unique' => 'Order number must be unique'
        ],
        'total_amount' => [
            'required' => 'Total amount is required',
            'decimal' => 'Total amount must be a valid decimal'
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
        
        // Generate order number if not provided
        if (!isset($data['data']['order_number']) || empty($data['data']['order_number'])) {
            $data['data']['order_number'] = $this->generateOrderNumber();
        }
        
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    public function generateOrderNumber()
    {
        $prefix = 'ORD';
        $date = date('Ymd');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        return $prefix . $date . $random;
    }

    public function getOrderWithItems($orderId)
    {
        $order = $this->find($orderId);
        if (!$order) {
            return null;
        }

        $orderItemModel = new \App\Models\OrderItemModel();
        $order['items'] = $orderItemModel->where('order_id', $orderId)->findAll();

        return $order;
    }

    public function getOrderWithCustomer($orderId)
    {
        $order = $this->find($orderId);
        if (!$order) {
            return null;
        }

        $customerModel = new \App\Models\CustomerModel();
        $order['customer'] = $customerModel->find($order['customer_id']);

        return $order;
    }

    public function getOrdersByStatus($status)
    {
        return $this->where('status', $status)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    public function getOrdersByCustomer($customerId)
    {
        return $this->where('customer_id', $customerId)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    public function updateStatus($orderId, $status)
    {
        return $this->update($orderId, ['status' => $status]);
    }

    public function updatePaymentStatus($orderId, $paymentStatus)
    {
        return $this->update($orderId, ['payment_status' => $paymentStatus]);
    }

    public function getOrderStats()
    {
        $stats = [];
        
        // Total orders
        $stats['total_orders'] = $this->countAllResults();
        
        // Orders by status
        $statuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'];
        foreach ($statuses as $status) {
            $stats['orders_by_status'][$status] = $this->where('status', $status)->countAllResults();
        }
        
        // Total revenue
        $stats['total_revenue'] = $this->selectSum('total_amount')
                                     ->where('payment_status', 'paid')
                                     ->get()
                                     ->getRow()
                                     ->total_amount ?? 0;
        
        // Recent orders (last 30 days)
        $stats['recent_orders'] = $this->where('created_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))
                                     ->countAllResults();
        
        return $stats;
    }
}