<?= $this->extend('admin/layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Order Details #<?= esc($order['order_number']) ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?= base_url('admin/orders') ?>" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back to Orders
            </a>
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="updateOrderStatus(<?= $order['id'] ?>)">
                <i class="fas fa-edit me-1"></i>Update Status
            </button>
        </div>
    </div>
</div>

<div class="row">
    <!-- Order Information -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Order Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Order Details</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Order Number:</strong></td>
                                <td>#<?= esc($order['order_number']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Order Date:</strong></td>
                                <td><?= date('M j, Y g:i A', strtotime($order['created_at'])) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <span class="badge bg-<?= $getStatusColor($order['status']) ?>">
                                        <?= ucfirst($order['status']) ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Payment Status:</strong></td>
                                <td>
                                    <span class="badge bg-<?= $getPaymentStatusColor($order['payment_status']) ?>">
                                        <?= ucfirst(str_replace('_', ' ', $order['payment_status'])) ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Payment Method:</strong></td>
                                <td><?= ucfirst(str_replace('_', ' ', $order['payment_method'])) ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Customer Information</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td><?= esc($order['customer_name']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td><?= esc($order['customer_email']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Phone:</strong></td>
                                <td><?= esc($order['customer_phone']) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Order Items</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($order['items'])): ?>
                                <?php foreach ($order['items'] as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <strong><?= esc($item['product_name']) ?></strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td>$<?= number_format($item['unit_price'], 2) ?></td>
                                    <td><strong>$<?= number_format($item['total_price'], 2) ?></strong></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No items found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Order Notes -->
        <?php if ($order['notes'] || (isset($order['admin_notes']) && $order['admin_notes'])): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Order Notes</h5>
            </div>
            <div class="card-body">
                <?php if ($order['notes']): ?>
                <h6>Customer Notes:</h6>
                <p class="text-muted"><?= esc($order['notes']) ?></p>
                <?php endif; ?>
                
                <?php if (isset($order['admin_notes']) && $order['admin_notes']): ?>
                <h6>Admin Notes:</h6>
                <p class="text-muted"><?= esc($order['admin_notes']) ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Order Summary -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Order Summary</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td>Subtotal:</td>
                        <td class="text-end">$<?= number_format($order['total_amount'] - ($order['shipping_cost'] ?? 0) - ($order['tax_amount'] ?? 0) + ($order['discount_amount'] ?? 0), 2) ?></td>
                    </tr>
                    <?php if ($order['discount_amount'] > 0): ?>
                    <tr>
                        <td>Discount:</td>
                        <td class="text-end text-success">-$<?= number_format($order['discount_amount'], 2) ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td>Shipping:</td>
                        <td class="text-end">$<?= number_format($order['shipping_cost'] ?? 0, 2) ?></td>
                    </tr>
                    <tr>
                        <td>Tax:</td>
                        <td class="text-end">$<?= number_format($order['tax_amount'] ?? 0, 2) ?></td>
                    </tr>
                    <tr class="table-active">
                        <td><strong>Total:</strong></td>
                        <td class="text-end"><strong>$<?= number_format($order['total_amount'], 2) ?></strong></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Shipping Address</h5>
            </div>
            <div class="card-body">
                <?php 
                $shippingAddress = json_decode($order['shipping_address'], true);
                if ($shippingAddress):
                ?>
                <address>
                    <strong><?= esc($shippingAddress['name']) ?></strong><br>
                    <?= esc($shippingAddress['address']) ?><br>
                    <?= esc($shippingAddress['city']) ?>, <?= esc($shippingAddress['country']) ?><br>
                    <i class="fas fa-phone me-1"></i><?= esc($shippingAddress['phone']) ?>
                </address>
                <?php else: ?>
                <p class="text-muted">No shipping address provided</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Billing Address -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Billing Address</h5>
            </div>
            <div class="card-body">
                <?php 
                $billingAddress = json_decode($order['billing_address'], true);
                if ($billingAddress):
                ?>
                <address>
                    <strong><?= esc($billingAddress['name']) ?></strong><br>
                    <?= esc($billingAddress['address']) ?><br>
                    <?= esc($billingAddress['city']) ?>, <?= esc($billingAddress['country']) ?><br>
                    <i class="fas fa-phone me-1"></i><?= esc($billingAddress['phone']) ?>
                </address>
                <?php else: ?>
                <p class="text-muted">No billing address provided</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="updateStatusForm">
                <div class="modal-body">
                    <input type="hidden" id="orderId" name="order_id" value="<?= $order['id'] ?>">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>Processing</option>
                            <option value="shipped" <?= $order['status'] === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                            <option value="delivered" <?= $order['status'] === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                            <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Admin Notes (Optional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"><?= esc($order['admin_notes'] ?? '') ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateOrderStatus(orderId) {
    const modal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
    modal.show();
}

document.getElementById('updateStatusForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('<?= base_url('admin/orders/update-status') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the order status.');
    });
});
</script>

<?php
// Helper functions for status colors
function getStatusColor($status) {
    switch ($status) {
        case 'pending': return 'warning';
        case 'processing': return 'info';
        case 'shipped': return 'primary';
        case 'delivered': return 'success';
        case 'cancelled': return 'danger';
        default: return 'secondary';
    }
}

function getPaymentStatusColor($status) {
    switch ($status) {
        case 'pending': return 'warning';
        case 'paid': return 'success';
        case 'failed': return 'danger';
        case 'refunded': return 'info';
        default: return 'secondary';
    }
}
?>

<?= $this->endSection() ?>
