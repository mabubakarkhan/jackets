<?php

namespace App\Controllers;

use App\Models\PageModel;
use App\Models\SettingModel;

class Page extends BaseController
{
    protected $pageModel;
    protected $settingModel;

    public function __construct()
    {
        $this->pageModel = new PageModel();
        $this->settingModel = new SettingModel();
    }

    public function show($slug)
    {
        $page = $this->pageModel->where('slug', $slug)
                                ->where('status', 'published')
                                ->first();

        if (!$page) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Page not found');
        }

        $data = [
            'meta_title' => $page['meta_title'] ?? $page['title'],
            'meta_description' => $page['meta_description'] ?? '',
            'meta_keywords' => $page['meta_keywords'] ?? '',
            'page' => $page
        ];

        return view('page/show', $this->getViewData($data));
    }
}
