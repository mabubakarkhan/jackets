<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<main class="main">
    <div class="page-header text-center" style="background-image: url('<?= base_url('html/assets/images/page-header-bg.jpg') ?>')">
        <div class="container">
            <h1 class="page-title">Shopping Cart</h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="cart">
            <div class="container">
                <?php if (!empty($cart)): ?>
                    <div class="row">
                        <div class="col-lg-9">
                            <table class="table table-cart table-mobile">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($cart as $cartKey => $item): ?>
                                        <tr>
                                            <td class="product-col">
                                                <div class="product">
                                                    <figure class="product-media">
                                                        <a href="<?= base_url('product/' . $item['product_slug']) ?>">
                                                            <?php if ($item['image']): ?>
                                                                <img src="<?= base_url('public/uploads/products/' . $item['image']) ?>" alt="<?= $item['product_name'] ?>" onerror="this.src='<?= base_url('html/assets/images/products/cart/product-1.jpg') ?>'">
                                                            <?php else: ?>
                                                                <img src="<?= base_url('html/assets/images/products/cart/product-1.jpg') ?>" alt="<?= $item['product_name'] ?>">
                                                            <?php endif; ?>
                                                        </a>
                                                    </figure>

                                                    <h3 class="product-title">
                                                        <a href="<?= base_url('product/' . $item['product_slug']) ?>"><?= esc($item['product_name']) ?></a>
                                                    </h3>

                                                    <?php if ($item['size_name'] || $item['color_name']): ?>
                                                        <div class="product-details">
                                                            <?php if ($item['size_name']): ?>
                                                                <span class="product-detail">Size: <?= esc($item['size_name']) ?></span>
                                                            <?php endif; ?>
                                                            <?php if ($item['color_name']): ?>
                                                                <span class="product-detail">Color: 
                                                                    <?php if ($item['color_hex']): ?>
                                                                        <span class="color-swatch" style="background-color: <?= $item['color_hex'] ?>; width: 16px; height: 16px; display: inline-block; border-radius: 2px; margin-left: 5px; border: 1px solid #ddd;"></span>
                                                                    <?php else: ?>
                                                                        <?= esc($item['color_name']) ?>
                                                                    <?php endif; ?>
                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td class="price-col">
                                                <?php 
                                                $itemPrice = $item['sale_price'] && $item['sale_price'] < $item['price'] ? $item['sale_price'] : $item['price'];
                                                ?>
                                                <span class="price">$<?= number_format($itemPrice, 2) ?></span>
                                                <?php if ($item['sale_price'] && $item['sale_price'] < $item['price']): ?>
                                                    <span class="old-price">$<?= number_format($item['price'], 2) ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="quantity-col">
                                                <div class="cart-product-quantity">
                                                    <input type="number" class="form-control" value="<?= $item['quantity'] ?>" min="1" max="10" data-cart-key="<?= $cartKey ?>">
                                                </div>
                                            </td>
                                            <td class="total-col">
                                                <span class="total">$<?= number_format($itemPrice * $item['quantity'], 2) ?></span>
                                            </td>
                                            <td class="remove-col">
                                                <button type="button" class="btn-remove" data-cart-key="<?= $cartKey ?>">
                                                    <i class="icon-close"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                            <div class="cart-bottom">
                                <div class="cart-discount">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="coupon-code" placeholder="coupon code">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary-2" type="button" id="apply-coupon-btn"><i class="icon-long-arrow-right"></i></button>
                                        </div>
                                    </div>
                                    <div id="coupon-message" class="mt-2"></div>
                                    <div id="applied-coupon" class="mt-2" style="display: none;">
                                        <div class="alert alert-success d-flex justify-content-between align-items-center">
                                            <span id="coupon-info"></span>
                                            <button type="button" class="btn-close" id="remove-coupon-btn"></button>
                                        </div>
                                    </div>
                                </div>

                                <a href="#" class="btn btn-outline-dark-2" id="update-cart-btn"><span>UPDATE CART</span><i class="icon-refresh"></i></a>
                            </div>
                        </div>

                        <aside class="col-lg-3">
                            <div class="summary summary-cart">
                                <h3 class="summary-title">Cart Total</h3>

                                <table class="table table-summary">
                                    <tbody>
                                        <tr class="summary-subtotal">
                                            <td>Subtotal:</td>
                                            <td id="cart-subtotal">$<?= number_format($total_price, 2) ?></td>
                                        </tr>
                                        <tr class="summary-discount" id="discount-row" style="display: none;">
                                            <td>Discount:</td>
                                            <td id="discount-amount">-$0.00</td>
                                        </tr>
                                        <tr class="summary-shipping">
                                            <td>Shipping:</td>
                                            <td>&nbsp;</td>
                                        </tr>

                                        <tr class="summary-shipping-row">
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="free-shipping" name="shipping" class="custom-control-input" checked>
                                                    <label class="custom-control-label" for="free-shipping">Free Shipping</label>
                                                </div>
                                            </td>
                                            <td>$0.00</td>
                                        </tr>

                                        <tr class="summary-shipping-row">
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="standard-shipping" name="shipping" class="custom-control-input">
                                                    <label class="custom-control-label" for="standard-shipping">Standard:</label>
                                                </div>
                                            </td>
                                            <td>$10.00</td>
                                        </tr>

                                        <tr class="summary-shipping-row">
                                            <td>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="express-shipping" name="shipping" class="custom-control-input">
                                                    <label class="custom-control-label" for="express-shipping">Express:</label>
                                                </div>
                                            </td>
                                            <td>$20.00</td>
                                        </tr>

                                        <tr class="summary-shipping-estimate">
                                            <td>Estimate for Your Country<br> <a href="#">Change</a></td>
                                            <td>&nbsp;</td>
                                        </tr>

                                        <tr class="summary-total">
                                            <td>Total:</td>
                                            <td id="cart-total">$<?= number_format($total_price, 2) ?></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <a href="<?= base_url('checkout') ?>" class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO CHECKOUT</a>
                            </div>

                            <a href="<?= base_url('shop') ?>" class="btn btn-outline-dark-2"><span>CONTINUE SHOPPING</span><i class="icon-long-arrow-right"></i></a>
                        </aside>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="empty-cart text-center">
                                <div class="empty-cart-icon">
                                    <i class="icon-cart" style="font-size: 4rem; color: #ccc;"></i>
                                </div>
                                <h2>Your cart is empty</h2>
                                <p>Looks like you haven't added any items to your cart yet.</p>
                                <a href="<?= base_url('shop') ?>" class="btn btn-primary">Start Shopping</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quantity update functionality
    const quantityInputs = document.querySelectorAll('.cart-product-quantity input');
    const removeButtons = document.querySelectorAll('.btn-remove');
    const clearCartBtn = document.querySelector('.clear-cart-btn');
    
    // Update cart when quantity changes
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const cartKey = this.getAttribute('data-cart-key');
            const quantity = parseInt(this.value);
            
            if (quantity < 1) {
                this.value = 1;
                return;
            }
            
            updateCartItem(cartKey, quantity);
        });
        
        // Also listen for input events for real-time updates
        input.addEventListener('input', function() {
            const cartKey = this.getAttribute('data-cart-key');
            const quantity = parseInt(this.value);
            
            if (quantity >= 1) {
                updateCartItem(cartKey, quantity);
            }
        });
    });
    
    // Remove item functionality
    removeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const cartKey = this.getAttribute('data-cart-key');
            removeCartItem(cartKey);
        });
    });
    
    // Clear cart functionality
    if (clearCartBtn) {
        clearCartBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to clear your cart?')) {
                clearCart();
            }
        });
    }
    
    // Update cart item function
    function updateCartItem(cartKey, quantity) {
        const formData = new FormData();
        formData.append('cart_key', cartKey);
        formData.append('quantity', quantity);
        
        fetch('<?= base_url('shop/update-cart') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update cart count in header
                updateCartCount(data.cart_count);
                
                // Update cart total
                updateCartTotal(data.cart_total);
                
                // Update item total
                updateItemTotal(cartKey, quantity);
                
                // Update cart dropdown if function exists
                if (typeof updateCartDropdown === 'function') {
                    updateCartDropdown();
                }
            } else {
                console.error('Error updating cart:', data.message);
                showNotification('Error updating cart: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error updating cart:', error);
            showNotification('Error updating cart', 'error');
        });
    }
    
    // Remove cart item function
    function removeCartItem(cartKey) {
        if (!confirm('Are you sure you want to remove this item from your cart?')) {
            return;
        }
        
        const formData = new FormData();
        formData.append('cart_key', cartKey);
        
        fetch('<?= base_url('shop/remove-from-cart') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove row from table
                const row = document.querySelector(`input[data-cart-key="${cartKey}"]`).closest('tr');
                if (row) {
                    row.remove();
                }
                
                // Update cart count in header
                updateCartCount(data.cart_count);
                
                // Update cart total
                updateCartTotal(data.cart_total);
                
                // Update cart dropdown if function exists
                if (typeof updateCartDropdown === 'function') {
                    updateCartDropdown();
                }
                
                // Check if cart is empty
                if (data.cart_count == 0) {
                    location.reload();
                }
                
                showNotification('Item removed from cart', 'success');
            } else {
                console.error('Error removing item:', data.message);
                showNotification('Error removing item: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error removing item:', error);
            showNotification('Error removing item', 'error');
        });
    }
    
    // Clear cart function
    function clearCart() {
        fetch('<?= base_url('shop/clear-cart') ?>', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                console.error('Error clearing cart:', data.message);
                showNotification('Error clearing cart: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error clearing cart:', error);
            showNotification('Error clearing cart', 'error');
        });
    }
    
    // Update cart count in header
    function updateCartCount(count) {
        const cartCountElements = document.querySelectorAll('.cart-count');
        cartCountElements.forEach(element => {
            element.textContent = count;
        });
    }
    
    // Update cart total
    function updateCartTotal(total) {
        const totalElements = document.querySelectorAll('.summary-total td:last-child, .summary-subtotal td:last-child');
        totalElements.forEach(element => {
            element.textContent = '$' + total;
        });
    }
    
    // Update item total
    function updateItemTotal(cartKey, quantity) {
        const row = document.querySelector(`input[data-cart-key="${cartKey}"]`).closest('tr');
        if (row) {
            const priceText = row.querySelector('.price-col .price').textContent;
            const price = parseFloat(priceText.replace('$', ''));
            const totalCol = row.querySelector('.total-col .total');
            if (totalCol) {
                totalCol.textContent = '$' + (price * quantity).toFixed(2);
            }
        }
    }
    
    // Show notification function
    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show`;
        notification.style.position = 'fixed';
        notification.style.top = '20px';
        notification.style.right = '20px';
        notification.style.zIndex = '9999';
        notification.style.minWidth = '300px';
        
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 3000);
    }

    // Coupon functionality
    const applyCouponBtn = document.getElementById('apply-coupon-btn');
    const removeCouponBtn = document.getElementById('remove-coupon-btn');
    const couponCodeInput = document.getElementById('coupon-code');
    const couponMessage = document.getElementById('coupon-message');
    const appliedCoupon = document.getElementById('applied-coupon');
    const couponInfo = document.getElementById('coupon-info');

    if (applyCouponBtn) {
        applyCouponBtn.addEventListener('click', function() {
            const couponCode = couponCodeInput.value.trim();
            
            if (!couponCode) {
                showCouponMessage('Please enter a coupon code', 'error');
                return;
            }

            applyCoupon(couponCode);
        });
    }

    if (removeCouponBtn) {
        removeCouponBtn.addEventListener('click', function() {
            removeCoupon();
        });
    }

    // Allow Enter key to apply coupon
    if (couponCodeInput) {
        couponCodeInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const couponCode = this.value.trim();
                if (couponCode) {
                    applyCoupon(couponCode);
                }
            }
        });
    }

    function applyCoupon(couponCode) {
        const formData = new FormData();
        formData.append('coupon_code', couponCode);

        fetch('<?= base_url('shop/validate-coupon') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showCouponMessage(data.message, 'success');
                displayAppliedCoupon(data.coupon);
                updateCartTotals(data.cart_total, data.discount, data.final_total);
            } else {
                showCouponMessage(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error applying coupon:', error);
            showCouponMessage('Error applying coupon', 'error');
        });
    }

    function removeCoupon() {
        fetch('<?= base_url('shop/remove-coupon') ?>', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showCouponMessage(data.message, 'success');
                hideAppliedCoupon();
                updateCartTotals(data.cart_total, '0.00', data.final_total);
            } else {
                showCouponMessage(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error removing coupon:', error);
            showCouponMessage('Error removing coupon', 'error');
        });
    }

    function showCouponMessage(message, type) {
        couponMessage.innerHTML = `<div class="alert alert-${type === 'error' ? 'danger' : 'success'} alert-sm">${message}</div>`;
        
        // Clear message after 5 seconds
        setTimeout(() => {
            couponMessage.innerHTML = '';
        }, 5000);
    }

    function displayAppliedCoupon(coupon) {
        const discountText = coupon.type === 'percentage' ? `${coupon.value}% off` : `$${coupon.value} off`;
        couponInfo.textContent = `${coupon.code} - ${discountText}`;
        appliedCoupon.style.display = 'block';
        couponCodeInput.value = '';
    }

    function hideAppliedCoupon() {
        appliedCoupon.style.display = 'none';
    }

    function updateCartTotals(subtotal, discount, total) {
        document.getElementById('cart-subtotal').textContent = '$' + subtotal;
        document.getElementById('cart-total').textContent = '$' + total;
        
        const discountRow = document.getElementById('discount-row');
        const discountAmount = document.getElementById('discount-amount');
        
        if (parseFloat(discount) > 0) {
            discountAmount.textContent = '-$' + discount;
            discountRow.style.display = '';
        } else {
            discountRow.style.display = 'none';
        }
    }
});
</script>

<?= $this->endSection() ?>