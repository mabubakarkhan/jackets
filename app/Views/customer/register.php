<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>
<div class="page-header text-center" style="background-image: url('<?= base_url('html/assets/images/page-header-bg.jpg') ?>')">
    <div class="container">
        <h1 class="page-title">Create Account<span>Customer Registration</span></h1>
    </div><!-- End .container -->
</div><!-- End .page-header -->
<nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Account</li>
        </ol>
    </div><!-- End .container -->
</nav><!-- End .breadcrumb-nav -->

<div class="main" style="padding-top: 2rem;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="register-form">
                    <h2 class="register-title">Create Account</h2>
                    <p class="text-muted">Join us today and start shopping for amazing jackets!</p>

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

                    <?php if (session()->getFlashdata('validation')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('validation')->getErrors() as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('customer/register') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Full Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="<?= old('name') ?>" required>
                                    <?php if (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('name')): ?>
                                        <div class="text-danger small"><?= session()->getFlashdata('validation')->getError('name') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email Address *</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?= old('email') ?>" required>
                                    <?php if (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('email')): ?>
                                        <div class="text-danger small"><?= session()->getFlashdata('validation')->getError('email') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone Number *</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                           value="<?= old('phone') ?>" required>
                                    <?php if (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('phone')): ?>
                                        <div class="text-danger small"><?= session()->getFlashdata('validation')->getError('phone') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country">Country *</label>
                                    <select class="form-control" id="country" name="country" required>
                                        <option value="">Select Country</option>
                                        <option value="US" <?= old('country') == 'US' ? 'selected' : '' ?>>United States</option>
                                        <option value="CA" <?= old('country') == 'CA' ? 'selected' : '' ?>>Canada</option>
                                        <option value="UK" <?= old('country') == 'UK' ? 'selected' : '' ?>>United Kingdom</option>
                                        <option value="AU" <?= old('country') == 'AU' ? 'selected' : '' ?>>Australia</option>
                                        <option value="DE" <?= old('country') == 'DE' ? 'selected' : '' ?>>Germany</option>
                                        <option value="FR" <?= old('country') == 'FR' ? 'selected' : '' ?>>France</option>
                                        <option value="IT" <?= old('country') == 'IT' ? 'selected' : '' ?>>Italy</option>
                                        <option value="ES" <?= old('country') == 'ES' ? 'selected' : '' ?>>Spain</option>
                                        <option value="Other" <?= old('country') == 'Other' ? 'selected' : '' ?>>Other</option>
                                    </select>
                                    <?php if (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('country')): ?>
                                        <div class="text-danger small"><?= session()->getFlashdata('validation')->getError('country') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">Address *</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required><?= old('address') ?></textarea>
                            <?php if (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('address')): ?>
                                <div class="text-danger small"><?= session()->getFlashdata('validation')->getError('address') ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city">City *</label>
                                    <input type="text" class="form-control" id="city" name="city" 
                                           value="<?= old('city') ?>" required>
                                    <?php if (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('city')): ?>
                                        <div class="text-danger small"><?= session()->getFlashdata('validation')->getError('city') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password *</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <small class="form-text text-muted">Minimum 6 characters</small>
                                    <?php if (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('password')): ?>
                                        <div class="text-danger small"><?= session()->getFlashdata('validation')->getError('password') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirm Password *</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            <?php if (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('confirm_password')): ?>
                                <div class="text-danger small"><?= session()->getFlashdata('validation')->getError('confirm_password') ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" class="text-primary">Terms and Conditions</a> and <a href="#" class="text-primary">Privacy Policy</a>
                                </label>
                            </div>
                            <?php if (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('terms')): ?>
                                <div class="text-danger small"><?= session()->getFlashdata('validation')->getError('terms') ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Create Account</button>
                        </div>

                        <div class="text-center">
                            <p class="text-muted">Already have an account? 
                                <a href="<?= base_url('customer/login') ?>" class="text-primary">Sign in here</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.register-form {
    background: #fff;
    padding: 3rem;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    margin: 2rem 0;
}

.register-title {
    font-size: 2.5rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    text-align: center;
    color: #333;
}

.form-group {
    margin-bottom: 2rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #333;
    font-size: 1.1rem;
}

.form-control {
    width: 100%;
    padding: 1rem;
    border: 2px solid #ddd;
    border-radius: 8px;
    font-size: 1.5rem;
    transition: all 0.3s ease;
}

.form-control select {
    font-size: 1.1rem;
}

select.form-control {
    font-size: 1.1rem;
}

.form-control:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    padding: 1rem 2rem;
    font-size: 1.2rem;
    font-weight: 600;
    border-radius: 8px;
    width: 100%;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

.alert {
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 5px;
}

.alert-danger {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}

.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}

.text-center {
    text-align: center;
}

.text-muted {
    color: #6c757d;
}

.text-primary {
    color: #007bff;
    text-decoration: none;
}

.text-primary:hover {
    text-decoration: underline;
}

.form-check {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.form-check-input {
    margin-right: 0;
    margin-top: 0.25rem;
    flex-shrink: 0;
    width: 1.2rem;
    height: 1.2rem;
}

.form-check-label {
    margin-bottom: 0;
    font-size: 1.1rem;
    line-height: 1.4;
    color: #333;
    padding-left: 0;
}

.form-text {
    font-size: 1rem;
    color: #6c757d;
    margin-top: 0.5rem;
}

/* Error message styling */
.text-danger.small {
    font-size: 0.95rem;
    margin-top: 0.75rem;
    margin-bottom: 0.5rem;
    font-weight: 500;
    display: block;
    padding: 0.5rem 0;
}

/* Ensure proper spacing for form groups with errors */
.form-group:has(.text-danger) {
    margin-bottom: 2rem;
}
</style>
<?= $this->endSection() ?>
