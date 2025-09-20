<?= $this->extend('admin/layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create New Page</h1>
    <div>
        <button type="submit" form="pageCreateForm" class="btn btn-primary me-2">
            <i class="fas fa-save"></i> Create Page
        </button>
        <a href="<?= base_url('admin/pages') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Pages
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<form id="pageCreateForm" action="<?= base_url('admin/pages/store') ?>" method="post">
    <?= csrf_field() ?>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Page Title *</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" placeholder="auto-generated">
                        <small class="form-text text-muted">Leave empty to auto-generate from title</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="content" class="form-label">Page Content *</label>
                        <textarea class="form-control" id="content" name="content" rows="12" required></textarea>
                        <small class="form-text text-muted">Use the rich text editor to format your content</small>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="page_type" class="form-label">Page Type</label>
                                <select class="form-select" id="page_type" name="page_type">
                                    <option value="static">Static Page</option>
                                    <option value="blog">Blog Post</option>
                                    <option value="faq">FAQ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="published">Published</option>
                                    <option value="draft">Draft</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" class="form-control" id="sort_order" name="sort_order" value="0" min="0">
                        <small class="form-text text-muted">Lower numbers appear first</small>
                    </div>
                    
                </div>
            </div>
        </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">SEO Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" class="form-control" id="meta_title" name="meta_title">
                    <small class="form-text text-muted">Leave empty to use page title</small>
                </div>
                
                <div class="mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea class="form-control" id="meta_description" name="meta_description" rows="3"></textarea>
                    <small class="form-text text-muted">Leave empty to use page content</small>
                </div>
                
                <div class="mb-3">
                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" placeholder="jacket, store, fashion">
                </div>
                
                <div class="mb-3">
                    <label for="canonical_url" class="form-label">Canonical URL</label>
                    <input type="url" class="form-control" id="canonical_url" name="canonical_url" placeholder="https://example.com/page-slug">
                    <small class="form-text text-muted">Leave empty to auto-generate from page URL</small>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Page Settings</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_static" name="is_static" value="1" disabled>
                        <label class="form-check-label" for="is_static">
                            Static Page
                        </label>
                        <small class="form-text text-muted d-block">Static pages cannot be deleted (determined by page type)</small>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="show_in_menu" name="show_in_menu" value="1" checked>
                        <label class="form-check-label" for="show_in_menu">
                            Show in Navigation Menu
                        </label>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="show_in_footer" name="show_in_footer" value="1">
                        <label class="form-check-label" for="show_in_footer">
                            Show in Footer
                        </label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Page Template</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="template" class="form-label">Template</label>
                    <select class="form-select" id="template" name="template">
                        <option value="default">Default Template</option>
                        <option value="fullwidth">Full Width</option>
                        <option value="sidebar">With Sidebar</option>
                        <option value="landing">Landing Page</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>

<!-- CKEditor Rich Text Editor -->
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

<script>
// Auto-generate slug and meta title from title
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const slugField = document.getElementById('slug');
    const metaTitleField = document.getElementById('meta_title');
    
    // Auto-generate slug (always update if title changes)
    const slug = title
        .toLowerCase()
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
        metaTitleField.value = title;
    }
});

// Auto-fill meta fields if empty
document.getElementById('title').addEventListener('blur', function() {
    const metaTitle = document.getElementById('meta_title');
    const metaDescription = document.getElementById('meta_description');
    
    if (!metaTitle.value) {
        metaTitle.value = this.value;
    }
    
    if (!metaDescription.value) {
        const content = document.getElementById('content').value;
        if (content) {
            // Strip HTML tags and get first 160 characters
            const plainText = content.replace(/<[^>]*>/g, '').substring(0, 160);
            metaDescription.value = plainText;
        }
    }
});

// Content change handler for meta description
document.getElementById('content').addEventListener('input', function() {
    const metaDescription = document.getElementById('meta_description');
    if (!metaDescription.value) {
        if (window.pageContentEditor) {
            const content = window.pageContentEditor.getData();
            const plainText = content.replace(/<[^>]*>/g, '');
            if (plainText) {
                metaDescription.value = plainText.substring(0, 160);
            }
        }
    }
});

// Initialize CKEditor for page content
ClassicEditor
    .create(document.querySelector('#content'), {
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'underline', '|',
                'bulletedList', 'numberedList', '|',
                'outdent', 'indent', '|',
                'link', 'insertTable', '|',
                'blockQuote', 'insertImage', '|',
                'undo', 'redo'
            ]
        },
        language: 'en',
        table: {
            contentToolbar: [
                'tableColumn',
                'tableRow',
                'mergeTableCells'
            ]
        }
    })
    .then(editor => {
        window.pageContentEditor = editor;
        console.log('CKEditor initialized successfully');
    })
    .catch(error => {
        console.error('Error initializing CKEditor:', error);
    });
</script>

<?= $this->endSection() ?>
