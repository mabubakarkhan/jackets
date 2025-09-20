<?= $this->extend('admin/layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Page</h1>
    <div>
        <button type="submit" form="pageEditForm" class="btn btn-primary me-2">
            <i class="fas fa-save"></i> Update Page
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

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<form id="pageEditForm" action="<?= base_url('admin/pages/update/' . $page['id']) ?>" method="post">
    <?= csrf_field() ?>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Page Title *</label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?= old('title', $page['title']) ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" 
                               value="<?= old('slug', $page['slug']) ?>" placeholder="auto-generated">
                        <small class="form-text text-muted">Leave empty to auto-generate from title</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="content" class="form-label">Page Content *</label>
                        <textarea class="form-control" id="content" name="content" rows="12" required><?= old('content', $page['content']) ?></textarea>
                        <small class="form-text text-muted">Use the rich text editor to format your content</small>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="page_type" class="form-label">Page Type</label>
                                <select class="form-select" id="page_type" name="page_type">
                                    <option value="static" <?= old('page_type', $page['page_type']) == 'static' ? 'selected' : '' ?>>Static Page</option>
                                    <option value="blog" <?= old('page_type', $page['page_type']) == 'blog' ? 'selected' : '' ?>>Blog Post</option>
                                    <option value="faq" <?= old('page_type', $page['page_type']) == 'faq' ? 'selected' : '' ?>>FAQ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="published" <?= old('status', $page['status']) == 'published' ? 'selected' : '' ?>>Published</option>
                                    <option value="draft" <?= old('status', $page['status']) == 'draft' ? 'selected' : '' ?>>Draft</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" class="form-control" id="sort_order" name="sort_order" 
                               value="<?= old('sort_order', $page['sort_order']) ?>" min="0">
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
                    <input type="text" class="form-control" id="meta_title" name="meta_title" 
                           value="<?= old('meta_title', $page['meta_title']) ?>">
                    <small class="form-text text-muted">Leave empty to use page title</small>
                </div>
                
                <div class="mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea class="form-control" id="meta_description" name="meta_description" rows="3"><?= old('meta_description', $page['meta_description']) ?></textarea>
                    <small class="form-text text-muted">Leave empty to use page content</small>
                </div>
                
                <div class="mb-3">
                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" 
                           value="<?= old('meta_keywords', $page['meta_keywords']) ?>" placeholder="jacket, store, fashion">
                </div>
                
                <div class="mb-3">
                    <label for="canonical_url" class="form-label">Canonical URL</label>
                    <input type="url" class="form-control" id="canonical_url" name="canonical_url" 
                           value="<?= old('canonical_url', $page['canonical_url'] ?? '') ?>" placeholder="https://example.com/page-slug">
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
                        <input class="form-check-input" type="checkbox" id="is_static" name="is_static" value="1" 
                               <?= old('page_type', $page['page_type']) === 'static' ? 'checked' : '' ?> disabled>
                        <label class="form-check-label" for="is_static">
                            Static Page
                        </label>
                        <small class="form-text text-muted d-block">Static pages cannot be deleted (determined by page type)</small>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="show_in_menu" name="show_in_menu" value="1" 
                               <?= old('show_in_menu', $page['show_in_menu'] ?? 1) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="show_in_menu">
                            Show in Navigation Menu
                        </label>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="show_in_footer" name="show_in_footer" value="1" 
                               <?= old('show_in_footer', $page['show_in_footer'] ?? 0) ? 'checked' : '' ?>>
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
                        <option value="default" <?= old('template', $page['template'] ?? 'default') === 'default' ? 'selected' : '' ?>>Default Template</option>
                        <option value="fullwidth" <?= old('template', $page['template'] ?? 'default') === 'fullwidth' ? 'selected' : '' ?>>Full Width</option>
                        <option value="sidebar" <?= old('template', $page['template'] ?? 'default') === 'sidebar' ? 'selected' : '' ?>>With Sidebar</option>
                        <option value="landing" <?= old('template', $page['template'] ?? 'default') === 'landing' ? 'selected' : '' ?>>Landing Page</option>
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

// Auto-fill meta description from content
document.getElementById('content').addEventListener('input', function() {
    const metaDescriptionField = document.getElementById('meta_description');
    
    // Auto-generate meta description (only if empty)
    if (!metaDescriptionField.value) {
        if (window.pageContentEditor) {
            const content = window.pageContentEditor.getData();
            const plainText = content.replace(/<[^>]*>/g, '');
            if (plainText) {
                metaDescriptionField.value = plainText.substring(0, 160);
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
