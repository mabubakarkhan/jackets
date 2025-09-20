<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SliderModel;

class Sliders extends BaseController
{
    protected $sliderModel;

    public function __construct()
    {
        // Check if admin is logged in
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $this->sliderModel = new SliderModel();
    }

    public function index()
    {
        $sliders = $this->sliderModel->orderBy('sort_order', 'ASC')->findAll();

        $data = [
            'title' => 'Slider Management',
            'sliders' => $sliders
        ];

        return view('admin/sliders/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create New Slider'
        ];

        return view('admin/sliders/create', $data);
    }

    public function store()
    {
        // Check if admin is logged in
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        // Validation rules
        $rules = [
            'title' => 'required|min_length[2]|max_length[255]',
            'image' => 'uploaded[image]|max_size[image,2048]|ext_in[image,jpg,jpeg,png,gif]',
            'sort_order' => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            $data = [
                'title' => 'Create New Slider',
                'validation' => $this->validator
            ];
            return view('admin/sliders/create', $data);
        }

        // Handle file upload
        $file = $this->request->getFile('image');
        $imageName = '';
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/sliders/', $imageName);
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'subtitle' => $this->request->getPost('subtitle'),
            'description' => $this->request->getPost('description'),
            'image' => $imageName,
            'button_text' => $this->request->getPost('button_text'),
            'button_url' => $this->request->getPost('button_url'),
            'sort_order' => $this->request->getPost('sort_order') ?: 0,
            'status' => $this->request->getPost('status') ?: 'active'
        ];

        try {
            $this->sliderModel->insert($data);
            return redirect()->to(base_url('admin/sliders'))->with('success', 'Slider created successfully');
        } catch (\Exception $e) {
            log_message('error', 'Slider store error: ' . $e->getMessage());
            return redirect()->to(base_url('admin/sliders/create'))->with('error', 'Failed to create slider: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $slider = $this->sliderModel->find($id);
        
        if (!$slider) {
            return redirect()->to(base_url('admin/sliders'))->with('error', 'Slider not found');
        }

        $data = [
            'title' => 'Edit Slider',
            'slider' => $slider
        ];

        return view('admin/sliders/edit', $data);
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

        // Add image validation only if new image is uploaded
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $rules['image'] = 'uploaded[image]|max_size[image,2048]|ext_in[image,jpg,jpeg,png,gif]';
        }

        if (!$this->validate($rules)) {
            $slider = $this->sliderModel->find($id);
            $data = [
                'title' => 'Edit Slider',
                'slider' => $slider,
                'validation' => $this->validator
            ];
            return view('admin/sliders/edit', $data);
        }

        // Handle file upload
        $imageName = $slider['image']; // Keep existing image by default
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Delete old image if exists
            if (!empty($slider['image']) && file_exists(ROOTPATH . 'public/uploads/sliders/' . $slider['image'])) {
                unlink(ROOTPATH . 'public/uploads/sliders/' . $slider['image']);
            }
            
            $imageName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/sliders/', $imageName);
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'subtitle' => $this->request->getPost('subtitle'),
            'description' => $this->request->getPost('description'),
            'image' => $imageName,
            'button_text' => $this->request->getPost('button_text'),
            'button_url' => $this->request->getPost('button_url'),
            'sort_order' => $this->request->getPost('sort_order') ?: 0,
            'status' => $this->request->getPost('status') ?: 'active'
        ];

        try {
            $this->sliderModel->update($id, $data);
            return redirect()->to(base_url('admin/sliders'))->with('success', 'Slider updated successfully');
        } catch (\Exception $e) {
            log_message('error', 'Slider update error: ' . $e->getMessage());
            return redirect()->to(base_url('admin/sliders/edit/' . $id))->with('error', 'Failed to update slider: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        // Check if admin is logged in
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        try {
            $this->sliderModel->delete($id);
            return redirect()->to(base_url('admin/sliders'))->with('success', 'Slider deleted successfully');
        } catch (\Exception $e) {
            log_message('error', 'Slider delete error: ' . $e->getMessage());
            return redirect()->to(base_url('admin/sliders'))->with('error', 'Failed to delete slider: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        // Check if admin is logged in
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        try {
            $this->sliderModel->toggleStatus($id);
            return redirect()->to(base_url('admin/sliders'))->with('success', 'Slider status updated successfully');
        } catch (\Exception $e) {
            log_message('error', 'Slider toggle status error: ' . $e->getMessage());
            return redirect()->to(base_url('admin/sliders'))->with('error', 'Failed to update slider status: ' . $e->getMessage());
        }
    }
}
