<?php

/**
 * Application Constants
 * 
 * This file contains application-wide constants and functions
 * that are available throughout the entire application.
 */

// Define missing constants for CodeIgniter
if (!defined('COMPOSER_PATH')) {
    define('COMPOSER_PATH', '');
}

if (!defined('APP_NAMESPACE')) {
    define('APP_NAMESPACE', 'App');
}

// Define missing debug constants
if (!defined('EXIT_ERROR')) {
    define('EXIT_ERROR', 1);
}

if (!defined('EXIT_SUCCESS')) {
    define('EXIT_SUCCESS', 0);
}

if (!defined('EXIT_CONFIG')) {
    define('EXIT_CONFIG', 3);
}

// Define missing path constants
if (!defined('WRITEPATH')) {
    define('WRITEPATH', FCPATH . 'writable' . DIRECTORY_SEPARATOR);
}

if (!defined('FCPATH')) {
    define('FCPATH', realpath(__DIR__ . '/../../public/') . DIRECTORY_SEPARATOR);
}

if (!defined('EXIT_UNKNOWN_FILE')) {
    define('EXIT_UNKNOWN_FILE', 4);
}

if (!defined('EXIT_UNKNOWN_CLASS')) {
    define('EXIT_UNKNOWN_CLASS', 5);
}

if (!defined('EXIT_UNKNOWN_METHOD')) {
    define('EXIT_UNKNOWN_METHOD', 6);
}

if (!defined('EXIT_USER_INPUT')) {
    define('EXIT_USER_INPUT', 7);
}

if (!defined('EXIT_DATABASE')) {
    define('EXIT_DATABASE', 8);
}

if (!defined('EXIT__AUTO_MIN')) {
    define('EXIT__AUTO_MIN', 9);
}

if (!defined('EXIT__AUTO_MAX')) {
    define('EXIT__AUTO_MAX', 125);
}

// Pricing Helper Functions
if (!function_exists('format_product_price')) {
    /**
     * Format product price with proper sale price logic
     * 
     * @param float $price Original price
     * @param float|null $sale_price Sale price (optional)
     * @param bool $show_html Whether to return HTML or plain text
     * @return string Formatted price
     */
    function format_product_price($price, $sale_price = null, $show_html = true)
    {
        // Ensure sale price is valid and lower than original price
        $has_sale = $sale_price && $sale_price > 0 && $sale_price < $price;
        
        if ($show_html) {
            if ($has_sale) {
                return sprintf(
                    '<span class="old-price">$%s</span><span class="new-price">$%s</span>',
                    number_format($price, 2),
                    number_format($sale_price, 2)
                );
            } else {
                return sprintf('<span class="new-price">$%s</span>', number_format($price, 2));
            }
        } else {
            if ($has_sale) {
                return '$' . number_format($sale_price, 2);
            } else {
                return '$' . number_format($price, 2);
            }
        }
    }
}

if (!function_exists('get_discount_percentage')) {
    /**
     * Calculate discount percentage
     * 
     * @param float $original_price
     * @param float $sale_price
     * @return int Discount percentage
     */
    function get_discount_percentage($original_price, $sale_price)
    {
        if ($sale_price >= $original_price) {
            return 0;
        }
        
        return round((($original_price - $sale_price) / $original_price) * 100);
    }
}

if (!function_exists('format_price_with_discount')) {
    /**
     * Format price with discount badge
     * 
     * @param float $price Original price
     * @param float|null $sale_price Sale price (optional)
     * @return string Formatted price with discount
     */
    function format_price_with_discount($price, $sale_price = null)
    {
        $has_sale = $sale_price && $sale_price > 0 && $sale_price < $price;
        
        if ($has_sale) {
            $discount = get_discount_percentage($price, $sale_price);
            return sprintf(
                '<div class="price-comparison">
                    <span class="current-price">$%s</span>
                    <span class="original-price">$%s</span>
                    <span class="discount-percentage">-%d%%</span>
                </div>',
                number_format($sale_price, 2),
                number_format($price, 2),
                $discount
            );
        } else {
            return sprintf('<span class="new-price">$%s</span>', number_format($price, 2));
        }
    }
}