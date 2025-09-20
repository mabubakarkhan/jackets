<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>
<div class="page-header text-center" style="background-image: url('<?= base_url('html/assets/images/page-header-bg.jpg') ?>')">
    <div class="container">
        <h1 class="page-title">My Account<span>Customer Dashboard</span></h1>
    </div><!-- End .container -->
</div><!-- End .page-header -->

<nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Account</li>
        </ol>
    </div><!-- End .container -->
</nav><!-- End .breadcrumb-nav -->

<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="customer-sidebar">
                    <div class="customer-info">
                        <h4>Welcome, <?= esc($customer['name']) ?>!</h4>
                        <p class="text-muted"><?= esc($customer['email']) ?></p>
                    </div>
                    
                    <nav class="customer-nav">
                        <ul>
                            <li><a href="<?= base_url('customer/dashboard') ?>" class="active">Dashboard</a></li>
                            <li><a href="<?= base_url('customer/orders') ?>">My Orders</a></li>
                            <li><a href="<?= base_url('customer/profile') ?>">Profile</a></li>
                            <li><a href="<?= base_url('customer/logout') ?>">Logout</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            
            <div class="col-lg-9">
                <div class="customer-content">
                    <h2>Dashboard</h2>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="dashboard-card">
                                <div class="card-icon">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                                <div class="card-content">
                                    <h3><?= count($orders) ?></h3>
                                    <p>Total Orders</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="dashboard-card">
                                <div class="card-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="card-content">
                                    <h3><?= count(array_filter($orders, function($order) { return $order['status'] == 'pending'; })) ?></h3>
                                    <p>Pending Orders</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="dashboard-card">
                                <div class="card-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="card-content">
                                    <h3><?= count(array_filter($orders, function($order) { return $order['status'] == 'delivered'; })) ?></h3>
                                    <p>Delivered Orders</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="recent-orders">
                        <h3>Recent Orders</h3>
                        
                        <?php if (empty($orders)): ?>
                            <div class="no-orders">
                                <i class="fas fa-shopping-bag"></i>
                                <h4>No orders yet</h4>
                                <p>Start shopping to see your orders here</p>
                                <a href="<?= base_url('shop') ?>" class="btn btn-primary">Start Shopping</a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (array_slice($orders, 0, 5) as $order): ?>
                                            <tr>
                                                <td><?= esc($order['order_number']) ?></td>
                                                <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                                                <td>
                                                    <span class="status-badge status-<?= $order['status'] ?>">
                                                        <?= ucfirst($order['status']) ?>
                                                    </span>
                                                </td>
                                                <td>$<?= number_format($order['total_amount'], 2) ?></td>
                                                <td>
                                                    <a href="<?= base_url('customer/order-detail/' . $order['id']) ?>" 
                                                       class="btn btn-sm btn-outline-primary">View</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="text-center">
                                <a href="<?= base_url('customer/orders') ?>" class="btn btn-outline-primary">View All Orders</a>
                            </div>
                        <?php endif; ?>
                    </div>
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

.dashboard-card {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 2rem;
    text-align: center;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.card-icon {
    font-size: 2.5rem;
    color: #007bff;
}

.card-content h3 {
    font-size: 2rem;
    font-weight: 600;
    margin: 0;
    color: #333;
}

.card-content p {
    margin: 0;
    color: #666;
    font-size: 0.9rem;
}

.recent-orders {
    margin-top: 2rem;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #dee2e6;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
    color: #333;
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

.btn {
    padding: 0.5rem 1rem;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
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

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.8rem;
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

.text-center {
    text-align: center;
}

.text-muted {
    color: #6c757d;
}
</style>
<?= $this->endSection() ?>
