<?= $this->extend('admin/layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Settings</h1>
    <button type="button" class="btn btn-primary" onclick="saveAllSettings()">
        <i class="fas fa-save"></i> Save All Settings
    </button>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <!-- General Settings -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-cog"></i> General Settings
                </h5>
            </div>
            <div class="card-body">
                <form id="generalSettingsForm">
                    <div class="mb-3">
                        <label for="site_name" class="form-label">Site Name</label>
                        <input type="text" class="form-control" id="site_name" name="site_name" value="<?= $settings['site_name'] ?? 'Jacket Store' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="site_description" class="form-label">Site Description</label>
                        <textarea class="form-control" id="site_description" name="site_description" rows="3"><?= $settings['site_description'] ?? 'Your premium jacket store' ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="contact_email" class="form-label">Contact Email</label>
                        <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?= $settings['contact_email'] ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="contact_phone" class="form-label">Contact Phone</label>
                        <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="<?= $settings['contact_phone'] ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="contact_address" class="form-label">Contact Address</label>
                        <textarea class="form-control" id="contact_address" name="contact_address" rows="3"><?= $settings['contact_address'] ?? '' ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="hero_image" class="form-label">Hero Image URL</label>
                        <input type="url" class="form-control" id="hero_image" name="hero_image" value="<?= $settings['hero_image'] ?? '' ?>" placeholder="https://example.com/hero-image.jpg">
                        <small class="form-text text-muted">URL for the main hero image displayed on the homepage</small>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Social Media & Analytics -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-share-alt"></i> Social Media & Analytics
                </h5>
            </div>
            <div class="card-body">
                <form id="socialSettingsForm">
                    <div class="mb-3">
                        <label for="facebook_url" class="form-label">Facebook URL</label>
                        <input type="url" class="form-control" id="facebook_url" name="facebook_url" value="<?= $settings['facebook_url'] ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="twitter_url" class="form-label">Twitter URL</label>
                        <input type="url" class="form-control" id="twitter_url" name="twitter_url" value="<?= $settings['twitter_url'] ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="instagram_url" class="form-label">Instagram URL</label>
                        <input type="url" class="form-control" id="instagram_url" name="instagram_url" value="<?= $settings['instagram_url'] ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="google_analytics" class="form-label">Google Analytics Code</label>
                        <textarea class="form-control" id="google_analytics" name="google_analytics" rows="3" placeholder="GA_MEASUREMENT_ID or full tracking code"><?= $settings['google_analytics'] ?? '' ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="facebook_pixel" class="form-label">Facebook Pixel Code</label>
                        <textarea class="form-control" id="facebook_pixel" name="facebook_pixel" rows="3" placeholder="Facebook Pixel ID or full code"><?= $settings['facebook_pixel'] ?? '' ?></textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- WhatsApp & Additional Settings -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fab fa-whatsapp"></i> WhatsApp & Additional
                </h5>
            </div>
            <div class="card-body">
                <form id="whatsappSettingsForm">
                    <div class="mb-3">
                        <label for="whatsapp_number" class="form-label">WhatsApp Number</label>
                        <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number" value="<?= $settings['whatsapp_number'] ?? '' ?>" placeholder="+1234567890">
                        <small class="form-text text-muted">Include country code (e.g., +1 for US)</small>
                    </div>
                    <div class="mb-3">
                        <label for="whatsapp_message" class="form-label">Default WhatsApp Message</label>
                        <textarea class="form-control" id="whatsapp_message" name="whatsapp_message" rows="2"><?= $settings['whatsapp_message'] ?? 'Hi! I have a question about your jackets.' ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="currency" class="form-label">Currency</label>
                        <select class="form-select" id="currency" name="currency">
                            <option value="USD" <?= ($settings['currency'] ?? 'USD') === 'USD' ? 'selected' : '' ?>>USD ($)</option>
                            <option value="EUR" <?= ($settings['currency'] ?? 'USD') === 'EUR' ? 'selected' : '' ?>>EUR (€)</option>
                            <option value="GBP" <?= ($settings['currency'] ?? 'USD') === 'GBP' ? 'selected' : '' ?>>GBP (£)</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SEO Settings -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-search"></i> SEO Settings
                </h5>
            </div>
            <div class="card-body">
                <form id="seoSettingsForm">
                    <div class="mb-3">
                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                        <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="2" placeholder="jacket, winter jacket, leather jacket"><?= $settings['meta_keywords'] ?? '' ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Default Meta Description</label>
                        <textarea class="form-control" id="meta_description" name="meta_description" rows="3"><?= $settings['meta_description'] ?? 'Premium jackets for all seasons. Quality materials and stylish designs.' ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="robots_txt" class="form-label">Robots.txt Content</label>
                        <textarea class="form-control" id="robots_txt" name="robots_txt" rows="4"><?= $settings['robots_txt'] ?? "User-agent: *\nAllow: /\nDisallow: /admin/\nDisallow: /writable/" ?></textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function saveAllSettings() {
    // Collect all form data
    const forms = [
        'generalSettingsForm',
        'socialSettingsForm', 
        'whatsappSettingsForm',
        'seoSettingsForm'
    ];
    
    const formData = new FormData();
    
    forms.forEach(formId => {
        const form = document.getElementById(formId);
        const formElements = form.elements;
        for (let i = 0; i < formElements.length; i++) {
            const element = formElements[i];
            if (element.name) {
                formData.append(element.name, element.value);
            }
        }
    });
    
    // Send to server
    fetch('<?= base_url('admin/settings/save') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Settings saved successfully!');
            location.reload();
        } else {
            alert('Error saving settings: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error saving settings');
    });
}
</script>

<?= $this->endSection() ?>
