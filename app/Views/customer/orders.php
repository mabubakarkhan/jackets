<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>
<div class="page-header text-center" style="background-image: url('<?= base_url('html/assets/images/page-header-bg.jpg') ?>')">
    <div class="container">
        <h1 class="page-title">My Orders<span>Order History</span></h1>
    </div><!-- End .container -->
</div><!-- End .page-header -->

<nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('customer/dashboard') ?>">My Account</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Orders</li>
        </ol>
    </div><!-- End .container -->
</nav><!-- End .breadcrumb-nav -->

<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="customer-sidebar">
                    <div class="customer-info">
                        <h4>Welcome, <?= esc(session()->get('customer_name')) ?>!</h4>
                        <p class="text-muted"><?= esc(session()->get('customer_email')) ?></p>
                    </div>
                    
                    <nav class="customer-nav">
                        <ul>
                            <li><a href="<?= base_url('customer/dashboard') ?>">Dashboard</a></li>
                            <li><a href="<?= base_url('customer/orders') ?>" class="active">My Orders</a></li>
                            <li><a href="<?= base_url('customer/profile') ?>">Profile</a></li>
                            <li><a href="<?= base_url('customer/logout') ?>">Logout</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            
            <div class="col-lg-9">
                <div class="customer-content">
                    <h2>My Orders</h2>
                    
                    <?php if (empty($orders)): ?>
                        <div class="no-orders">
                            <i class="fas fa-shopping-bag"></i>
                            <h4>No orders yet</h4>
                            <p>Start shopping to see your orders here</p>
                            <a href="<?= base_url('shop') ?>" class="btn btn-primary">Start Shopping</a>
                        </div>
                    <?php else: ?>
                        <div class="orders-list">
                            <?php foreach ($orders as $order): ?>
                                <div class="order-card">
                                    <div class="order-header">
                                        <div class="order-info">
                                            <h4>Order #<?= esc($order['order_number']) ?></h4>
                                            <p class="order-date">Placed on <?= date('M d, Y', strtotime($order['created_at'])) ?></p>
                                        </div>
                                        <div class="order-status">
                                            <span class="status-badge status-<?= $order['status'] ?>">
                                                <?= ucfirst($order['status']) ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="order-details">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Payment Status:</strong> 
                                                    <span class="payment-status payment-<?= $order['payment_status'] ?>">
                                                        <?= ucfirst($order['payment_status']) ?>
                                                    </span>
                                                </p>
                                                <p><strong>Payment Method:</strong> <?= ucfirst(str_replace('_', ' ', $order['payment_method'])) ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Total Amount:</strong> $<?= number_format($order['total_amount'], 2) ?></p>
                                                <?php if ($order['coupon_code']): ?>
                                                    <p><strong>Coupon Used:</strong> <?= esc($order['coupon_code']) ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="order-actions">
                                        <a href="<?= base_url('customer/order-detail/' . $order['id']) ?>" 
                                           class="btn btn-outline-primary">View Details</a>
                                        <a href="<?= base_url('customer/track-order/' . $order['id']) ?>" 
                                           class="btn btn-outline-secondary">Track Order</a>
                                        <?php if (in_array($order['status'], ['pending', 'confirmed'])): ?>
                                            <a href="<?= base_url('customer/cancel-order/' . $order['id']) ?>" 
                                               class="btn btn-outline-danger" 
                                               onclick="return confirm('Are you sure you want to cancel this order?')">Cancel Order</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.customer-sidebar {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    padding: 2rem;
    margin-bottom: 2rem;
}

.customer-info h4 {
    color: #333;
    margin-bottom: 0.5rem;
}

.customer-nav ul {
    list-style: none;
    padding: 0;
    margin: 2rem 0 0 0;
}

.customer-nav li {
    margin-bottom: 0.5rem;
}

.customer-nav a {
    display: block;
    padding: 0.75rem 1rem;
    color: #666;
    text-decoration: none;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.customer-nav a:hover,
.customer-nav a.active {
    background-color: #007bff;
    color: #fff;
}

.customer-content {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    padding: 2rem;
}

.orders-list {
    margin-top: 2rem;
}

.order-card {
    border: 1px solid #dee2e6;
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    background: #f8f9fa;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #dee2e6;
}

.order-info h4 {
    margin: 0;
    color: #333;
    font-size: 1.2rem;
}

.order-date {
    margin: 0.25rem 0 0 0;
    color: #666;
    font-size: 0.9rem;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    text-transform: uppercase;
}

.status-pending {
    background-color: #fff3cd;
    color: #856404;
}

.status-confirmed {
    background-color: #d1ecf1;
    color: #0c5460;
}

.status-processing {
    background-color: #d4edda;
    color: #155724;
}

.status-shipped {
    background-color: #cce5ff;
    color: #004085;
}

.status-delivered {
    background-color: #d4edda;
    color: #155724;
}

.status-cancelled {
    background-color: #f8d7da;
    color: #721c24;
}

.payment-status {
    padding: 0.2rem 0.5rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 500;
}

.payment-pending {
    background-color: #fff3cd;
    color: #856404;
}

.payment-paid {
    background-color: #d4edda;
    color: #155724;
}

.payment-failed {
    background-color: #f8d7da;
    color: #721c24;
}

.payment-refunded {
    background-color: #d1ecf1;
    color: #0c5460;
}

.order-details {
    margin-bottom: 1rem;
}

.order-details p {
    margin-bottom: 0.5rem;
    color: #666;
}

.order-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.btn {
    padding: 0.5rem 1rem;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.btn-primary {
    background-color: #007bff;
    color: #fff;
    border: 1px solid #007bff;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
    color: #fff;
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

.btn-outline-secondary {
    background-color: transparent;
    color: #6c757d;
    border: 1px solid #6c757d;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    color: #fff;
}

.btn-outline-danger {
    background-color: transparent;
    color: #dc3545;
    border: 1px solid #dc3545;
}

.btn-outline-danger:hover {
    background-color: #dc3545;
    color: #fff;
}

.no-orders {
    text-align: center;
    padding: 3rem;
    color: #666;
}

.no-orders i {
    font-size: 4rem;
    color: #ddd;
    margin-bottom: 1rem;
}

.no-orders h4 {
    color: #333;
    margin-bottom: 0.5rem;
}

.text-muted {
    color: #6c757d;
}
</style>
<?= $this->endSection() ?>
