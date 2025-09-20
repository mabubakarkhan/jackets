<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/search', 'Search::index');
$routes->post('/newsletter/subscribe', 'Newsletter::subscribe');

// Frontend Routes
$routes->get('about-us', 'Page::show/about-us');
$routes->get('contact-us', 'Page::show/contact-us');
$routes->get('privacy-policy', 'Page::show/privacy-policy');
$routes->get('return-policy', 'Page::show/return-policy');
$routes->get('terms-and-conditions', 'Page::show/terms-and-conditions');
$routes->get('shop', 'Shop::index');
$routes->get('category/(:segment)', 'Shop::category/$1');
$routes->get('product/(:segment)', 'Shop::product/$1');
$routes->post('shop/get-variant-price', 'Shop::getVariantPrice');
$routes->post('shop/add-to-cart', 'Shop::addToCart');
$routes->post('shop/update-cart', 'Shop::updateCart');
$routes->post('shop/remove-from-cart', 'Shop::removeFromCart');
$routes->post('shop/clear-cart', 'Shop::clearCart');
$routes->get('shop/get-cart-data', 'Shop::getCartData');
$routes->post('shop/validate-coupon', 'Shop::validateCoupon');
$routes->post('shop/remove-coupon', 'Shop::removeCoupon');
$routes->get('cart', 'Shop::cart');
$routes->get('checkout', 'Shop::checkout');
$routes->post('shop/place-order', 'Shop::placeOrder');

// Customer Authentication Routes
$routes->get('customer/login', 'CustomerAuth::login');
$routes->post('customer/login', 'CustomerAuth::processLogin');
$routes->get('customer/register', 'CustomerAuth::register');
$routes->post('customer/register', 'CustomerAuth::processRegister');
$routes->get('customer/logout', 'CustomerAuth::logout');
$routes->get('customer/dashboard', 'Customer::dashboard');
$routes->get('customer/profile', 'Customer::profile');
$routes->post('customer/profile', 'CustomerAuth::updateProfile');
$routes->post('customer/change-password', 'CustomerAuth::changePassword');
$routes->get('customer/forgot-password', 'CustomerAuth::forgotPassword');
$routes->post('customer/process-forgot-password', 'CustomerAuth::processForgotPassword');
$routes->get('customer/reset-password', 'CustomerAuth::resetPassword');
$routes->post('customer/process-reset-password', 'CustomerAuth::processResetPassword');
$routes->get('customer/orders', 'Customer::orders');
$routes->get('customer/order-detail/(:num)', 'Customer::orderDetail/$1');
$routes->get('customer/cancel-order/(:num)', 'Customer::cancelOrder/$1');
$routes->get('customer/track-order/(:num)', 'Customer::trackOrder/$1');
$routes->get('customer/wishlist', 'Customer::wishlist');
$routes->get('customer/addresses', 'Customer::addresses');
$routes->post('customer/addresses', 'Customer::updateAddress');

// Admin Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    // Default admin route redirects to login
    $routes->get('/', 'Auth::index');
    
    $routes->get('login', 'Auth::index');
    $routes->post('login', 'Auth::login');
    $routes->get('logout', 'Auth::logout');
    
    $routes->get('dashboard', 'Dashboard::index');
    
    // Products
    $routes->get('products', 'Products::index');
    $routes->get('products/create', 'Products::create');
    $routes->post('products/store', 'Products::store');
    $routes->get('products/edit/(:num)', 'Products::edit/$1');
    $routes->post('products/update/(:num)', 'Products::update/$1');
    $routes->post('products/delete-image', 'Products::deleteImage');
    $routes->get('products/delete/(:num)', 'Products::delete/$1');
    
    // Categories
    $routes->get('categories', 'Categories::index');
    $routes->get('categories/create', 'Categories::create');
    $routes->post('categories/store', 'Categories::store');
    $routes->get('categories/edit/(:num)', 'Categories::edit/$1');
    $routes->post('categories/update/(:num)', 'Categories::update/$1');
    $routes->get('categories/delete/(:num)', 'Categories::delete/$1');
    
    // Orders
    $routes->get('orders', 'Orders::index');
    $routes->get('orders/search', 'Orders::search');
    $routes->get('orders/view/(:num)', 'Orders::view/$1');
    $routes->post('orders/update-status', 'Orders::updateStatus');
    $routes->get('orders/delete/(:num)', 'Orders::delete/$1');
    
    // Customers
    $routes->get('customers', 'Customers::index');
    $routes->get('customers/view/(:num)', 'Customers::view/$1');
    $routes->get('customers/edit/(:num)', 'Customers::edit/$1');
    $routes->post('customers/update/(:num)', 'Customers::update/$1');
    $routes->get('customers/delete/(:num)', 'Customers::delete/$1');
    
    // Pages
    $routes->get('pages', 'Pages::index');
    $routes->get('pages/create', 'Pages::create');
    $routes->post('pages/store', 'Pages::store');
    $routes->get('pages/edit/(:num)', 'Pages::edit/$1');
    $routes->post('pages/update/(:num)', 'Pages::update/$1');
    $routes->get('pages/delete/(:num)', 'Pages::delete/$1');
    
    // Settings
    $routes->get('settings', 'Settings::index');
    $routes->post('settings/update', 'Settings::update');
    
    // Homepage Sections
    $routes->get('homepage-sections', 'HomepageSections::index');
    $routes->get('homepage-sections/edit/(:num)', 'HomepageSections::edit/$1');
    $routes->post('homepage-sections/update/(:num)', 'HomepageSections::update/$1');
    
    // Slider Management
    $routes->get('sliders', 'Sliders::index');
    $routes->get('sliders/create', 'Sliders::create');
    $routes->post('sliders/store', 'Sliders::store');
    $routes->get('sliders/edit/(:num)', 'Sliders::edit/$1');
    $routes->post('sliders/update/(:num)', 'Sliders::update/$1');
    $routes->get('sliders/delete/(:num)', 'Sliders::delete/$1');
    $routes->get('sliders/toggle-status/(:num)', 'Sliders::toggleStatus/$1');
    
    // Homepage Management
    $routes->get('homepage', 'Homepage::index');
    $routes->post('homepage/update-settings', 'Homepage::updateSettings');
    
    // Coupons
    $routes->get('coupons', 'Coupons::index');
    $routes->get('coupons/create', 'Coupons::create');
    $routes->post('coupons/store', 'Coupons::store');
    $routes->get('coupons/edit/(:num)', 'Coupons::edit/$1');
    $routes->post('coupons/update/(:num)', 'Coupons::update/$1');
    $routes->get('coupons/delete/(:num)', 'Coupons::delete/$1');
    $routes->get('coupons/toggle-status/(:num)', 'Coupons::toggleStatus/$1');
    
    // Orders
    $routes->get('orders', 'Orders::index');
    $routes->get('orders/view/(:num)', 'Orders::view/$1');
    $routes->post('orders/update-status', 'Orders::updateStatus');
    $routes->get('orders/delete/(:num)', 'Orders::delete/$1');
    
    // Debug route
    $routes->get('debug-dashboard', 'Dashboard::debug');
});
