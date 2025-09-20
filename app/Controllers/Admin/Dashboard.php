<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\CategoryModel;
use App\Models\PageModel;
use App\Models\CustomerModel;

class Dashboard extends BaseController
{
    protected $productModel;
    protected $orderModel;
    protected $categoryModel;
    protected $pageModel;
    protected $customerModel;

    public function __construct()
    {
        // Check if admin is logged in
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
        $this->categoryModel = new CategoryModel();
        $this->pageModel = new PageModel();
        $this->customerModel = new CustomerModel();
    }

    public function index()
    {
        try {
            // Use direct database queries instead of models to ensure we get the data
            $db = \Config\Database::connect();
            
            // Debug: Log the connection
            log_message('info', 'Dashboard: Database connection established');
            
            // Get counts using direct database queries
            $total_products = $db->table('products')->countAllResults();
            $total_orders = $db->table('orders')->countAllResults();
            $total_categories = $db->table('categories')->countAllResults();
            $total_pages = $db->table('pages')->countAllResults();
            $total_customers = $db->table('customers')->countAllResults();
            
            // Get order statistics by status
            $orders_by_status = $db->table('orders')
                ->select('status, COUNT(*) as count')
                ->groupBy('status')
                ->get()
                ->getResultArray();
            
            // Get monthly orders for the last 6 months
            $monthly_orders = $db->table('orders')
                ->select("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
                ->where('created_at >=', date('Y-m-01', strtotime('-5 months')))
                ->groupBy("DATE_FORMAT(created_at, '%Y-%m')")
                ->orderBy('month', 'ASC')
                ->get()
                ->getResultArray();
            
            // Fill in missing months with 0
            $last_6_months = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = date('Y-m', strtotime("-$i months"));
                $month_name = date('M Y', strtotime("-$i months"));
                $found = false;
                foreach ($monthly_orders as $order) {
                    if ($order['month'] === $month) {
                        $last_6_months[] = ['month' => $month_name, 'count' => $order['count']];
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $last_6_months[] = ['month' => $month_name, 'count' => 0];
                }
            }
            
            // Get recent customers
            $recent_customers = $db->table('customers')
                ->orderBy('created_at', 'DESC')
                ->limit(5)
                ->get()
                ->getResultArray();
            
            // Debug: Log the counts
            log_message('info', "Dashboard: Products: $total_products, Categories: $total_categories, Pages: $total_pages, Orders: $total_orders");
            
            // Get recent products
            $recent_products = $db->table('products')
                ->orderBy('created_at', 'DESC')
                ->limit(5)
                ->get()
                ->getResultArray();
            
            // Get recent orders
            $recent_orders = $db->table('orders')
                ->orderBy('created_at', 'DESC')
                ->limit(5)
                ->get()
                ->getResultArray();
            
            // Get revenue statistics
            $total_revenue = $db->table('orders')
                ->selectSum('total_amount')
                ->where('order_status', 'completed')
                ->get()
                ->getRowArray();
            
            $monthly_revenue = $db->table('orders')
                ->selectSum('total_amount')
                ->where('order_status', 'completed')
                ->where('created_at >=', date('Y-m-01'))
                ->get()
                ->getRowArray();
            
            // Get today's orders
            $today_orders = $db->table('orders')
                ->where('DATE(created_at)', date('Y-m-d'))
                ->countAllResults();
            
            // Get pending orders count
            $pending_orders = $db->table('orders')
                ->where('order_status', 'pending')
                ->countAllResults();

            // Debug: Log recent products
            log_message('info', 'Dashboard: Recent products count: ' . count($recent_products));

            $data = [
                'title' => 'Admin Dashboard',
                'total_products' => $total_products,
                'total_orders' => $total_orders,
                'total_categories' => $total_categories,
                'total_pages' => $total_pages,
                'total_customers' => $total_customers,
                'orders_by_status' => $orders_by_status,
                'monthly_orders' => $last_6_months,
                'total_revenue' => $total_revenue['total_amount'] ?? 0,
                'monthly_revenue' => $monthly_revenue['total_amount'] ?? 0,
                'today_orders' => $today_orders,
                'pending_orders' => $pending_orders,
                'recent_orders' => $recent_orders,
                'recent_products' => $recent_products,
                'recent_customers' => $recent_customers,
            ];

            return view('admin/dashboard/index', $data);

        } catch (\Exception $e) {
            log_message('error', 'Dashboard: General error - ' . $e->getMessage());
            
            // Return dashboard with zero values if there's an error
            $data = [
                'title' => 'Admin Dashboard',
                'total_products' => 0,
                'total_orders' => 0,
                'total_categories' => 0,
                'total_pages' => 0,
                'total_customers' => 0,
                'orders_by_status' => [],
                'monthly_orders' => [],
                'recent_orders' => [],
                'recent_products' => [],
                'recent_customers' => [],
            ];

            return view('admin/dashboard/index', $data);
        }
    }

    public function debug()
    {
        echo "<h1>Dashboard Debug</h1>";
        
        try {
            // Test database connection
            $db = \Config\Database::connect();
            echo "<p>✓ Database connection successful</p>";
            
            // Check what tables exist
            $tables = $db->listTables();
            echo "<p>✓ Available tables: " . implode(', ', $tables) . "</p>";
            
            // Test each table
            $tables_to_check = ['products', 'categories', 'pages', 'orders'];
            
            foreach ($tables_to_check as $table) {
                if (in_array($table, $tables)) {
                    $count = $db->table($table)->countAllResults();
                    echo "<p>✓ Table '$table': $count records</p>";
                    
                    if ($count > 0) {
                        $records = $db->table($table)->limit(3)->get()->getResultArray();
                        echo "<p>  Sample records:</p><ul>";
                        foreach ($records as $record) {
                            if (isset($record['name'])) {
                                echo "<li>ID: {$record['id']}, Name: {$record['name']}</li>";
                            } elseif (isset($record['title'])) {
                                echo "<li>ID: {$record['id']}, Title: {$record['title']}</li>";
                            } else {
                                echo "<li>ID: {$record['id']}</li>";
                            }
                        }
                        echo "</ul>";
                    }
                } else {
                    echo "<p>✗ Table '$table': DOES NOT EXIST</p>";
                }
            }
            
            // Test the exact queries used in dashboard
            echo "<h2>Dashboard Query Test</h2>";
            
            $total_products = $db->table('products')->countAllResults();
            echo "<p>Products count: $total_products</p>";
            
            $total_categories = $db->table('categories')->countAllResults();
            echo "<p>Categories count: $total_categories</p>";
            
            $total_pages = $db->table('pages')->countAllResults();
            echo "<p>Pages count: $total_pages</p>";
            
            $total_orders = $db->table('orders')->countAllResults();
            echo "<p>Orders count: $total_orders</p>";
            
            $recent_products = $db->table('products')
                ->orderBy('created_at', 'DESC')
                ->limit(5)
                ->get()
                ->getResultArray();
            
            echo "<p>Recent products: " . count($recent_products) . " found</p>";
            if (!empty($recent_products)) {
                echo "<ul>";
                foreach ($recent_products as $product) {
                    echo "<li>{$product['name']} (ID: {$product['id']})</li>";
                }
                echo "</ul>";
            }
            
        } catch (\Exception $e) {
            echo "<p>✗ Error: " . $e->getMessage() . "</p>";
        }
    }
}
