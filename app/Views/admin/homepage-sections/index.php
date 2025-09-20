<?= $this->extend('admin/layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Homepage Sections</h1>
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
                <h5 class="card-title mb-0">Manage Homepage Sections</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Section</th>
                                <th>Title</th>
                                <th>Content Preview</th>
                                <th>Image</th>
                                <th>Sort Order</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($sections)): ?>
                                <?php foreach ($sections as $section): ?>
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary"><?= esc($section['section_key']) ?></span>
                                        </td>
                                        <td><?= esc($section['title']) ?></td>
                                        <td>
                                            <?php if (!empty($section['content'])): ?>
                                                <?= esc(substr($section['content'], 0, 100)) ?><?= strlen($section['content']) > 100 ? '...' : '' ?>
                                            <?php else: ?>
                                                <span class="text-muted">No content</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($section['image_url'])): ?>
                                                <img src="<?= esc($section['image_url']) ?>" alt="Section Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                            <?php else: ?>
                                                <span class="text-muted">No image</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $section['sort_order'] ?></td>
                                        <td>
                                            <span class="badge bg-<?= $section['status'] === 'active' ? 'success' : 'secondary' ?>">
                                                <?= ucfirst($section['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/homepage-sections/edit/' . $section['id']) ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No homepage sections found</td>
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
                <h5 class="card-title mb-0">Section Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Available Sections:</h6>
                        <ul>
                            <li><strong>hero_section:</strong> Main hero banner section</li>
                            <li><strong>featured_products:</strong> Featured products section</li>
                            <li><strong>categories_section:</strong> Categories showcase section</li>
                            <li><strong>video_banner:</strong> Video banner section</li>
                            <li><strong>why_choose_us:</strong> Why choose us section</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Instructions:</h6>
                        <ul>
                            <li>Edit each section to customize the homepage content</li>
                            <li>Use sort order to control section display order</li>
                            <li>Set status to inactive to hide sections</li>
                            <li>Image URLs should be full URLs (e.g., https://example.com/image.jpg)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
