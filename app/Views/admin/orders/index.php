<?= $this->extend('admin/layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Orders Management</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" id="exportBtn">Export</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" id="printBtn">Print</button>
        </div>
    </div>
</div>

<!-- Search Box -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Quick Order Search</h5>
                <div class="input-group">
                    <input type="text" class="form-control" id="orderSearch" placeholder="Search by order number...">
                    <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div id="searchSuggestions" class="list-group mt-2" style="display: none;"></div>
            </div>
        </div>
    </div>
</div>

<!-- Order Statistics -->
<?php if (!empty($orderStats)): ?>
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Order Statistics
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($orderStats as $stat): ?>
                    <div class="col-md-2 mb-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h3 class="card-title text-primary"><?= $stat['count'] ?></h3>
                                <p class="card-text text-capitalize"><?= esc($stat['status']) ?></p>
                                <a href="<?= base_url('admin/orders?status=' . $stat['status']) ?>" 
                                   class="btn btn-sm <?= $currentStatus === $stat['status'] ? 'btn-primary' : 'btn-outline-primary' ?>">
                                    View
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

<!-- Filter Section -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="<?= base_url('admin/orders') ?>" class="row g-3">
                    <div class="col-md-3">
                        <label for="status" class="form-label">Filter by Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Orders</option>
                            <option value="pending" <?= $currentStatus === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="processing" <?= $currentStatus === 'processing' ? 'selected' : '' ?>>Processing</option>
                            <option value="shipped" <?= $currentStatus === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                            <option value="delivered" <?= $currentStatus === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                            <option value="cancelled" <?= $currentStatus === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="<?= base_url('admin/orders') ?>" class="btn btn-outline-secondary">Clear</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Orders Table -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <?= $currentStatus ? ucfirst($currentStatus) . ' ' : '' ?>Orders
                    <span class="badge bg-primary ms-2"><?= $pagination['total'] ?></span>
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($orders)): ?>
                    <div class="table-responsive">
                        <table id="ordersTable" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td>
                                        <strong>#<?= esc($order['order_number']) ?></strong>
                                    </td>
                                    <td>
                                        <div>
                                            <strong><?= esc($order['customer_name']) ?></strong><br>
                                            <small class="text-muted"><?= esc($order['customer_email']) ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <?= date('M j, Y', strtotime($order['created_at'])) ?><br>
                                        <small class="text-muted"><?= date('g:i A', strtotime($order['created_at'])) ?></small>
                                    </td>
                                    <td>
                                        <strong>$<?= number_format($order['total_amount'], 2) ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $getStatusColor($order['status']) ?>">
                                            <?= ucfirst($order['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $getPaymentStatusColor($order['payment_status']) ?>">
                                            <?= ucfirst(str_replace('_', ' ', $order['payment_status'])) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('admin/orders/view/' . $order['id']) ?>" 
                                               class="btn btn-sm btn-outline-primary" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-warning" 
                                                    onclick="updateOrderStatus(<?= $order['id'] ?>)" title="Update Status">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="<?= base_url('admin/orders/delete/' . $order['id']) ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               onclick="return confirm('Are you sure you want to delete this order?')" 
                                               title="Delete Order">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <?php if ($pagination['total_pages'] > 1): ?>
                    <nav aria-label="Orders pagination">
                        <ul class="pagination justify-content-center">
                            <?php if ($pagination['current_page'] > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $pagination['current_page'] - 1 ?><?= $currentStatus ? '&status=' . $currentStatus : '' ?>">Previous</a>
                            </li>
                            <?php endif; ?>
                            
                            <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                            <li class="page-item <?= $i === $pagination['current_page'] ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?><?= $currentStatus ? '&status=' . $currentStatus : '' ?>"><?= $i ?></a>
                            </li>
                            <?php endfor; ?>
                            
                            <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $pagination['current_page'] + 1 ?><?= $currentStatus ? '&status=' . $currentStatus : '' ?>">Next</a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No orders found</h5>
                        <p class="text-muted">
                            <?= $currentStatus ? 'No ' . $currentStatus . ' orders found.' : 'No orders have been placed yet.' ?>
                        </p>
                    </div>
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
                    <input type="hidden" id="orderId" name="order_id">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Admin Notes (Optional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
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
    document.getElementById('orderId').value = orderId;
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

<script>
// Wait for jQuery to be available
function initDataTables() {
    if (typeof $ === 'undefined') {
        setTimeout(initDataTables, 100);
        return;
    }
    
    // DataTables initialization
    $(document).ready(function() {
    var table = $('#ordersTable').DataTable({
        "pageLength": 25,
        "order": [[ 2, "desc" ]], // Sort by date column (index 2) descending
        "columnDefs": [
            { "orderable": false, "targets": [5] } // Disable sorting on Actions column
        ],
        "language": {
            "search": "Search orders:",
            "lengthMenu": "Show _MENU_ orders per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ orders",
            "infoEmpty": "No orders found",
            "infoFiltered": "(filtered from _MAX_ total orders)"
        },
        "dom": 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    
    // Export button functionality
    $('#exportBtn').on('click', function() {
        table.button('.buttons-excel').trigger();
    });
    
    // Print button functionality
    $('#printBtn').on('click', function() {
        table.button('.buttons-print').trigger();
    });
    
    // Order search functionality
    let searchTimeout;
    $('#orderSearch').on('input', function() {
        const query = $(this).val();
        
        clearTimeout(searchTimeout);
        
        if (query.length < 2) {
            $('#searchSuggestions').hide();
            return;
        }
        
        searchTimeout = setTimeout(function() {
            searchOrders(query);
        }, 300);
    });
    
    // Search button click
    $('#searchBtn').on('click', function() {
        const query = $('#orderSearch').val();
        if (query.length >= 2) {
            searchOrders(query);
        }
    });
    
    function searchOrders(query) {
        $.ajax({
            url: '<?= base_url('admin/orders/search') ?>',
            method: 'GET',
            data: { q: query },
            dataType: 'json',
            success: function(response) {
                if (response.success && response.orders.length > 0) {
                    displaySuggestions(response.orders);
                } else {
                    $('#searchSuggestions').hide();
                }
            },
            error: function() {
                $('#searchSuggestions').hide();
            }
        });
    }
    
    function displaySuggestions(orders) {
        let html = '';
        orders.forEach(function(order) {
            html += `
                <a href="<?= base_url('admin/orders/view/') ?>${order.id}" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">${order.order_number}</h6>
                        <small>${order.status}</small>
                    </div>
                    <p class="mb-1">${order.customer_name || order.customer_email}</p>
                    <small>$${parseFloat(order.total_amount).toFixed(2)} - ${new Date(order.created_at).toLocaleDateString()}</small>
                </a>
            `;
        });
        
        $('#searchSuggestions').html(html).show();
    }
    
    // Hide suggestions when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#orderSearch, #searchSuggestions').length) {
            $('#searchSuggestions').hide();
        }
    });
    });
}

// Initialize DataTables when page loads
initDataTables();
</script>

<?= $this->endSection() ?>