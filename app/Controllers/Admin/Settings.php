<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class Settings extends BaseController
{
    protected $settingModel;

    public function __construct()
    {
        // Check if admin is logged in
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $this->settingModel = new SettingModel();
    }

    public function index()
    {
        $settings = [];
        $allSettings = $this->settingModel->findAll();
        
        foreach ($allSettings as $setting) {
            $settings[$setting['setting_key']] = $setting['setting_value'];
        }

        $data = [
            'title' => 'Site Settings',
            'settings' => $settings
        ];

        return view('admin/settings/index', $data);
    }

    public function update()
    {
        $settings = [
            'site_name', 'site_description', 'site_email', 'site_phone', 'site_address',
            'facebook_url', 'instagram_url', 'twitter_url', 'whatsapp_number',
            'google_analytics', 'facebook_pixel', 'hero_image'
        ];

        foreach ($settings as $key) {
            $value = $this->request->getPost($key);
            if ($value !== null) {
                $this->settingModel->where('setting_key', $key)->set(['setting_value' => $value])->update();
            }
        }

        session()->setFlashdata('success', 'Settings updated successfully');
        return redirect()->back();
    }
}
