<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div class="container">
        <h1 class="page-title">Search Results</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Search</li>
            </ol>
        </nav>
    </div>
</div>

<div class="main">
    <div class="container">
        <?php if (!empty($query)): ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="search-info mb-4">
                        <h2>Search Results for: "<?= esc($query) ?>"</h2>
                        <p class="text-muted">Found <?= $totalProducts ?> product(s) matching your search</p>
                    </div>
                </div>
            </div>

            <?php if (!empty($products)): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="products">
                            <div class="row">
                                <?php foreach ($products as $product): ?>
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="product product-7 text-center">
                                            <figure class="product-media">
                                                <a href="<?= base_url('product/' . $product['slug']) ?>">
                                                    <?php if (!empty($product['images'])): ?>
                                                        <img src="<?= base_url('public/uploads/products/' . $product['images'][0]['image_path']) ?>" 
                                                             alt="<?= esc($product['name']) ?>" 
                                                             class="product-image">
                                                    <?php else: ?>
                                                        <img src="<?= base_url('assets/images/demos/demo-15/products/product-1.jpg') ?>" 
                                                             alt="<?= esc($product['name']) ?>" 
                                                             class="product-image">
                                                    <?php endif; ?>
                                                </a>

                                                <div class="product-action-vertical">
                                                    <a href="<?= base_url('product/' . $product['slug']) ?>" 
                                                       class="btn-product-icon btn-cart" 
                                                       title="Add to cart">
                                                        <span>add to cart</span>
                                                    </a>
                                                </div>
                                            </figure>

                                            <div class="product-body">
                                                <div class="product-cat">
                                                    <a href="<?= base_url('category/' . $product['category_id']) ?>">Jackets</a>
                                                </div>
                                                <h3 class="product-title">
                                                    <a href="<?= base_url('product/' . $product['slug']) ?>"><?= esc($product['name']) ?></a>
                                                </h3>
                                                <div class="product-price">
                                                    <?= format_product_price($product['price'], $product['sale_price'] ?? null) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <?php if ($totalPages > 1): ?>
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <?php if ($currentPage > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?q=<?= urlencode($query) ?>&page=<?= $currentPage - 1 ?>">Previous</a>
                                        </li>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                            <a class="page-link" href="?q=<?= urlencode($query) ?>&page=<?= $i ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($currentPage < $totalPages): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?q=<?= urlencode($query) ?>&page=<?= $currentPage + 1 ?>">Next</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h3>No products found</h3>
                            <p class="text-muted">Sorry, we couldn't find any products matching "<?= esc($query) ?>"</p>
                            <a href="<?= base_url('shop') ?>" class="btn btn-primary">Browse All Products</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($categories)): ?>
                <div class="row mt-5">
                    <div class="col-lg-12">
                        <h3>Related Categories</h3>
                        <div class="row">
                            <?php foreach ($categories as $category): ?>
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <a href="<?= base_url('category/' . $category['slug']) ?>"><?= esc($category['name']) ?></a>
                                            </h5>
                                            <p class="card-text"><?= esc($category['description']) ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h3>Search Products</h3>
                        <p class="text-muted">Enter a search term to find products</p>
                        <form action="<?= base_url('search') ?>" method="get" class="search-form">
                            <div class="input-group mb-3">
                                <input type="search" class="form-control" name="q" placeholder="Search products..." required>
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.search-info h2 {
    color: #333;
    margin-bottom: 0.5rem;
}

.product-7 {
    margin-bottom: 2rem;
}

.product-7 .product-image {
    width: 100%;
    height: 250px;
    object-fit: cover;
    border-radius: 8px;
}

.product-7 .product-body {
    padding: 1rem 0;
}

.product-7 .product-title a {
    color: #333;
    text-decoration: none;
    font-weight: 600;
}

.product-7 .product-title a:hover {
    color: #007bff;
}

.search-form .input-group {
    max-width: 500px;
    margin: 0 auto;
}

.search-form .form-control {
    border-radius: 25px 0 0 25px;
    border: 2px solid #ddd;
    padding: 12px 20px;
}

.search-form .btn {
    border-radius: 0 25px 25px 0;
    padding: 12px 25px;
    border: 2px solid #007bff;
}
</style>

<?= $this->endSection() ?>
