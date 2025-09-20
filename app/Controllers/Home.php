<?php

namespace App\Controllers;

use App\Models\SettingModel;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\ProductImageModel;
use App\Models\SliderModel;

class Home extends BaseController
{
    protected $settingModel;
    protected $categoryModel;
    protected $productModel;
    protected $productImageModel;
    protected $sliderModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
        $this->productImageModel = new ProductImageModel();
        $this->sliderModel = new SliderModel();
    }

    public function index()
    {

        // Get featured products with images
        $featuredProducts = $this->productModel->where('featured', 1)
                                              ->where('status', 'active')
                                              ->limit(8)
                                              ->find();

        // Get hot selling products with images
        $hotSellingProducts = $this->productModel->where('hot_selling', 1)
                                                ->where('status', 'active')
                                                ->limit(8)
                                                ->find();

        // Get hot products (products with high sales or views - for now using hot_selling as hot products)
        $hotProducts = $this->productModel->where('hot_selling', 1)
                                         ->where('status', 'active')
                                         ->limit(8)
                                         ->find();

        // Get product images for featured products
        foreach ($featuredProducts as &$product) {
            $product['images'] = $this->productImageModel->where('product_id', $product['id'])
                                                        ->orderBy('is_primary', 'DESC')
                                                        ->orderBy('sort_order', 'ASC')
                                                        ->find();
        }

        // Get product images for hot selling products
        foreach ($hotSellingProducts as &$product) {
            $product['images'] = $this->productImageModel->where('product_id', $product['id'])
                                                        ->orderBy('is_primary', 'DESC')
                                                        ->orderBy('sort_order', 'ASC')
                                                        ->find();
        }

        // Get product images for hot products
        foreach ($hotProducts as &$product) {
            $product['images'] = $this->productImageModel->where('product_id', $product['id'])
                                                        ->orderBy('is_primary', 'DESC')
                                                        ->orderBy('sort_order', 'ASC')
                                                        ->find();
        }

        // Get categories that should show on homepage
        $categories = $this->categoryModel->where('status', 'active')
                                         ->where('show_on_homepage', 1)
                                         ->orderBy('sort_order', 'ASC')
                                         ->find();

        // Get active sliders
        $sliders = $this->sliderModel->getActiveSliders();

        $data = [
            'meta_title' => $this->settings['site_name'] ?? 'Jacket Store - Premium Quality Jackets and Outerwear',
            'meta_description' => $this->settings['site_description'] ?? 'Discover our premium collection of stylish and comfortable jackets for men and women. Shop the latest trends in outerwear.',
            'meta_keywords' => 'jackets, outerwear, men jackets, women jackets, leather jackets, winter coats, premium jackets',
            'featured_products' => $featuredProducts,
            'hot_selling_products' => $hotSellingProducts,
            'hot_products' => $hotProducts,
            'categories' => $categories,
            'sliders' => $sliders
        ];

        return view('landing', $this->getViewData($data));
    }
}
