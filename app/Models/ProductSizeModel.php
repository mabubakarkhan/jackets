<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductSizeModel extends Model
{
    protected $table = 'product_sizes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'name',
        'slug',
        'sort_order',
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
        'name' => 'required|min_length[1]|max_length[50]',
        'slug' => 'required|min_length[1]|max_length[50]',
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

    public function getActiveSizes()
    {
        return $this->where('status', 'active')->orderBy('sort_order', 'ASC')->findAll();
    }
}
