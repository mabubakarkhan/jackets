<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<!-- Hero Slider Section -->
<div class="intro-slider-container">
    <div class="intro-slider owl-carousel owl-simple owl-nav-inside owl-light" data-toggle="owl" data-owl-options='{"nav":false, "dots": true, "autoplay": true, "autoplayTimeout": 5000, "loop": true}'>
        <?php if (!empty($sliders)): ?>
            <?php foreach ($sliders as $slider): ?>
                <div class="intro-slide" style="background-image: url(<?= base_url('public/uploads/sliders/' . $slider['image']) ?>);">
                    <div class="container intro-content text-center">
                        <?php if (!empty($slider['subtitle'])): ?>
                            <h3 class="intro-subtitle"><?= esc($slider['subtitle']) ?></h3>
                        <?php endif; ?>
                        <h1 class="intro-title text-white"><?= esc($slider['title']) ?></h1>
                        <?php if (!empty($slider['description'])): ?>
                            <p class="intro-text text-white"><?= esc($slider['description']) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($slider['button_text']) && !empty($slider['button_url'])): ?>
                            <a href="<?= esc($slider['button_url']) ?>" class="btn btn-outline-primary-2">
                                <span><?= esc($slider['button_text']) ?></span>
                                <i class="icon-long-arrow-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Fallback slider -->
            <div class="intro-slide" style="background-image: url(<?= !empty($settings['hero_image']) ? $settings['hero_image'] : base_url('assets/images/demos/demo-15/slider/slide-1.jpg') ?>);">
                <div class="container intro-content text-center">
                    <h3 class="intro-subtitle">Want to know what's hot?</h3>
                    <h1 class="intro-title text-white">Premium Jackets Collection 2024</h1>
                    <a href="#scroll-to-content" class="btn btn-outline-primary-2 scroll-to">
                        <span>Discover Now</span>
                        <i class="icon-long-arrow-right"></i>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <span class="slider-loader text-white"></span>
</div>

<!-- Featured Products Section -->
<div class="display-row" id="scroll-to-content">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-6 order-lg-last">
                <div class="banner banner-overlay">
                    <a href="<?= base_url('shop') ?>">
                        <?php if (!empty($featured_products) && !empty($featured_products[0]['images'])): ?>
                            <img src="<?= base_url('public/uploads/products/' . $featured_products[0]['images'][0]['image_path']) ?>" alt="Featured Product">
                        <?php else: ?>
                            <img src="<?= base_url('assets/images/demos/demo-15/banners/banner-1.jpg') ?>" alt="Featured Product">
                        <?php endif; ?>
                    </a>

                    <div class="banner-content men">
                        <h2 class="banner-title text-white">01. Get your <br>inspiration <br>in the street.</h2>
                        <h3 class="banner-subtitle text-brightblack">IN THIS LOOK</h3>

                        <ul class="text-white">
                            <?php if (!empty($featured_products)): ?>
                                <?php foreach (array_slice($featured_products, 0, 2) as $product): ?>
                                    <li><?= esc($product['name']) ?></li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li>Premium Jacket</li>
                                <li>Stylish Outerwear</li>
                            <?php endif; ?>
                        </ul>

                        <div class="banner-text text-brightblack">
                            <?php if (!empty($featured_products)): ?>
                                $<?= number_format(min(array_column($featured_products, 'price')), 2) ?> - $<?= number_format(max(array_column($featured_products, 'price')), 2) ?>
                            <?php else: ?>
                                $98.00 - $1,298.00
                            <?php endif; ?>
                        </div>
                        <a href="<?= base_url('shop') ?>" class="btn btn-outline-primary-2"><span>Shop All</span><i class="icon-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="heading text-center">
                    <h2 class="title">About This Look</h2>
                    <p class="title-desc">Discover our curated collection of premium jackets designed for the modern lifestyle. Each piece is carefully selected to provide both style and functionality.</p>
                </div>

                <div class="row">
                    <?php if (!empty($featured_products)): ?>
                        <?php foreach (array_slice($featured_products, 0, 2) as $product): ?>
                            <div class="col-6">
                                <div class="product product-4">
                                    <figure class="product-media">
                                        <a href="<?= base_url('product/' . $product['slug']) ?>">
                                            <?php if (!empty($product['images'])): ?>
                                                <img src="<?= base_url('public/uploads/products/' . $product['images'][0]['image_path']) ?>" alt="<?= esc($product['name']) ?>" class="product-image">
                                            <?php else: ?>
                                                <img src="<?= base_url('assets/images/demos/demo-15/products/product-1.jpg') ?>" alt="<?= esc($product['name']) ?>" class="product-image">
                                            <?php endif; ?>
                                        </a>



                                        <div class="product-action">
                                            <a href="<?= base_url('product/' . $product['slug']) ?>" class="btn-product btn-cart"><span>add to cart</span></a>
                                        </div>
                                    </figure>

                                    <div class="product-body">
                                        <div class="product-cat">
                                            <a href="<?= base_url('category/' . $product['category_id']) ?>">Jackets</a>
                                        </div>
                                        <h3 class="product-title"><a href="<?= base_url('product/' . $product['slug']) ?>"><?= esc($product['name']) ?></a></h3>
                                        <div class="product-price">
                                            <?= format_product_price($product['price'], $product['sale_price'] ?? null) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Categories Section -->
<div class="display-row bg-light">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="banner banner-light banner-overlay">
                    <a href="<?= base_url('shop') ?>">
                        <?php if (!empty($categories) && !empty($categories[0]['image'])): ?>
                            <img src="<?= base_url('public/uploads/categories/' . $categories[0]['image']) ?>" alt="<?= esc($categories[0]['name']) ?>">
                        <?php else: ?>
                            <img src="<?= base_url('assets/images/demos/demo-15/banners/banner-2.jpg') ?>" alt="Categories">
                        <?php endif; ?>
                    </a>

                    <div class="banner-content women">
                        <h2 class="banner-title">02. Jackets for <br>every season.</h2>
                        <h3 class="banner-subtitle text-darkblack">IN THIS COLLECTION</h3>

                        <div class="category-list">
                            <?php if (!empty($categories)): ?>
                                <?php foreach (array_slice($categories, 0, 3) as $category): ?>
                                    <div class="category-item"><?= esc($category['name']) ?></div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="category-item">Winter Jackets</div>
                                <div class="category-item">Leather Jackets</div>
                                <div class="category-item">Casual Jackets</div>
                            <?php endif; ?>
                        </div>

                        <div class="banner-text text-darkblack">Explore All Categories</div>
                        <a href="<?= base_url('shop') ?>" class="btn btn-outline-primary-2"><span>Shop All</span><i class="icon-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="heading text-center">
                    <h2 class="title">Shop by Category</h2>
                    <p class="title-desc">Find the perfect jacket for any occasion. From casual everyday wear to formal occasions, we have something for everyone.</p>
                </div>

                <div class="row">
                    <?php if (!empty($categories)): ?>
                        <?php foreach (array_slice($categories, 0, 3) as $category): ?>
                            <div class="col-6 col-md-4">
                                <div class="category-tile">
                                    <a href="<?= base_url('category/' . $category['slug']) ?>" class="category-link">
                                        <div class="category-content">
                                            <div class="category-icon">
                                                <i class="fas fa-tshirt fa-3x"></i>
                                            </div>
                                            <h3 class="category-title"><?= esc($category['name']) ?></h3>
                                            <p class="category-description">Explore Collection</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Products Section -->
<?php if (!empty($featured_products)): ?>
<section class="featured-products-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-5">
                <h2 class="section-title">Featured Products</h2>
                <p class="section-subtitle">Discover our handpicked collection of premium jackets</p>
            </div>
        </div>
        <div class="row">
            <?php foreach ($featured_products as $product): ?>
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <div class="product product-4">
                        <figure class="product-media">
                            <a href="<?= base_url('product/' . $product['slug']) ?>">
                                <?php if (!empty($product['images'])): ?>
                                    <img src="<?= base_url('public/uploads/products/' . $product['images'][0]['image_path']) ?>" 
                                         alt="<?= esc($product['name']) ?>" 
                                         class="product-image">
                                <?php else: ?>
                                    <div class="no-image-placeholder">
                                        <div class="placeholder-content">
                                            <i class="fas fa-image"></i>
                                            <span>No Image</span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </a>
                            <div class="product-action-vertical">
                                <a href="<?= base_url('product/' . $product['slug']) ?>" 
                                   class="btn-product-icon btn-cart" 
                                   title="Add to cart">
                                    <span>add to cart</span>
                                </a>
                            </div>
                        </figure>
                        <div class="product-body">
                            <div class="product-cat">
                                <a href="<?= base_url('category/' . $product['category_id']) ?>">Jackets</a>
                            </div>
                            <h3 class="product-title">
                                <a href="<?= base_url('product/' . $product['slug']) ?>"><?= esc($product['name']) ?></a>
                            </h3>
                            <div class="product-price">
                                <?= format_product_price($product['price'], $product['sale_price'] ?? null) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <a href="<?= base_url('shop') ?>" class="btn btn-outline-primary">View All Products</a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Hot Selling Products Section -->
<?php if (!empty($hot_selling_products)): ?>
<section class="hot-selling-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-5">
                <h2 class="section-title">Hot Selling</h2>
                <p class="section-subtitle">Our most popular and trending jackets</p>
            </div>
        </div>
        <div class="row">
            <?php foreach ($hot_selling_products as $product): ?>
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <div class="product product-4">
                        <figure class="product-media">
                            <a href="<?= base_url('product/' . $product['slug']) ?>">
                                <?php if (!empty($product['images'])): ?>
                                    <img src="<?= base_url('public/uploads/products/' . $product['images'][0]['image_path']) ?>" 
                                         alt="<?= esc($product['name']) ?>" 
                                         class="product-image">
                                <?php else: ?>
                                    <div class="no-image-placeholder">
                                        <div class="placeholder-content">
                                            <i class="fas fa-image"></i>
                                            <span>No Image</span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </a>
                            <div class="product-action-vertical">
                                <a href="<?= base_url('product/' . $product['slug']) ?>" 
                                   class="btn-product-icon btn-cart" 
                                   title="Add to cart">
                                    <span>add to cart</span>
                                </a>
                            </div>
                        </figure>
                        <div class="product-body">
                            <div class="product-cat">
                                <a href="<?= base_url('category/' . $product['category_id']) ?>">Jackets</a>
                            </div>
                            <h3 class="product-title">
                                <a href="<?= base_url('product/' . $product['slug']) ?>"><?= esc($product['name']) ?></a>
                            </h3>
                            <div class="product-price">
                                <?= format_product_price($product['price'], $product['sale_price'] ?? null) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <a href="<?= base_url('shop') ?>" class="btn btn-outline-primary">View All Products</a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Hot Products Section -->
<?php if (!empty($hot_products)): ?>
<section class="hot-products-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-5">
                <h2 class="section-title">Hot Products</h2>
                <p class="section-subtitle">Trending and popular items everyone's talking about</p>
            </div>
        </div>
        <div class="row">
            <?php foreach ($hot_products as $product): ?>
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <div class="product product-4">
                        <figure class="product-media">
                            <a href="<?= base_url('product/' . $product['slug']) ?>">
                                <?php if (!empty($product['images'])): ?>
                                    <img src="<?= base_url('public/uploads/products/' . $product['images'][0]['image_path']) ?>" 
                                         alt="<?= esc($product['name']) ?>" 
                                         class="product-image">
                                <?php else: ?>
                                    <div class="no-image-placeholder">
                                        <div class="placeholder-content">
                                            <i class="fas fa-image"></i>
                                            <span>No Image</span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </a>
                            <div class="product-action-vertical">
                                <a href="<?= base_url('product/' . $product['slug']) ?>" 
                                   class="btn-product-icon btn-cart" 
                                   title="Add to cart">
                                    <span>add to cart</span>
                                </a>
                            </div>
                        </figure>
                        <div class="product-body">
                            <div class="product-cat">
                                <a href="<?= base_url('category/' . $product['category_id']) ?>">Jackets</a>
                            </div>
                            <h3 class="product-title">
                                <a href="<?= base_url('product/' . $product['slug']) ?>"><?= esc($product['name']) ?></a>
                            </h3>
                            <div class="product-price">
                                <?= format_product_price($product['price'], $product['sale_price'] ?? null) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <a href="<?= base_url('shop') ?>" class="btn btn-outline-primary">View All Products</a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Video Banner Section -->
<div class="video-banner video-banner-bg video-fullheight bg-image text-center" style="background-image: url(<?= base_url('assets/images/demos/demo-15/bg-1.jpg') ?>)">
    <div class="container">
        <h3 class="video-banner-title h1 text-white"><span>Winter / Spring</span>The New Premium Collection 2024</h3>
        <a href="https://www.youtube.com/watch?v=vBPgmASQ1A0" class="btn-video btn-iframe"><i class="icon-play"></i></a>
    </div>
</div>

<!-- More Products Section -->
<div class="display-row bg-light">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-6 order-lg-last">
                <div class="banner banner-overlay">
                    <a href="<?= base_url('shop') ?>">
                        <?php if (!empty($featured_products) && count($featured_products) > 2 && !empty($featured_products[2]['images'])): ?>
                            <img src="<?= base_url('public/uploads/products/' . $featured_products[2]['images'][0]['image_path']) ?>" alt="More Products">
                        <?php else: ?>
                            <img src="<?= base_url('assets/images/demos/demo-15/banners/banner-3.jpg') ?>" alt="More Products">
                        <?php endif; ?>
                    </a>

                    <div class="banner-content men">
                        <h2 class="banner-title text-white">03. Beautiful <br>jackets perfect <br>for any occasion.</h2>
                        <h3 class="banner-subtitle text-brightblack">IN THIS COLLECTION</h3>

                        <ul class="text-white">
                            <?php if (!empty($featured_products) && count($featured_products) > 2): ?>
                                <?php foreach (array_slice($featured_products, 2, 2) as $product): ?>
                                    <li><?= esc($product['name']) ?></li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li>Formal Jackets</li>
                                <li>Casual Wear</li>
                            <?php endif; ?>
                        </ul>

                        <div class="banner-text text-brightblack">Premium Quality</div>
                        <a href="<?= base_url('shop') ?>" class="btn btn-outline-primary-2"><span>Shop All</span><i class="icon-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="heading text-center">
                    <h2 class="title">Why Choose Us?</h2>
                    <p class="title-desc">We are committed to providing the highest quality jackets with exceptional customer service and fast delivery.</p>
                </div>

                <div class="row">
                    <div class="col-md-4 text-center mb-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-tshirt fa-3x text-primary"></i>
                        </div>
                        <h4>Premium Quality</h4>
                        <p>We source only the finest materials to ensure durability and comfort.</p>
                    </div>
                    <div class="col-md-4 text-center mb-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-shipping-fast fa-3x text-primary"></i>
                        </div>
                        <h4>Fast Delivery</h4>
                        <p>Quick and reliable shipping with secure packaging.</p>
                    </div>
                    <div class="col-md-4 text-center mb-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-headset fa-3x text-primary"></i>
                        </div>
                        <h4>24/7 Support</h4>
                        <p>Our customer service team is always ready to help you.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Newsletter Section -->
<section class="newsletter-section py-5" style="background-color: #8B4513;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h3 class="text-white mb-3">Stay Updated</h3>
                <p class="text-white mb-4">Subscribe to our newsletter for the latest styles and exclusive offers.</p>
                <form class="newsletter-form" id="newsletterForm">
                    <div class="input-group">
                        <input type="email" class="form-control" name="email" id="newsletterEmail" placeholder="Enter your email" required>
                        <button class="btn btn-light" type="submit">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
/* Custom styles for the landing page */
.intro-slider-container {
    position: relative;
    height: 600px;
    overflow: hidden;
}

.intro-slide {
    height: 600px;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
}

.intro-content {
    position: relative;
    z-index: 2;
}

.intro-subtitle {
    font-size: 1.2rem;
    margin-bottom: 1rem;
    color: #fff;
}

.intro-title {
    font-size: 3.5rem;
    font-weight: 700;
    margin-bottom: 2rem;
    color: #fff;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}

.display-row {
    padding: 80px 0;
}

.banner {
    position: relative;
    overflow: hidden;
    border-radius: 10px;
}

.banner img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.banner:hover img {
    transform: scale(1.05);
}

.banner-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    z-index: 2;
}

.banner-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.banner-subtitle {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    letter-spacing: 2px;
}

.banner-content ul {
    list-style: none;
    padding: 0;
    margin: 1rem 0;
}

.banner-content li {
    margin: 0.5rem 0;
    font-size: 1.1rem;
}

.banner-text {
    font-size: 1.2rem;
    font-weight: 600;
    margin: 1rem 0;
}

.video-banner {
    position: relative;
    height: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.video-banner-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 2rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}

.btn-video {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 80px;
    height: 80px;
    background: rgba(255,255,255,0.2);
    border: 2px solid #fff;
    border-radius: 50%;
    color: #fff;
    font-size: 2rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-video:hover {
    background: rgba(255,255,255,0.3);
    color: #fff;
    transform: scale(1.1);
}

.product {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
    margin-bottom: 2rem;
}

.product:hover {
    transform: translateY(-5px);
}

.product-media {
    position: relative;
    overflow: hidden;
}

.product-image {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product:hover .product-image {
    transform: scale(1.05);
}

.product-action-vertical {
    position: absolute;
    top: 1rem;
    right: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product:hover .product-action-vertical {
    opacity: 1;
}

.btn-product-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.9);
    border: none;
    border-radius: 50%;
    color: #333;
    text-decoration: none;
    font-size: 1.2rem;
    transition: all 0.3s ease;
}

.btn-product-icon:hover {
    background: #333;
    color: #fff;
}

.product-action {
    position: absolute;
    bottom: 1rem;
    left: 1rem;
    right: 1rem;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product:hover .product-action {
    opacity: 1;
}

.btn-product {
    width: 100%;
    padding: 0.75rem;
    background: #333;
    color: #fff;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    text-align: center;
    font-weight: 600;
    transition: background 0.3s ease;
}

.btn-product:hover {
    background: #555;
    color: #fff;
}

.product-body {
    padding: 1.5rem;
}

.product.product-4 .product-body {
    padding-bottom: 0;
    padding: 10px;
}

.product-cat a {
    color: #999;
    text-decoration: none;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.product-title {
    margin: 0.5rem 0;
    font-size: 1.1rem;
    font-weight: 600;
}

.product-title a {
    color: #333;
    text-decoration: none;
}

.product-title a:hover {
    color: #007bff;
}

.product-price {
    margin-top: 0.5rem;
}

.new-price {
    color: #e74c3c;
    font-weight: 700;
    font-size: 1.2rem;
}

.old-price {
    color: #999;
    text-decoration: line-through;
    margin-left: 0.5rem;
    font-size: 1rem;
    font-weight: 400;
}

.feature-icon {
    color: #007bff;
}

.newsletter-form .input-group {
    max-width: 400px;
    margin: 0 auto;
}

.newsletter-form .form-control {
    border-radius: 25px 0 0 25px;
    border: none;
    padding: 12px 20px;
}

.newsletter-form .btn {
    border-radius: 0 25px 25px 0;
    padding: 12px 25px;
    border: none;
}

.section-title h2 {
    font-size: 2.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.section-title p {
    font-size: 1.1rem;
    color: #6c757d;
}

/* Category list without bullets */
.category-list {
    margin: 1rem 0;
}

.category-item {
    margin: 0.5rem 0;
    font-size: 1.1rem;
    color: #333;
}

/* Category Tiles */
.category-tile {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
    margin-bottom: 2rem;
    height: 200px;
    position: relative;
}

.category-tile:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
}

.category-link {
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: inherit;
    height: 100%;
    padding: 2rem;
}

.category-content {
    text-align: center;
    color: #fff;
}

.category-icon {
    margin-bottom: 1rem;
    opacity: 0.9;
}

.category-icon i {
    color: #fff;
    transition: transform 0.3s ease;
}

.category-tile:hover .category-icon i {
    transform: scale(1.1);
}

.category-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #fff;
    margin: 0 0 0.5rem 0;
    transition: color 0.3s ease;
}

.category-description {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
    margin: 0;
    font-weight: 500;
}

.category-tile:hover .category-title {
    color: #fff;
}

/* Dropdown Menu Styles */
.nav-item.dropdown {
    position: relative;
}

.dropdown-menu {
    background: #fff;
    border: none;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    padding: 0.5rem 0;
    margin-top: 0.5rem;
    min-width: 200px;
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    display: none;
}

.nav-item.dropdown:hover .dropdown-menu,
.nav-item.dropdown.show .dropdown-menu {
    display: block;
}

.dropdown-header {
    padding: 0.5rem 1rem;
    border-bottom: 1px solid #eee;
    margin-bottom: 0.5rem;
}

.dropdown-header h6 {
    font-size: 0.9rem;
    font-weight: 600;
    color: #666;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.dropdown-item {
    padding: 0.75rem 1rem;
    color: #333;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    display: block;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    color: #007bff;
}

.dropdown-divider {
    height: 1px;
    background-color: #eee;
    margin: 0.5rem 0;
}

/* Search Styles */
.header-search-wrapper {
    position: absolute;
    top: 100%;
    right: 0;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    padding: 1rem;
    min-width: 300px;
    z-index: 1000;
}

.search-form .input-group {
    border-radius: 25px;
    overflow: hidden;
    border: 2px solid #ddd;
}

.search-form .form-control {
    border: none;
    padding: 12px 20px;
    font-size: 14px;
}

.search-form .form-control:focus {
    box-shadow: none;
    border-color: #007bff;
}

.search-form .btn {
    border: none;
    padding: 12px 20px;
    background: #007bff;
    color: #fff;
}

.search-form .btn:hover {
    background: #0056b3;
}

/* Newsletter Form Styles */
.newsletter-form .input-group {
    border-radius: 30px;
    overflow: hidden;
    border: none;
    background: #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    max-width: 500px;
    margin: 0 auto;
}

.newsletter-form .form-control {
    border: none;
    background: #F8F5F0;
    padding: 8px 25px;
    font-size: 16px;
    color: #333;
    flex: 2;
}

.newsletter-form .form-control:focus {
    box-shadow: none;
    background: #F8F5F0;
    border: none;
}

.newsletter-form .form-control::placeholder {
    color: #999;
}

.newsletter-form .btn {
    border: none;
    padding: 8px 30px;
    background: #fff;
    color: #8B4513;
    font-weight: 700;
    font-size: 16px;
    flex: 1;
    transition: all 0.3s ease;
}

.newsletter-form .btn:hover {
    background: #f8f9fa;
    color: #8B4513;
    transform: translateY(-1px);
}

/* Responsive Slider Styles */
.intro-slide {
    min-height: 60vh;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
}

.intro-content {
    padding: 2rem 0;
}

.intro-subtitle {
    font-size: 1.2rem;
    margin-bottom: 1rem;
    opacity: 0.9;
}

.intro-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    line-height: 1.2;
}

.intro-text {
    font-size: 1.1rem;
    margin-bottom: 2rem;
    opacity: 0.9;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .intro-slide {
        min-height: 50vh;
    }
    
    .intro-title {
        font-size: 2rem;
    }
    
    .intro-subtitle {
        font-size: 1rem;
    }
    
    .intro-text {
        font-size: 1rem;
    }
    
    .intro-content {
        padding: 1rem 0;
    }
}

@media (max-width: 576px) {
    .intro-title {
        font-size: 1.5rem;
    }
    
    .intro-subtitle {
        font-size: 0.9rem;
    }
    
    .intro-text {
        font-size: 0.9rem;
    }
}

/* Featured and Hot Selling Sections */
.featured-products-section {
    background: #fff;
}

.hot-selling-section {
    background: #f8f9fa;
}

.hot-products-section {
    background: #fff;
}

.featured-products-section .section-title,
.hot-selling-section .section-title,
.hot-products-section .section-title {
    position: relative;
    display: inline-block;
    font-size: 2.5rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 1rem;
}

.featured-products-section .section-title::after,
.hot-selling-section .section-title::after,
.hot-products-section .section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: linear-gradient(45deg, #8B4513, #D2691E);
    border-radius: 2px;
}

.featured-products-section .section-subtitle,
.hot-selling-section .section-subtitle,
.hot-products-section .section-subtitle {
    font-size: 1.1rem;
    color: #666;
    margin-bottom: 0;
}


/* No Image Placeholder */
.no-image-placeholder {
    width: 100%;
    height: 250px;
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
}

.placeholder-content {
    text-align: center;
    color: #6c757d;
}

.placeholder-content i {
    font-size: 3rem;
    margin-bottom: 0.5rem;
    display: block;
}

.placeholder-content span {
    font-size: 1rem;
    font-weight: 500;
}
</style>

<script>
// Wait for jQuery to be available
function initLandingPage() {
    if (typeof jQuery !== 'undefined') {
        jQuery(document).ready(function($) {
            console.log('Document ready, initializing slider...');
            
            // Check if owl carousel is loaded
            if (typeof $.fn.owlCarousel !== 'undefined') {
                console.log('Owl Carousel loaded successfully');
                
                // Initialize the slider
                $('.intro-slider').owlCarousel({
                    nav: false,
                    dots: true,
                    autoplay: true,
                    autoplayTimeout: 5000,
                    loop: true,
                    items: 1,
                    animateOut: 'fadeOut',
                    animateIn: 'fadeIn'
                });
                
                console.log('Slider initialized successfully');
            } else {
                console.error('Owl Carousel not loaded');
            }
            
            // Dropdown menu functionality
            $('.nav-item.dropdown').hover(
                function() {
                    $(this).addClass('show');
                    $(this).find('.dropdown-menu').show();
                },
                function() {
                    $(this).removeClass('show');
                    $(this).find('.dropdown-menu').hide();
                }
            );
            
            // Newsletter form submission
            $('#newsletterForm').on('submit', function(e) {
                e.preventDefault();
                
                var email = $('#newsletterEmail').val();
                var form = $(this);
                var submitBtn = form.find('button[type="submit"]');
                
                if (email) {
                    // Disable button and show loading
                    submitBtn.prop('disabled', true).text('Subscribing...');
                    
                    // AJAX call to save email
                    $.post('<?= base_url('newsletter/subscribe') ?>', {email: email}, function(response) {
                        if (response.success) {
                            alert(response.message);
                            $('#newsletterEmail').val('');
                        } else {
                            alert(response.message);
                        }
                    }).fail(function() {
                        alert('Error subscribing. Please try again.');
                    }).always(function() {
                        // Re-enable button
                        submitBtn.prop('disabled', false).text('Subscribe');
                    });
                }
            });
        });
    } else {
        // Retry after a short delay if jQuery is not yet loaded
        setTimeout(initLandingPage, 100);
    }
}

// Start the initialization
initLandingPage();
</script>

<?= $this->endSection() ?>
