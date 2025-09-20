<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('shop') ?>">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $product['name'] ?? 'Product' ?></li>
            </ol>

            <nav class="product-pager ml-auto" aria-label="Product">
                <a class="product-pager-link product-pager-prev" href="#" aria-label="Previous" tabindex="-1">
                    <i class="icon-angle-left"></i>
                    <span>Prev</span>
                </a>

                <a class="product-pager-link product-pager-next" href="#" aria-label="Next" tabindex="-1">
                    <span>Next</span>
                    <i class="icon-angle-right"></i>
                </a>
            </nav>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            <div class="product-details-top">
                <div class="row">
                    <div class="col-md-6">
                        <div class="product-gallery product-gallery-vertical">
                            <div class="row">
                                <div class="col-4">
                                    <div id="product-zoom-gallery" class="product-image-gallery">
                                        <?php if (!empty($product['images']) && count($product['images']) > 0): ?>
                                            <?php foreach ($product['images'] as $index => $image): ?>
                                                <a class="product-gallery-item <?= $index === 0 ? 'active' : '' ?>" href="#" data-image="<?= base_url('public/uploads/products/' . $image['image_path']) ?>" data-zoom-image="<?= base_url('public/uploads/products/' . $image['image_path']) ?>">
                                                    <img src="<?= base_url('public/uploads/products/' . $image['image_path']) ?>" alt="product side">
                                                </a>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <a class="product-gallery-item active" href="#" data-image="<?= base_url('html/assets/images/products/single/1.jpg') ?>" data-zoom-image="<?= base_url('html/assets/images/products/single/1-big.jpg') ?>">
                                                <img src="<?= base_url('html/assets/images/products/single/1-small.jpg') ?>" alt="product side">
                                            </a>

                                            <a class="product-gallery-item" href="#" data-image="<?= base_url('html/assets/images/products/single/2.jpg') ?>" data-zoom-image="<?= base_url('html/assets/images/products/single/2-big.jpg') ?>">
                                                <img src="<?= base_url('html/assets/images/products/single/2-small.jpg') ?>" alt="product cross">
                                            </a>

                                            <a class="product-gallery-item" href="#" data-image="<?= base_url('html/assets/images/products/single/3.jpg') ?>" data-zoom-image="<?= base_url('html/assets/images/products/single/3-big.jpg') ?>">
                                                <img src="<?= base_url('html/assets/images/products/single/3-small.jpg') ?>" alt="product with model">
                                            </a>

                                            <a class="product-gallery-item" href="#" data-image="<?= base_url('html/assets/images/products/single/4.jpg') ?>" data-zoom-image="<?= base_url('html/assets/images/products/single/4-big.jpg') ?>">
                                                <img src="<?= base_url('html/assets/images/products/single/4-small.jpg') ?>" alt="product back">
                                            </a>
                                        <?php endif; ?>
                                    </div><!-- End .product-image-gallery -->
                                </div>
                                
                                <div class="col-8">
                                    <figure class="product-main-image">
                                        <?php if (!empty($product['images']) && count($product['images']) > 0): ?>
                                            <img id="product-zoom" src="<?= base_url('public/uploads/products/' . $product['images'][0]['image_path']) ?>" data-zoom-image="<?= base_url('public/uploads/products/' . $product['images'][0]['image_path']) ?>" alt="product image">
                                        <?php else: ?>
                                            <img id="product-zoom" src="<?= base_url('html/assets/images/products/single/1.jpg') ?>" data-zoom-image="<?= base_url('html/assets/images/products/single/1-big.jpg') ?>" alt="product image">
                                        <?php endif; ?>

                                        <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                            <i class="icon-arrows"></i>
                                        </a>
                                    </figure><!-- End .product-main-image -->
                                </div>
                            </div><!-- End .row -->
                        </div><!-- End .product-gallery -->
                    </div><!-- End .col-md-6 -->

                    <div class="col-md-6">
                        <div class="product-details">
                            <h1 class="product-title"><?= $product['name'] ?? 'Product' ?></h1><!-- End .product-title -->



                            <div class="product-price">
                                <?= format_product_price($product['price'] ?? 0, $product['sale_price'] ?? null) ?>
                            </div><!-- End .product-price -->

                            <div class="product-content">
                                <p><?= $product['short_description'] ?? 'Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing. Sed lectus.' ?></p>
                            </div><!-- End .product-content -->

                            <div class="details-filter-row details-row-size">
                                <label>Color:</label>

                                <div class="product-nav product-nav-thumbs" id="color-selection">
                                    <?php if (!empty($product['colors'])): ?>
                                        <?php foreach ($product['colors'] as $index => $color): ?>
                                            <a href="#" class="color-option <?= $index === 0 ? 'active' : '' ?>" 
                                               data-color-id="<?= $color['id'] ?>" 
                                               data-color-name="<?= $color['name'] ?>"
                                               data-hex-code="<?= $color['hex_code'] ?>">
                                                <?php if ($color['hex_code']): ?>
                                                    <div class="color-swatch" style="background-color: <?= $color['hex_code'] ?>; width: 40px; height: 40px; border-radius: 4px; border: 2px solid #ddd;"></div>
                                                <?php else: ?>
                                                    <span class="color-name"><?= $color['name'] ?></span>
                                                <?php endif; ?>
                                            </a>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <a href="#" class="active">
                                            <img src="<?= base_url('html/assets/images/products/single/1-thumb.jpg') ?>" alt="product desc">
                                        </a>
                                    <?php endif; ?>
                                </div><!-- End .product-nav -->
                            </div><!-- End .details-filter-row -->

                            <div class="details-filter-row details-row-size">
                                <label for="size">Size:</label>
                                <div class="select-custom">
                                    <select name="size" id="size" class="form-control">
                                        <option value="" selected="selected">Select a size</option>
                                        <?php if (!empty($product['sizes'])): ?>
                                            <?php foreach ($product['sizes'] as $size): ?>
                                                <option value="<?= $size['id'] ?>" data-size-name="<?= $size['name'] ?>"><?= $size['name'] ?></option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="s">Small</option>
                                            <option value="m">Medium</option>
                                            <option value="l">Large</option>
                                            <option value="xl">Extra Large</option>
                                        <?php endif; ?>
                                    </select>
                                </div><!-- End .select-custom -->

                                <a href="#" class="size-guide"><i class="icon-th-list"></i>size guide</a>
                            </div><!-- End .details-filter-row -->

                            <div class="details-filter-row details-row-size">
                                <label for="qty">Qty:</label>
                                <div class="product-details-quantity">
                                    <input type="number" id="qty" class="form-control" value="1" min="1" max="10" step="1" data-decimals="0" required>
                                </div><!-- End .product-details-quantity -->
                            </div><!-- End .details-filter-row -->

                            <div class="product-details-action">
                                <a href="#" class="btn-product btn-cart" id="add-to-cart-btn"><span>add to cart</span></a>
                            </div><!-- End .product-details-action -->

                            <div class="product-details-footer">
                                <div class="product-cat">
                                    <span>Category:</span>
                                    <a href="<?= base_url('category/' . ($product['category_slug'] ?? '')) ?>"><?= $product['category_name'] ?? 'Uncategorized' ?></a>
                                </div><!-- End .product-cat -->

                                <div class="social-icons social-icons-sm">
                                    <span class="social-label">Share:</span>
                                    <a href="#" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                                    <a href="#" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                                    <a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                                    <a href="#" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                                </div>
                            </div><!-- End .product-details-footer -->
                        </div><!-- End .product-details -->
                    </div><!-- End .col-md-6 -->
                </div><!-- End .row -->
            </div><!-- End .product-details-top -->

            <div class="product-details-tab">
                <ul class="nav nav-pills justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab" role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab" aria-controls="product-info-tab" aria-selected="false">Additional information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab" aria-selected="false">Shipping & Returns</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel" aria-labelledby="product-desc-link">
                        <div class="product-desc-content">
                            <h3>Product Information</h3>
                            <p><?= $product['description'] ?? 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna viverra non, semper suscipit, posuere a, pede. Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet orci. Aenean dignissim pellentesque felis. Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus.' ?></p>
                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->
                    <div class="tab-pane fade" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
                        <div class="product-desc-content">
                            <h3>Information</h3>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna viverra non, semper suscipit, posuere a, pede. Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet orci.</p>

                            <h3>Fabric & care</h3>
                            <ul>
                                <li>Faux suede fabric</li>
                                <li>Gold tone metal hoop handles.</li>
                                <li>RI branding</li>
                                <li>Snake print trim interior</li>
                                <li>Adjustable cross body strap</li>
                                <li>Height: 31cm; Width: 32cm; Depth: 12cm; Handle Drop: 61cm</li>
                            </ul>

                            <h3>Size</h3>
                            <p>one size</p>
                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->
                    <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel" aria-labelledby="product-shipping-link">
                        <div class="product-desc-content">
                            <h3>Delivery & returns</h3>
                            <p>We deliver to over 100 countries around the world. For full details of the delivery options we offer, please view our <a href="#">Delivery information</a><br>
                            We hope you'll love every purchase, but if you ever need to return an item you can do so within a month of receipt. For full details of how to make a return, please view our <a href="#">Returns information</a></p>
                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->
                </div><!-- End .tab-content -->
            </div><!-- End .product-details-tab -->

            <?php if (!empty($related_products)): ?>
                <h2 class="title text-center mb-4">You May Also Like</h2><!-- End .title text-center -->

                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                    data-owl-options='{
                        "nav": false, 
                        "dots": true,
                        "margin": 20,
                        "loop": false,
                        "responsive": {
                            "0": {
                                "items":1
                            },
                            "480": {
                                "items":2
                            },
                            "768": {
                                "items":3
                            },
                            "992": {
                                "items":4
                            },
                            "1200": {
                                "items":4,
                                "nav": true,
                                "dots": false
                            }
                        }
                    }'>
                    <?php foreach ($related_products as $relatedProduct): ?>
                        <div class="product product-7 text-center">
                            <figure class="product-media">
                                <a href="<?= base_url('product/' . $relatedProduct['slug']) ?>">
                                    <?php if (!empty($relatedProduct['images'])): ?>
                                        <img src="<?= base_url('public/uploads/products/' . $relatedProduct['images'][0]['image_path']) ?>" alt="Product image" class="product-image">
                                    <?php else: ?>
                                        <img src="<?= base_url('html/assets/images/products/product-4.jpg') ?>" alt="Product image" class="product-image">
                                    <?php endif; ?>
                                </a>

                                <div class="product-action">
                                    <a href="<?= base_url('product/' . $relatedProduct['slug']) ?>" class="btn-product btn-cart"><span>add to cart</span></a>
                                </div><!-- End .product-action -->
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="<?= base_url('category/' . ($relatedProduct['category_slug'] ?? '')) ?>"><?= $relatedProduct['category_name'] ?? 'Uncategorized' ?></a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a href="<?= base_url('product/' . $relatedProduct['slug']) ?>"><?= $relatedProduct['name'] ?? 'Product' ?></a></h3><!-- End .product-title -->
                                <div class="product-price">
                                    <?= format_product_price($relatedProduct['price'] ?? 0, $relatedProduct['sale_price'] ?? null) ?>
                                </div><!-- End .product-price -->

                            </div><!-- End .product-body -->
                        </div><!-- End .product -->
                    <?php endforeach; ?>
                </div><!-- End .owl-carousel -->
            <?php endif; ?>
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main><!-- End .main -->



<script>
document.addEventListener('DOMContentLoaded', function() {
    // Product image gallery functionality
    const galleryItems = document.querySelectorAll('.product-gallery-item');
    const mainImage = document.getElementById('product-zoom');
    const fullscreenBtn = document.getElementById('btn-product-gallery');
    
    if (galleryItems.length > 0 && mainImage) {
        galleryItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all items
                galleryItems.forEach(galleryItem => galleryItem.classList.remove('active'));
                
                // Add active class to clicked item
                this.classList.add('active');
                
                // Update main image
                const newImageSrc = this.getAttribute('data-image');
                const newZoomSrc = this.getAttribute('data-zoom-image');
                if (newImageSrc) {
                    mainImage.src = newImageSrc;
                    if (newZoomSrc) {
                        mainImage.setAttribute('data-zoom-image', newZoomSrc);
                    }
                }
            });
        });
    }
    
    // Full screen functionality
    if (fullscreenBtn && mainImage) {
        fullscreenBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Create fullscreen modal
            const modal = document.createElement('div');
            modal.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.9);
                z-index: 9999;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
            `;
            
            const fullscreenImg = document.createElement('img');
            fullscreenImg.src = mainImage.src;
            fullscreenImg.style.cssText = `
                max-width: 90%;
                max-height: 90%;
                object-fit: contain;
                border-radius: 8px;
            `;
            
            const closeBtn = document.createElement('div');
            closeBtn.innerHTML = '&times;';
            closeBtn.style.cssText = `
                position: absolute;
                top: 20px;
                right: 30px;
                color: white;
                font-size: 40px;
                font-weight: bold;
                cursor: pointer;
                z-index: 10000;
            `;
            
            modal.appendChild(fullscreenImg);
            modal.appendChild(closeBtn);
            document.body.appendChild(modal);
            
            // Close modal functions
            function closeModal() {
                document.body.removeChild(modal);
            }
            
            closeBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                closeModal();
            });
            
            modal.addEventListener('click', closeModal);
            
            // Close on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeModal();
                }
            });
        });
    }
    
    // Color and Size Selection with Dynamic Pricing
    const colorOptions = document.querySelectorAll('.color-option');
    const sizeSelect = document.getElementById('size');
    const productPrice = document.querySelector('.product-price');
    const productId = <?= $product['id'] ?>;
    
    let selectedColorId = null;
    let selectedSizeId = null;
    
    // Color selection
    colorOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all color options
            colorOptions.forEach(opt => opt.classList.remove('active'));
            
            // Add active class to clicked option
            this.classList.add('active');
            
            // Get selected color ID
            selectedColorId = this.getAttribute('data-color-id');
            
            // Update price
            updatePrice();
        });
    });
    
    // Size selection
    if (sizeSelect) {
        sizeSelect.addEventListener('change', function() {
            selectedSizeId = this.value;
            updatePrice();
        });
    }
    
    // Function to update price based on selected variants
    function updatePrice() {
        if (!selectedColorId && !selectedSizeId) {
            return; // No selection made yet
        }
        
        // Prepare data for API call
        const formData = new FormData();
        formData.append('product_id', productId);
        if (selectedSizeId) formData.append('size_id', selectedSizeId);
        if (selectedColorId) formData.append('color_id', selectedColorId);
        
        // Make API call to get variant price
        fetch('<?= base_url('shop/get-variant-price') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update price display
                let priceHtml = '';
                if (data.sale_price && data.sale_price < data.price) {
                    priceHtml = `<span class="old-price">$${parseFloat(data.price).toFixed(2)}</span> <span class="new-price">$${parseFloat(data.sale_price).toFixed(2)}</span>`;
                } else {
                    priceHtml = `<span class="new-price">$${parseFloat(data.price).toFixed(2)}</span>`;
                }
                productPrice.innerHTML = priceHtml;
            }
        })
        .catch(error => {
            console.error('Error updating price:', error);
        });
    }
    
    // Add to Cart functionality
    const addToCartBtn = document.getElementById('add-to-cart-btn');
    const quantityInput = document.getElementById('qty');
    
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const quantity = parseInt(quantityInput.value) || 1;
            
            // Prepare data for add to cart
            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('quantity', quantity);
            if (selectedSizeId) formData.append('size_id', selectedSizeId);
            if (selectedColorId) formData.append('color_id', selectedColorId);
            
            // Show loading state
            const originalText = this.querySelector('span').textContent;
            this.querySelector('span').textContent = 'Adding...';
            this.style.pointerEvents = 'none';
            
            // Make API call to add to cart
            fetch('<?= base_url('shop/add-to-cart') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showNotification(data.message, 'success');
                    
                    // Update cart display globally
                    if (typeof updateCartDisplay === 'function') {
                        updateCartDisplay(data.cart_count, data.cart_total);
                    } else {
                        // Fallback: just update cart count
                        const cartCount = document.querySelector('.cart-count');
                        if (cartCount) {
                            cartCount.textContent = data.cart_count;
                        }
                    }
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error adding to cart:', error);
                showNotification('Error adding product to cart', 'error');
            })
            .finally(() => {
                // Reset button state
                this.querySelector('span').textContent = originalText;
                this.style.pointerEvents = 'auto';
            });
        });
    }
    
    // Notification function
    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#007bff'};
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 4px;
            z-index: 10000;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            transform: translateX(100%);
            transition: transform 0.3s ease;
        `;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
});
</script>

<?= $this->endSection() ?>