<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\HomepageSectionModel;

class HomepageSections extends BaseController
{
    protected $homepageSectionModel;

    public function __construct()
    {
        // Check if admin is logged in
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $this->homepageSectionModel = new HomepageSectionModel();
    }

    public function index()
    {
        $sections = $this->homepageSectionModel->orderBy('sort_order', 'ASC')->findAll();

        $data = [
            'title' => 'Homepage Sections',
            'sections' => $sections
        ];

        return view('admin/homepage-sections/index', $data);
    }

    public function edit($id)
    {
        $section = $this->homepageSectionModel->find($id);
        
        if (!$section) {
            return redirect()->to(base_url('admin/homepage-sections'))->with('error', 'Section not found');
        }

        $data = [
            'title' => 'Edit Homepage Section',
            'section' => $section
        ];

        return view('admin/homepage-sections/edit', $data);
    }

    public function update($id)
    {
        // Check if admin is logged in
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        // Validation rules
        $rules = [
            'title' => 'required|min_length[2]|max_length[255]',
            'sort_order' => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            $section = $this->homepageSectionModel->find($id);
            $data = [
                'title' => 'Edit Homepage Section',
                'section' => $section,
                'validation' => $this->validator
            ];
            return view('admin/homepage-sections/edit', $data);
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'image_url' => $this->request->getPost('image_url'),
            'button_text' => $this->request->getPost('button_text'),
            'button_url' => $this->request->getPost('button_url'),
            'sort_order' => $this->request->getPost('sort_order') ?: 0,
            'status' => $this->request->getPost('status') ?: 'active',
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            $this->homepageSectionModel->update($id, $data);
            return redirect()->to(base_url('admin/homepage-sections'))->with('success', 'Section updated successfully');
        } catch (\Exception $e) {
            log_message('error', 'Homepage section update error: ' . $e->getMessage());
            return redirect()->to(base_url('admin/homepage-sections'))->with('error', 'Failed to update section: ' . $e->getMessage());
        }
    }
}
