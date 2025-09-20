<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PageModel;

class Pages extends BaseController
{
    protected $pageModel;

    public function __construct()
    {
        $this->pageModel = new PageModel();
    }

    public function index()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to(base_url('admin/login'));
        }

        try {
            $data['pages'] = $this->pageModel->findAll();
            return view('admin/pages/index', $data);
        } catch (\Exception $e) {
            log_message('error', 'Pages index error: ' . $e->getMessage());
            return view('admin/pages/index', ['pages' => []]);
        }
    }

    public function create()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to(base_url('admin/login'));
        }

        return view('admin/pages/create');
    }

    public function store()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to(base_url('admin/login'));
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'slug' => $this->sanitizeSlug($this->request->getPost('slug') ?: $this->request->getPost('title')),
            'page_type' => $this->request->getPost('page_type') ?: 'static',
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'canonical_url' => $this->request->getPost('canonical_url'),
            'status' => $this->request->getPost('status') ?: 'published',
            'sort_order' => $this->request->getPost('sort_order') ?: 0
        ];
        
        // Add sidebar fields only if they exist in database
        if ($this->request->getPost('show_in_menu') !== null) {
            $data['show_in_menu'] = $this->request->getPost('show_in_menu') ? 1 : 0;
        }
        if ($this->request->getPost('show_in_footer') !== null) {
            $data['show_in_footer'] = $this->request->getPost('show_in_footer') ? 1 : 0;
        }
        if ($this->request->getPost('template') !== null) {
            $data['template'] = $this->request->getPost('template') ?: 'default';
        }

        try {
            $this->pageModel->insert($data);
            return redirect()->to(base_url('admin/pages'))->with('success', 'Page created successfully');
        } catch (\Exception $e) {
            log_message('error', 'Page store error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create page: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to(base_url('admin/login'));
        }

        try {
            $page = $this->pageModel->find($id);
            if (!$page) {
                return redirect()->to(base_url('admin/pages'))->with('error', 'Page not found');
            }
            $data['page'] = $page;
            return view('admin/pages/edit', $data);
        } catch (\Exception $e) {
            log_message('error', 'Pages edit error: ' . $e->getMessage());
            return redirect()->to(base_url('admin/pages'))->with('error', 'Error loading page: ' . $e->getMessage());
        }
    }

    public function update($id)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to(base_url('admin/login'));
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'slug' => $this->sanitizeSlug($this->request->getPost('slug') ?: $this->request->getPost('title')),
            'page_type' => $this->request->getPost('page_type') ?: 'static',
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'canonical_url' => $this->request->getPost('canonical_url'),
            'status' => $this->request->getPost('status') ?: 'published',
            'sort_order' => $this->request->getPost('sort_order') ?: 0
        ];
        
        // Add sidebar fields only if they exist in database
        if ($this->request->getPost('show_in_menu') !== null) {
            $data['show_in_menu'] = $this->request->getPost('show_in_menu') ? 1 : 0;
        }
        if ($this->request->getPost('show_in_footer') !== null) {
            $data['show_in_footer'] = $this->request->getPost('show_in_footer') ? 1 : 0;
        }
        if ($this->request->getPost('template') !== null) {
            $data['template'] = $this->request->getPost('template') ?: 'default';
        }

        try {
            $this->pageModel->update($id, $data);
            return redirect()->to(base_url('admin/pages'))->with('success', 'Page updated successfully');
        } catch (\Exception $e) {
            log_message('error', 'Page update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update page: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to(base_url('admin/login'));
        }

        try {
            $page = $this->pageModel->find($id);
            if (!$page) {
                return redirect()->to(base_url('admin/pages'))->with('error', 'Page not found');
            }
            
            // Prevent deletion of static pages
            if ($page['page_type'] === 'static') {
                return redirect()->to(base_url('admin/pages'))->with('error', 'Cannot delete static pages');
            }
            
            $this->pageModel->delete($id);
            return redirect()->to(base_url('admin/pages'))->with('success', 'Page deleted successfully');
        } catch (\Exception $e) {
            log_message('error', 'Pages delete error: ' . $e->getMessage());
            return redirect()->to(base_url('admin/pages'))->with('error', 'Failed to delete page: ' . $e->getMessage());
        }
    }

    /**
     * Sanitize slug to ensure it only contains valid URL characters
     */
    private function sanitizeSlug($slug)
    {
        return strtolower(trim(preg_replace('/[^a-zA-Z0-9-]+/', '-', $slug), '-'));
    }
}
