<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>
<div class="page-header text-center" style="background-image: url('<?= base_url('html/assets/images/page-header-bg.jpg') ?>')">
    <div class="container">
        <h1 class="page-title">Order Details<span>Order #<?= esc($order['order_number']) ?></span></h1>
    </div><!-- End .container -->
</div><!-- End .page-header -->

<nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('customer/dashboard') ?>">My Account</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('customer/orders') ?>">My Orders</a></li>
            <li class="breadcrumb-item active" aria-current="page">Order #<?= esc($order['order_number']) ?></li>
        </ol>
    </div><!-- End .container -->
</nav><!-- End .breadcrumb-nav -->

<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="order-details">
                    <div class="order-info mb-4">
                        <h3>Order Information</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Order Number:</strong> <?= esc($order['order_number']) ?></p>
                                <p><strong>Order Date:</strong> <?= date('F j, Y g:i A', strtotime($order['created_at'])) ?></p>
                                <p><strong>Status:</strong> 
                                    <span class="badge badge-<?= $order['status'] == 'pending' ? 'warning' : ($order['status'] == 'delivered' ? 'success' : 'info') ?>">
                                        <?= ucfirst($order['status']) ?>
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Payment Status:</strong> 
                                    <span class="badge badge-<?= $order['payment_status'] == 'paid' ? 'success' : 'warning' ?>">
                                        <?= ucfirst($order['payment_status']) ?>
                                    </span>
                                </p>
                                <p><strong>Payment Method:</strong> <?= ucwords(str_replace('_', ' ', $order['payment_method'])) ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="order-items mb-4">
                        <h3>Order Items</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($order_items) && !empty($order_items)): ?>
                                        <?php foreach ($order_items as $item): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <?php if (!empty($item['product_image'])): ?>
                                                            <img src="<?= base_url('public/uploads/products/' . $item['product_image']) ?>" 
                                                                 alt="<?= esc($item['product_name']) ?>" 
                                                                 class="me-3" 
                                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                                        <?php endif; ?>
                                                        <div>
                                                            <h6 class="mb-0"><?= esc($item['product_name']) ?></h6>
                                                            <small class="text-muted">Product ID: <?= $item['product_id'] ?></small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?= $item['quantity'] ?></td>
                                                <td>$<?= number_format($item['unit_price'], 2) ?></td>
                                                <td>$<?= number_format($item['total_price'], 2) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No items found for this order.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="order-notes mb-4">
                        <?php if (!empty($order['notes'])): ?>
                            <h3>Order Notes</h3>
                            <p><?= esc($order['notes']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="order-summary">
                    <div class="summary-card">
                        <h4>Order Summary</h4>
                        
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span>$<?= number_format($order['subtotal'], 2) ?></span>
                        </div>
                        
                        <?php if ($order['discount_amount'] > 0): ?>
                            <div class="summary-row discount">
                                <span>Discount (<?= esc($order['coupon_code']) ?>):</span>
                                <span>-$<?= number_format($order['discount_amount'], 2) ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <div class="summary-row">
                            <span>Shipping:</span>
                            <span>$<?= number_format($order['shipping_cost'], 2) ?></span>
                        </div>
                        
                        <div class="summary-row">
                            <span>Tax:</span>
                            <span>$<?= number_format($order['tax_amount'], 2) ?></span>
                        </div>
                        
                        <hr>
                        
                        <div class="summary-row total">
                            <span><strong>Total:</strong></span>
                            <span><strong>$<?= number_format($order['total_amount'], 2) ?></strong></span>
                        </div>
                    </div>

                    <div class="shipping-info mt-4">
                        <h4>Shipping Address</h4>
                        <?php 
                        $shippingAddress = json_decode($order['shipping_address'], true);
                        if ($shippingAddress):
                        ?>
                            <address>
                                <strong><?= esc($shippingAddress['name']) ?></strong><br>
                                <?= esc($shippingAddress['address']) ?><br>
                                <?= esc($shippingAddress['city']) ?>, <?= esc($shippingAddress['country']) ?><br>
                                Phone: <?= esc($shippingAddress['phone']) ?>
                            </address>
                        <?php else: ?>
                            <p>No shipping address available.</p>
                        <?php endif; ?>
                    </div>

                    <div class="billing-info mt-4">
                        <h4>Billing Address</h4>
                        <?php 
                        $billingAddress = json_decode($order['billing_address'], true);
                        if ($billingAddress):
                        ?>
                            <address>
                                <strong><?= esc($billingAddress['name']) ?></strong><br>
                                <?= esc($billingAddress['address']) ?><br>
                                <?= esc($billingAddress['city']) ?>, <?= esc($billingAddress['country']) ?><br>
                                Phone: <?= esc($billingAddress['phone']) ?>
                            </address>
                        <?php else: ?>
                            <p>No billing address available.</p>
                        <?php endif; ?>
                    </div>

                    <div class="order-actions mt-4">
                        <a href="<?= base_url('customer/orders') ?>" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Orders
                        </a>
                        
                        <?php if ($order['status'] == 'pending'): ?>
                            <a href="<?= base_url('customer/cancel-order/' . $order['id']) ?>" 
                               class="btn btn-outline-danger ms-2"
                               onclick="return confirm('Are you sure you want to cancel this order?')">
                                <i class="fas fa-times me-2"></i>Cancel Order
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.order-details {
    background: #fff;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.summary-card {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.8rem;
    font-size: 1.1rem;
}

.summary-row.discount {
    color: #28a745;
}

.summary-row.total {
    font-size: 1.3rem;
    font-weight: 700;
    border-top: 2px solid #dee2e6;
    padding-top: 0.8rem;
    margin-top: 1rem;
}

.badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
}

.badge-warning {
    background-color: #ffc107;
    color: #212529;
}

.badge-success {
    background-color: #28a745;
    color: #fff;
}

.badge-info {
    background-color: #17a2b8;
    color: #fff;
}

.shipping-info, .billing-info {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.shipping-info h4, .billing-info h4 {
    margin-bottom: 1rem;
    color: #333;
}

.order-actions .btn {
    margin-bottom: 0.5rem;
}

@media (max-width: 768px) {
    .order-details {
        padding: 1rem;
    }
    
    .summary-card, .shipping-info, .billing-info {
        padding: 1rem;
    }
}
</style>

<?= $this->endSection() ?>
