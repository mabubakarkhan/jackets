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
                            
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="fas fa-edit me-2"></i>Order Notes
                                </h4>
                                <div class="form-group mb-3">
                                    <label for="notes" class="form-label">Special Instructions (Optional)</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Any special instructions for your order..."></textarea>
                                </div>
                            </div>
                                        <input type="tel" class="form-control" id="phone" name="phone" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h4 class="section-title">
                                <i class="fas fa-map-marker-alt me-2"></i>Shipping Address
                            </h4>
                            <div class="form-group mb-3">
                                <label for="address" class="form-label">Street Address *</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="city" class="form-label">City *</label>
                                        <input type="text" class="form-control" id="city" name="city" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="postal_code" class="form-label">Postal Code *</label>
                                        <input type="text" class="form-control" id="postal_code" name="postal_code" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="country" class="form-label">Country *</label>
                                <select class="form-control" id="country" name="country" required>
                                    <option value="">Select Country</option>
                                    <option value="PK">Pakistan</option>
                                    <option value="US">United States</option>
                                    <option value="UK">United Kingdom</option>
                                    <option value="CA">Canada</option>
                                    <option value="AU">Australia</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-section">
                            <h4 class="section-title">
                                <i class="fas fa-credit-card me-2"></i>Payment Method
                            </h4>
                            <div class="payment-methods">
                                <div class="payment-option">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                        <label class="form-check-label" for="cod">
                                            <i class="fas fa-money-bill-wave me-2"></i>
                                            <strong>Cash on Delivery</strong>
                                            <small class="d-block text-muted">Pay when your order is delivered</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="payment-option">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="inquiry" value="inquiry">
                                        <label class="form-check-label" for="inquiry">
                                            <i class="fas fa-question-circle me-2"></i>
                                            <strong>Inquiry</strong>
                                            <small class="d-block text-muted">We'll contact you for payment details</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h4 class="section-title">
                                <i class="fas fa-comment me-2"></i>Order Notes (Optional)
                            </h4>
                            <div class="form-group mb-3">
                                <textarea class="form-control" id="order_notes" name="order_notes" rows="4" placeholder="Any special instructions for your order..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="order-summary">
                        <div class="summary-card">
                            <h4 class="summary-title">Order Summary</h4>
                            
                            <div class="order-items" id="order-items">
                                <div class="order-item">
                                    <div class="item-info">
                                        <h6>Sample Product</h6>
                                        <small class="text-muted">Quantity: 1</small>
                                    </div>
                                    <div class="item-price">$99.00</div>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="summary-row">
                                <span>Subtotal:</span>
                                <span id="subtotal">$99.00</span>
                            </div>
                            
                            <div class="summary-row">
                                <span>Shipping:</span>
                                <span id="shipping">$0.00</span>
                            </div>
                            
                            <div class="summary-row">
                                <span>Tax:</span>
                                <span id="tax">$0.00</span>
                            </div>
                            
                            <hr>
                            
                            <div class="summary-row total">
                                <span>Total:</span>
                                <span id="total">$99.00</span>
                            </div>
                            
                            <div class="checkout-actions mt-4">
                                <button type="submit" class="btn btn-primary btn-lg w-100 mb-2">
                                    <i class="fas fa-lock me-2"></i>Place Order
                                </button>
                                <a href="<?= base_url('cart') ?>" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Cart
                                </a>
                            </div>
                        </div>

                        <div class="security-info mt-4">
                            <div class="info-card">
                                <h5><i class="fas fa-shield-alt me-2"></i>Secure Checkout</h5>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-lock text-success me-2"></i>SSL encrypted</li>
                                    <li><i class="fas fa-undo text-success me-2"></i>30-day returns</li>
                                    <li><i class="fas fa-headset text-success me-2"></i>24/7 support</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('checkout-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Get form data
    const formData = new FormData(this);
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
    submitBtn.disabled = true;
    
    // Simulate form submission (replace with actual AJAX call)
    setTimeout(() => {
        alert('Order placed successfully! We will contact you soon.');
        window.location.href = '<?= base_url() ?>';
    }, 2000);
});
</script>

<style>
.page-header {
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    padding: 4rem 0;
    margin-bottom: 0;
}

.page-title {
    color: white;
    font-size: 2.5rem;
    font-weight: 600;
    margin: 0;
}

.page-title span {
    display: block;
    font-size: 1rem;
    font-weight: 400;
    opacity: 0.8;
    margin-top: 0.5rem;
}

.breadcrumb {
    background: none;
    padding: 1rem 0;
    margin: 0;
}

.breadcrumb-item a {
    color: #333;
    text-decoration: none;
}

.breadcrumb-item a:hover {
    color: #007bff;
}

.breadcrumb-item.active {
    color: #6c757d;
}

.checkout-form {
    background: white;
    border-radius: 10px;
    padding: 2rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.form-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #e9ecef;
}

.form-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.section-title {
    font-weight: 600;
    color: #333;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e9ecef;
}

.form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
}

.form-control {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.payment-methods {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.payment-option {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 1rem;
    transition: border-color 0.3s ease;
}

.payment-option:hover {
    border-color: #007bff;
}

.form-check-input:checked + .form-check-label {
    color: #007bff;
}

.form-check-input:checked ~ .payment-option {
    border-color: #007bff;
}

.order-summary {
    position: sticky;
    top: 2rem;
}

.summary-card, .info-card {
    background: white;
    border-radius: 10px;
    padding: 2rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
}

.summary-title, .info-card h5 {
    font-weight: 600;
    color: #333;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e9ecef;
}

.order-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid #e9ecef;
}

.order-item:last-child {
    border-bottom: none;
}

.item-info h6 {
    margin: 0;
    color: #333;
    font-weight: 600;
}

.item-price {
    font-weight: 600;
    color: #e74c3c;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    color: #6c757d;
}

.summary-row.total {
    font-size: 1.2rem;
    font-weight: 600;
    color: #333;
    border-top: 2px solid #e9ecef;
    margin-top: 1rem;
    padding-top: 1rem;
}

.checkout-actions .btn {
    font-weight: 600;
    padding: 0.75rem 1.5rem;
}

.info-card ul li {
    padding: 0.5rem 0;
    color: #6c757d;
}

.info-card ul li i {
    width: 20px;
}

@media (max-width: 991px) {
    .order-summary {
        position: static;
        margin-top: 2rem;
    }
}
</style>

<?= $this->endSection() ?>
