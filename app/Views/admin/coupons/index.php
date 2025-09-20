<?= $this->extend('admin/layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title"><?= $title ?></h3>
                    <a href="<?= base_url('admin/coupons/create') ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Coupon
                    </a>
                </div>

                <div class="card-body">
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

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                    <th>Usage</th>
                                    <th>Status</th>
                                    <th>Valid Period</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($coupons)): ?>
                                    <?php foreach ($coupons as $coupon): ?>
                                        <tr>
                                            <td><?= $coupon['id'] ?></td>
                                            <td>
                                                <code><?= esc($coupon['code']) ?></code>
                                            </td>
                                            <td><?= esc($coupon['name']) ?></td>
                                            <td>
                                                <span class="badge bg-<?= $coupon['type'] === 'percentage' ? 'info' : 'warning' ?>">
                                                    <?= ucfirst($coupon['type']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($coupon['type'] === 'percentage'): ?>
                                                    <?= $coupon['value'] ?>%
                                                <?php else: ?>
                                                    $<?= number_format($coupon['value'], 2) ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= $coupon['used_count'] ?>
                                                <?php if ($coupon['usage_limit']): ?>
                                                    / <?= $coupon['usage_limit'] ?>
                                                <?php else: ?>
                                                    / ∞
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $coupon['status'] === 'active' ? 'success' : 'secondary' ?>">
                                                    <?= ucfirst($coupon['status']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <small>
                                                    <?= date('M d, Y', strtotime($coupon['start_date'])) ?><br>
                                                    to <?= date('M d, Y', strtotime($coupon['end_date'])) ?>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('admin/coupons/edit/' . $coupon['id']) ?>" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="<?= base_url('admin/coupons/toggle-status/' . $coupon['id']) ?>" 
                                                       class="btn btn-sm btn-outline-<?= $coupon['status'] === 'active' ? 'warning' : 'success' ?>"
                                                       onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-<?= $coupon['status'] === 'active' ? 'pause' : 'play' ?>"></i>
                                                    </a>
                                                    <a href="<?= base_url('admin/coupons/delete/' . $coupon['id']) ?>" 
                                                       class="btn btn-sm btn-outline-danger"
                                                       onclick="return confirm('Are you sure you want to delete this coupon?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center">No coupons found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
