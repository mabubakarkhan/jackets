<?= $this->extend('admin/layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Customer</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?= base_url('admin/customers') ?>" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Customers
            </a>
            <a href="<?= base_url('admin/customers/view/' . $customer['id']) ?>" class="btn btn-sm btn-primary">
                <i class="fas fa-eye"></i> View Customer
            </a>
        </div>
    </div>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2"></i>Edit Customer Information
                </h5>
            </div>
            <div class="card-body">
                <?= form_open('admin/customers/update/' . $customer['id']) ?>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?= (session('validation') && session('validation')->hasError('name')) ? 'is-invalid' : '' ?>" 
                               id="name" 
                               name="name" 
                               value="<?= old('name', $customer['name']) ?>" 
                               required>
                        <?php if (session('validation') && session('validation')->hasError('name')): ?>
                            <div class="invalid-feedback">
                                <?= session('validation')->getError('name') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" 
                               class="form-control <?= (session('validation') && session('validation')->hasError('email')) ? 'is-invalid' : '' ?>" 
                               id="email" 
                               name="email" 
                               value="<?= old('email', $customer['email']) ?>" 
                               required>
                        <?php if (session('validation') && session('validation')->hasError('email')): ?>
                            <div class="invalid-feedback">
                                <?= session('validation')->getError('email') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="tel" 
                               class="form-control <?= (session('validation') && session('validation')->hasError('phone')) ? 'is-invalid' : '' ?>" 
                               id="phone" 
                               name="phone" 
                               value="<?= old('phone', $customer['phone']) ?>" 
                               required>
                        <?php if (session('validation') && session('validation')->hasError('phone')): ?>
                            <div class="invalid-feedback">
                                <?= session('validation')->getError('phone') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select <?= (session('validation') && session('validation')->hasError('status')) ? 'is-invalid' : '' ?>" 
                                id="status" 
                                name="status" 
                                required>
                            <option value="">Select Status</option>
                            <option value="active" <?= old('status', $customer['status']) == 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= old('status', $customer['status']) == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            <option value="suspended" <?= old('status', $customer['status']) == 'suspended' ? 'selected' : '' ?>>Suspended</option>
                        </select>
                        <?php if (session('validation') && session('validation')->hasError('status')): ?>
                            <div class="invalid-feedback">
                                <?= session('validation')->getError('status') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-12">
                        <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                        <textarea class="form-control <?= (session('validation') && session('validation')->hasError('address')) ? 'is-invalid' : '' ?>" 
                                  id="address" 
                                  name="address" 
                                  rows="3" 
                                  required><?= old('address', $customer['address']) ?></textarea>
                        <?php if (session('validation') && session('validation')->hasError('address')): ?>
                            <div class="invalid-feedback">
                                <?= session('validation')->getError('address') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?= (session('validation') && session('validation')->hasError('city')) ? 'is-invalid' : '' ?>" 
                               id="city" 
                               name="city" 
                               value="<?= old('city', $customer['city']) ?>" 
                               required>
                        <?php if (session('validation') && session('validation')->hasError('city')): ?>
                            <div class="invalid-feedback">
                                <?= session('validation')->getError('city') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?= (session('validation') && session('validation')->hasError('country')) ? 'is-invalid' : '' ?>" 
                               id="country" 
                               name="country" 
                               value="<?= old('country', $customer['country']) ?>" 
                               required>
                        <?php if (session('validation') && session('validation')->hasError('country')): ?>
                            <div class="invalid-feedback">
                                <?= session('validation')->getError('country') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Customer
                        </button>
                        <a href="<?= base_url('admin/customers/view/' . $customer['id']) ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </div>
                
                <?= form_close() ?>
            </div>
        </div>
    </div>
    
    <!-- Customer Info Sidebar -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>Customer Information
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="avatar-lg bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center">
                        <?= strtoupper(substr($customer['name'], 0, 1)) ?>
                    </div>
                    <h5 class="mt-3 mb-1"><?= esc($customer['name']) ?></h5>
                    <p class="text-muted"><?= esc($customer['email']) ?></p>
                </div>
                
                <div class="row g-2">
                    <div class="col-12">
                        <small class="text-muted">Member Since</small>
                        <p class="mb-0"><?= date('F j, Y', strtotime($customer['created_at'])) ?></p>
                    </div>
                    <div class="col-12">
                        <small class="text-muted">Last Updated</small>
                        <p class="mb-0"><?= date('F j, Y g:i A', strtotime($customer['updated_at'] ?? $customer['created_at'])) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-lg {
    width: 80px;
    height: 80px;
    font-size: 32px;
    font-weight: bold;
}
</style>

<?= $this->endSection() ?>
