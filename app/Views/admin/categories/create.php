<?= $this->extend('admin/layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add New Category</h1>
    <a href="<?= base_url('admin/categories') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Categories
    </a>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (isset($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $error ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="<?= base_url('admin/categories/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" placeholder="auto-generated">
                        <small class="form-text text-muted">Leave empty to auto-generate from name</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="6"></textarea>
                        <small class="form-text text-muted">Use the rich text editor to format your content</small>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="parent_id" class="form-label">Parent Category</label>
                                <select class="form-select" id="parent_id" name="parent_id">
                                    <option value="">No Parent (Main Category)</option>
                                    <?php if (!empty($parent_categories)): ?>
                                        <?php foreach ($parent_categories as $parent): ?>
                                        <option value="<?= $parent['id'] ?>"><?= $parent['name'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" class="form-control" id="sort_order" name="sort_order" value="0" min="0">
                        <small class="form-text text-muted">Lower numbers appear first</small>
                    </div>
                    
                    <!-- SEO Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">SEO Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="meta_title" class="form-label">Meta Title</label>
                                <input type="text" class="form-control" id="meta_title" name="meta_title">
                                <small class="form-text text-muted">Leave empty to use category name</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control" id="meta_description" name="meta_description" rows="3"></textarea>
                                <small class="form-text text-muted">Leave empty to use category description</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" placeholder="jacket, winter, leather">
                            </div>
                            
                            <div class="mb-3">
                                <label for="canonical_url" class="form-label">Canonical URL</label>
                                <input type="url" class="form-control" id="canonical_url" name="canonical_url" placeholder="https://example.com/category-slug">
                                <small class="form-text text-muted">Leave empty to auto-generate from category URL</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Create Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Category Image</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="image" class="form-label">Category Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <small class="form-text text-muted">Recommended size: 300x300px</small>
                </div>
            </div>
        </div>
        
        <!-- Page Settings -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Page Settings</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="sort_order" class="form-label">Sort Order</label>
                    <input type="number" class="form-control" id="sort_order" name="sort_order" value="0" min="0">
                    <small class="form-text text-muted">Lower numbers appear first</small>
                </div>
                
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="show_on_homepage" name="show_on_homepage" value="1">
                    <label class="form-check-label" for="show_on_homepage">
                        Show on Homepage
                    </label>
                    <small class="form-text text-muted d-block">Display this category in the homepage categories section</small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-generate slug and meta title from name
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const slugField = document.getElementById('slug');
    const metaTitleField = document.getElementById('meta_title');
    
    // Auto-generate slug (always update if name changes)
    const slug = name.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '') // Remove all special characters except spaces and hyphens
        .replace(/[^\w\s-]/g, '') // Remove any remaining non-word characters
        .replace(/\s+/g, '-') // Replace spaces with hyphens
        .replace(/-+/g, '-') // Replace multiple hyphens with single hyphen
        .replace(/^-+|-+$/g, '') // Remove leading and trailing hyphens
        .replace(/[^a-z0-9-]/g, '') // Final cleanup - only allow letters, numbers, and hyphens
        .trim();
    slugField.value = slug;
    
    // Auto-generate meta title (only if empty)
    if (!metaTitleField.value) {
        metaTitleField.value = name;
    }
});

// Auto-fill meta description from description
document.getElementById('description').addEventListener('input', function() {
    const metaDescriptionField = document.getElementById('meta_description');
    
    // Auto-generate meta description (only if empty)
    if (!metaDescriptionField.value) {
        if (window.categoryDescriptionEditor) {
            const description = window.categoryDescriptionEditor.getData();
            const plainText = description.replace(/<[^>]*>/g, '');
            if (plainText) {
                metaDescriptionField.value = plainText.substring(0, 160);
            }
        }
    }
});

// Initialize CKEditor for category description
ClassicEditor
    .create(document.querySelector('#description'), {
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'underline', '|',
                'bulletedList', 'numberedList', '|',
                'outdent', 'indent', '|',
                'link', '|',
                'undo', 'redo'
            ]
        },
        language: 'en'
    })
    .then(editor => {
        window.categoryDescriptionEditor = editor;
    })
    .catch(error => {
        console.error('Error initializing CKEditor:', error);
    });
</script>

<!-- CKEditor Rich Text Editor -->
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

<?= $this->endSection() ?>
