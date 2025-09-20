<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="page-header text-center" style="background-image: url('<?= base_url('html/assets/images/page-header-bg.jpg') ?>')">
    <div class="container">
        <h1 class="page-title">Checkout<span>Complete Your Order</span></h1>
    </div>
</div>

<nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('shop') ?>">Shop</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('cart') ?>">Cart</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
        </ol>
    </div>
</nav>

<div class="page-content">
    <div class="container">
        <form id="checkout-form" method="POST" action="<?= base_url('shop/place-order') ?>">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="checkout-form">
                        <div class="form-section">
                            <h4 class="section-title">
                                <i class="fas fa-user me-2"></i>Customer Information
                            </h4>
                            <div class="customer-info-display">
                                <p><strong>Name:</strong> <?= esc($customer['name']) ?></p>
                                <p><strong>Email:</strong> <?= esc($customer['email']) ?></p>
                                <p><strong>Phone:</strong> <?= esc($customer['phone']) ?></p>
                                <p><strong>Address:</strong> <?= esc($customer['address']) ?>, <?= esc($customer['city']) ?>, <?= esc($customer['country']) ?></p>
                                <a href="<?= base_url('customer/profile') ?>" class="btn btn-outline-primary btn-sm">Update Profile</a>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h4 class="section-title">
                                <i class="fas fa-edit me-2"></i>Order Notes
                            </h4>
                            <div class="form-group mb-3">
                                <label for="notes" class="form-label">Special Instructions (Optional)</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Any special instructions for your order..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="order-summary">
                        <div class="summary-card">
                            <h4 class="summary-title">Order Summary</h4>
                            
                            <div class="order-items">
                                <?php foreach ($cart as $item): ?>
                                    <div class="order-item">
                                        <div class="item-info">
                                            <h6><?= esc($item['product_name']) ?></h6>
                                            <small class="text-muted">
                                                Quantity: <?= $item['quantity'] ?>
                                                <?php if ($item['size_name']): ?>
                                                    | Size: <?= esc($item['size_name']) ?>
                                                <?php endif; ?>
                                                <?php if ($item['color_name']): ?>
                                                    | Color: <?= esc($item['color_name']) ?>
                                                <?php endif; ?>
                                            </small>
                                        </div>
                                        <div class="item-price">
                                            $<?= number_format(($item['sale_price'] && $item['sale_price'] < $item['price'] ? $item['sale_price'] : $item['price']) * $item['quantity'], 2) ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <hr>
                            
                            <div class="summary-totals">
                                <div class="total-row">
                                    <span>Subtotal:</span>
                                    <span id="cart-subtotal">$<?= number_format($cart_total, 2) ?></span>
                                </div>
                                
                                <?php if ($discount_amount > 0): ?>
                                    <div class="total-row discount">
                                        <span>Discount (<?= esc($applied_coupon['code']) ?>):</span>
                                        <span>-$<?= number_format($discount_amount, 2) ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="total-row">
                                    <span>Shipping:</span>
                                    <span>Free</span>
                                </div>
                                
                                <div class="total-row">
                                    <span>Tax:</span>
                                    <span>$0.00</span>
                                </div>
                                
                                <hr>
                                
                                <div class="total-row total">
                                    <span><strong>Total:</strong></span>
                                    <span><strong id="cart-total">$<?= number_format($final_total, 2) ?></strong></span>
                                </div>
                            </div>
                            
                            <div class="checkout-actions">
                                <button type="submit" class="btn btn-primary btn-block" id="place-order-btn">
                                    <i class="fas fa-credit-card me-2"></i>Place Order
                                </button>
                                <p class="text-muted text-center mt-2">
                                    <small>You will pay cash on delivery</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.checkout-form {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    padding: 2rem;
    margin-bottom: 2rem;
}

.form-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #eee;
}

.form-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.section-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}

.customer-info-display {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
}

.customer-info-display p {
    margin-bottom: 0.5rem;
    color: #666;
}

.customer-info-display strong {
    color: #333;
}

.order-summary {
    position: sticky;
    top: 2rem;
}

.summary-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    padding: 2rem;
}

.summary-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 1.5rem;
    text-align: center;
}

.order-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 1rem 0;
    border-bottom: 1px solid #eee;
}

.order-item:last-child {
    border-bottom: none;
}

.item-info h6 {
    margin: 0 0 0.25rem 0;
    color: #333;
    font-size: 0.9rem;
}

.item-info small {
    color: #666;
    font-size: 0.8rem;
}

.item-price {
    font-weight: 600;
    color: #333;
    font-size: 0.9rem;
}

.summary-totals {
    margin: 1.5rem 0;
}

.total-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    color: #666;
}

.total-row.discount {
    color: #28a745;
}

.total-row.total {
    font-size: 1.1rem;
    color: #333;
    margin-top: 1rem;
}

.checkout-actions {
    margin-top: 2rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 1rem;
    font-weight: 500;
}

.btn-primary {
    background-color: #007bff;
    color: #fff;
    width: 100%;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-outline-primary {
    background-color: transparent;
    color: #007bff;
    border: 1px solid #007bff;
}

.btn-outline-primary:hover {
    background-color: #007bff;
    color: #fff;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
}

.text-muted {
    color: #6c757d;
}

.text-center {
    text-align: center;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
}

.form-control:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #333;
}

.mb-3 {
    margin-bottom: 1rem;
}

.me-2 {
    margin-right: 0.5rem;
}

.mt-2 {
    margin-top: 0.5rem;
}

hr {
    border: none;
    border-top: 1px solid #eee;
    margin: 1rem 0;
}
</style>

<script>
document.getElementById('checkout-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('place-order-btn');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Placing Order...';
    submitBtn.disabled = true;
    
    // Submit form data
    const formData = new FormData(this);
    
    fetch('<?= base_url('shop/place-order') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            alert(data.message);
            // Redirect to order detail page
            window.location.href = data.redirect_url;
        } else {
            // Show error message
            alert(data.message);
            // Reset button
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while placing your order. Please try again.');
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});
</script>

<?= $this->endSection() ?>
