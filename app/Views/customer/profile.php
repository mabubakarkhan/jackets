<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>
<div class="page-header text-center" style="background-image: url('<?= base_url('html/assets/images/page-header-bg.jpg') ?>')">
    <div class="container">
        <h1 class="page-title">My Profile<span>Manage Your Account</span></h1>
    </div><!-- End .container -->
</div><!-- End .page-header -->

<nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('customer/dashboard') ?>">My Account</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Profile</li>
        </ol>
    </div><!-- End .container -->
</nav><!-- End .breadcrumb-nav -->

<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="profile-section">
                    <div class="profile-header mb-4">
                        <h3>Profile Information</h3>
                        <p class="text-muted">Update your personal information and account details.</p>
                    </div>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('validation')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('validation')->getErrors() as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('customer/profile') ?>" method="post" class="profile-form">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Full Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="<?= esc($customer['name']) ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email Address *</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?= esc($customer['email']) ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone Number *</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                           value="<?= esc($customer['phone']) ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country">Country *</label>
                                    <select class="form-control" id="country" name="country" required>
                                        <option value="">Select Country</option>
                                        <option value="US" <?= $customer['country'] == 'US' ? 'selected' : '' ?>>United States</option>
                                        <option value="CA" <?= $customer['country'] == 'CA' ? 'selected' : '' ?>>Canada</option>
                                        <option value="UK" <?= $customer['country'] == 'UK' ? 'selected' : '' ?>>United Kingdom</option>
                                        <option value="AU" <?= $customer['country'] == 'AU' ? 'selected' : '' ?>>Australia</option>
                                        <option value="DE" <?= $customer['country'] == 'DE' ? 'selected' : '' ?>>Germany</option>
                                        <option value="FR" <?= $customer['country'] == 'FR' ? 'selected' : '' ?>>France</option>
                                        <option value="IT" <?= $customer['country'] == 'IT' ? 'selected' : '' ?>>Italy</option>
                                        <option value="ES" <?= $customer['country'] == 'ES' ? 'selected' : '' ?>>Spain</option>
                                        <option value="Other" <?= $customer['country'] == 'Other' ? 'selected' : '' ?>>Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">Address *</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required><?= esc($customer['address']) ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city">City *</label>
                                    <input type="text" class="form-control" id="city" name="city" 
                                           value="<?= esc($customer['city']) ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Account Status</label>
                                    <input type="text" class="form-control" value="<?= ucfirst($customer['status']) ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="created_at">Member Since</label>
                            <input type="text" class="form-control" value="<?= date('F j, Y', strtotime($customer['created_at'])) ?>" readonly>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Profile
                            </button>
                            <a href="<?= base_url('customer/dashboard') ?>" class="btn btn-outline-secondary ms-2">
                                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="profile-sidebar">
                    <div class="account-info">
                        <h4>Account Information</h4>
                        <div class="info-item">
                            <strong>Email:</strong>
                            <span><?= esc($customer['email']) ?></span>
                        </div>
                        <div class="info-item">
                            <strong>Phone:</strong>
                            <span><?= esc($customer['phone']) ?></span>
                        </div>
                        <div class="info-item">
                            <strong>Country:</strong>
                            <span><?= esc($customer['country']) ?></span>
                        </div>
                        <div class="info-item">
                            <strong>Status:</strong>
                            <span class="badge badge-<?= $customer['status'] == 'active' ? 'success' : 'warning' ?>">
                                <?= ucfirst($customer['status']) ?>
                            </span>
                        </div>
                    </div>

                    <div class="quick-actions mt-4">
                        <h4>Quick Actions</h4>
                        <div class="d-grid gap-2">
                            <a href="<?= base_url('customer/orders') ?>" class="btn btn-outline-primary">
                                <i class="fas fa-shopping-bag me-2"></i>My Orders
                            </a>
                            <a href="<?= base_url('customer/change-password') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-key me-2"></i>Change Password
                            </a>
                            <a href="<?= base_url('customer/logout') ?>" class="btn btn-outline-danger">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-section {
    background: #fff;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.profile-sidebar {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.account-info .info-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.8rem;
    padding-bottom: 0.8rem;
    border-bottom: 1px solid #dee2e6;
}

.account-info .info-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.badge {
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
}

.badge-success {
    background-color: #28a745;
    color: #fff;
}

.badge-warning {
    background-color: #ffc107;
    color: #212529;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #333;
}

.form-control {
    font-size: 1rem;
    padding: 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 4px;
}

.form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.form-actions {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #dee2e6;
}

.btn {
    font-size: 1rem;
    padding: 0.75rem 1.5rem;
    border-radius: 4px;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

.quick-actions .btn {
    text-align: left;
    margin-bottom: 0.5rem;
}

@media (max-width: 768px) {
    .profile-section {
        padding: 1rem;
    }
    
    .profile-sidebar {
        padding: 1rem;
        margin-top: 2rem;
    }
}

/* Add space between page content and footer */
.main {
    margin-bottom: 3rem !important;
    padding-bottom: 2rem !important;
}

.profile-section {
    margin-bottom: 2rem;
}
</style>

<?= $this->endSection() ?>
