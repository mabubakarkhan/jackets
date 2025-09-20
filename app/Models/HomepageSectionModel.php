<?php

namespace App\Models;

use CodeIgniter\Model;

class HomepageSectionModel extends Model
{
    protected $table = 'homepage_sections';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'section_key', 'title', 'content', 'image_url', 'button_text', 'button_url', 'sort_order', 'status'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'section_key' => 'required|is_unique[homepage_sections.section_key,id,{id}]',
        'title' => 'required|min_length[2]|max_length[255]',
        'sort_order' => 'permit_empty|integer'
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Get active sections ordered by sort_order
     */
    public function getActiveSections()
    {
        return $this->where('status', 'active')
                   ->orderBy('sort_order', 'ASC')
                   ->find();
    }

    /**
     * Get section by key
     */
    public function getSectionByKey($key)
    {
        return $this->where('section_key', $key)
                   ->where('status', 'active')
                   ->first();
    }
}
