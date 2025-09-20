<?= $this->extend('admin/layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add New Product</h1>
    <a href="<?= base_url('admin/products') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Products
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

<?php if (isset($validation) && $validation->hasErrors()): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h6>Please fix the following errors:</h6>
        <ul class="mb-0">
            <?php foreach ($validation->getErrors() as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('admin/products/store') ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <!-- Basic Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Basic Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Product Name *</label>
                                <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('name')) ? 'is-invalid' : '' ?>" 
                                       id="name" name="name" value="<?= old('name') ?>" required>
                                <?php if (isset($validation) && $validation->hasError('name')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('name') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-3">
                                <label for="slug" class="form-label">URL Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug" value="<?= old('slug') ?>" placeholder="auto-generated">
                                <small class="form-text text-muted">Leave empty to auto-generate from product name</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="8"></textarea>
                                <small class="form-text text-muted">Use the rich text editor above to format your content</small>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price *</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control <?= (isset($validation) && $validation->hasError('price')) ? 'is-invalid' : '' ?>" 
                                                   id="price" name="price" step="0.01" min="0" value="<?= old('price') ?>" required>
                                        </div>
                                        <?php if (isset($validation) && $validation->hasError('price')): ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $validation->getError('price') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sale_price" class="form-label">Sale Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" id="sale_price" name="sale_price" step="0.01" min="0" value="<?= old('sale_price') ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="stock_quantity" class="form-label">Stock Quantity</label>
                                        <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" min="0" value="<?= old('stock_quantity', 0) ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sku" class="form-label">SKU</label>
                                        <input type="text" class="form-control" id="sku" name="sku" placeholder="Stock Keeping Unit" value="<?= old('sku') ?>">
                                    </div>
                                </div>
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
                                <input type="text" class="form-control" id="meta_title" name="meta_title" value="<?= old('meta_title') ?>">
                                <small class="form-text text-muted">Leave empty to use product name</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control" id="meta_description" name="meta_description" rows="3"><?= old('meta_description') ?></textarea>
                                <small class="form-text text-muted">Leave empty to use product description</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" placeholder="jacket, winter, leather" value="<?= old('meta_keywords') ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="canonical_url" class="form-label">Canonical URL</label>
                                <input type="url" class="form-control" id="canonical_url" name="canonical_url" placeholder="https://example.com/product-slug" value="<?= old('canonical_url') ?>">
                                <small class="form-text text-muted">Leave empty to auto-generate from product URL</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <!-- Category & Status -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Category & Status</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category *</label>
                                <select class="form-select <?= (isset($validation) && $validation->hasError('category_id')) ? 'is-invalid' : '' ?>" 
                                        id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    <?php if (!empty($categories)): ?>
                                        <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>" <?= (old('category_id') == $category['id']) ? 'selected' : '' ?>>
                                            <?= $category['name'] ?>
                                        </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <?php if (isset($validation) && $validation->hasError('category_id')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('category_id') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="active" <?= (old('status', 'active') == 'active') ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= (old('status') == 'inactive') ? 'selected' : '' ?>>Inactive</option>
                                    <option value="draft" <?= (old('status') == 'draft') ? 'selected' : '' ?>>Draft</option>
                                </select>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" <?= (old('featured') == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="featured">
                                            Featured Product
                                        </label>
                                        <div class="form-text">Show this product in the featured section on homepage</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="hot_selling" name="hot_selling" value="1" <?= (old('hot_selling') == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="hot_selling">
                                            Hot Selling
                                        </label>
                                        <div class="form-text">Show this product in the hot selling section on homepage</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sizes & Colors -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Sizes & Colors</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Available Sizes</label>
                                <div class="row">
                                    <?php if (!empty($sizes)): ?>
                                        <?php foreach ($sizes as $size): ?>
                                        <div class="col-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="size_<?= $size['id'] ?>" 
                                                       name="sizes[]" value="<?= $size['id'] ?>">
                                                <label class="form-check-label" for="size_<?= $size['id'] ?>">
                                                    <?= $size['name'] ?>
                                                </label>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <small class="form-text text-muted">Select sizes available for this product</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Available Colors</label>
                                <div class="row">
                                    <?php if (!empty($colors)): ?>
                                        <?php foreach ($colors as $color): ?>
                                        <div class="col-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="color_<?= $color['id'] ?>" 
                                                       name="colors[]" value="<?= $color['id'] ?>">
                                                <label class="form-check-label d-flex align-items-center" for="color_<?= $color['id'] ?>">
                                                    <?php if ($color['hex_code']): ?>
                                                        <span class="color-preview me-2" style="width: 20px; height: 20px; background-color: <?= $color['hex_code'] ?>; border: 1px solid #ccc; border-radius: 3px;"></span>
                                                    <?php endif; ?>
                                                    <?= $color['name'] ?>
                                                </label>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <small class="form-text text-muted">Select colors available for this product</small>
                            </div>
                            
                            <!-- Variant Pricing -->
                            <div class="mb-3">
                                <label class="form-label">Variant Preview</label>
                                <div class="alert alert-info">
                                    <small>
                                        <i class="fas fa-info-circle"></i>
                                        Preview of variants that will be created. All variants will inherit the main product's price, sale price, and stock quantity.
                                    </small>
                                </div>
                                
                                <!-- Dynamic Variant Table -->
                                <div id="variant-table-container">
                                    <div class="table-responsive">
                                        <table class="table table-sm" id="variant-table">
                                            <thead>
                                                <tr>
                                                    <th>Size</th>
                                                    <th>Color</th>
                                                    <th>Price</th>
                                                    <th>Sale Price</th>
                                                    <th>Stock</th>
                                                </tr>
                                            </thead>
                                            <tbody id="variant-tbody">
                                                <tr><td colspan="5" class="text-center text-muted">Select sizes and/or colors to see variants</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product Images -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Product Images</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="main_image" class="form-label">Main Image</label>
                                <input type="file" class="form-control" id="main_image" name="main_image" accept="image/*">
                            </div>
                            
                            <div class="mb-3">
                                <label for="additional_images" class="form-label">Additional Images</label>
                                <input type="file" class="form-control" id="additional_images" name="additional_images[]" accept="image/*" multiple>
                                <small class="form-text text-muted">You can select multiple images</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Save Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Create Product
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- CKEditor Rich Text Editor -->
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
// Initialize CKEditor
ClassicEditor
    .create(document.querySelector('#description'), {
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'underline', '|',
                'bulletedList', 'numberedList', '|',
                'outdent', 'indent', '|',
                'link', 'insertTable', '|',
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
        window.descriptionEditor = editor;
    })
    .catch(error => {
        console.error('Error initializing CKEditor:', error);
    });

// Auto-generate SKU, slug, and meta title
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const skuField = document.getElementById('sku');
    const slugField = document.getElementById('slug');
    const metaTitleField = document.getElementById('meta_title');
    
    // Auto-generate SKU (only if empty)
    if (!skuField.value) {
        const cleanName = name.replace(/[^a-zA-Z0-9]/g, '').toUpperCase();
        if (cleanName.length > 0) {
            skuField.value = cleanName.substring(0, 8) + '-' + Date.now().toString().slice(-4);
        }
    }
    
    // Auto-generate slug (always update if name changes)
    const slug = name
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
        metaTitleField.value = name;
    }
});

// Auto-fill meta fields if empty
document.getElementById('name').addEventListener('blur', function() {
    const metaTitle = document.getElementById('meta_title');
    const metaDescription = document.getElementById('meta_description');
    
    if (!metaTitle.value) {
        metaTitle.value = this.value;
    }
    
    if (!metaDescription.value) {
        if (window.descriptionEditor) {
            const description = window.descriptionEditor.getData();
            // Strip HTML tags and get plain text
            const plainText = description.replace(/<[^>]*>/g, '');
            if (plainText) {
                metaDescription.value = plainText.substring(0, 160);
            }
        }
    }
});

// Dynamic variant table functionality for create form
document.addEventListener('DOMContentLoaded', function() {
    const sizeCheckboxes = document.querySelectorAll('input[name="sizes[]"]');
    const colorCheckboxes = document.querySelectorAll('input[name="colors[]"]');
    const variantTbody = document.getElementById('variant-tbody');
    const priceInput = document.getElementById('price');
    const salePriceInput = document.getElementById('sale_price');
    const stockInput = document.getElementById('stock_quantity');
    
    // Function to update variant table
    function updateVariantTable() {
        const selectedSizes = Array.from(sizeCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => ({ id: cb.value, name: cb.nextElementSibling.textContent.trim() }));
        
        const selectedColors = Array.from(colorCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => ({ 
                id: cb.value, 
                name: cb.nextElementSibling.textContent.trim(),
                hexCode: cb.nextElementSibling.querySelector('.color-preview')?.style.backgroundColor || ''
            }));
        
        // Clear existing rows
        variantTbody.innerHTML = '';
        
        // If no sizes or colors selected, show message
        if (selectedSizes.length === 0 && selectedColors.length === 0) {
            variantTbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">Select sizes and/or colors to see variants</td></tr>';
            return;
        }
        
        // Generate variants
        const variants = [];
        
        if (selectedSizes.length === 0) {
            // Only colors selected
            selectedColors.forEach(color => {
                variants.push({ sizeId: null, sizeName: 'N/A', colorId: color.id, colorName: color.name, hexCode: color.hexCode });
            });
        } else if (selectedColors.length === 0) {
            // Only sizes selected
            selectedSizes.forEach(size => {
                variants.push({ sizeId: size.id, sizeName: size.name, colorId: null, colorName: 'N/A', hexCode: '' });
            });
        } else {
            // Both sizes and colors selected
            selectedSizes.forEach(size => {
                selectedColors.forEach(color => {
                    variants.push({ sizeId: size.id, sizeName: size.name, colorId: color.id, colorName: color.name, hexCode: color.hexCode });
                });
            });
        }
        
        // Create table rows
        variants.forEach((variant, index) => {
            const currentPrice = priceInput ? priceInput.value || '0.00' : '0.00';
            const currentSalePrice = salePriceInput ? salePriceInput.value || '0.00' : '0.00';
            const currentStock = stockInput ? stockInput.value || '0' : '0';
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${variant.sizeName}</td>
                <td>
                    ${variant.hexCode ? `<span class="color-preview me-1" style="width: 15px; height: 15px; background-color: ${variant.hexCode}; border: 1px solid #ccc; border-radius: 2px; display: inline-block;"></span>` : ''}
                    ${variant.colorName}
                </td>
                <td>
                    <span class="text-muted">${currentPrice}</span>
                    <small class="d-block text-muted">(from main price)</small>
                </td>
                <td>
                    <span class="text-muted">${currentSalePrice}</span>
                    <small class="d-block text-muted">(from main sale price)</small>
                </td>
                <td>
                    <span class="text-muted">${currentStock}</span>
                    <small class="d-block text-muted">(from main stock)</small>
                </td>
            `;
            variantTbody.appendChild(row);
        });
    }
    
    // Add event listeners to checkboxes
    sizeCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateVariantTable);
    });
    
    colorCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateVariantTable);
    });
    
    // Update when main product fields change
    if (priceInput) {
        priceInput.addEventListener('input', updateVariantTable);
    }
    if (salePriceInput) {
        salePriceInput.addEventListener('input', updateVariantTable);
    }
    if (stockInput) {
        stockInput.addEventListener('input', updateVariantTable);
    }
    
    // Initial load
    updateVariantTable();
});
</script>

<?= $this->endSection() ?>
