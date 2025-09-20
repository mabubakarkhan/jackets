<?php

namespace App\Models;

use CodeIgniter\Model;

class SliderModel extends Model
{
    protected $table = 'sliders';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'title', 'subtitle', 'description', 'image', 'button_text', 'button_url', 'sort_order', 'status'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'title' => 'required|min_length[2]|max_length[255]',
        'sort_order' => 'permit_empty|integer'
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Get active sliders ordered by sort_order
     */
    public function getActiveSliders()
    {
        return $this->where('status', 'active')
                   ->orderBy('sort_order', 'ASC')
                   ->find();
    }

    /**
     * Get slider by ID
     */
    public function getSliderById($id)
    {
        return $this->find($id);
    }

    /**
     * Update slider sort order
     */
    public function updateSortOrder($id, $sortOrder)
    {
        return $this->update($id, ['sort_order' => $sortOrder]);
    }

    /**
     * Toggle slider status
     */
    public function toggleStatus($id)
    {
        $slider = $this->find($id);
        if ($slider) {
            $newStatus = $slider['status'] === 'active' ? 'inactive' : 'active';
            return $this->update($id, ['status' => $newStatus]);
        }
        return false;
    }
}
