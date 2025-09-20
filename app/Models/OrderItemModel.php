<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'order_id', 'product_id', 'product_name', 'quantity', 'unit_price', 'total_price'
    ];

    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = null;
    protected $updatedField = null;

    /**
     * Override to prevent timestamp handling
     */
    protected function setTimestamps(array $data): array
    {
        return $data;
    }

    /**
     * Custom insert method that doesn't use timestamps
     */
    public function insert($data = null, $returnID = true)
    {
        // Temporarily disable timestamps
        $this->useTimestamps = false;
        
        $result = parent::insert($data, $returnID);
        
        return $result;
    }

    protected $validationRules = [
        'order_id' => 'required|integer',
        'product_id' => 'required|integer',
        'product_name' => 'required|max_length[255]',
        'quantity' => 'required|integer|greater_than[0]',
        'unit_price' => 'required|decimal',
        'total_price' => 'required|decimal'
    ];

    protected $validationMessages = [
        'order_id' => [
            'required' => 'Order ID is required',
            'integer' => 'Order ID must be a valid integer'
        ],
        'product_id' => [
            'required' => 'Product ID is required',
            'integer' => 'Product ID must be a valid integer'
        ],
        'product_name' => [
            'required' => 'Product name is required',
            'max_length' => 'Product name cannot exceed 255 characters'
        ],
        'quantity' => [
            'required' => 'Quantity is required',
            'integer' => 'Quantity must be a valid integer',
            'greater_than' => 'Quantity must be greater than 0'
        ],
        'unit_price' => [
            'required' => 'Unit price is required',
            'decimal' => 'Unit price must be a valid decimal'
        ],
        'total_price' => [
            'required' => 'Total price is required',
            'decimal' => 'Total price must be a valid decimal'
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
        
        // Calculate total price if not provided
        if (isset($data['data']['quantity']) && isset($data['data']['unit_price'])) {
            $data['data']['total_price'] = $data['data']['quantity'] * $data['data']['unit_price'];
        }
        
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        
        // Recalculate total price if quantity or unit price changed
        if (isset($data['data']['quantity']) || isset($data['data']['unit_price'])) {
            $quantity = $data['data']['quantity'] ?? $this->find($data['id'])['quantity'];
            $unitPrice = $data['data']['unit_price'] ?? $this->find($data['id'])['unit_price'];
            $data['data']['total_price'] = $quantity * $unitPrice;
        }
        
        return $data;
    }

    public function getItemsByOrder($orderId)
    {
        return $this->where('order_id', $orderId)->findAll();
    }

    public function getItemsWithProduct($orderId)
    {
        $items = $this->where('order_id', $orderId)->findAll();
        
        $productModel = new \App\Models\ProductModel();
        foreach ($items as &$item) {
            $product = $productModel->find($item['product_id']);
            $item['product'] = $product;
        }
        
        return $items;
    }

    public function getTotalQuantityByOrder($orderId)
    {
        $result = $this->selectSum('quantity')
                      ->where('order_id', $orderId)
                      ->get()
                      ->getRow();
        
        return $result->quantity ?? 0;
    }

    public function getTotalAmountByOrder($orderId)
    {
        $result = $this->selectSum('total_price')
                      ->where('order_id', $orderId)
                      ->get()
                      ->getRow();
        
        return $result->total_price ?? 0;
    }
}