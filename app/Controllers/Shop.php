<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\SettingModel;
use App\Models\ProductImageModel;
use App\Models\ProductVariantModel;
use App\Models\ProductColorModel;
use App\Models\ProductSizeModel;
use App\Models\CouponModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\CustomerModel;

class Shop extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $settingModel;
    protected $productImageModel;
    protected $productVariantModel;
    protected $productColorModel;
    protected $productSizeModel;
    protected $couponModel;
    protected $orderModel;
    protected $orderItemModel;
    protected $customerModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->settingModel = new SettingModel();
        $this->productImageModel = new ProductImageModel();
        $this->productVariantModel = new ProductVariantModel();
        $this->productColorModel = new ProductColorModel();
        $this->productSizeModel = new ProductSizeModel();
        $this->couponModel = new CouponModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->customerModel = new CustomerModel();
    }

    /**
     * Get filtered products with unified query logic
     */
    private function getFilteredProducts($categoryId = null)
    {
        // Get filter parameters
        $categoryFilter = $this->request->getGet('category');
        $priceMin = $this->request->getGet('price_min');
        $priceMax = $this->request->getGet('price_max');
        $sizeFilter = $this->request->getGet('size');
        $colorFilter = $this->request->getGet('color');
        $sortBy = $this->request->getGet('sort') ?: 'newest';

        // Build product query with filters
        $builder = $this->productModel->where('status', 'active');

        // Category filter - use provided categoryId or filter parameter
        if ($categoryId) {
            $builder->where('category_id', $categoryId);
        } elseif ($categoryFilter) {
            $builder->where('category_id', $categoryFilter);
        }

        // Price filters
        if ($priceMin) {
            $builder->where('price >=', $priceMin);
        }

        if ($priceMax) {
            $builder->where('price <=', $priceMax);
        }

        // Size filter - now using the size field in products table
        if ($sizeFilter) {
            $builder->where('size', $sizeFilter);
        }

        // Color filter - based on product name keywords
        if ($colorFilter) {
            $colorKeywords = [
                'Brown' => ['brown', 'tan', 'beige'],
                'Yellow' => ['yellow', 'gold', 'amber'],
                'Black' => ['black', 'dark', 'charcoal'],
                'Red' => ['red', 'crimson', 'burgundy'],
                'Blue' => ['blue', 'navy', 'royal'],
                'Green' => ['green', 'olive', 'forest'],
                'Pink' => ['pink', 'rose', 'coral'],
                'Gray' => ['gray', 'grey', 'silver']
            ];
            
            if (isset($colorKeywords[$colorFilter])) {
                $colorConditions = [];
                foreach ($colorKeywords[$colorFilter] as $keyword) {
                    $colorConditions[] = "name LIKE '%{$keyword}%'";
                }
                if (!empty($colorConditions)) {
                    $builder->where('(' . implode(' OR ', $colorConditions) . ')');
                }
            }
        }

        // Apply sorting
        switch ($sortBy) {
            case 'name_asc':
                $builder->orderBy('name', 'ASC');
                break;
            case 'name_desc':
                $builder->orderBy('name', 'DESC');
                break;
            case 'price_asc':
                $builder->orderBy('price', 'ASC');
                break;
            case 'price_desc':
                $builder->orderBy('price', 'DESC');
                break;
            case 'newest':
            default:
                $builder->orderBy('created_at', 'DESC');
                break;
        }

        // Get products
        $products = $builder->findAll();

        // Get product images for each product
        foreach ($products as &$product) {
            $product['images'] = $this->productImageModel->where('product_id', $product['id'])
                                                        ->orderBy('is_primary', 'DESC')
                                                        ->orderBy('sort_order', 'ASC')
                                                        ->find();
        }

        return [
            'products' => $products,
            'filters' => [
                'category' => $categoryId ?: $categoryFilter,
                'price_min' => $priceMin,
                'price_max' => $priceMax,
                'size' => $sizeFilter,
                'color' => $colorFilter,
                'sort' => $sortBy
            ]
        ];
    }

    public function index()
    {

        // Get all categories for sidebar with product counts
        $categories = $this->categoryModel->where('status', 'active')
                                         ->orderBy('name', 'ASC')
                                         ->findAll();

        // Add product counts to each category
        foreach ($categories as &$category) {
            $category['product_count'] = $this->productModel->where('category_id', $category['id'])
                                                           ->where('status', 'active')
                                                           ->countAllResults();
        }

        // Get filtered products using unified method
        $result = $this->getFilteredProducts();

        $data = [
            'meta_title' => 'Shop - ' . ($this->settings['site_name'] ?? 'Jacket Store'),
            'meta_description' => 'Shop our complete collection of premium jackets and outerwear for men and women.',
            'meta_keywords' => 'shop jackets, buy jackets, online jacket store, premium outerwear',
            'products' => $result['products'],
            'categories' => $categories,
            'filters' => $result['filters'],
            'header_override' => true
        ];

        return view('shop/index', $this->getViewData($data));
    }

    public function category($slug)
    {
        $category = $this->categoryModel->where('slug', $slug)
                                       ->where('status', 'active')
                                       ->first();

        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Category not found');
        }

        // Get all categories for sidebar with product counts
        $categories = $this->categoryModel->where('status', 'active')
                                         ->orderBy('name', 'ASC')
                                         ->findAll();

        // Add product counts to each category
        foreach ($categories as &$cat) {
            $cat['product_count'] = $this->productModel->where('category_id', $cat['id'])
                                                      ->where('status', 'active')
                                                      ->countAllResults();
        }

        // Get filtered products using unified method (pass category ID)
        $result = $this->getFilteredProducts($category['id']);

        $data = [
            'meta_title' => $category['meta_title'] ?? $category['name'] . ' - ' . ($this->settings['site_name'] ?? 'Jacket Store'),
            'meta_description' => $category['meta_description'] ?? 'Browse our collection of ' . $category['name'] . ' jackets and outerwear.',
            'meta_keywords' => $category['meta_keywords'] ?? $category['name'] . ', jackets, outerwear',
            'canonical_url' => base_url('category/' . $category['slug']),
            'category' => $category,
            'products' => $result['products'],
            'categories' => $categories,
            'filters' => $result['filters'],
            'header_override' => true
        ];

        return view('shop/category', $this->getViewData($data));
    }

    public function product($slug)
    {
        $product = $this->productModel->where('slug', $slug)
                                     ->where('status', 'active')
                                     ->first();

        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }

        // Get product images
        $product['images'] = $this->productImageModel->where('product_id', $product['id'])
                                                    ->orderBy('is_primary', 'DESC')
                                                    ->orderBy('sort_order', 'ASC')
                                                    ->find();

        // Get product variants
        $product['variants'] = $this->productVariantModel->getProductVariants($product['id']);
        
        // Get available colors and sizes for this product
        $product['colors'] = $this->productColorModel->getActiveColors();
        $product['sizes'] = $this->productSizeModel->getActiveSizes();

        // Get related products (same category, excluding current product)
        $relatedProducts = $this->productModel->where('category_id', $product['category_id'])
                                             ->where('id !=', $product['id'])
                                             ->where('status', 'active')
                                             ->limit(4)
                                             ->findAll();

        // Get images for related products
        foreach ($relatedProducts as &$relatedProduct) {
            $relatedProduct['images'] = $this->productImageModel->where('product_id', $relatedProduct['id'])
                                                               ->orderBy('is_primary', 'DESC')
                                                               ->orderBy('sort_order', 'ASC')
                                                               ->find();
        }

        $data = [
            'meta_title' => $product['meta_title'] ?? $product['name'] . ' - ' . ($this->settings['site_name'] ?? 'Jacket Store'),
            'meta_description' => $product['meta_description'] ?? $product['short_description'] ?? 'Shop ' . $product['name'] . ' - Premium quality jacket with excellent craftsmanship.',
            'meta_keywords' => $product['meta_keywords'] ?? $product['name'] . ', jacket, outerwear',
            'canonical_url' => base_url('product/' . $product['slug']),
            'product' => $product,
            'related_products' => $relatedProducts,
            'header_override' => true
        ];

        return view('shop/product', $this->getViewData($data));
    }

    public function getVariantPrice()
    {
        $productId = $this->request->getPost('product_id');
        $sizeId = $this->request->getPost('size_id');
        $colorId = $this->request->getPost('color_id');

        if (!$productId) {
            return $this->response->setJSON(['error' => 'Product ID is required']);
        }

        $variant = $this->productVariantModel->getVariantBySizeAndColor($productId, $sizeId, $colorId);
        
        if ($variant) {
            return $this->response->setJSON([
                'success' => true,
                'price' => $variant['price'],
                'sale_price' => $variant['sale_price'],
                'stock_quantity' => $variant['stock_quantity'],
                'sku' => $variant['sku']
            ]);
        } else {
            // Return main product price if no variant found
            $product = $this->productModel->find($productId);
            return $this->response->setJSON([
                'success' => true,
                'price' => $product['price'],
                'sale_price' => $product['sale_price'],
                'stock_quantity' => $product['stock_quantity'] ?? 0,
                'sku' => $product['sku'] ?? ''
            ]);
        }
    }

    public function addToCart()
    {
        $productId = $this->request->getPost('product_id');
        $sizeId = $this->request->getPost('size_id');
        $colorId = $this->request->getPost('color_id');
        $quantity = (int)$this->request->getPost('quantity', FILTER_SANITIZE_NUMBER_INT);
        
        if (!$productId || $quantity < 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid product or quantity']);
        }
        
        // Get product details
        $product = $this->productModel->find($productId);
        if (!$product) {
            return $this->response->setJSON(['success' => false, 'message' => 'Product not found']);
        }
        
        // Get variant details if size/color selected
        $variant = null;
        if ($sizeId || $colorId) {
            $variant = $this->productVariantModel->getVariantBySizeAndColor($productId, $sizeId, $colorId);
        }
        
        // Get cart from session
        $cart = session()->get('cart') ?? [];
        
        // Create cart item key
        $cartKey = $productId . '_' . ($sizeId ?? '0') . '_' . ($colorId ?? '0');
        
        // Check if item already exists in cart
        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            // Get size and color names
            $sizeName = '';
            $colorName = '';
            $colorHex = '';
            
            if ($sizeId) {
                $size = $this->productSizeModel->find($sizeId);
                $sizeName = $size ? $size['name'] : '';
            }
            
            if ($colorId) {
                $color = $this->productColorModel->find($colorId);
                $colorName = $color ? $color['name'] : '';
                $colorHex = $color ? $color['hex_code'] : '';
            }
            
            // Get product image
            $productImage = $this->productImageModel->where('product_id', $productId)
                                                   ->orderBy('is_primary', 'DESC')
                                                   ->first();
            
            $cart[$cartKey] = [
                'product_id' => $productId,
                'product_name' => $product['name'],
                'product_slug' => $product['slug'],
                'size_id' => $sizeId,
                'size_name' => $sizeName,
                'color_id' => $colorId,
                'color_name' => $colorName,
                'color_hex' => $colorHex,
                'quantity' => $quantity,
                'price' => $variant ? $variant['price'] : $product['price'],
                'sale_price' => $variant ? $variant['sale_price'] : $product['sale_price'],
                'image' => $productImage ? $productImage['image_path'] : null,
                'sku' => $variant ? $variant['sku'] : $product['sku']
            ];
        }
        
        // Save cart to session
        session()->set('cart', $cart);
        
        
        // Calculate cart totals
        $totalItems = array_sum(array_column($cart, 'quantity'));
        $totalPrice = 0;
        foreach ($cart as $item) {
            $itemPrice = $item['sale_price'] && $item['sale_price'] < $item['price'] ? $item['sale_price'] : $item['price'];
            $totalPrice += $itemPrice * $item['quantity'];
        }
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Product added to cart successfully',
            'cart_count' => $totalItems,
            'cart_total' => number_format($totalPrice, 2)
        ]);
    }

    public function cart()
    {
        $cart = session()->get('cart') ?? [];
        
        // Calculate cart totals
        $totalItems = array_sum(array_column($cart, 'quantity'));
        $totalPrice = 0;
        foreach ($cart as $item) {
            $itemPrice = $item['sale_price'] && $item['sale_price'] < $item['price'] ? $item['sale_price'] : $item['price'];
            $totalPrice += $itemPrice * $item['quantity'];
        }
        
        $data = [
            'meta_title' => 'Shopping Cart - ' . ($this->settings['site_name'] ?? 'Jacket Store'),
            'meta_description' => 'Review your selected items and proceed to checkout.',
            'meta_keywords' => 'shopping cart, checkout, jacket store',
            'cart' => $cart,
            'total_items' => $totalItems,
            'total_price' => $totalPrice,
            'header_override' => true
        ];

        return view('shop/cart', $this->getViewData($data));
    }

    public function updateCart()
    {
        $cartKey = $this->request->getPost('cart_key');
        $quantity = (int)$this->request->getPost('quantity', FILTER_SANITIZE_NUMBER_INT);
        
        if (!$cartKey || $quantity < 0) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid cart item or quantity']);
        }
        
        $cart = session()->get('cart') ?? [];
        
        if ($quantity == 0) {
            // Remove item from cart
            unset($cart[$cartKey]);
        } else {
            // Update quantity
            if (isset($cart[$cartKey])) {
                $cart[$cartKey]['quantity'] = $quantity;
            }
        }
        
        // Save cart to session
        session()->set('cart', $cart);
        
        // Calculate cart totals
        $totalItems = array_sum(array_column($cart, 'quantity'));
        $totalPrice = 0;
        foreach ($cart as $item) {
            $itemPrice = $item['sale_price'] && $item['sale_price'] < $item['price'] ? $item['sale_price'] : $item['price'];
            $totalPrice += $itemPrice * $item['quantity'];
        }
        
        return $this->response->setJSON([
            'success' => true,
            'cart_count' => $totalItems,
            'cart_total' => number_format($totalPrice, 2)
        ]);
    }

    public function removeFromCart()
    {
        $cartKey = $this->request->getPost('cart_key');
        
        if (!$cartKey) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid cart item']);
        }
        
        $cart = session()->get('cart') ?? [];
        unset($cart[$cartKey]);
        
        // Save cart to session
        session()->set('cart', $cart);
        
        // Calculate cart totals
        $totalItems = array_sum(array_column($cart, 'quantity'));
        $totalPrice = 0;
        foreach ($cart as $item) {
            $itemPrice = $item['sale_price'] && $item['sale_price'] < $item['price'] ? $item['sale_price'] : $item['price'];
            $totalPrice += $itemPrice * $item['quantity'];
        }
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Item removed from cart',
            'cart_count' => $totalItems,
            'cart_total' => number_format($totalPrice, 2)
        ]);
    }

    public function clearCart()
    {
        session()->remove('cart');
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Cart cleared successfully',
            'cart_count' => 0,
            'cart_total' => '0.00'
        ]);
    }

    public function getCartData()
    {
        $cart = session()->get('cart') ?? [];
        $cartTotal = 0;
        $cartCount = 0;
        
        
        $html = '';
        
        if (!empty($cart)) {
            $html .= '<div class="dropdown-cart-products">';
            
            foreach (array_slice($cart, 0, 3) as $cartKey => $item) {
                $itemPrice = $item['sale_price'] && $item['sale_price'] < $item['price'] ? $item['sale_price'] : $item['price'];
                $cartTotal += $itemPrice * $item['quantity'];
                $cartCount += $item['quantity'];
                
                $html .= '<div class="product">';
                $html .= '<div class="product-cart-details">';
                $html .= '<h4 class="product-title">';
                $html .= '<a href="' . base_url('product/' . $item['product_slug']) . '">' . esc($item['product_name']) . '</a>';
                $html .= '</h4>';
                $html .= '<span class="cart-product-info">';
                $html .= '<span class="cart-product-qty">' . $item['quantity'] . '</span>';
                $html .= ' x $' . number_format($itemPrice, 2);
                $html .= '</span>';
                
                if ($item['size_name'] || $item['color_name']) {
                    $html .= '<div class="product-details">';
                    if ($item['size_name']) {
                        $html .= '<small>Size: ' . esc($item['size_name']) . '</small>';
                    }
                    if ($item['color_name']) {
                        $html .= '<small>Color: ' . esc($item['color_name']) . '</small>';
                    }
                    $html .= '</div>';
                }
                
                $html .= '</div>';
                $html .= '<figure class="product-image-container">';
                $html .= '<a href="' . base_url('product/' . $item['product_slug']) . '" class="product-image">';
                
                if ($item['image']) {
                    $html .= '<img src="' . base_url('public/uploads/products/' . $item['image']) . '" alt="' . esc($item['product_name']) . '" onerror="this.src=\'' . base_url('html/assets/images/products/cart/product-1.jpg') . '\'">';
                } else {
                    $html .= '<img src="' . base_url('html/assets/images/products/cart/product-1.jpg') . '" alt="' . esc($item['product_name']) . '">';
                }
                
                $html .= '</a>';
                $html .= '</figure>';
                $html .= '<a href="#" class="btn-remove" title="Remove Product" data-cart-key="' . $cartKey . '"><i class="icon-close"></i></a>';
                $html .= '</div>';
            }
            
            if (count($cart) > 3) {
                $html .= '<div class="text-center">';
                $html .= '<small>And ' . (count($cart) - 3) . ' more items...</small>';
                $html .= '</div>';
            }
            
            $html .= '</div>';
            $html .= '<div class="dropdown-cart-total">';
            $html .= '<span>Total</span>';
            $html .= '<span class="cart-total-price">$' . number_format($cartTotal, 2) . '</span>';
            $html .= '</div>';
            $html .= '<div class="dropdown-cart-action">';
            $html .= '<a href="' . base_url('cart') . '" class="btn btn-primary">View Cart</a>';
            $html .= '<a href="' . base_url('checkout') . '" class="btn btn-outline-primary-2"><span>Checkout</span><i class="icon-long-arrow-right"></i></a>';
            $html .= '</div>';
        } else {
            $html .= '<div class="dropdown-cart-empty">';
            $html .= '<p>Your cart is empty</p>';
            $html .= '<a href="' . base_url('shop') . '" class="btn btn-primary">Start Shopping</a>';
            $html .= '</div>';
        }
        
        return $this->response->setJSON([
            'success' => true,
            'html' => $html,
            'cart_count' => $cartCount,
            'cart_total' => number_format($cartTotal, 2)
        ]);
    }

    public function checkout()
    {
        // Check if customer is logged in
        if (!session()->get('customer_logged_in')) {
            session()->set('redirect_after_login', 'checkout');
            return redirect()->to('customer/login?redirect=' . urlencode(current_url()))->with('error', 'Please login to proceed with checkout.');
        }

        // Get customer data
        $customerId = session()->get('customer_id');
        $customer = $this->customerModel->find($customerId);

        // Check if cart is not empty
        $cart = session()->get('cart') ?? [];
        if (empty($cart)) {
            return redirect()->to('cart')->with('error', 'Your cart is empty. Please add some items before checkout.');
        }

        // Get site settings
        $settings = [];
        $allSettings = $this->settingModel->findAll();
        foreach ($allSettings as $setting) {
            $settings[$setting['setting_key']] = $setting['setting_value'];
        }

        // Calculate cart totals
        $cartTotal = 0;
        foreach ($cart as $item) {
            $itemPrice = $item['sale_price'] && $item['sale_price'] < $item['price'] ? $item['sale_price'] : $item['price'];
            $cartTotal += $itemPrice * $item['quantity'];
        }

        // Get applied coupon
        $appliedCoupon = session()->get('applied_coupon');
        $discount = 0;
        if ($appliedCoupon) {
            $discount = $appliedCoupon['discount'];
        }

        $data = [
            'meta_title' => 'Checkout - ' . ($settings['site_name'] ?? 'Jacket Store'),
            'meta_description' => 'Complete your order and provide delivery information.',
            'settings' => $settings,
            'customer' => $customer,
            'cart' => $cart,
            'cart_total' => $cartTotal,
            'discount' => $discount,
            'final_total' => $cartTotal - $discount,
            'applied_coupon' => $appliedCoupon
        ];

        return view('shop/checkout', $data);
    }

    public function processOrder()
    {
        // Check if customer is logged in
        if (!session()->get('customer_logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to place an order.'
            ]);
        }

        // Check if cart is not empty
        $cart = session()->get('cart') ?? [];
        if (empty($cart)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Your cart is empty.'
            ]);
        }

        // Validate shipping information
        $rules = [
            'shipping_name' => 'required|max_length[255]',
            'shipping_email' => 'required|valid_email|max_length[255]',
            'shipping_phone' => 'required|max_length[20]',
            'shipping_address' => 'required',
            'shipping_city' => 'required|max_length[100]',
            'shipping_state' => 'required|max_length[100]',
            'shipping_country' => 'required|max_length[100]',
            'shipping_postal_code' => 'required|max_length[20]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please fill in all required shipping information.',
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $itemPrice = $item['sale_price'] && $item['sale_price'] < $item['price'] ? $item['sale_price'] : $item['price'];
            $subtotal += $itemPrice * $item['quantity'];
        }

        $appliedCoupon = session()->get('applied_coupon');
        $discount = $appliedCoupon ? $appliedCoupon['discount'] : 0;
        $shipping = 0; // Free shipping for now
        $tax = 0; // No tax for now
        $total = $subtotal - $discount + $shipping + $tax;

        // Create order
        $orderData = [
            'customer_id' => $customer['id'],
            'subtotal' => $subtotal,
            'discount_amount' => $discount,
            'shipping_amount' => $shipping,
            'tax_amount' => $tax,
            'total_amount' => $total,
            'shipping_name' => $this->request->getPost('shipping_name'),
            'shipping_email' => $this->request->getPost('shipping_email'),
            'shipping_phone' => $this->request->getPost('shipping_phone'),
            'shipping_address' => $this->request->getPost('shipping_address'),
            'shipping_city' => $this->request->getPost('shipping_city'),
            'shipping_state' => $this->request->getPost('shipping_state'),
            'shipping_country' => $this->request->getPost('shipping_country'),
            'shipping_postal_code' => $this->request->getPost('shipping_postal_code'),
            'notes' => $this->request->getPost('notes'),
            'status' => 'pending',
            'payment_status' => 'pending'
        ];

        $orderId = $this->orderModel->insert($orderData);

        if ($orderId) {
            // Create order items
            $this->orderItemModel->createFromCart($orderId, $cart);

            // Clear cart and applied coupon
            session()->remove('cart');
            session()->remove('applied_coupon');

            // Get order details
            $order = $this->orderModel->getOrderWithItems($orderId);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_id' => $orderId,
                'order_number' => $order['order_number'],
                'redirect_url' => base_url('customer/orders/view/' . $orderId)
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to create order. Please try again.'
            ]);
        }
    }

    public function validateCoupon()
    {
        $couponCode = $this->request->getPost('coupon_code');
        
        if (!$couponCode) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Coupon code is required'
            ]);
        }

        // Get cart total
        $cart = session()->get('cart') ?? [];
        $cartTotal = 0;
        foreach ($cart as $item) {
            $itemPrice = $item['sale_price'] && $item['sale_price'] < $item['price'] ? $item['sale_price'] : $item['price'];
            $cartTotal += $itemPrice * $item['quantity'];
        }

        // Debug: Log the validation attempt
        log_message('debug', "Coupon validation attempt: Code=$couponCode, CartTotal=$cartTotal");

        // Test if CouponModel is working
        try {
            $testCoupon = $this->couponModel->getCouponByCode($couponCode);
            if ($testCoupon) {
                // If we found the coupon directly, let's return success for testing
                $discount = $this->couponModel->calculateDiscount($testCoupon, $cartTotal);
                $finalTotal = $cartTotal - $discount;
                
                // Store coupon in session
                session()->set('applied_coupon', [
                    'code' => $testCoupon['code'],
                    'name' => $testCoupon['name'],
                    'type' => $testCoupon['type'],
                    'value' => $testCoupon['value'],
                    'discount' => $discount,
                    'minimum_amount' => $testCoupon['minimum_amount'],
                    'maximum_discount' => $testCoupon['maximum_discount']
                ]);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Coupon applied successfully (direct test)',
                    'coupon' => [
                        'code' => $testCoupon['code'],
                        'name' => $testCoupon['name'],
                        'type' => $testCoupon['type'],
                        'value' => $testCoupon['value'],
                        'discount' => $discount,
                        'minimum_amount' => $testCoupon['minimum_amount'],
                        'maximum_discount' => $testCoupon['maximum_discount']
                    ],
                    'cart_total' => number_format($cartTotal, 2),
                    'discount' => number_format($discount, 2),
                    'final_total' => number_format($finalTotal, 2)
                ]);
            }
        } catch (Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'CouponModel error: ' . $e->getMessage()
            ]);
        }

        // Validate coupon
        $validation = $this->couponModel->validateCoupon($couponCode, $cartTotal);
        
        // Debug: Log the validation result
        log_message('debug', "Coupon validation result: " . json_encode($validation));
        
        if (!$validation['valid']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $validation['message']
            ]);
        }

        $coupon = $validation['coupon'];
        $discount = $this->couponModel->calculateDiscount($coupon, $cartTotal);
        $finalTotal = $cartTotal - $discount;

        // Store coupon in session
        session()->set('applied_coupon', [
            'code' => $coupon['code'],
            'name' => $coupon['name'],
            'type' => $coupon['type'],
            'value' => $coupon['value'],
            'discount' => $discount,
            'minimum_amount' => $coupon['minimum_amount'],
            'maximum_discount' => $coupon['maximum_discount']
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Coupon applied successfully',
            'coupon' => [
                'code' => $coupon['code'],
                'name' => $coupon['name'],
                'type' => $coupon['type'],
                'value' => $coupon['value'],
                'discount' => $discount,
                'minimum_amount' => $coupon['minimum_amount'],
                'maximum_discount' => $coupon['maximum_discount']
            ],
            'cart_total' => number_format($cartTotal, 2),
            'discount' => number_format($discount, 2),
            'final_total' => number_format($finalTotal, 2)
        ]);
    }

    public function removeCoupon()
    {
        session()->remove('applied_coupon');
        
        // Recalculate cart total
        $cart = session()->get('cart') ?? [];
        $cartTotal = 0;
        foreach ($cart as $item) {
            $itemPrice = $item['sale_price'] && $item['sale_price'] < $item['price'] ? $item['sale_price'] : $item['price'];
            $cartTotal += $itemPrice * $item['quantity'];
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Coupon removed successfully',
            'cart_total' => number_format($cartTotal, 2),
            'final_total' => number_format($cartTotal, 2)
        ]);
    }

    public function placeOrder()
    {
        try {
            // Check if customer is logged in
            if (!session()->get('customer_logged_in')) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Please login to place an order.'
                ]);
            }

        // Get cart
        $cart = session()->get('cart') ?? [];
        if (empty($cart)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Your cart is empty.'
            ]);
        }

        $customerId = session()->get('customer_id');
        $customerModel = new \App\Models\CustomerModel();
        $customer = $customerModel->find($customerId);

        // Calculate totals
        $cartTotal = 0;
        foreach ($cart as $item) {
            $itemPrice = $item['sale_price'] && $item['sale_price'] < $item['price'] ? $item['sale_price'] : $item['price'];
            $cartTotal += $itemPrice * $item['quantity'];
        }

        // Get applied coupon
        $appliedCoupon = session()->get('applied_coupon');
        $discountAmount = $appliedCoupon['discount'] ?? 0;
        $shippingCost = 0; // Free shipping for now
        $taxAmount = 0; // No tax for now
        $finalTotal = $cartTotal - $discountAmount + $shippingCost + $taxAmount;

        // Create order
        $orderData = [
            'customer_id' => $customerId,
            'order_number' => 'ORD-' . time() . '-' . rand(1000, 9999),
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => 'cash_on_delivery',
            'customer_name' => $customer['name'],
            'customer_email' => $customer['email'],
            'customer_phone' => $customer['phone'],
            'customer_address' => $customer['address'],
            'customer_city' => $customer['city'],
            'customer_country' => $customer['country'],
            'subtotal' => $cartTotal,
            'shipping_address' => json_encode([
                'name' => $customer['name'],
                'address' => $customer['address'],
                'city' => $customer['city'],
                'country' => $customer['country'],
                'phone' => $customer['phone']
            ]),
            'billing_address' => json_encode([
                'name' => $customer['name'],
                'address' => $customer['address'],
                'city' => $customer['city'],
                'country' => $customer['country'],
                'phone' => $customer['phone']
            ]),
            'notes' => $this->request->getPost('notes'),
            'coupon_code' => $appliedCoupon['code'] ?? null,
            'discount_amount' => $discountAmount,
            'shipping_cost' => $shippingCost,
            'tax_amount' => $taxAmount,
            'total_amount' => $finalTotal,
            'order_status' => 'pending'
        ];

        // Debug: Log order data before insertion
        log_message('debug', 'Order data: ' . json_encode($orderData));
        
        // Use direct database query to avoid any timestamp issues
        $db = \Config\Database::connect();
        $orderSql = "INSERT INTO orders (customer_id, order_number, status, payment_status, payment_method, customer_name, customer_email, customer_phone, customer_address, customer_city, customer_country, subtotal, shipping_address, billing_address, notes, coupon_code, discount_amount, shipping_cost, tax_amount, total_amount, order_status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        $orderQuery = $db->query($orderSql, [
            $orderData['customer_id'],
            $orderData['order_number'],
            $orderData['status'],
            $orderData['payment_status'],
            $orderData['payment_method'],
            $orderData['customer_name'],
            $orderData['customer_email'],
            $orderData['customer_phone'],
            $orderData['customer_address'],
            $orderData['customer_city'],
            $orderData['customer_country'],
            $orderData['subtotal'],
            $orderData['shipping_address'],
            $orderData['billing_address'],
            $orderData['notes'],
            $orderData['coupon_code'],
            $orderData['discount_amount'],
            $orderData['shipping_cost'],
            $orderData['tax_amount'],
            $orderData['total_amount'],
            $orderData['order_status']
        ]);
        
        if ($orderQuery) {
            $orderId = $db->insertID();
            log_message('debug', 'Order created with ID: ' . $orderId);
            
            // Get the created order
            $orderQuery = $db->query("SELECT * FROM orders WHERE id = ?", [$orderId]);
            $order = $orderQuery->getRowArray();
            log_message('debug', 'Order found: ' . json_encode($order));

            // Create order items
            foreach ($cart as $item) {
                $itemPrice = $item['sale_price'] && $item['sale_price'] < $item['price'] ? $item['sale_price'] : $item['price'];
                
                $orderItemData = [
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $itemPrice,
                    'total_price' => $itemPrice * $item['quantity']
                ];

                log_message('debug', 'Order item data: ' . json_encode($orderItemData));
                
                // Use direct database query to avoid timestamp issues
                $db = \Config\Database::connect();
                $sql = "INSERT INTO order_items (order_id, product_id, product_name, quantity, unit_price, total_price, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
                $query = $db->query($sql, [
                    $orderItemData['order_id'],
                    $orderItemData['product_id'],
                    $orderItemData['product_name'],
                    $orderItemData['quantity'],
                    $orderItemData['unit_price'],
                    $orderItemData['total_price']
                ]);
                
                if (!$query) {
                    log_message('error', 'Failed to insert order item with direct query');
                    throw new \Exception('Failed to create order item');
                }
            }

            // Clear cart and applied coupon
            try {
                // Clear session data without triggering session write
                $session = session();
                $session->remove('cart');
                $session->remove('applied_coupon');
                // Don't call session_write_close() to avoid the error
            } catch (\Exception $e) {
                // Log the error but don't fail the order
                log_message('error', 'Session error when clearing cart: ' . $e->getMessage());
            }

            // Increment coupon usage if applied
            if ($appliedCoupon) {
                $couponModel = new \App\Models\CouponModel();
                $coupon = $couponModel->getCouponByCode($appliedCoupon['code']);
                if ($coupon) {
                    $couponModel->incrementUsage($coupon['id']);
                }
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_id' => $orderId,
                'order_number' => $order['order_number'],
                'redirect_url' => base_url('customer/order-detail/' . $orderId)
            ]);
        } else {
            // Log the order insertion failure
            log_message('error', 'Order insertion failed with direct query');
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to place order. Please try again.'
            ]);
        }
        } catch (\Exception $e) {
            log_message('error', 'Order placement error: ' . $e->getMessage());
            log_message('error', 'Order placement stack trace: ' . $e->getTraceAsString());
            
            // Return detailed error information for debugging
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An error occurred while placing your order. Please try again.',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}