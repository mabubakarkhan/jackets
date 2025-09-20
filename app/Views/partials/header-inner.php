<header class="header">
    <div class="header-top">
        <div class="container">
            <div class="header-left">
                <div class="header-dropdown">
                    <a href="#">Usd</a>
                    <div class="header-menu">
                        <ul>
                            <li><a href="#">Eur</a></li>
                            <li><a href="#">Usd</a></li>
                        </ul>
                    </div><!-- End .header-menu -->
                </div><!-- End .header-dropdown -->

                <div class="header-dropdown">
                    <a href="#">Eng</a>
                    <div class="header-menu">
                        <ul>
                            <li><a href="#">English</a></li>
                            <li><a href="#">French</a></li>
                            <li><a href="#">Spanish</a></li>
                        </ul>
                    </div><!-- End .header-menu -->
                </div><!-- End .header-dropdown -->
            </div><!-- End .header-left -->

            <div class="header-right">
                <ul class="top-menu">
                    <li>
                        <a href="#">Links</a>
                        <ul>
                            <li><a href="tel:<?= $settings['site_phone'] ?? '+0123 456 789' ?>"><i class="icon-phone"></i>Call: <?= $settings['site_phone'] ?? '+0123 456 789' ?></a></li>
                            <li><a href="mailto:<?= $settings['site_email'] ?? 'info@example.com' ?>"><i class="icon-envelope"></i><?= $settings['site_email'] ?? 'info@example.com' ?></a></li>
                            <li><a href="<?= base_url('about-us') ?>">About Us</a></li>
                            <li><a href="<?= base_url('contact-us') ?>">Contact Us</a></li>
                            <li><a href="<?= base_url('cart') ?>"><i class="icon-shopping-cart"></i>Cart</a></li>
                            <li><a href="#signin-modal" data-toggle="modal"><i class="icon-user"></i>Login</a></li>
                        </ul>
                    </li>
                </ul><!-- End .top-menu -->
                
                <!-- Social Media Links -->
                <div class="header-social">
                    <?php if (!empty($settings['facebook_url'])): ?>
                        <a href="<?= $settings['facebook_url'] ?>" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($settings['twitter_url'])): ?>
                        <a href="<?= $settings['twitter_url'] ?>" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($settings['instagram_url'])): ?>
                        <a href="<?= $settings['instagram_url'] ?>" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
                    <?php endif; ?>
                </div><!-- End .header-social -->
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-top -->

    <div class="header-middle sticky-header">
        <div class="container">
            <div class="header-left">
                <button class="mobile-menu-toggler">
                    <span class="sr-only">Toggle mobile menu</span>
                    <i class="icon-bars"></i>
                </button>

                <a href="<?= base_url() ?>" class="logo">
                    <img src="<?= base_url('html/assets/images/logo.png') ?>" alt="<?= $settings['site_name'] ?? 'Molla Logo' ?>" width="105" height="25">
                </a>

                <nav class="main-nav">
                    <ul class="menu sf-arrows">
                        <li class="megamenu-container">
                            <a href="<?= base_url() ?>" class="sf-with-ul">Home</a>
                        </li>
                        <li>
                            <a href="<?= base_url('shop') ?>" class="sf-with-ul">Shop</a>

                            <div class="megamenu megamenu-md">
                                <div class="row no-gutters">
                                    <div class="col-md-8">
                                        <div class="menu-col">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="menu-title">Shop Categories</div><!-- End .menu-title -->
                                                    <ul>
                                                        <li><a href="<?= base_url('shop') ?>">All Products</a></li>
                                                        <li><a href="<?= base_url('category/mens-jackets') ?>">Men's Jackets</a></li>
                                                        <li><a href="<?= base_url('category/womens-jackets') ?>">Women's Jackets</a></li>
                                                        <li><a href="<?= base_url('category/leather-jackets') ?>">Leather Jackets</a></li>
                                                        <li><a href="<?= base_url('category/winter-coats') ?>">Winter Coats</a></li>
                                                    </ul>
                                                </div><!-- End .col-md-6 -->

                                                <div class="col-md-6">
                                                    <div class="menu-title">Shop Pages</div><!-- End .menu-title -->
                                                    <ul>
                                                        <li><a href="<?= base_url('cart') ?>">Cart</a></li>
                                                        <li><a href="<?= base_url('checkout') ?>">Checkout</a></li>
                                                        <li><a href="<?= base_url('wishlist') ?>">Wishlist</a></li>
                                                        <li><a href="<?= base_url('account') ?>">My Account</a></li>
                                                    </ul>
                                                </div><!-- End .col-md-6 -->
                                            </div><!-- End .row -->
                                        </div><!-- End .menu-col -->
                                    </div><!-- End .col-md-8 -->

                                    <div class="col-md-4">
                                        <div class="banner banner-overlay">
                                            <a href="<?= base_url('shop') ?>" class="banner banner-menu">
                                                <img src="<?= base_url('html/assets/images/menu/banner-1.jpg') ?>" alt="Banner">

                                                <div class="banner-content banner-content-top">
                                                    <div class="banner-title text-white">New <br>Collection<br><span><strong>2024</strong></span></div><!-- End .banner-title -->
                                                </div><!-- End .banner-content -->
                                            </a>
                                        </div><!-- End .banner banner-overlay -->
                                    </div><!-- End .col-md-4 -->
                                </div><!-- End .row -->
                            </div><!-- End .megamenu megamenu-md -->
                        </li>
                        <li>
                            <a href="<?= base_url('shop') ?>" class="sf-with-ul">Product</a>

                            <div class="megamenu megamenu-sm">
                                <div class="row no-gutters">
                                    <div class="col-md-6">
                                        <div class="menu-col">
                                            <div class="menu-title">Product Details</div><!-- End .menu-title -->
                                            <ul>
                                                <li><a href="<?= base_url('product/sample') ?>">Default</a></li>
                                                <li><a href="<?= base_url('product/sample') ?>">Gallery</a></li>
                                                <li><a href="<?= base_url('product/sample') ?>">Full Width</a></li>
                                            </ul>
                                        </div><!-- End .menu-col -->
                                    </div><!-- End .col-md-6 -->

                                    <div class="col-md-6">
                                        <div class="banner banner-overlay">
                                            <a href="<?= base_url('shop') ?>">
                                                <img src="<?= base_url('html/assets/images/menu/banner-2.jpg') ?>" alt="Banner">

                                                <div class="banner-content banner-content-bottom">
                                                    <div class="banner-title text-white">Premium<br><span><strong>Jackets</strong></span></div><!-- End .banner-title -->
                                                </div><!-- End .banner-content -->
                                            </a>
                                        </div><!-- End .banner -->
                                    </div><!-- End .col-md-6 -->
                                </div><!-- End .row -->
                            </div><!-- End .megamenu megamenu-sm -->
                        </li>
                        <li>
                            <a href="#" class="sf-with-ul">Pages</a>

                            <ul>
                                <li>
                                    <a href="<?= base_url('about-us') ?>" class="sf-with-ul">About</a>
                                </li>
                                <li>
                                    <a href="<?= base_url('contact-us') ?>" class="sf-with-ul">Contact</a>
                                </li>
                                <li><a href="<?= base_url('login') ?>">Login</a></li>
                                <li><a href="<?= base_url('faq') ?>">FAQs</a></li>
                                <li><a href="<?= base_url('privacy-policy') ?>">Privacy Policy</a></li>
                                <li><a href="<?= base_url('terms-conditions') ?>">Terms & Conditions</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?= base_url('blog') ?>" class="sf-with-ul">Blog</a>

                            <ul>
                                <li><a href="<?= base_url('blog') ?>">Blog List</a></li>
                                <li><a href="<?= base_url('blog/category/fashion') ?>">Fashion</a></li>
                                <li><a href="<?= base_url('blog/category/style') ?>">Style Tips</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?= base_url('cart') ?>">Cart</a>
                        </li>
                    </ul><!-- End .menu -->
                </nav><!-- End .main-nav -->
            </div><!-- End .header-left -->

            <div class="header-right">
                <div class="header-search">
                    <a href="#" class="search-toggle" role="button" id="searchToggle" title="Search"><i class="icon-search"></i></a>
                    <div class="header-search-wrapper" id="searchWrapper" style="display: none;">
                        <form action="<?= base_url('search') ?>" method="get" class="search-form">
                            <div class="input-group">
                                <label for="q" class="sr-only">Search</label>
                                <input type="search" class="form-control" name="q" id="q" placeholder="Search products..." required>
                                <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div><!-- End .header-search-wrapper -->
                </div><!-- End .header-search -->


                <div class="dropdown cart-dropdown">
                    <a href="<?= base_url('cart') ?>" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                        <i class="icon-shopping-cart"></i>
                        <span class="cart-count"><?= session()->get('cart') ? array_sum(array_column(session()->get('cart'), 'quantity')) : 0 ?></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" id="cart-dropdown-menu">
                        <!-- Cart content will be loaded dynamically via JavaScript -->
                        <div class="dropdown-cart-loading">
                            <p>Loading cart...</p>
                        </div>
                    </div><!-- End .dropdown-menu -->
                </div><!-- End .cart-dropdown -->
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-middle -->
</header><!-- End .header -->

<style>
.header-search {
    position: relative;
}

.header-search-wrapper {
    position: absolute;
    top: 100%;
    right: 0;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    z-index: 1000;
    min-width: 300px;
    padding: 15px;
}

.header-5 .header-search .header-search-wrapper {
    background: #fff;
}

.header-search .btn {
    margin-top: -11px;
}

.search-form .input-group {
    display: flex;
    align-items: center;
}

.search-form .form-control {
    border: 1px solid #ddd;
    border-radius: 4px 0 0 4px;
    padding: 8px 12px;
    font-size: 14px;
    flex: 1;
}

.search-form .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    outline: none;
}

.search-form .btn {
    border-radius: 0 4px 4px 0;
    padding: 8px 15px;
    border: 1px solid #007bff;
    background: #007bff;
    color: #fff;
    transition: all 0.3s ease;
}

.search-form .btn:hover {
    background: #0056b3;
    border-color: #0056b3;
}

.search-toggle {
    color: #333;
    text-decoration: none;
    padding: 8px;
    border-radius: 4px;
    transition: all 0.3s ease;
    cursor: pointer;
    display: inline-block;
    position: relative;
    z-index: 10;
}

.search-toggle:hover {
    color: #007bff;
    background: #f8f9fa;
}

.search-toggle i {
    font-size: 18px;
    pointer-events: none;
}

.search-toggle.active {
    color: #007bff;
    background: #f8f9fa;
}
</style>
