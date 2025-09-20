<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'category_id', 'name', 'slug', 'sku', 'description', 'short_description',
        'price', 'sale_price', 'cost_price', 'stock_quantity', 'weight',
        'dimensions', 'featured', 'meta_title', 'meta_description', 'meta_keywords', 'canonical_url', 'status'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'category_id' => 'required|integer',
        'name' => 'required|min_length[3]|max_length[255]',
        'price' => 'required|decimal',
        'slug' => 'permit_empty|regex_match[/^[a-z0-9-]+$/]|max_length[255]'
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;
}
