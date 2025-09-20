<?= $this->extend('admin/layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Product</h1>
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
        <form action="<?= base_url('admin/products/update/' . $product['id']) ?>" method="post" enctype="multipart/form-data">
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
                                       id="name" name="name" value="<?= old('name', $product['name']) ?>" required>
                                <?php if (isset($validation) && $validation->hasError('name')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('name') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-3">
                                <label for="slug" class="form-label">URL Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug" value="<?= old('slug', $product['slug']) ?>" placeholder="auto-generated">
                                <small class="form-text text-muted">Leave empty to auto-generate from product name</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="8"><?= old('description', $product['description']) ?></textarea>
                                <small class="form-text text-muted">Use the rich text editor above to format your content</small>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price *</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control <?= (isset($validation) && $validation->hasError('price')) ? 'is-invalid' : '' ?>" 
                                                   id="price" name="price" step="0.01" min="0" value="<?= old('price', $product['price']) ?>" required>
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
                                            <input type="number" class="form-control" id="sale_price" name="sale_price" step="0.01" min="0" value="<?= old('sale_price', $product['sale_price']) ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="stock_quantity" class="form-label">Stock Quantity</label>
                                        <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" min="0" value="<?= old('stock_quantity', $product['stock_quantity']) ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sku" class="form-label">SKU</label>
                                        <input type="text" class="form-control" id="sku" name="sku" placeholder="Stock Keeping Unit" value="<?= old('sku', $product['sku']) ?>">
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
                                <input type="text" class="form-control" id="meta_title" name="meta_title" value="<?= old('meta_title', $product['meta_title']) ?>">
                                <small class="form-text text-muted">Leave empty to use product name</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control" id="meta_description" name="meta_description" rows="3"><?= old('meta_description', $product['meta_description']) ?></textarea>
                                <small class="form-text text-muted">Leave empty to use product description</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" placeholder="jacket, winter, leather" value="<?= old('meta_keywords', $product['meta_keywords']) ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="canonical_url" class="form-label">Canonical URL</label>
                                <input type="url" class="form-control" id="canonical_url" name="canonical_url" placeholder="https://example.com/product-slug" value="<?= old('canonical_url', $product['canonical_url'] ?? '') ?>">
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
                                        <option value="<?= $category['id'] ?>" <?= (old('category_id', $product['category_id']) == $category['id']) ? 'selected' : '' ?>>
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
                                    <option value="active" <?= (old('status', $product['status']) == 'active') ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= (old('status', $product['status']) == 'inactive') ? 'selected' : '' ?>>Inactive</option>
                                    <option value="draft" <?= (old('status', $product['status']) == 'draft') ? 'selected' : '' ?>>Draft</option>
                                </select>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" <?= (old('featured', $product['featured']) == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="featured">
                                            Featured Product
                                        </label>
                                        <div class="form-text">Show this product in the featured section on homepage</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="hot_selling" name="hot_selling" value="1" <?= (old('hot_selling', $product['hot_selling']) == 1) ? 'checked' : '' ?>>
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
                                                       name="sizes[]" value="<?= $size['id'] ?>"
                                                       <?= (in_array($size['id'], array_column($existing_variants ?? [], 'size_id'))) ? 'checked' : '' ?>>
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
                                                       name="colors[]" value="<?= $color['id'] ?>"
                                                       <?= (in_array($color['id'], array_column($existing_variants ?? [], 'color_id'))) ? 'checked' : '' ?>>
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
                                <label class="form-label">Variant Pricing</label>
                                <div class="alert alert-info">
                                    <small>
                                        <i class="fas fa-info-circle"></i>
                                        New variants will inherit: Price ($<span id="main-price"><?= number_format($product['price'], 2) ?></span>), 
                                        Sale Price ($<span id="main-sale-price"><?= number_format($product['sale_price'] ?: 0, 2) ?></span>), 
                                        Stock (<span id="main-stock"><?= $product['stock_quantity'] ?: 0 ?></span>).
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
                                                <!-- Variants will be populated dynamically -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <!-- Hidden inputs to store existing variant data -->
                                <div id="existing-variants-data" style="display: none;">
                                    <?php if (!empty($existing_variants)): ?>
                                        <?php foreach ($existing_variants as $variant): ?>
                                        <div class="existing-variant" 
                                             data-variant-id="<?= $variant['id'] ?>"
                                             data-size-id="<?= $variant['size_id'] ?>"
                                             data-color-id="<?= $variant['color_id'] ?>"
                                             data-size-name="<?= $variant['size_name'] ?? 'N/A' ?>"
                                             data-color-name="<?= $variant['color_name'] ?? 'N/A' ?>"
                                             data-hex-code="<?= $variant['hex_code'] ?? '' ?>"
                                             data-price="<?= $variant['price'] ?>"
                                             data-sale-price="<?= $variant['sale_price'] ?>"
                                             data-stock="<?= $variant['stock_quantity'] ?>">
                                        </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Images -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Product Images</h5>
                        </div>
                        <div class="card-body">
                            <!-- Existing Images -->
                            <?php if (!empty($existing_images)): ?>
                                <div class="mb-4">
                                    <!-- Primary Image -->
                                    <?php 
                                    $primaryImage = null;
                                    $additionalImages = [];
                                    foreach ($existing_images as $image) {
                                        if ($image['is_primary'] == 1) {
                                            $primaryImage = $image;
                                        } else {
                                            $additionalImages[] = $image;
                                        }
                                    }
                                    ?>
                                    
                                    <?php if ($primaryImage): ?>
                                        <div class="mb-3">
                                            <h6>Main Image:</h6>
                                            <div class="d-flex justify-content-center">
                                                <div class="position-relative" style="width: 120px; height: 120px;">
                                                    <img src="<?= base_url('public/uploads/products/' . $primaryImage['image_path']) ?>" 
                                                         class="img-thumbnail" 
                                                         alt="<?= esc($primaryImage['alt_text']) ?>"
                                                         style="width: 120px; height: 120px; object-fit: cover; cursor: pointer;"
                                                         onclick="openImageModal('<?= base_url('public/uploads/products/' . $primaryImage['image_path']) ?>', <?= $primaryImage['id'] ?>)">
                                                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" 
                                                            style="transform: translate(25%, -25%); width: 25px; height: 25px; padding: 0; border-radius: 50%;"
                                                            onclick="deleteImage(<?= $primaryImage['id'] ?>, this)">
                                                        <i class="fas fa-times" style="font-size: 10px;"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Additional Images -->
                                    <?php if (!empty($additionalImages)): ?>
                                        <div class="mb-3">
                                            <h6>Additional Images:</h6>
                                            <div class="d-flex flex-wrap gap-2">
                                                <?php foreach ($additionalImages as $image): ?>
                                                    <div class="position-relative" style="width: 80px; height: 80px;">
                                                        <img src="<?= base_url('public/uploads/products/' . $image['image_path']) ?>" 
                                                             class="img-thumbnail" 
                                                             alt="<?= esc($image['alt_text']) ?>"
                                                             style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                                                             onclick="openImageModal('<?= base_url('public/uploads/products/' . $image['image_path']) ?>', <?= $image['id'] ?>)">
                                                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" 
                                                                style="transform: translate(25%, -25%); width: 20px; height: 20px; padding: 0; border-radius: 50%;"
                                                                onclick="deleteImage(<?= $image['id'] ?>, this)">
                                                            <i class="fas fa-times" style="font-size: 8px;"></i>
                                                        </button>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Upload New Images -->
                            <div class="mb-3">
                                <label for="main_image" class="form-label">Upload New Main Image</label>
                                <input type="file" class="form-control" id="main_image" name="main_image" accept="image/*">
                                <small class="form-text text-muted">Leave empty to keep current main image</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="additional_images" class="form-label">Upload Additional Images</label>
                                <input type="file" class="form-control" id="additional_images" name="additional_images[]" accept="image/*" multiple>
                                <small class="form-text text-muted">You can select multiple images</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Product
                </button>
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

// Open image in modal
function openImageModal(imageSrc, imageId) {
    // Create modal HTML
    const modalHtml = `
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Product Image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="${imageSrc}" class="img-fluid" alt="Product Image" style="max-height: 70vh;">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" onclick="deleteImageFromModal(${imageId})">
                            <i class="fas fa-trash"></i> Delete Image
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('imageModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
    
    // Remove modal from DOM when hidden
    document.getElementById('imageModal').addEventListener('hidden.bs.modal', function () {
        this.remove();
    });
}

// Delete image function
function deleteImage(imageId, buttonElement) {
    if (confirm('Are you sure you want to delete this image?')) {
        deleteImageRequest(imageId);
    }
}

// Delete image from modal
function deleteImageFromModal(imageId) {
    if (confirm('Are you sure you want to delete this image?')) {
        // Close modal first
        const modal = bootstrap.Modal.getInstance(document.getElementById('imageModal'));
        modal.hide();
        
        // Delete image
        deleteImageRequest(imageId);
    }
}

// Common delete image request function
function deleteImageRequest(imageId) {
    // Create a form to submit the delete request
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= base_url('admin/products/delete-image') ?>';
    
    // Add CSRF token if available
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = 'csrf_token';
        csrfInput.value = csrfToken.getAttribute('content');
        form.appendChild(csrfInput);
    }
    
    // Add image ID
    const imageIdInput = document.createElement('input');
    imageIdInput.type = 'hidden';
    imageIdInput.name = 'image_id';
    imageIdInput.value = imageId;
    form.appendChild(imageIdInput);
    
    // Add product ID
    const productIdInput = document.createElement('input');
    productIdInput.type = 'hidden';
    productIdInput.name = 'product_id';
    productIdInput.value = '<?= $product['id'] ?>';
    form.appendChild(productIdInput);
    
    document.body.appendChild(form);
    form.submit();
}

// Dynamic variant table functionality
document.addEventListener('DOMContentLoaded', function() {
    const sizeCheckboxes = document.querySelectorAll('input[name="sizes[]"]');
    const colorCheckboxes = document.querySelectorAll('input[name="colors[]"]');
    const variantTbody = document.getElementById('variant-tbody');
    const mainPrice = document.getElementById('main-price');
    const mainSalePrice = document.getElementById('main-sale-price');
    const mainStock = document.getElementById('main-stock');
    
    // Get main product values from form inputs
    const priceInput = document.getElementById('price');
    const salePriceInput = document.getElementById('sale_price');
    const stockInput = document.getElementById('stock_quantity');
    
    // Store existing variant data
    const existingVariants = [];
    document.querySelectorAll('.existing-variant').forEach(variant => {
        existingVariants.push({
            id: variant.dataset.variantId,
            sizeId: variant.dataset.sizeId,
            colorId: variant.dataset.colorId,
            sizeName: variant.dataset.sizeName,
            colorName: variant.dataset.colorName,
            hexCode: variant.dataset.hexCode,
            price: variant.dataset.price,
            salePrice: variant.dataset.salePrice,
            stock: variant.dataset.stock
        });
    });
    
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
            // Check if this variant exists in existing data
            const existingVariant = existingVariants.find(ev => 
                ev.sizeId == variant.sizeId && ev.colorId == variant.colorId
            );
            
            // Get current main product values
            const currentMainPrice = priceInput ? priceInput.value : mainPrice.textContent;
            const currentMainSalePrice = salePriceInput ? salePriceInput.value : mainSalePrice.textContent;
            const currentMainStock = stockInput ? stockInput.value : mainStock.textContent;
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${variant.sizeName}</td>
                <td>
                    ${variant.hexCode ? `<span class="color-preview me-1" style="width: 15px; height: 15px; background-color: ${variant.hexCode}; border: 1px solid #ccc; border-radius: 2px; display: inline-block;"></span>` : ''}
                    ${variant.colorName}
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm variant-price" 
                           name="variant_price[${existingVariant ? existingVariant.id : 'new_' + index}]" 
                           value="${existingVariant ? existingVariant.price : currentMainPrice}" 
                           step="0.01" min="0" placeholder="${currentMainPrice}">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm variant-sale-price" 
                           name="variant_sale_price[${existingVariant ? existingVariant.id : 'new_' + index}]" 
                           value="${existingVariant ? existingVariant.salePrice : currentMainSalePrice}" 
                           step="0.01" min="0" placeholder="${currentMainSalePrice}">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm variant-stock" 
                           name="variant_stock[${existingVariant ? existingVariant.id : 'new_' + index}]" 
                           value="${existingVariant ? existingVariant.stock : currentMainStock}" 
                           min="0" placeholder="${currentMainStock}">
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
    
    // Add event listeners to main product fields
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
