<?= $this->extend('admin/layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Homepage Management</h1>
    <div>
        <a href="<?= base_url('admin/sliders') ?>" class="btn btn-outline-primary me-2">
            <i class="fas fa-images"></i> Manage Sliders
        </a>
        <a href="<?= base_url('admin/homepage-sections') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-th-large"></i> Manage Sections
        </a>
    </div>
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
    <!-- Slider Management -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Homepage Slider</h5>
                <a href="<?= base_url('admin/sliders') ?>" class="btn btn-sm btn-primary">
                    <i class="fas fa-cog"></i> Manage
                </a>
            </div>
            <div class="card-body">
                <?php if (!empty($sliders)): ?>
                    <div class="row">
                        <?php foreach (array_slice($sliders, 0, 3) as $slider): ?>
                            <div class="col-12 mb-3">
                                <div class="d-flex align-items-center">
                                    <img src="<?= base_url('public/uploads/sliders/' . $slider['image']) ?>" alt="Slider" 
                                         class="rounded me-3" style="width: 80px; height: 50px; object-fit: cover;"
                                         onerror="this.src='<?= base_url('assets/images/placeholder.jpg') ?>'">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?= esc($slider['title']) ?></h6>
                                        <small class="text-muted"><?= esc($slider['subtitle']) ?></small>
                                        <div class="mt-1">
                                            <span class="badge bg-<?= $slider['status'] === 'active' ? 'success' : 'secondary' ?>">
                                                <?= ucfirst($slider['status']) ?>
                                            </span>
                                            <span class="badge bg-info">Order: <?= $slider['sort_order'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($sliders) > 3): ?>
                        <div class="text-center">
                            <small class="text-muted">And <?= count($sliders) - 3 ?> more sliders...</small>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-images fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No sliders configured</p>
                        <a href="<?= base_url('admin/sliders/create') ?>" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create First Slider
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Homepage Sections -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Homepage Sections</h5>
                <a href="<?= base_url('admin/homepage-sections') ?>" class="btn btn-sm btn-secondary">
                    <i class="fas fa-cog"></i> Manage
                </a>
            </div>
            <div class="card-body">
                <?php if (!empty($sections)): ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($sections as $section): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h6 class="mb-1"><?= esc($section['title']) ?></h6>
                                    <small class="text-muted"><?= esc($section['section_key']) ?></small>
                                </div>
                                <span class="badge bg-<?= $section['status'] === 'active' ? 'success' : 'secondary' ?>">
                                    <?= ucfirst($section['status']) ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-th-large fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No sections configured</p>
                        <a href="<?= base_url('admin/homepage-sections') ?>" class="btn btn-secondary">
                            <i class="fas fa-plus"></i> Configure Sections
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Homepage Settings -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Homepage Settings</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('admin/homepage/update-settings') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="site_name" class="form-label">Site Name</label>
                                <input type="text" class="form-control" id="site_name" name="site_name" 
                                       value="<?= $settings['site_name'] ?? '' ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="site_description" class="form-label">Site Description</label>
                                <textarea class="form-control" id="site_description" name="site_description" rows="3"><?= $settings['site_description'] ?? '' ?></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="hero_image" class="form-label">Hero Image URL</label>
                                <input type="url" class="form-control" id="hero_image" name="hero_image" 
                                       value="<?= $settings['hero_image'] ?? '' ?>" 
                                       placeholder="https://example.com/hero-image.jpg">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="site_email" class="form-label">Contact Email</label>
                                <input type="email" class="form-control" id="site_email" name="site_email" 
                                       value="<?= $settings['site_email'] ?? '' ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="site_phone" class="form-label">Contact Phone</label>
                                <input type="tel" class="form-control" id="site_phone" name="site_phone" 
                                       value="<?= $settings['site_phone'] ?? '' ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="whatsapp_number" class="form-label">WhatsApp Number</label>
                                <input type="tel" class="form-control" id="whatsapp_number" name="whatsapp_number" 
                                       value="<?= $settings['whatsapp_number'] ?? '' ?>" 
                                       placeholder="+1234567890">
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Homepage Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="<?= base_url('admin/sliders/create') ?>" class="btn btn-outline-primary w-100">
                            <i class="fas fa-plus"></i><br>
                            <small>Add New Slider</small>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?= base_url('admin/homepage-sections') ?>" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-th-large"></i><br>
                            <small>Manage Sections</small>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?= base_url('admin/products') ?>" class="btn btn-outline-success w-100">
                            <i class="fas fa-box"></i><br>
                            <small>Manage Products</small>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?= base_url('/') ?>" target="_blank" class="btn btn-outline-info w-100">
                            <i class="fas fa-external-link-alt"></i><br>
                            <small>View Homepage</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
