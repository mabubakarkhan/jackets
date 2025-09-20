<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductImageModel;

class Search extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $productImageModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->productImageModel = new ProductImageModel();
    }

    public function index()
    {
        $query = $this->request->getGet('q');
        $page = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 12;
        $offset = ($page - 1) * $perPage;

        $products = [];
        $totalProducts = 0;
        $categories = [];

        if (!empty($query)) {
            // Search products
            $products = $this->productModel->like('name', $query)
                ->orLike('description', $query)
                ->orLike('short_description', $query)
                ->where('status', 'active')
                ->findAll($perPage, $offset);

            $totalProducts = $this->productModel->like('name', $query)
                ->orLike('description', $query)
                ->orLike('short_description', $query)
                ->where('status', 'active')
                ->countAllResults();

            // Search categories
            $categories = $this->categoryModel->like('name', $query)
                ->orLike('description', $query)
                ->where('status', 'active')
                ->findAll();

            // Get product images
            foreach ($products as &$product) {
                $product['images'] = $this->productImageModel->where('product_id', $product['id'])
                    ->orderBy('is_primary', 'DESC')
                    ->orderBy('sort_order', 'ASC')
                    ->find();
            }
        }

        $data = [
            'title' => 'Search Results',
            'meta_title' => 'Search Results - ' . ($query ?: 'Search'),
            'meta_description' => 'Search results for: ' . ($query ?: 'Search'),
            'query' => $query,
            'products' => $products,
            'categories' => $categories,
            'totalProducts' => $totalProducts,
            'currentPage' => $page,
            'perPage' => $perPage,
            'totalPages' => ceil($totalProducts / $perPage)
        ];

        return view('search/index', $this->getViewData($data));
    }
}
