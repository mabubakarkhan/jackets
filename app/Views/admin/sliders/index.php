<?= $this->extend('admin/layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Slider Management</h1>
    <a href="<?= base_url('admin/sliders/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Slider
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

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Manage Homepage Sliders</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Subtitle</th>
                                <th>Button</th>
                                <th>Sort Order</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($sliders)): ?>
                                <?php foreach ($sliders as $slider): ?>
                                    <tr>
                                        <td>
                                            <img src="<?= base_url('public/uploads/sliders/' . $slider['image']) ?>" alt="Slider Image" 
                                                 style="width: 80px; height: 50px; object-fit: cover; border-radius: 5px;"
                                                 onerror="this.src='<?= base_url('assets/images/placeholder.jpg') ?>'">
                                        </td>
                                        <td><?= esc($slider['title']) ?></td>
                                        <td><?= esc($slider['subtitle']) ?></td>
                                        <td>
                                            <?php if (!empty($slider['button_text'])): ?>
                                                <span class="badge bg-info"><?= esc($slider['button_text']) ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">No button</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $slider['sort_order'] ?></td>
                                        <td>
                                            <span class="badge bg-<?= $slider['status'] === 'active' ? 'success' : 'secondary' ?>">
                                                <?= ucfirst($slider['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('admin/sliders/edit/' . $slider['id']) ?>" 
                                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= base_url('admin/sliders/toggle-status/' . $slider['id']) ?>" 
                                                   class="btn btn-sm btn-outline-<?= $slider['status'] === 'active' ? 'warning' : 'success' ?>" 
                                                   title="<?= $slider['status'] === 'active' ? 'Deactivate' : 'Activate' ?>">
                                                    <i class="fas fa-<?= $slider['status'] === 'active' ? 'eye-slash' : 'eye' ?>"></i>
                                                </a>
                                                <a href="<?= base_url('admin/sliders/delete/' . $slider['id']) ?>" 
                                                   class="btn btn-sm btn-outline-danger" 
                                                   title="Delete" 
                                                   onclick="return confirm('Are you sure you want to delete this slider?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-images fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No sliders found</p>
                                        <a href="<?= base_url('admin/sliders/create') ?>" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Create Your First Slider
                                        </a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Slider Preview</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php if (!empty($sliders)): ?>
                        <?php foreach (array_slice($sliders, 0, 3) as $slider): ?>
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <img src="<?= base_url('public/uploads/sliders/' . $slider['image']) ?>" class="card-img-top" 
                                         style="height: 200px; object-fit: cover;"
                                         onerror="this.src='<?= base_url('assets/images/placeholder.jpg') ?>'">
                                    <div class="card-body">
                                        <h6 class="card-title"><?= esc($slider['title']) ?></h6>
                                        <p class="card-text text-muted"><?= esc($slider['subtitle']) ?></p>
                                        <?php if (!empty($slider['button_text'])): ?>
                                            <a href="<?= esc($slider['button_url']) ?>" class="btn btn-sm btn-primary">
                                                <?= esc($slider['button_text']) ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center text-muted">
                            <p>No sliders to preview</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
