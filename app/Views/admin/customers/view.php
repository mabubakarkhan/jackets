<?= $this->extend('admin/layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Customer Details</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?= base_url('admin/customers') ?>" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Customers
            </a>
            <a href="<?= base_url('admin/customers/edit/' . $customer['id']) ?>" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Edit Customer
            </a>
        </div>
    </div>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <!-- Customer Information -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>Customer Information
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="avatar-lg bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center">
                        <?= strtoupper(substr($customer['name'], 0, 1)) ?>
                    </div>
                    <h4 class="mt-3 mb-1"><?= esc($customer['name']) ?></h4>
                    <p class="text-muted"><?= esc($customer['email']) ?></p>
                    <span class="badge bg-<?= getStatusColor($customer['status']) ?> fs-6">
                        <?= ucfirst($customer['status']) ?>
                    </span>
                </div>
                
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-bold">Phone</label>
                        <p class="mb-0"><?= esc($customer['phone']) ?></p>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Address</label>
                        <p class="mb-0"><?= esc($customer['address']) ?></p>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold">City</label>
                        <p class="mb-0"><?= esc($customer['city']) ?></p>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold">Country</label>
                        <p class="mb-0"><?= esc($customer['country']) ?></p>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Member Since</label>
                        <p class="mb-0"><?= date('F j, Y', strtotime($customer['created_at'])) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Customer Statistics -->
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title"><?= $total_orders ?></h4>
                                <p class="card-text">Total Orders</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-shopping-cart fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title">$<?= number_format($total_spent, 2) ?></h4>
                                <p class="card-text">Total Spent</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-dollar-sign fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Customer Orders -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-shopping-bag me-2"></i>Order History
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($orders)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td>
                                        <strong><?= esc($order['order_number']) ?></strong>
                                    </td>
                                    <td><?= date('M j, Y', strtotime($order['created_at'])) ?></td>
                                    <td>
                                        <span class="badge bg-<?= getOrderStatusColor($order['order_status']) ?>">
                                            <?= ucfirst($order['order_status']) ?>
                                        </span>
                                    </td>
                                    <td>$<?= number_format($order['total_amount'], 2) ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/orders/view/' . $order['id']) ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No orders yet</h5>
                        <p class="text-muted">This customer hasn't placed any orders.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
// Helper functions
function getStatusColor($status) {
    switch ($status) {
        case 'active': return 'success';
        case 'inactive': return 'warning';
        case 'suspended': return 'danger';
        default: return 'secondary';
    }
}

function getOrderStatusColor($status) {
    switch ($status) {
        case 'pending': return 'warning';
        case 'processing': return 'info';
        case 'shipped': return 'primary';
        case 'delivered': return 'success';
        case 'cancelled': return 'danger';
        case 'completed': return 'success';
        default: return 'secondary';
    }
}
?>

<style>
.avatar-lg {
    width: 80px;
    height: 80px;
    font-size: 32px;
    font-weight: bold;
}
</style>

<?= $this->endSection() ?>
