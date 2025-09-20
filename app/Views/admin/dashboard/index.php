<?= $this->extend('admin/layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Print</button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title"><?= $total_products ?? 0 ?></h4>
                        <p class="card-text">Total Products</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title"><?= $total_categories ?? 0 ?></h4>
                        <p class="card-text">Categories</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-tags fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title"><?= $total_orders ?? 0 ?></h4>
                        <p class="card-text">Orders</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title"><?= $total_customers ?? 0 ?></h4>
                        <p class="card-text">Customers</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-secondary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title"><?= $total_pages ?? 0 ?></h4>
                        <p class="card-text">Pages</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-file-alt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Additional Metrics Row -->
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">$<?= number_format($total_revenue ?? 0, 2) ?></h4>
                        <p class="card-text">Total Revenue</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-dollar-sign fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">$<?= number_format($monthly_revenue ?? 0, 2) ?></h4>
                        <p class="card-text">This Month</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar-alt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title"><?= $today_orders ?? 0 ?></h4>
                        <p class="card-text">Today's Orders</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-shopping-bag fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title"><?= $pending_orders ?? 0 ?></h4>
                        <p class="card-text">Pending Orders</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie me-2"></i>Orders by Status
                </h5>
            </div>
            <div class="card-body">
                <canvas id="orderStatusChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Monthly Orders
                </h5>
            </div>
            <div class="card-body">
                <canvas id="monthlyOrdersChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Order Status Cards -->
<?php if (!empty($orders_by_status)): ?>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>Order Status Summary
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($orders_by_status as $status): ?>
                    <div class="col-md-2 mb-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h3 class="card-title text-primary"><?= $status['count'] ?></h3>
                                <p class="card-text text-capitalize"><?= esc($status['status']) ?></p>
                                <a href="<?= base_url('admin/orders?status=' . $status['status']) ?>" class="btn btn-sm btn-outline-primary">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Products</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_products)): ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recent_products as $product): ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1"><?= esc($product['name']) ?></h6>
                                <small class="text-muted">$<?= number_format($product['price'], 2) ?></small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-primary rounded-pill"><?= esc($product['status']) ?></span>
                                <a href="<?= base_url('admin/products/edit/' . $product['id']) ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="card-footer">
                        <a href="<?= base_url('admin/products') ?>" class="btn btn-primary btn-sm">View All Products</a>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-box fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No products yet</p>
                        <a href="<?= base_url('admin/products/create') ?>" class="btn btn-primary">Add Your First Product</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Orders</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_orders)): ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recent_orders as $order): ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Order #<?= esc($order['order_number']) ?></h6>
                                <small class="text-muted"><?= esc($order['customer_name']) ?> - $<?= number_format($order['total_amount'], 2) ?></small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-warning rounded-pill"><?= esc($order['order_status']) ?></span>
                                <a href="<?= base_url('admin/orders/view/' . $order['id']) ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="card-footer">
                        <a href="<?= base_url('admin/orders') ?>" class="btn btn-warning btn-sm">View All Orders</a>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No orders yet</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Customers</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_customers)): ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recent_customers as $customer): ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1"><?= esc($customer['name']) ?></h6>
                                <small class="text-muted"><?= esc($customer['email']) ?></small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <small class="text-muted"><?= date('M j, Y', strtotime($customer['created_at'])) ?></small>
                                <a href="<?= base_url('admin/customers/view/' . $customer['id']) ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="card-footer">
                        <a href="<?= base_url('admin/customers') ?>" class="btn btn-info btn-sm">View All Customers</a>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No customers yet</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="<?= base_url('admin/products/create') ?>" class="btn btn-primary w-100">
                            <i class="fas fa-plus"></i> Add New Product
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="<?= base_url('admin/categories/create') ?>" class="btn btn-success w-100">
                            <i class="fas fa-tag"></i> Add New Category
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="<?= base_url('admin/pages/create') ?>" class="btn btn-info w-100">
                            <i class="fas fa-file-alt"></i> Create New Page
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="<?= base_url('admin/settings') ?>" class="btn btn-warning w-100">
                            <i class="fas fa-cog"></i> Manage Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Wait for jQuery to be available
function initDashboardCharts() {
    if (typeof $ === 'undefined' || typeof Chart === 'undefined') {
        setTimeout(initDashboardCharts, 100);
        return;
    }
    
    $(document).ready(function() {
        // Order Status Pie Chart
        const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
        const orderStatusData = <?= json_encode($orders_by_status) ?>;
        
        const statusLabels = orderStatusData.map(item => item.status.charAt(0).toUpperCase() + item.status.slice(1));
        const statusCounts = orderStatusData.map(item => parseInt(item.count));
        const statusColors = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#FF6384'
        ];
        
        new Chart(orderStatusCtx, {
            type: 'pie',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusCounts,
                    backgroundColor: statusColors.slice(0, statusLabels.length),
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
        
        // Monthly Orders Bar Chart
        const monthlyOrdersCtx = document.getElementById('monthlyOrdersChart').getContext('2d');
        
        // Get last 6 months data
        const monthlyData = <?= json_encode($monthly_orders ?? []) ?>;
        
        new Chart(monthlyOrdersCtx, {
            type: 'bar',
            data: {
                labels: monthlyData.map(item => item.month),
                datasets: [{
                    label: 'Orders',
                    data: monthlyData.map(item => parseInt(item.count)),
                    backgroundColor: '#36A2EB',
                    borderColor: '#36A2EB',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    });
}

// Initialize charts when page loads
initDashboardCharts();
</script>

<?= $this->endSection() ?>
