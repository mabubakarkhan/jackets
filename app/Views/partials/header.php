<header class="header header-5">
    <div class="header-middle sticky-header">
        <div class="container-fluid">
            <div class="header-left">
                <button class="mobile-menu-toggler">
                    <span class="sr-only">Toggle mobile menu</span>
                    <i class="icon-bars"></i>
                </button>

                <a href="<?= base_url() ?>" class="logo">
                    <img src="<?= base_url('assets/images/demos/demo-15/logo.png') ?>" alt="<?= $settings['site_name'] ?? 'Jacket Store' ?>" width="105" height="25">
                </a>

                <nav class="main-nav">
                    <ul class="menu sf-arrows">
                        <li class="megamenu-container active">
                            <a href="<?= base_url() ?>" class="sf-with-ul">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="<?= base_url('shop') ?>" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                            <ul class="dropdown-menu">
                                <li><h6 class="dropdown-header">Categories</h6></li>
                                <li><a class="dropdown-item" href="<?= base_url('category/mens-jackets') ?>">Men's Jackets</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('category/womens-jackets') ?>">Women's Jackets</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('category/leather-jackets') ?>">Leather Jackets</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= base_url('shop') ?>">All Products</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?= base_url('about-us') ?>">About Us</a>
                        </li>
                        <li>
                            <a href="<?= base_url('contact-us') ?>">Contact</a>
                        </li>
                        <li>
                            <a href="<?= base_url('blog') ?>">Blog</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="header-right">
                <div class="header-search">
                    <a href="#" class="search-toggle" role="button" id="searchToggle"><i class="icon-search"></i></a>
                    <div class="header-search-wrapper" id="searchWrapper" style="display: none;">
                        <form action="<?= base_url('search') ?>" method="get" class="search-form">
                            <div class="input-group">
                                <label for="q" class="sr-only">Search</label>
                                <input type="search" class="form-control" name="q" id="q" placeholder="Search products..." required>
                                <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="header-contact">
                    <span class="contact-label">Customer Service</span>
                    <a href="tel:<?= $settings['site_phone'] ?? '' ?>"><?= $settings['site_phone'] ?? '' ?></a>
                </div>

                <div class="dropdown cart-dropdown">
                    <a href="<?= base_url('cart') ?>" class="dropdown-toggle">
                        <i class="icon-shopping-cart"></i>
                        <span class="cart-count">0</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

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

