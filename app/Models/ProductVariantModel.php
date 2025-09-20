<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductVariantModel extends Model
{
    protected $table = 'product_variants';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'product_id',
        'size_id',
        'color_id',
        'sku',
        'price',
        'sale_price',
        'stock_quantity',
        'weight',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = null;

    protected $validationRules = [
        'product_id' => 'required|numeric',
        'size_id' => 'permit_empty|numeric',
        'color_id' => 'permit_empty|numeric',
        'sku' => 'permit_empty|max_length[100]',
        'price' => 'permit_empty|decimal',
        'sale_price' => 'permit_empty|decimal',
        'stock_quantity' => 'permit_empty|numeric',
        'weight' => 'permit_empty|decimal',
        'status' => 'required|in_list[active,inactive]'
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function getProductVariants($productId)
    {
        return $this->select('product_variants.*, ps.name as size_name, pc.name as color_name, pc.hex_code')
                    ->join('product_sizes ps', 'ps.id = product_variants.size_id', 'left')
                    ->join('product_colors pc', 'pc.id = product_variants.color_id', 'left')
                    ->where('product_variants.product_id', $productId)
                    ->orderBy('product_variants.id', 'ASC')
                    ->findAll();
    }

    public function getVariantBySizeAndColor($productId, $sizeId = null, $colorId = null)
    {
        $builder = $this->where('product_id', $productId);
        
        if ($sizeId) {
            $builder->where('size_id', $sizeId);
        } else {
            $builder->where('size_id IS NULL');
        }
        
        if ($colorId) {
            $builder->where('color_id', $colorId);
        } else {
            $builder->where('color_id IS NULL');
        }
        
        return $builder->first();
    }
}
