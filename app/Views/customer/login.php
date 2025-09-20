<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>
<div class="main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="login-form">
                    <h2 class="login-title">Customer Login</h2>
                    <p class="text-muted">Sign in to your account to continue shopping</p>

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

                    <form action="<?= base_url('customer/login') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= old('email') ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password *</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>

                        <div class="text-center">
                            <p class="text-muted">
                                <a href="<?= base_url('customer/forgot-password') ?>" class="text-primary">
                                    <i class="fas fa-key me-1"></i>Forgot Password?
                                </a>
                            </p>
                            <p class="text-muted">Don't have an account? 
                                <a href="<?= base_url('customer/register') ?>" class="text-primary">Sign up here</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.login-form {
    background: #fff;
    padding: 3rem;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    margin: 2rem 0;
}

.login-title {
    font-size: 2rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    text-align: center;
    color: #333;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #333;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
}

.form-control:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    padding: 0.75rem 2rem;
    font-size: 1rem;
    font-weight: 500;
    border-radius: 5px;
    width: 100%;
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
</style>
<?= $this->endSection() ?>
