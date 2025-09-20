<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CouponModel;

class Coupons extends BaseController
{
    protected $couponModel;

    public function __construct()
    {
        $this->couponModel = new CouponModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Coupons Management',
            'coupons' => $this->couponModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('admin/coupons/index', $this->getViewData($data));
    }

    public function create()
    {
        $data = [
            'title' => 'Create New Coupon'
        ];

        return view('admin/coupons/create', $this->getViewData($data));
    }

    public function store()
    {
        $rules = [
            'code' => 'required|max_length[50]|is_unique[coupons.code]',
            'name' => 'required|max_length[255]',
            'type' => 'required|in_list[percentage,fixed]',
            'value' => 'required|decimal',
            'minimum_amount' => 'decimal',
            'maximum_discount' => 'decimal',
            'usage_limit' => 'integer',
            'start_date' => 'required|valid_date',
            'end_date' => 'required|valid_date',
            'status' => 'in_list[active,inactive]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        $data = [
            'code' => strtoupper($this->request->getPost('code')),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'type' => $this->request->getPost('type'),
            'value' => $this->request->getPost('value'),
            'minimum_amount' => $this->request->getPost('minimum_amount') ?: 0,
            'maximum_discount' => $this->request->getPost('maximum_discount') ?: null,
            'usage_limit' => $this->request->getPost('usage_limit') ?: null,
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'status' => $this->request->getPost('status') ?: 'active'
        ];

        if ($this->couponModel->insert($data)) {
            return redirect()->to('admin/coupons')
                ->with('success', 'Coupon created successfully');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create coupon');
        }
    }

    public function edit($id)
    {
        $coupon = $this->couponModel->find($id);
        
        if (!$coupon) {
            return redirect()->to('admin/coupons')
                ->with('error', 'Coupon not found');
        }

        $data = [
            'title' => 'Edit Coupon',
            'coupon' => $coupon
        ];

        return view('admin/coupons/edit', $this->getViewData($data));
    }

    public function update($id)
    {
        $coupon = $this->couponModel->find($id);
        
        if (!$coupon) {
            return redirect()->to('admin/coupons')
                ->with('error', 'Coupon not found');
        }

        $rules = [
            'code' => "required|max_length[50]|is_unique[coupons.code,id,{$id}]",
            'name' => 'required|max_length[255]',
            'type' => 'required|in_list[percentage,fixed]',
            'value' => 'required|decimal',
            'minimum_amount' => 'decimal',
            'maximum_discount' => 'decimal',
            'usage_limit' => 'integer',
            'start_date' => 'required|valid_date',
            'end_date' => 'required|valid_date',
            'status' => 'in_list[active,inactive]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        $data = [
            'code' => strtoupper($this->request->getPost('code')),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'type' => $this->request->getPost('type'),
            'value' => $this->request->getPost('value'),
            'minimum_amount' => $this->request->getPost('minimum_amount') ?: 0,
            'maximum_discount' => $this->request->getPost('maximum_discount') ?: null,
            'usage_limit' => $this->request->getPost('usage_limit') ?: null,
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'status' => $this->request->getPost('status')
        ];

        if ($this->couponModel->update($id, $data)) {
            return redirect()->to('admin/coupons')
                ->with('success', 'Coupon updated successfully');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update coupon');
        }
    }

    public function delete($id)
    {
        $coupon = $this->couponModel->find($id);
        
        if (!$coupon) {
            return redirect()->to('admin/coupons')
                ->with('error', 'Coupon not found');
        }

        if ($this->couponModel->delete($id)) {
            return redirect()->to('admin/coupons')
                ->with('success', 'Coupon deleted successfully');
        } else {
            return redirect()->to('admin/coupons')
                ->with('error', 'Failed to delete coupon');
        }
    }

    public function toggleStatus($id)
    {
        $coupon = $this->couponModel->find($id);
        
        if (!$coupon) {
            return redirect()->to('admin/coupons')
                ->with('error', 'Coupon not found');
        }

        $newStatus = $coupon['status'] === 'active' ? 'inactive' : 'active';
        
        if ($this->couponModel->update($id, ['status' => $newStatus])) {
            $statusText = $newStatus === 'active' ? 'activated' : 'deactivated';
            return redirect()->to('admin/coupons')
                ->with('success', "Coupon {$statusText} successfully");
        } else {
            return redirect()->to('admin/coupons')
                ->with('error', 'Failed to update coupon status');
        }
    }
}
