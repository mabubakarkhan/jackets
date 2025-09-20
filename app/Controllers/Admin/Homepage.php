<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SliderModel;
use App\Models\HomepageSectionModel;
use App\Models\SettingModel;

class Homepage extends BaseController
{
    protected $sliderModel;
    protected $homepageSectionModel;
    protected $settingModel;

    public function __construct()
    {
        // Check if admin is logged in
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $this->sliderModel = new SliderModel();
        $this->homepageSectionModel = new HomepageSectionModel();
        $this->settingModel = new SettingModel();
    }

    public function index()
    {
        // Get all homepage data
        $sliders = $this->sliderModel->getActiveSliders();
        $sections = $this->homepageSectionModel->getActiveSections();
        
        // Get settings
        $settings = [];
        $allSettings = $this->settingModel->findAll();
        foreach ($allSettings as $setting) {
            $settings[$setting['setting_key']] = $setting['setting_value'];
        }

        $data = [
            'title' => 'Homepage Management',
            'sliders' => $sliders,
            'sections' => $sections,
            'settings' => $settings
        ];

        return view('admin/homepage/index', $data);
    }

    public function updateSettings()
    {
        // Check if admin is logged in
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $settings = [
            'site_name', 'site_description', 'site_email', 'site_phone', 'site_address',
            'facebook_url', 'instagram_url', 'twitter_url', 'whatsapp_number',
            'google_analytics', 'facebook_pixel', 'hero_image'
        ];

        foreach ($settings as $key) {
            $value = $this->request->getPost($key);
            if ($value !== null) {
                // Update or insert setting
                $existing = $this->settingModel->where('setting_key', $key)->first();
                if ($existing) {
                    $this->settingModel->update($existing['id'], ['setting_value' => $value]);
                } else {
                    $this->settingModel->insert([
                        'setting_key' => $key,
                        'setting_value' => $value,
                        'setting_type' => 'text'
                    ]);
                }
            }
        }

        return redirect()->to(base_url('admin/homepage'))->with('success', 'Homepage settings updated successfully');
    }
}
