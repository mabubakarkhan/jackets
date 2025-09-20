<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-center">
                            <i class="fas fa-lock me-2"></i>Reset Password
                        </h3>
                    </div>
                    <div class="card-body">
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <?= session()->getFlashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <p class="text-muted text-center mb-4">
                            Enter the 6-digit code sent to your email and create a new password.
                        </p>

                        <form method="POST" action="<?= base_url('customer/process-reset-password') ?>">
                            <?= csrf_field() ?>
                            
                            <div class="form-group mb-3">
                                <label for="code" class="form-label">
                                    <i class="fas fa-key me-2"></i>Verification Code
                                </label>
                                <input type="text" 
                                       class="form-control text-center <?= session('validation') && session('validation')->hasError('code') ? 'is-invalid' : '' ?>" 
                                       id="code" 
                                       name="code" 
                                       value="<?= old('code') ?>" 
                                       placeholder="Enter 6-digit code"
                                       maxlength="6"
                                       pattern="[0-9]{6}"
                                       required>
                                <?php if (session('validation') && session('validation')->hasError('code')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('validation')->getError('code') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group mb-3">
                                <label for="new_password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>New Password
                                </label>
                                <input type="password" 
                                       class="form-control <?= session('validation') && session('validation')->hasError('new_password') ? 'is-invalid' : '' ?>" 
                                       id="new_password" 
                                       name="new_password" 
                                       placeholder="Enter new password"
                                       minlength="6"
                                       required>
                                <?php if (session('validation') && session('validation')->hasError('new_password')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('validation')->getError('new_password') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group mb-4">
                                <label for="confirm_password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Confirm New Password
                                </label>
                                <input type="password" 
                                       class="form-control <?= session('validation') && session('validation')->hasError('confirm_password') ? 'is-invalid' : '' ?>" 
                                       id="confirm_password" 
                                       name="confirm_password" 
                                       placeholder="Confirm new password"
                                       minlength="6"
                                       required>
                                <?php if (session('validation') && session('validation')->hasError('confirm_password')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('validation')->getError('confirm_password') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-check me-2"></i>Reset Password
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <p class="mb-0">
                                Didn't receive the code? 
                                <a href="<?= base_url('customer/forgot-password') ?>" class="text-decoration-none">
                                    <i class="fas fa-redo me-1"></i>Resend code
                                </a>
                            </p>
                            <p class="mb-0 mt-2">
                                Remember your password? 
                                <a href="<?= base_url('customer/login') ?>" class="text-decoration-none">
                                    <i class="fas fa-sign-in-alt me-1"></i>Login here
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.page-content {
    padding: 4rem 0;
    min-height: 60vh;
    display: flex;
    align-items: center;
}

.card {
    border: none;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    border-radius: 10px;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px 10px 0 0 !important;
    border: none;
    padding: 2rem;
}

.card-title {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
}

.card-body {
    padding: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
}

.form-control {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.form-control.text-center {
    font-size: 1.2rem;
    font-weight: 600;
    letter-spacing: 0.2em;
}

.btn {
    border-radius: 8px;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.alert {
    border: none;
    border-radius: 8px;
    font-weight: 500;
}

.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
}

.alert-danger {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
}

.text-muted {
    color: #6c757d !important;
}

.invalid-feedback {
    display: block;
    font-size: 0.875rem;
    color: #dc3545;
    margin-top: 0.25rem;
}

.is-invalid {
    border-color: #dc3545;
}

@media (max-width: 768px) {
    .page-content {
        padding: 2rem 0;
    }
    
    .card-header,
    .card-body {
        padding: 1.5rem;
    }
}
</style>

<script>
// Auto-format code input
document.getElementById('code').addEventListener('input', function(e) {
    // Remove any non-numeric characters
    this.value = this.value.replace(/[^0-9]/g, '');
    
    // Limit to 6 digits
    if (this.value.length > 6) {
        this.value = this.value.slice(0, 6);
    }
});

// Password confirmation validation
document.getElementById('confirm_password').addEventListener('input', function() {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = this.value;
    
    if (confirmPassword && newPassword !== confirmPassword) {
        this.setCustomValidity('Passwords do not match');
    } else {
        this.setCustomValidity('');
    }
});

document.getElementById('new_password').addEventListener('input', function() {
    const confirmPassword = document.getElementById('confirm_password');
    if (confirmPassword.value) {
        confirmPassword.dispatchEvent(new Event('input'));
    }
});
</script>

<?= $this->endSection() ?>
