<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Dashboard' ?> - Jacket Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .sidebar {
            min-height: 100vh;
            background: #343a40;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            padding: 0.75rem 1rem;
            border-radius: 0.25rem;
            margin: 0.25rem 0;
        }
        .sidebar .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.1);
        }
        .sidebar .nav-link.active {
            color: #fff;
            background: #007bff;
        }
        .sidebar .nav-link i {
            margin-right: 0.5rem;
            width: 20px;
        }
        main {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .content-wrapper {
            padding: 2rem;
        }
        .navbar-brand {
            font-weight: bold;
            color: #fff !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">Jacket Store</h4>
                        <small class="text-muted">Admin Panel</small>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?= current_url() == base_url('admin/dashboard') ? 'active' : '' ?>" href="<?= base_url('admin/dashboard') ?>">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= current_url() == base_url('admin/products') ? 'active' : '' ?>" href="<?= base_url('admin/products') ?>">
                                <i class="fas fa-box"></i> Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= current_url() == base_url('admin/categories') ? 'active' : '' ?>" href="<?= base_url('admin/categories') ?>">
                                <i class="fas fa-tags"></i> Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= current_url() == base_url('admin/orders') ? 'active' : '' ?>" href="<?= base_url('admin/orders') ?>">
                                <i class="fas fa-shopping-cart"></i> Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(current_url(), base_url('admin/customers')) !== false ? 'active' : '' ?>" href="<?= base_url('admin/customers') ?>">
                                <i class="fas fa-users"></i> Customers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= current_url() == base_url('admin/coupons') ? 'active' : '' ?>" href="<?= base_url('admin/coupons') ?>">
                                <i class="fas fa-ticket-alt"></i> Coupons
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= current_url() == base_url('admin/pages') ? 'active' : '' ?>" href="<?= base_url('admin/pages') ?>">
                                <i class="fas fa-file-alt"></i> Pages
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= current_url() == base_url('admin/homepage') ? 'active' : '' ?>" href="<?= base_url('admin/homepage') ?>">
                                <i class="fas fa-home"></i> Homepage
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= current_url() == base_url('admin/sliders') ? 'active' : '' ?>" href="<?= base_url('admin/sliders') ?>">
                                <i class="fas fa-images"></i> Sliders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= current_url() == base_url('admin/settings') ? 'active' : '' ?>" href="<?= base_url('admin/settings') ?>">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                        </li>
                        <li class="nav-item mt-4">
                            <a class="nav-link text-danger" href="<?= base_url('admin/logout') ?>">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="content-wrapper">
                    <?= $this->renderSection('content') ?>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
</body>
</html>
