<?= $this->extend('admin/layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Slider</h1>
    <a href="<?= base_url('admin/sliders') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Sliders
    </a>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Submit Button at Top -->
<div class="d-grid mb-4">
    <button type="submit" form="slider-form" class="btn btn-primary btn-lg">
        <i class="fas fa-save"></i> Update Slider
    </button>
</div>

<div class="row">
    <div class="col-md-8">
        <form id="slider-form" action="<?= base_url('admin/sliders/update/' . $slider['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Slider Content</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('title')) ? 'is-invalid' : '' ?>" 
                               id="title" name="title" value="<?= old('title', $slider['title']) ?>" required>
                        <?php if (isset($validation) && $validation->hasError('title')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('title') ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="subtitle" class="form-label">Subtitle</label>
                        <input type="text" class="form-control" id="subtitle" name="subtitle" 
                               value="<?= old('subtitle', $slider['subtitle']) ?>" placeholder="e.g., Want to know what's hot?">
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?= old('description', $slider['description']) ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Slider Image</label>
                        <input type="file" class="form-control <?= (isset($validation) && $validation->hasError('image')) ? 'is-invalid' : '' ?>" 
                               id="image" name="image" accept="image/*">
                        <?php if (isset($validation) && $validation->hasError('image')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('image') ?></div>
                        <?php endif; ?>
                        <small class="form-text text-muted">Leave empty to keep current image. Max size: 2MB</small>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="button_text" class="form-label">Button Text</label>
                                <input type="text" class="form-control" id="button_text" name="button_text" 
                                       value="<?= old('button_text', $slider['button_text']) ?>" placeholder="e.g., Shop Now, Learn More">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="button_url" class="form-label">Button URL</label>
                                <input type="url" class="form-control" id="button_url" name="button_url" 
                                       value="<?= old('button_url', $slider['button_url']) ?>" placeholder="https://example.com/page">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Slider Settings</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="sort_order" class="form-label">Sort Order</label>
                    <input type="number" class="form-control" id="sort_order" name="sort_order" 
                           value="<?= old('sort_order', $slider['sort_order']) ?>" min="0" form="slider-form">
                    <small class="form-text text-muted">Lower numbers appear first</small>
                </div>
                
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" form="slider-form">
                        <option value="active" <?= (old('status', $slider['status']) == 'active') ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= (old('status', $slider['status']) == 'inactive') ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Current Preview</h5>
            </div>
            <div class="card-body">
                <img id="current-image" src="<?= base_url('public/uploads/sliders/' . $slider['image']) ?>" alt="Current Slider" class="img-fluid rounded mb-3"
                     style="width: 100%; height: 150px; object-fit: cover;"
                     onerror="this.src='<?= base_url('assets/images/placeholder.jpg') ?>'">
                <h6><?= esc($slider['title']) ?></h6>
                <?php if (!empty($slider['subtitle'])): ?>
                    <p class="text-muted"><?= esc($slider['subtitle']) ?></p>
                <?php endif; ?>
                <?php if (!empty($slider['button_text'])): ?>
                    <a href="<?= esc($slider['button_url']) ?>" class="btn btn-sm btn-primary">
                        <?= esc($slider['button_text']) ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Live preview functionality for file upload
document.getElementById('image').addEventListener('change', function() {
    const file = this.files[0];
    const preview = document.getElementById('current-image');
    
    if (file && preview) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>

<?= $this->endSection() ?>
