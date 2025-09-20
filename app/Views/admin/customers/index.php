<?= $this->extend('admin/layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Customers Management</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="exportCustomers()">Export</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="printCustomers()">Print</button>
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

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-users me-2"></i>All Customers
        </h5>
    </div>
    <div class="card-body">
        <?php if (!empty($customers)): ?>
            <div class="table-responsive">
                <table id="customersTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?= $customer['id'] ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                        <?= strtoupper(substr($customer['name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <strong><?= esc($customer['name']) ?></strong>
                                    </div>
                                </div>
                            </td>
                            <td><?= esc($customer['email']) ?></td>
                            <td><?= esc($customer['phone']) ?></td>
                            <td><?= esc($customer['city']) ?></td>
                            <td>
                                <span class="badge bg-<?= getStatusColor($customer['status']) ?>">
                                    <?= ucfirst($customer['status']) ?>
                                </span>
                            </td>
                            <td><?= date('M j, Y', strtotime($customer['created_at'])) ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?= base_url('admin/customers/view/' . $customer['id']) ?>" 
                                       class="btn btn-sm btn-outline-primary" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('admin/customers/edit/' . $customer['id']) ?>" 
                                       class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger" 
                                            title="Delete"
                                            onclick="deleteCustomer(<?= $customer['id'] ?>, '<?= esc($customer['name']) ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No customers found</h5>
                <p class="text-muted">No customers have registered yet.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Wait for jQuery to be available
function initCustomersDataTable() {
    if (typeof $ === 'undefined') {
        setTimeout(initCustomersDataTable, 100);
        return;
    }
    
    $(document).ready(function() {
        $('#customersTable').DataTable({
            "pageLength": 25,
            "order": [[ 0, "desc" ]], // Sort by ID descending
            "columnDefs": [
                { "orderable": false, "targets": [7] } // Disable sorting on Actions column
            ],
            "language": {
                "lengthMenu": "Show _MENU_ customers per page",
                "zeroRecords": "No customers found",
                "info": "Showing _START_ to _END_ of _TOTAL_ customers",
                "infoEmpty": "No customers available",
                "infoFiltered": "(filtered from _MAX_ total customers)"
            },
            "dom": 'Bfrtip',
            "buttons": [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
}

// Initialize DataTables when page loads
initCustomersDataTable();

// Delete customer function
function deleteCustomer(customerId, customerName) {
    if (confirm('Are you sure you want to delete customer "' + customerName + '"?\n\nThis action cannot be undone.')) {
        window.location.href = '<?= base_url('admin/customers/delete/') ?>' + customerId;
    }
}

// Export functions
function exportCustomers() {
    // Trigger DataTables export
    $('#customersTable').DataTable().button('.buttons-csv').trigger();
}

function printCustomers() {
    // Trigger DataTables print
    $('#customersTable').DataTable().button('.buttons-print').trigger();
}
</script>

<?php
// Helper function for status colors
function getStatusColor($status) {
    switch ($status) {
        case 'active': return 'success';
        case 'inactive': return 'warning';
        case 'suspended': return 'danger';
        default: return 'secondary';
    }
}
?>

<style>
.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 14px;
    font-weight: bold;
}
</style>

<?= $this->endSection() ?>
