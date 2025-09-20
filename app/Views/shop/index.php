<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="shop-page">
    <div class="container py-5">
        <div class="page-header text-center mb-5">
            <h1 class="page-title">Shop All Jackets</h1>
            <p class="page-subtitle">Discover our complete collection of premium jackets and outerwear</p>
        </div>
        
        <div class="row">
            <div class="col-lg-9">
                <?php if (!empty($products)): ?>
                <div class="row">
                    <?php foreach ($products as $product): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="product-card">
                            <div class="product-image mb-3">
                                <?php if (!empty($product['images'])): ?>
                                    <img src="<?= base_url('public/uploads/products/' . $product['images'][0]['image_path']) ?>" 
                                         alt="<?= $product['images'][0]['alt_text'] ?? $product['name'] ?>" class="img-fluid">
                                <?php else: ?>
                                    <div class="no-image-placeholder">
                                        <div class="placeholder-content">
                                            <i class="fas fa-image"></i>
                                            <span>No Image</span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="product-info text-center">
                                <h5><?= $product['name'] ?></h5>
                                <div class="price mb-3">
                                    <?= format_product_price($product['price'], $product['sale_price'] ?? null) ?>
                                </div>
                                <a href="<?= base_url('product/' . $product['slug']) ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="text-center py-5">
                    <h3>No products found</h3>
                    <p>No products match your current filters. Try adjusting your search criteria.</p>
                    <a href="<?= base_url('shop') ?>" class="btn btn-primary">View All Products</a>
                </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-3">
                <div class="sidebar">
                    <div class="widget widget-clean">
                        <label>Filters:</label>
                        <a href="<?= base_url('shop') ?>" class="sidebar-filter-clear">Clean All</a>
                    </div>

                    <div class="widget widget-collapsible">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
                                Categories
                            </a>
                        </h3>

                        <div class="collapse show" id="widget-1">
                            <div class="widget-body">
                                <div class="filter-items filter-items-count">
                                    <?php foreach ($categories as $cat): ?>
                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input category-filter" 
                                                   id="cat-<?= $cat['id'] ?>" 
                                                   value="<?= $cat['id'] ?>"
                                                   <?= ($filters['category'] == $cat['id']) ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="cat-<?= $cat['id'] ?>">
                                                <a href="<?= base_url('category/' . $cat['slug']) ?>"><?= $cat['name'] ?></a>
                                            </label>
                                        </div>
                                        <span class="item-count"><?= $cat['product_count'] ?></span>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="widget widget-collapsible">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-2" role="button" aria-expanded="true" aria-controls="widget-2">
                                Size
                            </a>
                        </h3>

                        <div class="collapse show" id="widget-2">
                            <div class="widget-body">
                                <div class="filter-items">
                                    <div class="filter-item">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input size-filter" 
                                                   id="size-none" 
                                                   name="size" value=""
                                                   <?= (!$filters['size']) ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="size-none">All Sizes</label>
                                        </div>
                                    </div>
                                    <?php 
                                    $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
                                    foreach ($sizes as $size): 
                                    ?>
                                    <div class="filter-item">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input size-filter" 
                                                   id="size-<?= strtolower($size) ?>" 
                                                   name="size" value="<?= $size ?>"
                                                   <?= ($filters['size'] == $size) ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="size-<?= strtolower($size) ?>"><?= $size ?></label>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="widget widget-collapsible">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-3" role="button" aria-expanded="true" aria-controls="widget-3">
                                Color
                            </a>
                        </h3>

                        <div class="collapse show" id="widget-3">
                            <div class="widget-body">
                                <div class="filter-colors">
                                    <a href="#" class="color-filter <?= (!$filters['color']) ? 'active' : '' ?>" 
                                       data-color=""
                                       style="background: #f8f9fa; border: 2px solid #dee2e6;"
                                       title="All Colors">
                                        <span class="sr-only">All Colors</span>
                                    </a>
                                    <?php 
                                    $colors = [
                                        'Brown' => '#b87145',
                                        'Yellow' => '#f0c04a', 
                                        'Black' => '#333333',
                                        'Red' => '#cc3333',
                                        'Blue' => '#3399cc',
                                        'Green' => '#669933',
                                        'Pink' => '#f27171',
                                        'Gray' => '#ebebeb'
                                    ];
                                    foreach ($colors as $colorName => $colorCode): 
                                    ?>
                                    <a href="#" class="color-filter <?= ($filters['color'] == $colorName) ? 'active' : '' ?>" 
                                       data-color="<?= $colorName ?>"
                                       style="background: <?= $colorCode ?>;"
                                       title="<?= $colorName ?>">
                                        <span class="sr-only"><?= $colorName ?></span>
                                    </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="widget widget-collapsible">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-4" role="button" aria-expanded="true" aria-controls="widget-4">
                                Price
                            </a>
                        </h3>

                        <div class="collapse show" id="widget-4">
                            <div class="widget-body">
                                <div class="filter-price">
                                    <form method="GET" action="<?= base_url('shop') ?>" id="price-filter-form">
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="number" name="price_min" class="form-control" 
                                                       placeholder="Min Price" value="<?= $filters['price_min'] ?? '' ?>">
                                            </div>
                                            <div class="col-6">
                                                <input type="number" name="price_max" class="form-control" 
                                                       placeholder="Max Price" value="<?= $filters['price_max'] ?? '' ?>">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm mt-2">Apply</button>
                                        <a href="<?= base_url('shop') ?>" class="btn btn-secondary btn-sm mt-2">Clear</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="widget widget-collapsible">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true" aria-controls="widget-5">
                                Sort By
                            </a>
                        </h3>

                        <div class="collapse show" id="widget-5">
                            <div class="widget-body">
                                <div class="filter-items">
                                    <div class="filter-item">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input sort-filter" 
                                                   id="sort-newest" name="sort" value="newest"
                                                   <?= ($filters['sort'] == 'newest' || !$filters['sort']) ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="sort-newest">Newest First</label>
                                        </div>
                                    </div>
                                    <div class="filter-item">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input sort-filter" 
                                                   id="sort-name-asc" name="sort" value="name_asc"
                                                   <?= ($filters['sort'] == 'name_asc') ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="sort-name-asc">Name A-Z</label>
                                        </div>
                                    </div>
                                    <div class="filter-item">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input sort-filter" 
                                                   id="sort-name-desc" name="sort" value="name_desc"
                                                   <?= ($filters['sort'] == 'name_desc') ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="sort-name-desc">Name Z-A</label>
                                        </div>
                                    </div>
                                    <div class="filter-item">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input sort-filter" 
                                                   id="sort-price-asc" name="sort" value="price_asc"
                                                   <?= ($filters['sort'] == 'price_asc') ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="sort-price-asc">Price Low to High</label>
                                        </div>
                                    </div>
                                    <div class="filter-item">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input sort-filter" 
                                                   id="sort-price-desc" name="sort" value="price_desc"
                                                   <?= ($filters['sort'] == 'price_desc') ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="sort-price-desc">Price High to Low</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.page-title {
    font-size: 2.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #333;
}

.page-subtitle {
    font-size: 1.1rem;
    color: #6c757d;
}

.product-card {
    background: white;
    padding: 1.5rem;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
    height: 100%;
}

.product-card:hover {
    transform: translateY(-5px);
}

.product-image img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    border-radius: 10px;
}

.product-info h5 {
    color: #333;
    margin-bottom: 1rem;
    min-height: 3rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.price {
    font-size: 1.1rem;
}

.price .text-decoration-line-through {
    margin-right: 0.5rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle category filter checkboxes
    const categoryCheckboxes = document.querySelectorAll('.category-filter');
    
    categoryCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                // Uncheck all other category checkboxes
                categoryCheckboxes.forEach(function(otherCheckbox) {
                    if (otherCheckbox !== checkbox) {
                        otherCheckbox.checked = false;
                    }
                });
                
                // Navigate to the selected category
                const categoryLink = this.nextElementSibling.querySelector('a').href;
                window.location.href = categoryLink;
            }
        });
    });
    
    // Handle size filter radio buttons
    const sizeRadios = document.querySelectorAll('.size-filter');
    sizeRadios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            applyFilters();
        });
    });
    
    // Handle color filter clicks
    const colorFilters = document.querySelectorAll('.color-filter');
    colorFilters.forEach(function(colorFilter) {
        colorFilter.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all color filters
            colorFilters.forEach(function(cf) {
                cf.classList.remove('active');
            });
            
            // Add active class to clicked filter
            this.classList.add('active');
            
            applyFilters();
        });
    });
    
    // Handle sort filter radio buttons
    const sortFilters = document.querySelectorAll('.sort-filter');
    sortFilters.forEach(function(radio) {
        radio.addEventListener('change', function() {
            applyFilters();
        });
    });
    
    // Handle price filter form
    const priceForm = document.getElementById('price-filter-form');
    if (priceForm) {
        priceForm.addEventListener('submit', function(e) {
            e.preventDefault();
            applyFilters();
        });
    }
    
    // Function to apply all filters
    function applyFilters() {
        const params = new URLSearchParams();
        
        // Add price filters
        const priceMin = document.querySelector('input[name="price_min"]').value;
        const priceMax = document.querySelector('input[name="price_max"]').value;
        
        if (priceMin) {
            params.append('price_min', priceMin);
        }
        if (priceMax) {
            params.append('price_max', priceMax);
        }
        
        // Add size filter
        const selectedSize = document.querySelector('input[name="size"]:checked');
        if (selectedSize) {
            params.append('size', selectedSize.value);
        }
        
        // Add color filter
        const selectedColor = document.querySelector('.color-filter.active');
        if (selectedColor) {
            params.append('color', selectedColor.dataset.color);
        }
        
        // Add sort filter
        const selectedSort = document.querySelector('.sort-filter:checked');
        if (selectedSort) {
            params.append('sort', selectedSort.value);
        }
        
        // Navigate with filter parameters
        const currentUrl = '<?= base_url('shop') ?>';
        const newUrl = params.toString() ? currentUrl + '?' + params.toString() : currentUrl;
        window.location.href = newUrl;
    }
});
</script>

<?= $this->endSection() ?>
