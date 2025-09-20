<?= $this->extend('admin/layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?= $title ?></h3>
                    <div class="card-tools">
                        <a href="<?= base_url('admin/coupons') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Coupons
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('admin/coupons/store') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code" class="form-label">Coupon Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="code" name="code" 
                                           value="<?= old('code') ?>" required>
                                    <?php if (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('code')): ?>
                                        <div class="text-danger"><?= session()->getFlashdata('validation')->getError('code') ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Coupon Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="<?= old('name') ?>" required>
                                    <?php if (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('name')): ?>
                                        <div class="text-danger"><?= session()->getFlashdata('validation')->getError('name') ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"><?= old('description') ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="type" class="form-label">Discount Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="type" name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="percentage" <?= old('type') === 'percentage' ? 'selected' : '' ?>>Percentage</option>
                                        <option value="fixed" <?= old('type') === 'fixed' ? 'selected' : '' ?>>Fixed Amount</option>
                                    </select>
                                    <?php if (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('type')): ?>
                                        <div class="text-danger"><?= session()->getFlashdata('validation')->getError('type') ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="value" class="form-label">Discount Value <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="value" name="value" 
                                               value="<?= old('value') ?>" step="0.01" min="0" required>
                                        <span class="input-group-text" id="value-suffix">%</span>
                                    </div>
                                    <?php if (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('value')): ?>
                                        <div class="text-danger"><?= session()->getFlashdata('validation')->getError('value') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="minimum_amount" class="form-label">Minimum Order Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" id="minimum_amount" name="minimum_amount" 
                                               value="<?= old('minimum_amount') ?: '0' ?>" step="0.01" min="0">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="maximum_discount" class="form-label">Maximum Discount (for percentage)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" id="maximum_discount" name="maximum_discount" 
                                               value="<?= old('maximum_discount') ?>" step="0.01" min="0">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="usage_limit" class="form-label">Usage Limit</label>
                                    <input type="number" class="form-control" id="usage_limit" name="usage_limit" 
                                           value="<?= old('usage_limit') ?>" min="1">
                                    <div class="form-text">Leave empty for unlimited usage</div>
                                </div>

                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="start_date" name="start_date" 
                                           value="<?= old('start_date') ?>" required>
                                    <?php if (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('start_date')): ?>
                                        <div class="text-danger"><?= session()->getFlashdata('validation')->getError('start_date') ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="end_date" name="end_date" 
                                           value="<?= old('end_date') ?>" required>
                                    <?php if (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('end_date')): ?>
                                        <div class="text-danger"><?= session()->getFlashdata('validation')->getError('end_date') ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="active" <?= old('status', 'active') === 'active' ? 'selected' : '' ?>>Active</option>
                                        <option value="inactive" <?= old('status') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Coupon
                                </button>
                                <a href="<?= base_url('admin/coupons') ?>" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const valueInput = document.getElementById('value');
    const valueSuffix = document.getElementById('value-suffix');
    const maximumDiscountGroup = document.getElementById('maximum_discount').closest('.mb-3');

    function updateValueSuffix() {
        if (typeSelect.value === 'percentage') {
            valueSuffix.textContent = '%';
            valueInput.setAttribute('max', '100');
            maximumDiscountGroup.style.display = 'block';
        } else {
            valueSuffix.textContent = '$';
            valueInput.removeAttribute('max');
            maximumDiscountGroup.style.display = 'none';
        }
    }

    typeSelect.addEventListener('change', updateValueSuffix);
    updateValueSuffix(); // Initialize on page load
});
</script>
<?= $this->endSection() ?>
