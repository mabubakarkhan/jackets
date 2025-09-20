<?= $this->extend('admin/layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Categories</h1>
    <a href="<?= base_url('admin/categories/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Category
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
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?= $category['id'] ?></td>
                            <td><?= $category['name'] ?></td>
                            <td><code><?= $category['slug'] ?></code></td>
                            <td><?= $category['description'] ?? 'No description' ?></td>
                            <td>
                                <span class="badge bg-<?= $category['status'] === 'active' ? 'success' : 'secondary' ?>">
                                    <?= ucfirst($category['status']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/categories/edit/' . $category['id']) ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= base_url('admin/categories/delete/' . $category['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No categories found</p>
                                <a href="<?= base_url('admin/categories/create') ?>" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Your First Category
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
