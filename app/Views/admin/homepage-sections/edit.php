<?= $this->extend('admin/layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Homepage Section</h1>
    <a href="<?= base_url('admin/homepage-sections') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Sections
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
    <div class="col-md-8">
        <form action="<?= base_url('admin/homepage-sections/update/' . $section['id']) ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Section Details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="section_key" class="form-label">Section Key</label>
                        <input type="text" class="form-control" id="section_key" value="<?= esc($section['section_key']) ?>" readonly>
                        <small class="form-text text-muted">This is the unique identifier for this section</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?= old('title', $section['title']) ?>" required>
                        <?php if (isset($validation) && $validation->hasError('title')): ?>
                            <div class="text-danger"><?= $validation->getError('title') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="5"><?= old('content', $section['content']) ?></textarea>
                        <small class="form-text text-muted">Main content for this section</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="image_url" class="form-label">Image URL</label>
                        <input type="url" class="form-control" id="image_url" name="image_url" 
                               value="<?= old('image_url', $section['image_url']) ?>" 
                               placeholder="https://example.com/image.jpg">
                        <small class="form-text text-muted">Full URL to the image for this section</small>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="button_text" class="form-label">Button Text</label>
                                <input type="text" class="form-control" id="button_text" name="button_text" 
                                       value="<?= old('button_text', $section['button_text']) ?>" 
                                       placeholder="e.g., Shop Now, Learn More">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="button_url" class="form-label">Button URL</label>
                                <input type="url" class="form-control" id="button_url" name="button_url" 
                                       value="<?= old('button_url', $section['button_url']) ?>" 
                                       placeholder="https://example.com/page">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-grid mt-3">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i> Update Section
                </button>
            </div>
        </form>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Section Settings</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="sort_order" class="form-label">Sort Order</label>
                    <input type="number" class="form-control" id="sort_order" name="sort_order" 
                           value="<?= old('sort_order', $section['sort_order']) ?>" min="0">
                    <small class="form-text text-muted">Lower numbers appear first</small>
                </div>
                
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="active" <?= (old('status', $section['status']) == 'active') ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= (old('status', $section['status']) == 'inactive') ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Preview</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($section['image_url'])): ?>
                    <img src="<?= esc($section['image_url']) ?>" alt="Section Preview" class="img-fluid rounded mb-3">
                <?php endif; ?>
                
                <h6><?= esc($section['title']) ?></h6>
                <?php if (!empty($section['content'])): ?>
                    <p class="text-muted"><?= esc(substr($section['content'], 0, 100)) ?><?= strlen($section['content']) > 100 ? '...' : '' ?></p>
                <?php endif; ?>
                
                <?php if (!empty($section['button_text'])): ?>
                    <a href="<?= esc($section['button_url']) ?>" class="btn btn-sm btn-outline-primary">
                        <?= esc($section['button_text']) ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
