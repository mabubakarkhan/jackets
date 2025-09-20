<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <title><?= $meta_title ?? 'Jacket Store - Premium Quality Jackets and Outerwear' ?></title>
    <meta name="description" content="<?= $meta_description ?? 'Discover our premium collection of stylish and comfortable jackets for men and women. Shop the latest trends in outerwear.' ?>">
    <meta name="keywords" content="<?= $meta_keywords ?? 'jackets, outerwear, men jackets, women jackets, leather jackets, winter coats' ?>">
    <meta name="author" content="Jacket Store">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?= $meta_title ?? 'Jacket Store - Premium Quality Jackets and Outerwear' ?>">
    <meta property="og:description" content="<?= $meta_description ?? 'Discover our premium collection of stylish and comfortable jackets for men and women.' ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:image" content="<?= base_url('html/assets/images/og-image.jpg') ?>">
    <meta property="og:site_name" content="Jacket Store">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $meta_title ?? 'Jacket Store - Premium Quality Jackets and Outerwear' ?>">
    <meta name="twitter:description" content="<?= $meta_description ?? 'Discover our premium collection of stylish and comfortable jackets for men and women.' ?>">
    <meta name="twitter:image" content="<?= base_url('html/assets/images/twitter-card.jpg') ?>">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?= current_url() ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('html/assets/images/favicon.ico') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('html/assets/images/apple-touch-icon.png') ?>">
    
    <!-- Preload Critical Resources -->
    <link rel="preload" href="<?= base_url('html/assets/css/style.css') ?>" as="style">
    <link rel="preload" href="<?= base_url('html/assets/js/main.js') ?>" as="script">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="<?= base_url('html/assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('html/assets/css/plugins/owl-carousel/owl.carousel.css') ?>">
    <link rel="stylesheet" href="<?= base_url('html/assets/css/plugins/magnific-popup/magnific-popup.css') ?>">
    <link rel="stylesheet" href="<?= base_url('html/assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('html/assets/css/demos/demo-15.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/pricing.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom styles for image placeholders -->
    <style>
        @font-face {
            font-family: 'molla';
            src: url('<?= base_url('html/assets/fonts/molla0ab2.eot') ?>');
            src: url('<?= base_url('html/assets/fonts/molla0ab2.eot') ?>?#iefix') format('embedded-opentype'),
                 url('<?= base_url('html/assets/fonts/molla0ab2.woff2') ?>') format('woff2'),
                 url('<?= base_url('html/assets/fonts/molla0ab2.woff') ?>') format('woff'),
                 url('<?= base_url('html/assets/fonts/molla0ab2.ttf') ?>') format('truetype'),
                 url('<?= base_url('html/assets/fonts/molla0ab2.svg') ?>#molla') format('svg');
            font-weight: normal;
            font-style: normal;
        }
        /* Product image containers - fixed dimensions */
        .product-image, .product-media > a, .product-main-image {
            position: relative;
            width: 100%;
            height: 280px; /* Fixed height for product cards */
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Product detail page main image - larger */
        .product-main-image {
            height: 500px; /* Larger for product detail page */
        }
        
        /* Ensure images fit properly inside containers */
        .product-image img, .product-media img, .product-main-image img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Maintain aspect ratio, crop if needed */
            object-position: center;
        }
        
        /* Product card alignment fixes */
        .product-card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .product-info {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .product-info h5 {
            height: 48px; /* Fixed height for product titles */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-bottom: 1rem;
            overflow: hidden;
            line-height: 1.2;
        }
        .product-info .price {
            margin-bottom: 1rem;
        }
        
        /* Category page styling */
        .category-header {
            padding: 2rem 0;
        }
        .category-title {
            font-size: 2.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
        }
        .category-description {
            font-size: 1.1rem;
            color: #666;
            line-height: 1.6;
        }
        
        /* Product page gallery styling */
        .product-gallery {
            margin-bottom: 2rem;
        }
        
        /* Fix header overlap and page spacing */
        .page-content {
            padding-top: 2rem;
            margin-top: 0;
        }
        
        .main {
            padding-top: 0;
        }
        
        /* Ensure content is not hidden behind sticky header */
        .main:first-child {
            margin-top: 0;
        }
        
        /* Remove extra padding from main since we have margin-top */
        .main .page-content {
            padding-top: 1rem;
        }
        
        /* Ensure all pages have proper top spacing */
        .main {
            margin-top: 0;
            padding-top: 0;
        }
        
        /* Fix for pages with page-header */
        .page-header {
            margin-top: 0;
        }
        
        /* Fix for pages without page-header */
        .main > .container {
            padding-top: 2rem;
        }
        
        /* Ensure all pages show properly under header */
        .main {
            position: relative;
            z-index: 1;
        }
        
        /* Fix for sticky header */
        .header-middle.sticky-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        
        /* Add top margin to body when header is sticky */
        body.sticky-header-active {
            padding-top: 80px;
        }
        
        /* Ensure all pages have proper top spacing */
        .main {
            margin-top: 0;
            padding-top: 0;
        }
        
        /* Fix for pages with page-header */
        .page-header {
            margin-top: 0;
        }
        
        /* Fix for pages without page-header */
        .main > .container {
            padding-top: 2rem;
        }
        
        /* Ensure all pages show properly under header */
        .main {
            position: relative;
            z-index: 1;
        }
        
        /* Fix for sticky header */
        .header-middle.sticky-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        
        /* Add top margin to body when header is sticky */
        body.sticky-header-active {
            padding-top: 80px;
        }
        
        /* Fix slider image spacing - vertical layout on left side */
        .product-image-gallery {
            display: flex;
            flex-direction: column;
            gap: 0;
            margin-top: 0;
            padding-right: 1rem;
            width: 100% !important;
            max-width: none !important;
        }
        .product-gallery-item {
            width: 150px !important;
            height: auto !important;
            min-width: 150px !important;
            border: 2px solid transparent;
            border-radius: 4px;
            overflow: hidden;
            display: block;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }
        .product-gallery-item.active {
            border-color: #c96;
        }
        .product-gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .product-main-image {
            position: relative;
            margin-bottom: 1rem;
            width: 100%;
        }
        .product-main-image img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            max-height: 500px;
            object-fit: cover;
        }
        .btn-product-gallery {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(0, 0, 0, 0.7);
            border: none;
            border-radius: 50%;
            width: 3rem;
            height: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            z-index: 10;
        }
        .btn-product-gallery:hover {
            background: rgba(0, 0, 0, 0.9);
            color: white;
            text-decoration: none;
        }
        
        /* Color Selection Styles */
        .color-option {
            display: inline-block;
            margin-right: 0.5rem;
            text-decoration: none;
            border: 2px solid transparent;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        .color-option.active {
            border-color: #c96;
        }
        .color-swatch {
            display: block;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        .color-name {
            display: block;
            padding: 0.5rem;
            text-align: center;
            font-size: 0.9rem;
            color: #333;
        }
        
        /* Cart dropdown empty state */
        .dropdown-cart-empty {
            padding: 2rem;
            text-align: center;
        }
        .dropdown-cart-empty p {
            margin-bottom: 1rem;
            color: #666;
        }
        
        /* Cart dropdown loading state */
        .dropdown-cart-loading {
            padding: 2rem;
            text-align: center;
        }
        .dropdown-cart-loading p {
            margin-bottom: 1rem;
            color: #666;
            font-style: italic;
        }

        .product-details {
            padding: 2rem;
            margin-top: 0;
        }
        
        /* Ensure proper spacing for product details top section */
        .product-details-top {
            margin-top: 2rem;
        }
        .product-title {
            font-size: 2.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
        }
        .ratings-container {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        .ratings {
            width: 100px;
            height: 20px;
            background: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            margin-right: 0.5rem;
        }
        .ratings-val {
            height: 100%;
            background: #ffc107;
            border-radius: 10px;
        }
        .ratings-text {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .product-price {
            font-size: 2rem;
            font-weight: 600;
            color: #e74c3c;
            margin-bottom: 1.5rem;
        }
        .product-content {
            margin-bottom: 2rem;
        }
        .details-filter-row {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        .details-filter-row label {
            min-width: 80px;
            font-weight: 600;
            margin-right: 1rem;
        }
        .select-custom {
            flex: 1;
        }
        .product-details-quantity {
            width: 120px;
        }
        .product-details-action {
            margin: 2rem 0;
        }
        .btn-product {
            color: #c96;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 12rem;
            padding: 1.2rem 2rem;
            border: .1rem solid #e5e5e5;
            background-color: #fff;
            text-decoration: none;
            font-weight: 400;
            font-size: 1.3rem;
            letter-spacing: -.01em;
            transition: all .35s ease;
        }
        .btn-product:before {
            font-family: "molla";
            margin-right: .9rem;
        }
        .btn-product span {
            color: #666666;
            font-weight: 400;
            font-size: 1.3rem;
            letter-spacing: -.01em;
            transition: all .35s ease;
        }
        .btn-product:hover, .btn-product:focus {
            outline: none !important;
        }
        .btn-product:hover span, .btn-product:focus span {
            color: #c96;
            box-shadow: 0 1px 0 0 #c96;
        }
        .btn-cart:before {
            content: '\e812';
        }

        .product-details-action .btn-cart {
            color: #c96;
            border-color: #c96;
        }
        .product-details-action .btn-cart:hover, .product-details-action .btn-cart:focus {
            border-color: #c96;
            background-color: #c96;
        }
        .product-details-action .btn-cart:hover span, .product-details-action .btn-cart:focus span {
            color: #fff;
        }


        
        /* Header styling - Exact template match */
        .header {
            width: 100%;
            background-color: #fff;
        }
        
        .header .container,
        .header .container-fluid {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .header-left,
        .header-center,
        .header-right {
            display: flex;
            align-items: center;
        }
        
        .header-right {
            margin-left: auto;
            align-self: stretch;
        }
        
        .header-center {
            margin-left: auto;
            margin-right: auto;
        }
        
        .logo {
            display: block;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
            flex-shrink: 0;
            min-height: 25px;
        }
        
        .logo img {
            display: block;
            max-width: 100%;
            height: auto;
        }
        
        .header-top {
            font-weight: 300;
            font-size: 1.3rem;
            line-height: 1.5;
            letter-spacing: 0;
            color: #777;
            margin-bottom: .1rem;
        }
        
        .header-top a {
            color: inherit;
        }
        
        .header-top a:hover, .header-top a:focus {
            color: #cc9966;
        }
        
        .header-top .container,
        .header-top .container-fluid {
            position: relative;
        }
        
        .header-top .container:after,
        .header-top .container-fluid:after {
            content: '';
            display: block;
            height: 1px;
            position: absolute;
            bottom: -1px;
            left: 10px;
            right: 10px;
            background-color: #ebebeb;
        }
        
        .header-top .top-menu li + li {
            margin-left: 2.6rem;
        }
        
        .top-menu {
            text-transform: uppercase;
            letter-spacing: -.01em;
            margin: 0;
        }
        
        .top-menu > li {
            position: relative;
        }
        
        .top-menu > li > a {
            display: none;
        }
        
        .top-menu ul {
            display: flex;
            align-items: center;
        }
        
        .top-menu li + li {
            margin-left: 3rem;
        }
        
        .top-menu a {
            display: inline-flex;
            align-items: center;
        }
        
        .top-menu i {
            font-size: 1.5rem;
            margin-right: .8rem;
            line-height: 1;
        }
        
        .top-menu i.icon-heart-o {
            margin-top: -.2rem;
        }
        
        .top-menu span {
            color: #cc9966;
            margin-left: .3rem;
        }
        
        .header-dropdown {
            position: relative;
            padding-top: .8rem;
            padding-bottom: .8rem;
        }
        
        .header-dropdown + .header-dropdown {
            margin-left: 2.9rem;
        }
        
        .header-dropdown > a,
        .header-dropdown > span {
            position: relative;
            display: inline-flex;
            padding-top: .2rem;
            padding-bottom: .2rem;
            padding-right: 2.2rem;
            align-items: center;
            text-transform: uppercase;
        }
        
        .header-dropdown > a::after,
        .header-dropdown > span::after {
            font-family: "molla";
            content: '\f110';
            position: absolute;
            right: 0;
            top: 50%;
            display: inline-block;
            font-size: 1.2rem;
            line-height: 1;
            margin-top: -.7rem;
        }
        
        .header-dropdown a:hover, .header-dropdown a:focus {
            text-decoration: none;
        }
        
        .header-menu {
            position: absolute;
            left: -1.5rem;
            top: 100%;
            z-index: 20;
            padding-top: .6rem;
            padding-bottom: .6rem;
            min-width: 100%;
            visibility: hidden;
            opacity: 0;
            background-color: #fff;
            box-shadow: 2px 5px 8px rgba(51, 51, 51, 0.05), -2px 5px 8px rgba(51, 51, 51, 0.05);
            transition: all .25s;
            margin-top: 1px;
        }
        
        .header-dropdown:first-child .header-menu {
            left: 0;
        }
        
        .header-menu:before {
            content: '';
            display: block;
            width: 100%;
            height: .1rem;
            position: absolute;
            top: -1px;
            left: 0;
        }
        
        .header-dropdown:hover > .header-menu, .header-dropdown:focus > .header-menu {
            visibility: visible;
            opacity: 1;
        }
        
        .header-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .header-menu ul li {
            margin: 0;
        }
        
        .header-menu ul a {
            padding: .3rem 1.5rem;
            display: flex;
            align-items: center;
            white-space: nowrap;
        }
        
        .header-menu a {
            color: inherit;
        }
        
        .header-menu a:hover, .header-menu a:focus {
            color: #cc9966;
        }
        
        .header-right .header-menu,
        .header-right .header-dropdown:first-child .header-menu {
            left: auto;
            right: 0;
        }
        
        .header-right .top-menu + .header-dropdown {
            margin-left: 2.5rem;
        }
        
        .header-social {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-left: 2rem;
        }
        
        .header-social a {
            color: #777;
            font-size: 1.4rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .header-social a:hover {
            color: #cc9966;
        }
        
        .header-middle {
            border-bottom: .1rem solid #f4f4f4;
        }
        
        .header-middle .menu > li > a {
            letter-spacing: .01em;
        }
        
        .header-middle .menu.sf-arrows > li > .sf-with-ul {
            padding-right: 1.5rem;
        }
        
        .menu,
        .menu ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        
        .menu {
            display: flex;
            align-items: center;
        }
        
        .menu li {
            position: relative;
        }
        
        .menu li:hover > ul,
        .menu li:hover > .megamenu, .menu li.show > ul,
        .menu li.show > .megamenu {
            display: block;
        }
        
        .menu .megamenu-container {
            position: static;
        }
        
        .menu ul {
            position: absolute;
            display: none;
            top: 100%;
            left: 0;
            z-index: 1002;
        }
        
        .menu ul ul {
            top: -1.6rem;
            left: 100%;
        }
        
        .menu .megamenu {
            display: none;
            position: absolute;
            left: 1.5rem;
            right: 1.5rem;
            top: 100%;
            z-index: 1002;
        }
        
        .menu .megamenu.megamenu-sm {
            left: 0;
            right: auto;
            width: 456px;
        }
        
        .menu .megamenu.megamenu-md {
            left: -10rem;
            right: auto;
            width: 694px;
        }
        
        .menu .megamenu > ul,
        .menu .megamenu div > ul {
            display: block;
            position: static;
            left: auto;
            right: auto;
            top: auto;
            bottom: auto;
            box-shadow: none;
            margin-top: 0;
            padding: 0;
            min-width: 0;
        }
        
        .menu ul,
        .menu .megamenu {
            margin-top: 1px;
        }
        
        .menu ul:before,
        .menu .megamenu:before {
            content: '';
            display: block;
            position: absolute;
            bottom: 100%;
            height: 1px;
            left: 0;
            right: 0;
        }
        
        .menu ul ul,
        .menu .megamenu ul {
            margin-top: 0;
        }
        
        .menu a:not(.btn) {
            display: block;
            position: relative;
            text-decoration: none;
        }
        
        .menu a:not(.btn):focus {
            outline: none !important;
        }
        
        .menu {
            line-height: 1.5;
        }
        
        .menu li > a {
            color: #999999;
            font-weight: 300;
            font-size: 1.3rem;
            letter-spacing: 0;
            padding-top: .5rem;
            padding-bottom: .5rem;
            padding-left: 3rem;
            padding-right: 3rem;
        }
        
        .menu li > a span:not(.tip) {
            position: relative;
        }
        
        .menu > li > a {
            color: #333;
            font-weight: 500;
            font-size: 1.4rem;
            letter-spacing: -.01em;
            padding: 1rem 2rem;
            text-transform: uppercase;
        }
        
        .menu > li + li {
            margin-left: 0;
        }
        
        .menu.sf-arrows > li > .sf-with-ul {
            padding-right: 2rem;
        }
        
        .menu.sf-arrows > li > .sf-with-ul::after {
            font-family: "molla";
            content: '\f110';
            position: absolute;
            right: 1rem;
            top: 50%;
            display: inline-block;
            font-size: 1.2rem;
            line-height: 1;
            margin-top: -.7rem;
        }
        
        .cart-dropdown,
        .compare-dropdown {
            display: flex;
            align-self: stretch;
            align-items: center;
            position: relative;
        }
        
        .cart-dropdown .dropdown-toggle,
        .compare-dropdown .dropdown-toggle {
            position: relative;
            display: flex;
            align-items: center;
            text-decoration: none !important;
            line-height: 1;
            color: #333;
            cursor: pointer;
            z-index: 10;
        }
        
        .cart-dropdown .dropdown-toggle::after,
        .compare-dropdown .dropdown-toggle::after {
            display: none;
        }
        
        .cart-dropdown .dropdown-menu,
        .compare-dropdown .dropdown-menu {
            display: block;
            width: 300px;
            z-index: 9999;
            font-size: 1.3rem;
            border: none;
            margin: 1px 0 0;
            padding: 2.2rem 3rem 2.5rem;
            border-radius: 0;
            border: none;
            box-shadow: 5px 10px 16px rgba(51, 51, 51, 0.05), -5px 10px 16px rgba(51, 51, 51, 0.05);
            background-color: #fff;
            visibility: hidden;
            opacity: 0;
            transition: all .25s;
            position: absolute;
            top: 100%;
            right: 0;
        }
        
        .cart-dropdown .dropdown-menu:before,
        .compare-dropdown .dropdown-menu:before {
            content: '';
            display: block;
            position: absolute;
            bottom: 100%;
            left: 0;
            right: 0;
            height: 1px;
        }
        
        .cart-dropdown .dropdown-menu.dropdown-menu-right,
        .compare-dropdown .dropdown-menu.dropdown-menu-right {
            right: -1px;
        }
        
        .cart-dropdown:hover .dropdown-toggle, .cart-dropdown.show .dropdown-toggle,
        .compare-dropdown:hover .dropdown-toggle,
        .compare-dropdown.show .dropdown-toggle {
            color: #cc9966;
        }
        
        .cart-dropdown:hover .dropdown-menu, .cart-dropdown.show .dropdown-menu,
        .compare-dropdown:hover .dropdown-menu,
        .compare-dropdown.show .dropdown-menu {
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* Ensure cart dropdown is clickable */
        .cart-dropdown .dropdown-menu {
            pointer-events: auto;
        }
        
        .cart-dropdown .dropdown-menu:hover {
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* Cart dropdown content styling */
        .dropdown-cart-products {
            max-height: 300px;
            overflow-y: auto;
        }
        
        .dropdown-cart-products .product {
            display: flex;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #eee;
        }
        
        .dropdown-cart-products .product:last-child {
            border-bottom: none;
        }
        
        .dropdown-cart-products .product-cart-details {
            flex: 1;
            margin-right: 1rem;
        }
        
        .dropdown-cart-products .product-title {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }
        
        .dropdown-cart-products .product-title a {
            color: #333;
            text-decoration: none;
        }
        
        .dropdown-cart-products .cart-product-info {
            color: #666;
            font-size: 1.1rem;
        }
        
        .dropdown-cart-products .product-image-container {
            width: 60px;
            height: 60px;
            margin-right: 1rem;
        }
        
        .dropdown-cart-products .product-image {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .dropdown-cart-products .btn-remove {
            color: #999;
            font-size: 1.4rem;
            text-decoration: none;
            padding: 0.5rem;
        }
        
        .dropdown-cart-products .btn-remove:hover {
            color: #e74c3c;
        }
        
        .dropdown-cart-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-top: 1px solid #eee;
            font-size: 1.4rem;
            font-weight: 600;
        }
        
        .dropdown-cart-action {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .dropdown-cart-action .btn {
            flex: 1;
            text-align: center;
            padding: 0.8rem 1rem;
            font-size: 1.2rem;
        }
        
        .compare-dropdown {
            padding-left: 2.5rem;
        }
        
        .compare-dropdown .dropdown-toggle {
            font-size: 2.6rem;
        }
        
        .cart-count {
            position: absolute;
            top: -.5rem;
            right: -.5rem;
            background: #cc9966;
            color: white;
            border-radius: 50%;
            width: 1.8rem;
            height: 1.8rem;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
        }
        
        /* Main content spacing to avoid header overlap */
        .main {
            margin-top: 20px; /* Minimal spacing between header and content */
        }
        
        /* Breadcrumb and Product Pager */
        .breadcrumb-nav {
            background: #f8f9fa;
            padding: 1rem 0;
        }
        .product-pager {
            display: flex;
            gap: 1rem;
        }
        .product-pager-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        .product-pager-link:hover {
            color: #c96;
        }
        .product-pager-link i {
            font-size: 0.8rem;
        }
        
        /* Product Gallery Enhancements */
        .product-gallery-vertical .row {
            display: flex;
            flex-direction: row;
        }
        .product-main-image {
            position: relative;
            margin-bottom: 1rem;
        }

        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .main {
                margin-top: 10px; /* Minimal margin on mobile */
            }
            
            .header-top {
                display: none; /* Hide top header on mobile */
            }
            
            .header-middle {
                padding: 0.5rem 0;
            }
            
            .header-middle .header-left {
                gap: 1rem;
            }
            
            .header-middle .menu {
                gap: 1rem;
            }
            
            .header-middle .megamenu {
                min-width: 300px;
                padding: 1rem;
            }
            
            .menu > li > a {
                padding: 0.5rem 1rem;
                font-size: 1.2rem;
            }
            
            .logo {
                margin-top: 0.25rem;
                margin-bottom: 0.25rem;
            }
            .product-details-top {
                margin-top: 1rem;
            }
            .product-details {
                padding: 1rem;
            }
            .product-image-gallery {
                flex-direction: row;
                gap: 0;
                padding-right: 0;
                margin-top: 1rem;
                flex-wrap: wrap;
            }
            .product-gallery-item {
                width: 100px !important;
                height: auto !important;
                min-width: 100px !important;
            }

        }
        .product-details-footer {
            border-top: 1px solid #e9ecef;
            padding-top: 1.5rem;
            margin-top: 2rem;
        }
        .product-cat {
            margin-bottom: 1rem;
        }
        .product-cat span {
            font-weight: 600;
            margin-right: 0.5rem;
        }
        .social-icons {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .social-label {
            font-weight: 600;
            margin-right: 0.5rem;
        }
        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            background: #f8f9fa;
            color: #6c757d;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .social-icon:hover {
            background: #007bff;
            color: white;
            text-decoration: none;
        }
        
        /* No image placeholder styling */
        .no-image-placeholder {
            background-color: #f8f9fa;
            border: 2px dashed #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            color: #6c757d;
            text-align: center;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .no-image-placeholder:hover {
            background-color: #e9ecef;
            border-color: #adb5bd;
        }
        
        .placeholder-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }
        
        .placeholder-content i {
            font-size: 2rem;
            opacity: 0.5;
        }
        
        .placeholder-content span {
            font-size: 0.9rem;
            font-weight: 500;
            opacity: 0.7;
        }
        
        /* Larger placeholder for product detail page */
        .product-main-image .placeholder-content i {
            font-size: 3rem;
        }
        
        .product-main-image .placeholder-content span {
            font-size: 1.1rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .product-image, .product-media > a {
                height: 220px; /* Smaller on mobile */
            }
            
            .product-main-image {
                height: 350px; /* Smaller on mobile */
            }
        }
        
        @media (max-width: 576px) {
            .product-image, .product-media > a {
                height: 200px; /* Even smaller on small mobile */
            }
            
            .product-main-image {
                height: 300px; /* Even smaller on small mobile */
            }
        }
        
        /* Filter sidebar styling improvements */
        .widget-title {
            padding: 1.5rem 1rem 1rem 1rem !important;
            margin-bottom: 0 !important;
            font-weight: 600;
            font-size: 1.4rem;
            color: #333;
            border-bottom: 1px solid #eee;
            background: #f8f9fa;
        }
        
        .widget-title a {
            color: inherit !important;
            text-decoration: none !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 0;
        }
        
        .widget-title a:hover {
            color: #007bff !important;
        }
        
        .widget-body {
            padding: 1rem 0 !important;
        }
        
        .filter-item {
            padding: 0.5rem 0;
            border-bottom: 1px solid #f5f5f5;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .filter-item:last-child {
            border-bottom: none;
        }
        
        .item-count {
            background-color: #f8f9fa;
            color: #6c757d;
            padding: 0.2rem 0.5rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .widget-clean {
            padding: 1rem 0;
            border-bottom: 1px solid #eee;
            margin-bottom: 1rem;
        }
        
        .widget-clean label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0;
        }
        
        .sidebar-filter-clear {
            color: #007bff;
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .sidebar-filter-clear:hover {
            color: #0056b3;
            text-decoration: underline;
        }
        
        /* Color filter active state */
        .color-filter.active {
            border-color: #007bff !important;
            transform: scale(1.1);
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
        }
        
        /* Radio button styling */
        .custom-radio .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
    
    <!-- Google Analytics -->
    <?php if (isset($settings['google_analytics']) && !empty($settings['google_analytics'])): ?>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= $settings['google_analytics'] ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?= $settings['google_analytics'] ?>');
    </script>
    <?php endif; ?>
    
    <!-- Facebook Pixel -->
    <?php if (isset($settings['facebook_pixel']) && !empty($settings['facebook_pixel'])): ?>
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '<?= $settings['facebook_pixel'] ?>');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=<?= $settings['facebook_pixel'] ?>&ev=PageView&noscript=1"
    /></noscript>
    <?php endif; ?>
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "<?= $settings['site_name'] ?? 'Jacket Store' ?>",
        "description": "<?= $settings['site_description'] ?? 'Premium Quality Jackets and Outerwear' ?>",
        "url": "<?= base_url() ?>",
        "logo": "<?= base_url('html/assets/images/logo.png') ?>",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "<?= $settings['site_phone'] ?? '' ?>",
            "contactType": "customer service",
            "email": "<?= $settings['site_email'] ?? '' ?>"
        },
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "<?= $settings['site_address'] ?? '' ?>",
            "addressCountry": "PK"
        },
        "sameAs": [
            "<?= $settings['facebook_url'] ?? '' ?>",
            "<?= $settings['instagram_url'] ?? '' ?>",
            "<?= $settings['twitter_url'] ?? '' ?>"
        ]
    }
    </script>
</head>
<body>
    <!-- WhatsApp Floating Button -->
    <?php if (isset($settings['whatsapp_number']) && !empty($settings['whatsapp_number'])): ?>
    <div class="whatsapp-float">
        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $settings['whatsapp_number']) ?>?text=Hi, I'm interested in your jackets" target="_blank" rel="noopener">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>
    <?php endif; ?>

    <!-- Header -->
    <?php if (isset($header_override) && $header_override): ?>
        <?= $this->include('partials/header-inner') ?>
    <?php else: ?>
        <?= $this->include('partials/header') ?>
    <?php endif; ?>

    <!-- Main Content -->
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <?= $this->include('partials/footer') ?>

    <!-- JavaScript Files -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        if (typeof jQuery === 'undefined') {
            document.write('<script src="<?= base_url('html/assets/js/jquery.min.js') ?>"><\/script>');
        }
    </script>
    <script src="<?= base_url('html/assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('html/assets/js/owl.carousel.min.js') ?>"></script>
    <script src="<?= base_url('html/assets/js/jquery.magnific-popup.min.js') ?>"></script>
    <script src="<?= base_url('html/assets/js/jquery.waypoints.min.js') ?>"></script>
    <script src="<?= base_url('html/assets/js/main.js') ?>"></script>
    
    <!-- Search Functionality -->
    <script>
    // Vanilla JavaScript fallback for search functionality
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Search functionality initializing...');
        
        // Search toggle functionality
        document.addEventListener('click', function(e) {
            console.log('Click detected on:', e.target);
            
            // Check if clicked element is search toggle or inside it
            var searchToggle = e.target.closest('#searchToggle');
            if (searchToggle) {
                console.log('Search toggle clicked!');
                e.preventDefault();
                e.stopPropagation();
                
                var searchWrapper = document.getElementById('searchWrapper');
                console.log('Search wrapper found:', searchWrapper);
                
                if (searchWrapper) {
                    if (searchWrapper.style.display === 'none' || searchWrapper.style.display === '') {
                        searchWrapper.style.display = 'block';
                        console.log('Search form opened');
                        var searchInput = document.getElementById('q');
                        if (searchInput) {
                            searchInput.focus();
                        }
                    } else {
                        searchWrapper.style.display = 'none';
                        console.log('Search form closed');
                    }
                }
                return;
            }
            
            // Close search when clicking outside
            if (!e.target.closest('.header-search')) {
                var searchWrapper = document.getElementById('searchWrapper');
                if (searchWrapper && searchWrapper.style.display === 'block') {
                    searchWrapper.style.display = 'none';
                    console.log('Search form closed by outside click');
                }
            }
        });
        
        // Handle search form submission
        document.addEventListener('submit', function(e) {
            if (e.target.classList.contains('search-form')) {
                var query = e.target.querySelector('input[name="q"]').value.trim();
                if (query === '') {
                    e.preventDefault();
                    alert('Please enter a search term');
                    return false;
                }
            }
        });
        
        console.log('Search functionality initialized');
        
        // Test if search toggle element exists
        var searchToggle = document.getElementById('searchToggle');
        if (searchToggle) {
            console.log('Search toggle element found:', searchToggle);
            searchToggle.addEventListener('click', function(e) {
                console.log('Direct click event on search toggle!');
                e.preventDefault();
                e.stopPropagation();
                
                var searchWrapper = document.getElementById('searchWrapper');
                if (searchWrapper) {
                    if (searchWrapper.style.display === 'none' || searchWrapper.style.display === '') {
                        searchWrapper.style.display = 'block';
                        console.log('Search form opened via direct event');
                        var searchInput = document.getElementById('q');
                        if (searchInput) {
                            searchInput.focus();
                        }
                    } else {
                        searchWrapper.style.display = 'none';
                        console.log('Search form closed via direct event');
                    }
                }
            });
        } else {
            console.log('Search toggle element NOT found!');
        }
    });
    
    // jQuery version (when available)
    jQuery(document).ready(function($) {
        // Search toggle functionality
        $(document).on('click', '#searchToggle', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('#searchWrapper').slideToggle(300);
            $('#q').focus();
        });
        
        // Close search when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.header-search').length) {
                $('#searchWrapper').slideUp(300);
            }
        });
        
        // Prevent search form from closing when clicking inside
        $(document).on('click', '.search-form, .header-search-wrapper', function(e) {
            e.stopPropagation();
        });
        
        // Handle search form submission
        $(document).on('submit', '.search-form', function(e) {
            var query = $(this).find('input[name="q"]').val().trim();
            if (query === '') {
                e.preventDefault();
                alert('Please enter a search term');
                return false;
            }
        });
    });
    </script>

    <style>
        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
        }
        .whatsapp-float a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            background: #25d366;
            color: white;
            border-radius: 50%;
            text-decoration: none;
            font-size: 30px;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
            transition: all 0.3s ease;
        }
        .whatsapp-float a:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.6);
            color: white;
        }
        .whatsapp-float a:active {
            transform: scale(0.95);
        }
    </style>
    
    <!-- Global Cart Update Script -->
    <script>
    // Global function to update cart count and dropdown
    function updateCartDisplay(cartCount, cartTotal) {
        console.log('Updating cart display - Count:', cartCount, 'Total:', cartTotal);
        
        // Update cart count in header
        const cartCountElements = document.querySelectorAll('.cart-count');
        cartCountElements.forEach(element => {
            element.textContent = cartCount;
        });
        
        // Update cart dropdown content
        updateCartDropdown();
    }
    
    // Function to update cart dropdown content
    function updateCartDropdown() {
        const dropdown = document.querySelector('#cart-dropdown-menu');
        if (!dropdown) {
            console.log('Cart dropdown element not found');
            return;
        }
        
        console.log('Updating cart dropdown...');
        
        // Don't show the dropdown automatically, let hover/click handle it
        
        // Show loading state
        dropdown.innerHTML = '<div class="dropdown-cart-loading"><p>Loading cart...</p></div>';
        
        // Fetch current cart data
        fetch('<?= base_url('shop/get-cart-data') ?>', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('Cart data response:', response);
            if (!response.ok) {
                throw new Error('HTTP error! status: ' + response.status);
            }
            return response.text(); // Get as text first
        })
        .then(text => {
            console.log('Cart data text:', text);
            try {
                const data = JSON.parse(text);
                console.log('Cart data received:', data);
                if (data.success) {
                    dropdown.innerHTML = data.html;
                } else {
                    dropdown.innerHTML = '<div class="dropdown-cart-empty"><p>Your cart is empty</p><a href="<?= base_url('shop') ?>" class="btn btn-primary btn-sm">Start Shopping</a></div>';
                }
            } catch (parseError) {
                console.error('JSON parse error:', parseError);
                console.error('Response text:', text);
                dropdown.innerHTML = '<div class="dropdown-cart-empty"><p>Your cart is empty</p><a href="<?= base_url('shop') ?>" class="btn btn-primary btn-sm">Start Shopping</a></div>';
            }
        })
        .catch(error => {
            console.error('Error updating cart dropdown:', error);
            dropdown.innerHTML = '<div class="dropdown-cart-empty"><p>Your cart is empty</p><a href="<?= base_url('shop') ?>" class="btn btn-primary btn-sm">Start Shopping</a></div>';
        });
    }
    
    // Function to hide cart dropdown
    function hideCartDropdown() {
        const dropdown = document.querySelector('#cart-dropdown-menu');
        if (dropdown) {
            dropdown.style.visibility = 'hidden';
            dropdown.style.opacity = '0';
        }
    }
    
    // Load cart content when page loads - simplified to avoid excessive requests
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Page loaded, cart will load on click only');
        // Cart will only load when user clicks on cart icon
    });
    
    // Load cart content when dropdown is clicked
    document.addEventListener('click', function(e) {
        if (e.target && e.target.closest && e.target.closest('.cart-dropdown .dropdown-toggle')) {
            console.log('Cart dropdown clicked');
            e.preventDefault();
            e.stopPropagation();
            updateCartDropdown();
            // Show the dropdown
            const dropdown = document.querySelector('#cart-dropdown-menu');
            if (dropdown) {
                dropdown.style.visibility = 'visible';
                dropdown.style.opacity = '1';
            }
        } else if (e.target && e.target.closest && !e.target.closest('.cart-dropdown')) {
            // Hide cart dropdown when clicking outside
            hideCartDropdown();
        }
    });
    
    // Removed hover functionality to prevent excessive requests
    
    // Add event listeners for cart dropdown remove buttons
    document.addEventListener('click', function(e) {
        if (e.target && e.target.closest && e.target.closest('.btn-remove')) {
            e.preventDefault();
            const cartKey = e.target.closest('.btn-remove').getAttribute('data-cart-key');
            if (cartKey) {
                removeFromCartDropdown(cartKey);
            }
        }
    });
    
    // Function to remove item from cart dropdown
    function removeFromCartDropdown(cartKey) {
        const formData = new FormData();
        formData.append('cart_key', cartKey);
        
        fetch('<?= base_url('shop/remove-from-cart') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartDisplay(data.cart_count, data.cart_total);
            }
        })
        .catch(error => {
            console.error('Error removing from cart:', error);
        });
    }
    </script>
    
    <style>
        /* Fix header overlapping issue - Force proper positioning */
        .header-middle.sticky-header {
            top: 40px !important; /* Position below the top header */
            position: fixed !important;
            left: 0 !important;
            right: 0 !important;
            z-index: 1000 !important;
        }
        
        body.sticky-header-active {
            padding-top: 120px !important; /* Account for both headers */
        }
        
        .header-top {
            position: relative !important;
            z-index: 1001 !important;
        }
        
        /* Ensure main content starts below header */
        .main {
            margin-top: 0 !important;
            padding-top: 0 !important;
            position: relative !important;
            z-index: 1 !important;
        }
        
        /* Force page content below header */
        .page-content {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
        
        /* Add top spacing for pages without page-header */
        .main:not(:has(.page-header)) {
            padding-top: 2rem !important;
        }
        
        /* Additional header overlap fixes */
        .page-header {
            margin-top: 120px !important;
        }
        
        /* Force body to account for fixed header */
        body {
            padding-top: 0 !important;
        }
        
        /* Ensure all content is below header */
        .main > .container:first-child {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
        
        /* Specific spacing for different page types */
        .main:not(:has(.page-header)) {
            padding-top: 2rem !important;
        }
        
.main:has(.page-header) {
    padding-top: 0 !important;
}

/* Add space between page content and footer */
.main {
    margin-bottom: 3rem !important;
    padding-bottom: 2rem !important;
}
    </style>
</body>
</html>

