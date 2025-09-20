<?= $this->extend('admin/layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Products</h1>
    <a href="<?= base_url('admin/products/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Product
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="productsTable" class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Hot Selling</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product['id'] ?></td>
                            <td><?= $product['name'] ?></td>
                            <td>
                                <?php if ($product['sale_price'] && $product['sale_price'] < $product['price']): ?>
                                    <span class="text-danger fw-bold">$<?= number_format($product['sale_price'], 2) ?></span>
                                    <br><small class="text-muted text-decoration-line-through">$<?= number_format($product['price'], 2) ?></small>
                                <?php else: ?>
                                    <span class="fw-bold">$<?= number_format($product['price'], 2) ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-<?= $product['status'] === 'active' ? 'success' : 'secondary' ?>">
                                    <?= ucfirst($product['status']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($product['featured'] == 1): ?>
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-star"></i> Featured
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($product['hot_selling'] == 1): ?>
                                    <span class="badge bg-danger">
                                        <i class="fas fa-fire"></i> Hot
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/products/edit/' . $product['id']) ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= base_url('admin/products/delete/' . $product['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-box fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No products found</p>
                                <a href="<?= base_url('admin/products/create') ?>" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Your First Product
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// Wait for jQuery to be available
function initProductsDataTable() {
    if (typeof $ === 'undefined') {
        setTimeout(initProductsDataTable, 100);
        return;
    }
    
    $(document).ready(function() {
        $('#productsTable').DataTable({
        "pageLength": 25,
        "order": [[ 0, "desc" ]], // Sort by ID descending
        "columnDefs": [
            { "orderable": false, "targets": [4] } // Disable sorting on Actions column
        ],
        "language": {
            "search": "Search products:",
            "lengthMenu": "Show _MENU_ products per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ products",
            "infoEmpty": "No products found",
            "infoFiltered": "(filtered from _MAX_ total products)"
        },
        "dom": 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
        });
    });
}

// Initialize DataTables when page loads
initProductsDataTable();
</script>

<?= $this->endSection() ?>
