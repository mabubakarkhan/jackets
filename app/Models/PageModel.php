<?php

namespace App\Models;

use CodeIgniter\Model;

class PageModel extends Model
{
    protected $table = 'pages';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'title', 'slug', 'content', 'page_type', 'meta_title',
        'meta_description', 'meta_keywords', 'canonical_url', 'status', 'sort_order',
        'show_in_menu', 'show_in_footer', 'template'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'title' => 'required|min_length[2]|max_length[255]',
        'slug' => 'permit_empty|regex_match[/^[a-z0-9-]+$/]|max_length[255]',
        'content' => 'required'
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;
}
