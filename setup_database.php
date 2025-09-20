<?php

// Database setup script for Jacket Store
// Run this script to create database, run migrations, and seed data

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'jacket_store';

try {
    // Create database connection
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to MySQL server successfully.\n";
    
    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $pdo->exec($sql);
    echo "Database '$database' created or already exists.\n";
    
    // Select the database
    $pdo->exec("USE `$database`");
    
    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS `users` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `username` varchar(100) NOT NULL,
        `email` varchar(255) NOT NULL,
        `password` varchar(255) NOT NULL,
        `role` enum('admin','user') NOT NULL DEFAULT 'user',
        `status` enum('active','inactive') NOT NULL DEFAULT 'active',
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `username` (`username`),
        UNIQUE KEY `email` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "Users table created successfully.\n";
    
    // Create categories table
    $sql = "CREATE TABLE IF NOT EXISTS `categories` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `parent_id` int(11) unsigned DEFAULT NULL,
        `name` varchar(255) NOT NULL,
        `slug` varchar(255) NOT NULL,
        `description` text,
        `image` varchar(255) DEFAULT NULL,
        `meta_title` varchar(255) DEFAULT NULL,
        `meta_description` text,
        `meta_keywords` text,
        `sort_order` int(11) NOT NULL DEFAULT '0',
        `status` enum('active','inactive') NOT NULL DEFAULT 'active',
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`id`),
        KEY `parent_id` (`parent_id`),
        UNIQUE KEY `slug` (`slug`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "Categories table created successfully.\n";
    
    // Create products table
    $sql = "CREATE TABLE IF NOT EXISTS `products` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `category_id` int(11) unsigned NOT NULL,
        `name` varchar(255) NOT NULL,
        `slug` varchar(255) NOT NULL,
        `sku` varchar(100) NOT NULL,
        `description` text,
        `short_description` text,
        `price` decimal(10,2) NOT NULL,
        `sale_price` decimal(10,2) DEFAULT NULL,
        `cost_price` decimal(10,2) DEFAULT NULL,
        `stock_quantity` int(11) NOT NULL DEFAULT '0',
        `weight` decimal(8,2) DEFAULT NULL,
        `dimensions` varchar(100) DEFAULT NULL,
        `featured` tinyint(1) NOT NULL DEFAULT '0',
        `meta_title` varchar(255) DEFAULT NULL,
        `meta_description` text,
        `meta_keywords` text,
        `status` enum('active','inactive','draft') NOT NULL DEFAULT 'active',
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`id`),
        KEY `category_id` (`category_id`),
        UNIQUE KEY `slug` (`slug`),
        UNIQUE KEY `sku` (`sku`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "Products table created successfully.\n";
    
    // Create product_images table
    $sql = "CREATE TABLE IF NOT EXISTS `product_images` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `product_id` int(11) unsigned NOT NULL,
        `image_path` varchar(255) NOT NULL,
        `alt_text` varchar(255) DEFAULT NULL,
        `sort_order` int(11) NOT NULL DEFAULT '0',
        `is_primary` tinyint(1) NOT NULL DEFAULT '0',
        `created_at` datetime NOT NULL,
        PRIMARY KEY (`id`),
        KEY `product_id` (`product_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "Product images table created successfully.\n";
    
    // Create orders table
    $sql = "CREATE TABLE IF NOT EXISTS `orders` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `order_number` varchar(50) NOT NULL,
        `customer_name` varchar(255) NOT NULL,
        `customer_email` varchar(255) NOT NULL,
        `customer_phone` varchar(20) NOT NULL,
        `customer_address` text NOT NULL,
        `customer_city` varchar(100) NOT NULL,
        `customer_state` varchar(100) NOT NULL,
        `customer_zip` varchar(20) NOT NULL,
        `customer_country` varchar(100) NOT NULL DEFAULT 'Pakistan',
        `subtotal` decimal(10,2) NOT NULL,
        `shipping_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
        `total_amount` decimal(10,2) NOT NULL,
        `payment_method` enum('cash_on_delivery','bank_transfer','inquiry') NOT NULL DEFAULT 'cash_on_delivery',
        `order_status` enum('pending','confirmed','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
        `notes` text,
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `order_number` (`order_number`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "Orders table created successfully.\n";
    
    // Create order_items table
    $sql = "CREATE TABLE IF NOT EXISTS `order_items` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `order_id` int(11) unsigned NOT NULL,
        `product_id` int(11) unsigned NOT NULL,
        `product_name` varchar(255) NOT NULL,
        `quantity` int(11) NOT NULL,
        `unit_price` decimal(10,2) NOT NULL,
        `total_price` decimal(10,2) NOT NULL,
        `created_at` datetime NOT NULL,
        PRIMARY KEY (`id`),
        KEY `order_id` (`order_id`),
        KEY `product_id` (`product_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "Order items table created successfully.\n";
    
    // Create pages table
    $sql = "CREATE TABLE IF NOT EXISTS `pages` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `slug` varchar(255) NOT NULL,
        `content` longtext NOT NULL,
        `page_type` enum('static','blog','faq') NOT NULL DEFAULT 'static',
        `meta_title` varchar(255) DEFAULT NULL,
        `meta_description` text,
        `meta_keywords` text,
        `status` enum('published','draft') NOT NULL DEFAULT 'published',
        `sort_order` int(11) NOT NULL DEFAULT '0',
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `slug` (`slug`),
        KEY `page_type` (`page_type`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "Pages table created successfully.\n";
    
    // Create settings table
    $sql = "CREATE TABLE IF NOT EXISTS `settings` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `setting_key` varchar(100) NOT NULL,
        `setting_value` text,
        `setting_type` enum('text','textarea','image','boolean','json') NOT NULL DEFAULT 'text',
        `created_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `setting_key` (`setting_key`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "Settings table created successfully.\n";
    
    // Insert admin user
    $adminPassword = password_hash('chor', PASSWORD_DEFAULT);
    $sql = "INSERT IGNORE INTO users (username, email, password, role, status, created_at, updated_at) 
            VALUES ('admin', 'admin@jacketstore.com', '$adminPassword', 'admin', 'active', NOW(), NOW())";
    $pdo->exec($sql);
    echo "Admin user created successfully.\n";
    
    // Insert default settings
    $settings = [
        ['site_name', 'Jacket Store', 'text'],
        ['site_description', 'Premium Quality Jackets and Outerwear', 'textarea'],
        ['site_email', 'info@jacketstore.com', 'text'],
        ['site_phone', '+92 300 1234567', 'text'],
        ['site_address', '123 Main Street, Karachi, Pakistan', 'textarea'],
        ['facebook_url', 'https://facebook.com/jacketstore', 'text'],
        ['instagram_url', 'https://instagram.com/jacketstore', 'text'],
        ['twitter_url', 'https://twitter.com/jacketstore', 'text'],
        ['whatsapp_number', '+92 300 1234567', 'text'],
        ['google_analytics', 'GA_MEASUREMENT_ID', 'text'],
        ['facebook_pixel', 'FB_PIXEL_ID', 'text']
    ];
    
    foreach ($settings as $setting) {
        $sql = "INSERT IGNORE INTO settings (setting_key, setting_value, setting_type, created_at, updated_at) 
                VALUES (?, ?, ?, NOW(), NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($setting);
    }
    echo "Default settings inserted successfully.\n";
    
    // Insert static pages
    $pages = [
        [
            'About Us',
            'about-us',
            '<h1>About Us</h1><p>Welcome to Jacket Store, your premier destination for high-quality jackets and outerwear. We specialize in providing stylish, durable, and comfortable jackets for all seasons.</p><p>Our commitment to quality and customer satisfaction has made us a trusted name in the fashion industry.</p>',
            'About Us - Jacket Store',
            'Learn more about Jacket Store, your premier destination for high-quality jackets and outerwear.',
            'about us, jacket store, company information'
        ],
        [
            'Contact Us',
            'contact-us',
            '<h1>Contact Us</h1><p>Get in touch with us for any inquiries or support.</p><h3>Contact Information:</h3><ul><li><strong>Email:</strong> info@jacketstore.com</li><li><strong>Phone:</strong> +92 300 1234567</li><li><strong>Address:</strong> 123 Main Street, Karachi, Pakistan</li></ul>',
            'Contact Us - Jacket Store',
            'Contact Jacket Store for inquiries, support, or any questions about our products.',
            'contact us, customer support, jacket store contact'
        ],
        [
            'Privacy Policy',
            'privacy-policy',
            '<h1>Privacy Policy</h1><p>This Privacy Policy describes how Jacket Store collects, uses, and protects your personal information.</p><h3>Information We Collect</h3><p>We collect information you provide directly to us, such as when you create an account, make a purchase, or contact us.</p>',
            'Privacy Policy - Jacket Store',
            'Read our privacy policy to understand how Jacket Store collects, uses, and protects your personal information.',
            'privacy policy, data protection, personal information'
        ],
        [
            'Return Policy',
            'return-policy',
            '<h1>Return Policy</h1><p>We want you to be completely satisfied with your purchase. If you are not satisfied, you may return your item within 30 days of delivery.</p><h3>Return Conditions</h3><ul><li>Item must be unused and in original packaging</li><li>Return within 30 days of delivery</li><li>Original receipt required</li></ul>',
            'Return Policy - Jacket Store',
            'Learn about our return policy, conditions, and process for returning items at Jacket Store.',
            'return policy, refund policy, returns'
        ],
        [
            'Terms and Conditions',
            'terms-and-conditions',
            '<h1>Terms and Conditions</h1><p>By using our website and services, you agree to these terms and conditions.</p><h3>Use of Website</h3><p>You may use our website for lawful purposes only. You may not use our website to transmit any material that is defamatory, offensive, or otherwise objectionable.</p>',
            'Terms and Conditions - Jacket Store',
            'Read our terms and conditions to understand the rules and guidelines for using Jacket Store services.',
            'terms and conditions, terms of service, user agreement'
        ]
    ];
    
    foreach ($pages as $page) {
        $sql = "INSERT IGNORE INTO pages (title, slug, content, page_type, meta_title, meta_description, meta_keywords, status, sort_order, created_at, updated_at) 
                VALUES (?, ?, ?, 'static', ?, ?, ?, 'published', ?, NOW(), NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$page[0], $page[1], $page[2], $page[3], $page[4], $page[5], $page[6]]);
    }
    echo "Static pages inserted successfully.\n";
    
    // Insert sample categories
    $categories = [
        [
            'Men\'s Jackets',
            'mens-jackets',
            'Stylish and comfortable jackets for men',
            'Men\'s Jackets - Jacket Store',
            'Discover our collection of stylish and comfortable men\'s jackets.',
            'men jackets, mens outerwear, men coats'
        ],
        [
            'Women\'s Jackets',
            'womens-jackets',
            'Elegant and trendy jackets for women',
            'Women\'s Jackets - Jacket Store',
            'Explore our elegant collection of women\'s jackets and outerwear.',
            'women jackets, womens outerwear, women coats'
        ],
        [
            'Leather Jackets',
            'leather-jackets',
            'Premium quality leather jackets',
            'Leather Jackets - Jacket Store',
            'Premium quality leather jackets for men and women.',
            'leather jackets, genuine leather, premium jackets'
        ]
    ];
    
    foreach ($categories as $index => $category) {
        $sql = "INSERT IGNORE INTO categories (name, slug, description, meta_title, meta_description, meta_keywords, sort_order, status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 'active', NOW(), NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$category[0], $category[1], $category[2], $category[3], $category[4], $category[5], $index + 1]);
    }
    echo "Sample categories inserted successfully.\n";
    
    echo "\nDatabase setup completed successfully!\n";
    echo "Admin Login Details:\n";
    echo "Username: admin\n";
    echo "Password: chor\n";
    echo "Admin URL: http://localhost/jacket/admin/login\n";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
