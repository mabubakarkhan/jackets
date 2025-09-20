<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class Categories extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to(base_url('admin/login'));
        }

        $data['categories'] = $this->categoryModel->findAll();
        return view('admin/categories/index', $data);
    }

    public function create()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to(base_url('admin/login'));
        }

        // Get parent categories (categories without parent_id)
        $data['parent_categories'] = $this->categoryModel->where('parent_id IS NULL')->findAll();
        return view('admin/categories/create', $data);
    }

    public function store()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to(base_url('admin/login'));
        }

        // Validation rules
        $rules = [
            'name' => 'required|min_length[2]|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            // Get parent categories for error display
            $parent_categories = $this->categoryModel->where('parent_id IS NULL')->findAll();
            
            $data = [
                'parent_categories' => $parent_categories,
                'validation' => $this->validator
            ];
            
            return view('admin/categories/create', $data);
        }

        $data = [
            'parent_id' => $this->request->getPost('parent_id') ?: null,
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'slug' => $this->sanitizeSlug($this->request->getPost('slug') ?: $this->request->getPost('name')),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'canonical_url' => $this->request->getPost('canonical_url'),
            'status' => $this->request->getPost('status') ?: 'active',
            'sort_order' => $this->request->getPost('sort_order') ?: 0,
            'show_on_homepage' => $this->request->getPost('show_on_homepage') ? 1 : 0
        ];

        try {
            $this->categoryModel->insert($data);
            return redirect()->to(base_url('admin/categories'))->with('success', 'Category created successfully');
        } catch (\Exception $e) {
            log_message('error', 'Category store error: ' . $e->getMessage());
            
            // Get parent categories for error display
            $parent_categories = $this->categoryModel->where('parent_id IS NULL')->findAll();
            
            $data = [
                'parent_categories' => $parent_categories,
                'error' => 'Failed to create category: ' . $e->getMessage()
            ];
            
            return view('admin/categories/create', $data);
        }
    }

    public function edit($id)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to(base_url('admin/login'));
        }

        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->to(base_url('admin/categories'))->with('error', 'Category not found');
        }

        // Get parent categories (categories without parent_id, excluding current category)
        $parent_categories = $this->categoryModel->where('parent_id IS NULL')
                                               ->where('id !=', $id)
                                               ->findAll();

        $data = [
            'category' => $category,
            'parent_categories' => $parent_categories
        ];
        
        return view('admin/categories/edit', $data);
    }

    public function update($id)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to(base_url('admin/login'));
        }

        // Validation rules
        $rules = [
            'name' => 'required|min_length[2]|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            // Get category data for error display
            $category = $this->categoryModel->find($id);
            $parent_categories = $this->categoryModel->where('parent_id IS NULL')
                                                   ->where('id !=', $id)
                                                   ->findAll();

            $data = [
                'category' => $category,
                'parent_categories' => $parent_categories,
                'validation' => $this->validator
            ];

            return view('admin/categories/edit', $data);
        }

        $data = [
            'parent_id' => $this->request->getPost('parent_id') ?: null,
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'slug' => $this->sanitizeSlug($this->request->getPost('slug') ?: $this->request->getPost('name')),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'canonical_url' => $this->request->getPost('canonical_url'),
            'status' => $this->request->getPost('status') ?: 'active',
            'sort_order' => $this->request->getPost('sort_order') ?: 0,
            'show_on_homepage' => $this->request->getPost('show_on_homepage') ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->categoryModel->update($id, $data);
        return redirect()->to(base_url('admin/categories'))->with('success', 'Category updated successfully');
    }

    public function delete($id)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to(base_url('admin/login'));
        }

        $this->categoryModel->delete($id);
        return redirect()->to(base_url('admin/categories'))->with('success', 'Category deleted successfully');
    }

    /**
     * Sanitize slug to ensure it only contains valid URL characters
     */
    private function sanitizeSlug($slug)
    {
        return strtolower(trim(preg_replace('/[^a-zA-Z0-9-]+/', '-', $slug), '-'));
    }
}
