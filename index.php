<?php

/**
 * CodeIgniter Front Controller
 * 
 * This file serves as the main entry point for the application.
 * It redirects all requests to the public folder where the actual
 * CodeIgniter application is located.
 */

// Define the path to the public directory
$publicPath = __DIR__ . '/public';

// Get the requested URI
$requestUri = $_SERVER['REQUEST_URI'];

// Remove the base path if it exists
$basePath = '/jacket';
if (strpos($requestUri, $basePath) === 0) {
    $requestUri = substr($requestUri, strlen($basePath));
}

// If the request is for the root, redirect to public
if ($requestUri === '/' || $requestUri === '') {
    $requestUri = '/public/';
}

// Build the full path to the public directory
$fullPath = $publicPath . $requestUri;

// If it's a file request, serve it directly
if (file_exists($fullPath) && is_file($fullPath)) {
    // Set appropriate content type
    $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
    $mimeTypes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
    ];
    
    if (isset($mimeTypes[$extension])) {
        header('Content-Type: ' . $mimeTypes[$extension]);
    }
    
    readfile($fullPath);
    exit;
}

// For all other requests, include the public/index.php
require_once $publicPath . '/index.php';
