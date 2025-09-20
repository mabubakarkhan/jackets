<?php

namespace App\Models;

use CodeIgniter\Model;

class CouponModel extends Model
{
    protected $table = 'coupons';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'code', 'name', 'description', 'type', 'value', 'minimum_amount', 
        'maximum_discount', 'usage_limit', 'used_count', 'start_date', 
        'end_date', 'status'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'code' => 'required|max_length[50]|is_unique[coupons.code,id,{id}]',
        'name' => 'required|max_length[255]',
        'type' => 'required|in_list[percentage,fixed]',
        'value' => 'required|decimal',
        'minimum_amount' => 'decimal',
        'maximum_discount' => 'decimal',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
        'start_date' => 'required|valid_date',
        'end_date' => 'required|valid_date',
        'status' => 'in_list[active,inactive]'
    ];

    protected $validationMessages = [
        'code' => [
            'required' => 'Coupon code is required',
            'is_unique' => 'This coupon code already exists'
        ],
        'name' => [
            'required' => 'Coupon name is required'
        ],
        'type' => [
            'required' => 'Coupon type is required',
            'in_list' => 'Coupon type must be percentage or fixed'
        ],
        'value' => [
            'required' => 'Coupon value is required',
            'decimal' => 'Coupon value must be a valid decimal'
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
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    public function getActiveCoupons()
    {
        return $this->where('status', 'active')
                    ->where('start_date <=', date('Y-m-d H:i:s'))
                    ->where('end_date >=', date('Y-m-d H:i:s'))
                    ->findAll();
    }

    public function getCouponByCode($code)
    {
        return $this->where('code', $code)
                    ->where('status', 'active')
                    ->where('start_date <=', date('Y-m-d H:i:s'))
                    ->where('end_date >=', date('Y-m-d H:i:s'))
                    ->first();
    }

    public function validateCoupon($code, $cartTotal)
    {
        $coupon = $this->getCouponByCode($code);
        
        if (!$coupon) {
            return ['valid' => false, 'message' => 'Invalid coupon code'];
        }

        // Check if coupon has reached usage limit
        if ($coupon['usage_limit'] && $coupon['used_count'] >= $coupon['usage_limit']) {
            return ['valid' => false, 'message' => 'Coupon has reached its usage limit'];
        }

        // Check minimum amount
        if ($coupon['minimum_amount'] > 0 && $cartTotal < $coupon['minimum_amount']) {
            return ['valid' => false, 'message' => 'Minimum order amount not met'];
        }

        return ['valid' => true, 'coupon' => $coupon];
    }

    public function calculateDiscount($coupon, $cartTotal)
    {
        $discount = 0;
        
        if ($coupon['type'] === 'percentage') {
            $discount = ($cartTotal * $coupon['value']) / 100;
            
            // Apply maximum discount limit if set
            if ($coupon['maximum_discount'] && $discount > $coupon['maximum_discount']) {
                $discount = $coupon['maximum_discount'];
            }
        } else {
            $discount = $coupon['value'];
        }

        // Ensure discount doesn't exceed cart total
        return min($discount, $cartTotal);
    }

    public function incrementUsage($couponId)
    {
        $this->set('used_count', 'used_count + 1', false)
             ->where('id', $couponId)
             ->update();
    }
}
