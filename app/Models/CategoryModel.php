<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'parent_id', 'name', 'slug', 'description', 'image', 'meta_title',
        'meta_description', 'meta_keywords', 'canonical_url', 'sort_order', 'status', 'show_on_homepage'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[255]',
        'slug' => 'permit_empty|regex_match[/^[a-z0-9-]+$/]|max_length[255]'
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;
    
    /**
     * Get parent categories (categories without parent_id)
     */
    public function getParentCategories()
    {
        return $this->where('parent_id IS NULL')->findAll();
    }
    
    /**
     * Get subcategories of a specific parent
     */
    public function getSubcategories($parentId)
    {
        return $this->where('parent_id', $parentId)->findAll();
    }
    
    /**
     * Get category hierarchy
     */
    public function getCategoryHierarchy()
    {
        $categories = $this->findAll();
        $hierarchy = [];
        
        foreach ($categories as $category) {
            if ($category['parent_id'] === null) {
                $hierarchy[] = $category;
                $hierarchy[count($hierarchy) - 1]['children'] = $this->getSubcategories($category['id']);
            }
        }
        
        return $hierarchy;
    }
}
