<?= $this->extend('admin/layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/categories') ?>">Categories</a></li>
                        <li class="breadcrumb-item active">Edit Category</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Category</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('admin/categories/update/' . $category['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-md-8">
                                <!-- Basic Information -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Basic Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" 
                                                   value="<?= old('name', $category['name']) ?>" required>
                                            <?php if (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('name')): ?>
                                                <div class="text-danger"><?= session()->getFlashdata('validation')->getError('name') ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="4"><?= old('description', $category['description']) ?></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="parent_id" class="form-label">Parent Category</label>
                                            <select class="form-select" id="parent_id" name="parent_id">
                                                <option value="">No Parent (Top Level)</option>
                                                <?php if (!empty($parent_categories)): ?>
                                                    <?php foreach ($parent_categories as $parent): ?>
                                                        <option value="<?= $parent['id'] ?>" 
                                                                <?= (old('parent_id', $category['parent_id']) == $parent['id']) ? 'selected' : '' ?>>
                                                            <?= $parent['name'] ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                            <small class="form-text text-muted">Select a parent category to create a subcategory</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- SEO Information -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">SEO Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="meta_title" class="form-label">Meta Title</label>
                                            <input type="text" class="form-control" id="meta_title" name="meta_title" 
                                                   value="<?= old('meta_title', $category['meta_title']) ?>" maxlength="60">
                                            <small class="form-text text-muted">Recommended: 50-60 characters</small>
                                        </div>

                                        <div class="mb-3">
                                            <label for="meta_description" class="form-label">Meta Description</label>
                                            <textarea class="form-control" id="meta_description" name="meta_description" 
                                                      rows="3" maxlength="160"><?= old('meta_description', $category['meta_description']) ?></textarea>
                                            <small class="form-text text-muted">Recommended: 150-160 characters</small>
                                        </div>

                                        <div class="mb-3">
                                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" 
                                                   value="<?= old('meta_keywords', $category['meta_keywords']) ?>">
                                            <small class="form-text text-muted">Separate keywords with commas</small>
                                        </div>

                                        <div class="mb-3">
                                            <label for="canonical_url" class="form-label">Canonical URL</label>
                                            <input type="url" class="form-control" id="canonical_url" name="canonical_url" 
                                                   value="<?= old('canonical_url', $category['canonical_url'] ?? '') ?>" 
                                                   placeholder="https://example.com/category-slug">
                                            <small class="form-text text-muted">Leave empty to auto-generate from category URL</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Category Settings -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Category Settings</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="active" <?= (old('status', $category['status']) == 'active') ? 'selected' : '' ?>>Active</option>
                                                <option value="inactive" <?= (old('status', $category['status']) == 'inactive') ? 'selected' : '' ?>>Inactive</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="sort_order" class="form-label">Sort Order</label>
                                            <input type="number" class="form-control" id="sort_order" name="sort_order" 
                                                   value="<?= old('sort_order', $category['sort_order']) ?>" min="0">
                                            <small class="form-text text-muted">Lower numbers appear first</small>
                                        </div>
                                        
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="show_on_homepage" name="show_on_homepage" value="1" 
                                                   <?= (old('show_on_homepage', $category['show_on_homepage'] ?? 0)) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="show_on_homepage">
                                                Show on Homepage
                                            </label>
                                            <small class="form-text text-muted d-block">Display this category in the homepage categories section</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Update Category
                                            </button>
                                            <a href="<?= base_url('admin/categories') ?>" class="btn btn-secondary">
                                                <i class="fas fa-arrow-left"></i> Back to Categories
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug and meta title from category name
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    const metaTitleInput = document.getElementById('meta_title');
    
    if (nameInput) {
        nameInput.addEventListener('input', function() {
            const name = this.value;
            
            // Auto-generate slug (always update if name changes)
            if (slugInput) {
                const slug = name.toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '') // Remove all special characters except spaces and hyphens
                    .replace(/[^\w\s-]/g, '') // Remove any remaining non-word characters
                    .replace(/\s+/g, '-') // Replace spaces with hyphens
                    .replace(/-+/g, '-') // Replace multiple hyphens with single hyphen
                    .replace(/^-+|-+$/g, '') // Remove leading and trailing hyphens
                    .replace(/[^a-z0-9-]/g, '') // Final cleanup - only allow letters, numbers, and hyphens
                    .trim();
                slugInput.value = slug;
            }
            
            // Auto-generate meta title (only if empty)
            if (metaTitleInput && !metaTitleInput.value) {
                metaTitleInput.value = name;
            }
        });
    }
    
    // Auto-generate meta description from description
    const descriptionInput = document.getElementById('description');
    const metaDescriptionInput = document.getElementById('meta_description');
    
    if (descriptionInput && metaDescriptionInput) {
        descriptionInput.addEventListener('input', function() {
            if (!metaDescriptionInput.value && this.value) {
                // Strip HTML tags and get plain text
                const plainText = this.value.replace(/<[^>]*>/g, '');
                if (plainText) {
                    metaDescriptionInput.value = plainText.substring(0, 160);
                }
            }
        });
    }
});
</script>

<?= $this->endSection() ?>
