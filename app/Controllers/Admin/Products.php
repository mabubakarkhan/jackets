<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductImageModel;

class Products extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $productImageModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->productImageModel = new ProductImageModel();
        $this->productSizeModel = new \App\Models\ProductSizeModel();
        $this->productColorModel = new \App\Models\ProductColorModel();
        $this->productVariantModel = new \App\Models\ProductVariantModel();
    }

    public function index()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $data['products'] = $this->productModel->findAll();
        return view('admin/products/index', $data);
    }

    public function create()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $data = [
            'title' => 'Create Product',
            'categories' => $this->categoryModel->findAll(),
            'sizes' => $this->productSizeModel->getActiveSizes(),
            'colors' => $this->productColorModel->getActiveColors()
        ];
        
        return view('admin/products/create', $data);
    }

    public function store()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        // Validation rules
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'price' => 'required|numeric|greater_than[0]',
            'category_id' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            $data = [
                'title' => 'Create Product',
                'categories' => $this->categoryModel->findAll(),
                'sizes' => $this->productSizeModel->getActiveSizes(),
                'colors' => $this->productColorModel->getActiveColors(),
                'validation' => $this->validator
            ];
            return view('admin/products/create', $data);
        }

        try {
            // Prepare data
            $name = $this->request->getPost('name');
            $slug = $this->sanitizeSlug($this->request->getPost('slug') ?: $name); // Use provided slug or generate from name
            
            $data = [
                'name' => $name,
                'slug' => $slug,
                'description' => $this->request->getPost('description'),
                'price' => $this->request->getPost('price'),
                'sale_price' => $this->request->getPost('sale_price') ?: null,
                'cost_price' => null, // Set to null for now
                'stock_quantity' => $this->request->getPost('stock_quantity') ?: 0,
                'sku' => $this->request->getPost('sku') ?: 'SKU-' . time(), // Use provided SKU or generate
                'weight' => null, // Set to null for now
                'dimensions' => null, // Set to null for now
                'category_id' => $this->request->getPost('category_id'),
                'status' => $this->request->getPost('status') ?: 'active',
                'featured' => $this->request->getPost('featured') ? 1 : 0,
                'hot_selling' => $this->request->getPost('hot_selling') ? 1 : 0,
                'meta_title' => $this->request->getPost('meta_title'),
                'meta_description' => $this->request->getPost('meta_description'),
                'meta_keywords' => $this->request->getPost('meta_keywords'),
                'canonical_url' => $this->request->getPost('canonical_url'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            // Log the data being inserted for debugging
            log_message('info', 'Product data to insert: ' . json_encode($data));

            // Note: Main image will be handled after product creation
            // since there's no main_image column in products table

            // Insert product
            $productId = $this->productModel->insert($data);
            
            // Log the result
            log_message('info', 'Product insert result: ' . ($productId ? 'Success - ID: ' . $productId : 'Failed'));
            
            // Check for database errors
            if ($this->productModel->errors()) {
                $errorMessage = 'Database error: ' . implode(', ', $this->productModel->errors());
                log_message('error', $errorMessage);
                $data = [
                    'title' => 'Create Product',
                    'categories' => $this->categoryModel->findAll(),
                    'error' => $errorMessage
                ];
                return view('admin/products/create', $data);
            }
            
            if ($productId) {
                $sortOrder = 1;
                
                // Handle main image first
                $mainImage = $this->request->getFile('main_image');
                if ($mainImage && $mainImage->isValid() && !$mainImage->hasMoved()) {
                    $newName = $mainImage->getRandomName();
                    if ($mainImage->move(ROOTPATH . 'public/uploads/products', $newName)) {
                        // Insert main image as primary
                        $imageData = [
                            'product_id' => $productId,
                            'image_path' => $newName, // Only save filename, not full path
                            'alt_text' => $name . ' - Main Image',
                            'sort_order' => $sortOrder,
                            'is_primary' => 1, // Main image is primary
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                        
                        log_message('info', 'Main image data to insert: ' . json_encode($imageData));
                        
                        // Use direct database insert to avoid model issues
                        $db = \Config\Database::connect();
                        $sql = "INSERT INTO product_images (product_id, image_path, alt_text, sort_order, is_primary, created_at) VALUES (?, ?, ?, ?, ?, ?)";
                        $result = $db->query($sql, [
                            $imageData['product_id'],
                            $imageData['image_path'],
                            $imageData['alt_text'],
                            $imageData['sort_order'],
                            $imageData['is_primary'],
                            $imageData['created_at']
                        ]);
                        
                        if ($result) {
                            $imageId = $db->insertID();
                            log_message('info', 'Main image uploaded successfully: ' . $newName . ' (ID: ' . $imageId . ')');
                        } else {
                            log_message('error', 'Failed to insert main image using direct query');
                        }
                        $sortOrder++;
                    } else {
                        log_message('error', 'Failed to move main image: ' . $mainImage->getErrorString());
                    }
                }
                
                // Handle additional images
                $additionalImages = $this->request->getFileMultiple('additional_images');
                log_message('info', 'Additional images count: ' . count($additionalImages));
                if ($additionalImages) {
                    foreach ($additionalImages as $image) {
                        if ($image && $image->isValid() && !$image->hasMoved()) {
                            $newName = $image->getRandomName();
                            if ($image->move(ROOTPATH . 'public/uploads/products', $newName)) {
                                // Insert into product_images table
                                $imageData = [
                                    'product_id' => $productId,
                                    'image_path' => $newName, // Only save filename, not full path
                                    'alt_text' => $name . ' - Image ' . $sortOrder,
                                    'sort_order' => $sortOrder,
                                    'is_primary' => 0, // Additional images are not primary
                                    'created_at' => date('Y-m-d H:i:s')
                                ];
                                
                                log_message('info', 'Additional image data to insert: ' . json_encode($imageData));
                                
                                // Use direct database insert to avoid model issues
                                $db = \Config\Database::connect();
                                $sql = "INSERT INTO product_images (product_id, image_path, alt_text, sort_order, is_primary, created_at) VALUES (?, ?, ?, ?, ?, ?)";
                                $result = $db->query($sql, [
                                    $imageData['product_id'],
                                    $imageData['image_path'],
                                    $imageData['alt_text'],
                                    $imageData['sort_order'],
                                    $imageData['is_primary'],
                                    $imageData['created_at']
                                ]);
                                
                                if ($result) {
                                    $imageId = $db->insertID();
                                    log_message('info', 'Additional image uploaded successfully: ' . $newName . ' (ID: ' . $imageId . ')');
                                } else {
                                    log_message('error', 'Failed to insert additional image using direct query');
                                }
                                $sortOrder++;
                            } else {
                                log_message('error', 'Failed to move uploaded image: ' . $image->getErrorString());
                            }
                        }
                    }
                }
                
                // Handle product variants (sizes and colors)
                $this->handleProductVariants($productId);
                
                return redirect()->to('/admin/products')->with('success', 'Product created successfully');
            } else {
                $data = [
                    'title' => 'Create Product',
                    'categories' => $this->categoryModel->findAll(),
                    'sizes' => $this->productSizeModel->getActiveSizes(),
                    'colors' => $this->productColorModel->getActiveColors(),
                    'error' => 'Failed to create product. Please try again.'
                ];
                return view('admin/products/create', $data);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Product creation failed: ' . $e->getMessage());
            $data = [
                'title' => 'Create Product',
                'categories' => $this->categoryModel->findAll(),
                'sizes' => $this->productSizeModel->getActiveSizes(),
                'colors' => $this->productColorModel->getActiveColors(),
                'error' => 'An error occurred while creating the product: ' . $e->getMessage()
            ];
            return view('admin/products/create', $data);
        }
    }

    public function edit($id)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        try {
            $product = $this->productModel->find($id);
            
            if (!$product) {
                return redirect()->to('/admin/products')->with('error', 'Product not found.');
            }
            
            // Fetch existing product images
            $db = \Config\Database::connect();
            $existingImages = $db->query("SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order ASC", [$id])->getResultArray();
            
            // Fetch existing product variants
            $existingVariants = $this->productVariantModel->getProductVariants($id);
            
            $data = [
                'title' => 'Edit Product',
                'product' => $product,
                'categories' => $this->categoryModel->findAll(),
                'sizes' => $this->productSizeModel->getActiveSizes(),
                'colors' => $this->productColorModel->getActiveColors(),
                'existing_images' => $existingImages,
                'existing_variants' => $existingVariants
            ];
            
            return view('admin/products/edit', $data);
            
        } catch (\Exception $e) {
            log_message('error', 'Error in edit method: ' . $e->getMessage());
            return redirect()->to('/admin/products')->with('error', 'An error occurred while loading the product.');
        }
    }

    public function update($id)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        // Validation rules
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'price' => 'required|numeric|greater_than[0]',
            'category_id' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            // Get product data for error display
            $product = $this->productModel->find($id);
            $existingImages = [];
            $existingVariants = [];
            
            if ($product) {
                $db = \Config\Database::connect();
                $existingImages = $db->query("SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order ASC", [$id])->getResultArray();
                $existingVariants = $this->productVariantModel->getProductVariants($id);
            }
            
            $data = [
                'title' => 'Edit Product',
                'product' => $product,
                'categories' => $this->categoryModel->findAll(),
                'sizes' => $this->productSizeModel->getActiveSizes(),
                'colors' => $this->productColorModel->getActiveColors(),
                'existing_images' => $existingImages,
                'existing_variants' => $existingVariants,
                'validation' => $this->validator
            ];
            
            return view('admin/products/edit', $data);
        }

        try {
            $name = $this->request->getPost('name');
            $slug = $this->sanitizeSlug($this->request->getPost('slug') ?: $name);
            
            // Debug logging
            log_message('info', 'Update product - Name: ' . $name);
            log_message('info', 'Update product - Slug: ' . $slug);
            log_message('info', 'Update product - All POST data: ' . json_encode($this->request->getPost()));
            
            $data = [
                'name' => $name,
                'slug' => $slug,
                'description' => $this->request->getPost('description'),
                'price' => $this->request->getPost('price'),
                'sale_price' => $this->request->getPost('sale_price') ?: null,
                'stock_quantity' => $this->request->getPost('stock_quantity') ?: 0,
                'sku' => $this->request->getPost('sku') ?: null,
                'category_id' => $this->request->getPost('category_id'),
                'status' => $this->request->getPost('status') ?: 'active',
                'featured' => $this->request->getPost('featured') ? 1 : 0,
                'hot_selling' => $this->request->getPost('hot_selling') ? 1 : 0,
                'meta_title' => $this->request->getPost('meta_title'),
                'meta_description' => $this->request->getPost('meta_description'),
                'meta_keywords' => $this->request->getPost('meta_keywords'),
                'canonical_url' => $this->request->getPost('canonical_url'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->productModel->update($id, $data);
            
            // Handle new image uploads
            $db = \Config\Database::connect();
            
            // Get current max sort order for this product
            $maxSortOrder = $db->query("SELECT MAX(sort_order) as max_order FROM product_images WHERE product_id = ?", [$id])->getRowArray();
            $sortOrder = ($maxSortOrder['max_order'] ?? 0) + 1;
            
            // Handle new main image
            $mainImage = $this->request->getFile('main_image');
            if ($mainImage && $mainImage->isValid() && !$mainImage->hasMoved()) {
                $newName = $mainImage->getRandomName();
                if ($mainImage->move(ROOTPATH . 'public/uploads/products', $newName)) {
                    // Insert new main image
                    $imageData = [
                        'product_id' => $id,
                        'image_path' => $newName,
                        'alt_text' => $name . ' - Main Image',
                        'sort_order' => $sortOrder,
                        'is_primary' => 1,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    
                    $db->query("INSERT INTO product_images (product_id, image_path, alt_text, sort_order, is_primary, created_at) VALUES (?, ?, ?, ?, ?, ?)", [
                        $imageData['product_id'],
                        $imageData['image_path'],
                        $imageData['alt_text'],
                        $imageData['sort_order'],
                        $imageData['is_primary'],
                        $imageData['created_at']
                    ]);
                    $sortOrder++;
                }
            }
            
            // Handle new additional images
            $additionalImages = $this->request->getFileMultiple('additional_images');
            if ($additionalImages) {
                foreach ($additionalImages as $image) {
                    if ($image && $image->isValid() && !$image->hasMoved()) {
                        $newName = $image->getRandomName();
                        if ($image->move(ROOTPATH . 'public/uploads/products', $newName)) {
                            // Insert new additional image
                            $imageData = [
                                'product_id' => $id,
                                'image_path' => $newName,
                                'alt_text' => $name . ' - Image ' . $sortOrder,
                                'sort_order' => $sortOrder,
                                'is_primary' => 0,
                                'created_at' => date('Y-m-d H:i:s')
                            ];
                            
                            $db->query("INSERT INTO product_images (product_id, image_path, alt_text, sort_order, is_primary, created_at) VALUES (?, ?, ?, ?, ?, ?)", [
                                $imageData['product_id'],
                                $imageData['image_path'],
                                $imageData['alt_text'],
                                $imageData['sort_order'],
                                $imageData['is_primary'],
                                $imageData['created_at']
                            ]);
                            $sortOrder++;
                        }
                    }
                }
            }
            
            // Handle product variants update
            $this->updateProductVariants($id);
            
            return redirect()->to('/admin/products')->with('success', 'Product updated successfully');
            
        } catch (\Exception $e) {
            log_message('error', 'Product update failed: ' . $e->getMessage());
            
            // Get product data for error display
            $product = $this->productModel->find($id);
            $existingImages = [];
            $existingVariants = [];
            
            if ($product) {
                $db = \Config\Database::connect();
                $existingImages = $db->query("SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order ASC", [$id])->getResultArray();
                $existingVariants = $this->productVariantModel->getProductVariants($id);
            }
            
            $data = [
                'title' => 'Edit Product',
                'product' => $product,
                'categories' => $this->categoryModel->findAll(),
                'sizes' => $this->productSizeModel->getActiveSizes(),
                'colors' => $this->productColorModel->getActiveColors(),
                'existing_images' => $existingImages,
                'existing_variants' => $existingVariants,
                'error' => 'An error occurred while updating the product: ' . $e->getMessage()
            ];
            
            return view('admin/products/edit', $data);
        }
    }

    public function delete($id)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        try {
            $this->productModel->delete($id);
            return redirect()->to('/admin/products')->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            log_message('error', 'Product deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting the product.');
        }
    }

    public function deleteImage()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        try {
            $imageId = $this->request->getPost('image_id');
            $productId = $this->request->getPost('product_id');
            
            if (!$imageId || !$productId) {
                return redirect()->back()->with('error', 'Invalid image or product ID.');
            }
            
            // Get image info before deleting
            $db = \Config\Database::connect();
            $image = $db->query("SELECT * FROM product_images WHERE id = ? AND product_id = ?", [$imageId, $productId])->getRowArray();
            
            if (!$image) {
                return redirect()->back()->with('error', 'Image not found.');
            }
            
            // Delete from database
            $db->query("DELETE FROM product_images WHERE id = ?", [$imageId]);
            
            // Delete physical file
            $filePath = ROOTPATH . 'public/uploads/products/' . $image['image_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
                log_message('info', 'Deleted image file: ' . $filePath);
            } else {
                log_message('warning', 'Image file not found: ' . $filePath);
            }
            
            return redirect()->back()->with('success', 'Image deleted successfully.');
            
        } catch (\Exception $e) {
            log_message('error', 'Image deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting the image.');
        }
    }

    private function handleProductVariants($productId)
    {
        try {
            $sizes = $this->request->getPost('sizes');
            $colors = $this->request->getPost('colors');
            
            // Debug logging
            log_message('info', 'Create variants - Sizes: ' . json_encode($sizes));
            log_message('info', 'Create variants - Colors: ' . json_encode($colors));
            
            // If no sizes or colors selected, create a default variant
            if (empty($sizes) && empty($colors)) {
                $variantData = [
                    'product_id' => $productId,
                    'size_id' => null,
                    'color_id' => null,
                    'sku' => $this->request->getPost('sku') ?: 'SKU-' . $productId . '-' . time(),
                    'price' => $this->request->getPost('price'),
                    'sale_price' => $this->request->getPost('sale_price') ?: null,
                    'stock_quantity' => $this->request->getPost('stock_quantity') ?: 0,
                    'weight' => null,
                    'status' => 'active',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                
                $this->productVariantModel->insert($variantData);
                return;
            }
            
            // Create variants for each size and color combination
            if (empty($sizes)) $sizes = [null];
            if (empty($colors)) $colors = [null];
            
            foreach ($sizes as $sizeId) {
                foreach ($colors as $colorId) {
                    $variantData = [
                        'product_id' => $productId,
                        'size_id' => $sizeId ?: null,
                        'color_id' => $colorId ?: null,
                        'sku' => $this->generateVariantSku($productId, $sizeId, $colorId),
                        'price' => $this->request->getPost('price'),
                        'sale_price' => $this->request->getPost('sale_price') ?: null,
                        'stock_quantity' => $this->request->getPost('stock_quantity') ?: 0,
                        'weight' => null,
                        'status' => 'active',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    
                    $this->productVariantModel->insert($variantData);
                }
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Error handling product variants: ' . $e->getMessage());
        }
    }
    
    private function generateVariantSku($productId, $sizeId, $colorId)
    {
        $sku = 'SKU-' . $productId;
        
        if ($sizeId) {
            $size = $this->productSizeModel->find($sizeId);
            if ($size) {
                $sku .= '-' . strtoupper($size['slug']);
            }
        }
        
        if ($colorId) {
            $color = $this->productColorModel->find($colorId);
            if ($color) {
                $sku .= '-' . strtoupper($color['slug']);
            }
        }
        
        return $sku;
    }

    private function updateProductVariants($productId)
    {
        try {
            // Get variant pricing data
            $variantPrices = $this->request->getPost('variant_price') ?: [];
            $variantSalePrices = $this->request->getPost('variant_sale_price') ?: [];
            $variantStocks = $this->request->getPost('variant_stock') ?: [];
            
            // Get main product price as default
            $mainPrice = $this->request->getPost('price');
            $mainSalePrice = $this->request->getPost('sale_price');
            $mainStock = $this->request->getPost('stock_quantity') ?: 0;
            
            // Update existing variants with individual pricing
            if (!empty($variantPrices)) {
                foreach ($variantPrices as $variantId => $price) {
                    // Skip new variants (they start with 'new_')
                    if (strpos($variantId, 'new_') === 0) {
                        continue;
                    }
                    
                    $updateData = [
                        'price' => $price ?: $mainPrice,
                        'sale_price' => isset($variantSalePrices[$variantId]) ? $variantSalePrices[$variantId] : $mainSalePrice,
                        'stock_quantity' => isset($variantStocks[$variantId]) ? $variantStocks[$variantId] : $mainStock,
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    
                    $this->productVariantModel->update($variantId, $updateData);
                }
            }
            
            // Get new sizes and colors from form
            $sizes = $this->request->getPost('sizes');
            $colors = $this->request->getPost('colors');
            
            // Debug logging
            log_message('info', 'Update variants - Sizes: ' . json_encode($sizes));
            log_message('info', 'Update variants - Colors: ' . json_encode($colors));
            
            // If no sizes or colors selected, create a default variant
            if (empty($sizes) && empty($colors)) {
                // Check if default variant already exists
                $existingDefault = $this->productVariantModel->where('product_id', $productId)
                                                           ->where('size_id IS NULL')
                                                           ->where('color_id IS NULL')
                                                           ->first();
                
                if (!$existingDefault) {
                    $variantData = [
                        'product_id' => $productId,
                        'size_id' => null,
                        'color_id' => null,
                        'sku' => $this->request->getPost('sku') ?: 'SKU-' . $productId . '-' . time(),
                        'price' => $mainPrice,
                        'sale_price' => $mainSalePrice,
                        'stock_quantity' => $mainStock,
                        'weight' => null,
                        'status' => 'active',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    
                    $this->productVariantModel->insert($variantData);
                }
                return;
            }
            
            // Delete existing variants that are not in the new selection
            $existingVariants = $this->productVariantModel->where('product_id', $productId)->findAll();
            foreach ($existingVariants as $existing) {
                $shouldKeep = false;
                
                if ($existing['size_id'] && in_array($existing['size_id'], $sizes)) {
                    $shouldKeep = true;
                } elseif (!$existing['size_id'] && empty($sizes)) {
                    $shouldKeep = true;
                }
                
                if ($existing['color_id'] && in_array($existing['color_id'], $colors)) {
                    $shouldKeep = $shouldKeep && true;
                } elseif (!$existing['color_id'] && empty($colors)) {
                    $shouldKeep = $shouldKeep && true;
                } else {
                    $shouldKeep = false;
                }
                
                if (!$shouldKeep) {
                    $this->productVariantModel->delete($existing['id']);
                }
            }
            
            // Create new variants for each size and color combination
            if (empty($sizes)) $sizes = [null];
            if (empty($colors)) $colors = [null];
            
            $variantIndex = 0;
            foreach ($sizes as $sizeId) {
                foreach ($colors as $colorId) {
                    // Check if this combination already exists
                    $existing = $this->productVariantModel->where('product_id', $productId)
                                                         ->where('size_id', $sizeId ?: null)
                                                         ->where('color_id', $colorId ?: null)
                                                         ->first();
                    
                    if (!$existing) {
                        // Check if there are individual prices for this new variant
                        $newVariantKey = 'new_' . $variantIndex;
                        $individualPrice = null;
                        $individualSalePrice = null;
                        $individualStock = null;
                        
                        // Look for individual pricing data for new variants
                        if (isset($variantPrices[$newVariantKey])) {
                            $individualPrice = $variantPrices[$newVariantKey];
                        }
                        if (isset($variantSalePrices[$newVariantKey])) {
                            $individualSalePrice = $variantSalePrices[$newVariantKey];
                        }
                        if (isset($variantStocks[$newVariantKey])) {
                            $individualStock = $variantStocks[$newVariantKey];
                        }
                        
                        $variantData = [
                            'product_id' => $productId,
                            'size_id' => $sizeId ?: null,
                            'color_id' => $colorId ?: null,
                            'sku' => $this->generateVariantSku($productId, $sizeId, $colorId),
                            'price' => $individualPrice ?: $mainPrice,
                            'sale_price' => $individualSalePrice ?: $mainSalePrice,
                            'stock_quantity' => $individualStock ?: $mainStock,
                            'weight' => null,
                            'status' => 'active',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ];
                        
                        $this->productVariantModel->insert($variantData);
                    }
                    $variantIndex++;
                }
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Error updating product variants: ' . $e->getMessage());
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
