<?= $this->extend('admin/layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Pages</h1>
    <a href="<?= base_url('admin/pages/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Page
    </a>
</div>

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
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Last Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pages)): ?>
                        <?php foreach ($pages as $page): ?>
                        <tr>
                            <td><?= $page['id'] ?></td>
                            <td>
                                <strong><?= $page['title'] ?></strong>
                                <?php if ($page['page_type'] === 'static'): ?>
                                    <span class="badge bg-info ms-2">Static</span>
                                <?php endif; ?>
                            </td>
                            <td><code><?= $page['slug'] ?></code></td>
                            <td><?= ucfirst($page['page_type'] ?? 'static') ?></td>
                            <td>
                                <span class="badge bg-<?= $page['status'] === 'published' ? 'success' : 'secondary' ?>">
                                    <?= ucfirst($page['status']) ?>
                                </span>
                            </td>
                            <td>
                                <small><?= date('M d, Y', strtotime($page['updated_at'] ?? $page['created_at'] ?? 'now')) ?></small>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/pages/edit/' . $page['id']) ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($page['page_type'] !== 'static'): ?>
                                <a href="<?= base_url('admin/pages/delete/' . $page['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <?php endif; ?>
                                <a href="<?= base_url($page['slug']) ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No pages found</p>
                                <a href="<?= base_url('admin/pages/create') ?>" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Create Your First Page
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
