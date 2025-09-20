<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="page-content">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="page-header text-center mb-5">
                    <h1 class="page-title"><?= $page['title'] ?></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= $page['title'] ?></li>
                        </ol>
                    </nav>
                </div>
                
                <div class="page-content">
                    <?= $page['content'] ?>
                </div>
                
                <?php if ($page['page_type'] === 'contact'): ?>
                <div class="contact-info mt-5">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <div class="contact-icon mb-3">
                                <i class="fas fa-envelope fa-2x text-primary"></i>
                            </div>
                            <h5>Email</h5>
                            <p><a href="mailto:<?= $settings['site_email'] ?? '' ?>"><?= $settings['site_email'] ?? '' ?></a></p>
                        </div>
                        <div class="col-md-4 text-center mb-4">
                            <div class="contact-icon mb-3">
                                <i class="fas fa-phone fa-2x text-primary"></i>
                            </div>
                            <h5>Phone</h5>
                            <p><a href="tel:<?= $settings['site_phone'] ?? '' ?>"><?= $settings['site_phone'] ?? '' ?></a></p>
                        </div>
                        <div class="col-md-4 text-center mb-4">
                            <div class="contact-icon mb-3">
                                <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                            </div>
                            <h5>Address</h5>
                            <p><?= $settings['site_address'] ?? '' ?></p>
                        </div>
                    </div>
                    
                    <!-- Social Media Links -->
                    <?php if (!empty($settings['facebook_url']) || !empty($settings['twitter_url']) || !empty($settings['instagram_url'])): ?>
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <h5 class="mb-3">Follow Us</h5>
                            <div class="social-links">
                                <?php if (!empty($settings['facebook_url'])): ?>
                                    <a href="<?= $settings['facebook_url'] ?>" target="_blank" class="social-link" title="Facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($settings['twitter_url'])): ?>
                                    <a href="<?= $settings['twitter_url'] ?>" target="_blank" class="social-link" title="Twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($settings['instagram_url'])): ?>
                                    <a href="<?= $settings['instagram_url'] ?>" target="_blank" class="social-link" title="Instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.page-title {
    font-size: 2.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #333;
}

.breadcrumb {
    background: transparent;
    padding: 0;
}

.breadcrumb-item a {
    color: #667eea;
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #6c757d;
}

.page-content {
    line-height: 1.8;
    font-size: 1.1rem;
}

.page-content h1, .page-content h2, .page-content h3 {
    color: #333;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.page-content p {
    margin-bottom: 1.5rem;
}

.page-content ul, .page-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.page-content li {
    margin-bottom: 0.5rem;
}

.contact-icon {
    color: #667eea;
}

.contact-info h5 {
    color: #333;
    margin-bottom: 0.5rem;
}

.contact-info p {
    margin-bottom: 0;
}

.contact-info a {
    color: #667eea;
    text-decoration: none;
}

.contact-info a:hover {
    text-decoration: underline;
}

.social-links {
    display: flex;
    justify-content: center;
    gap: 1rem;
}

.social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    background: #667eea;
    color: white;
    border-radius: 50%;
    text-decoration: none;
    font-size: 1.5rem;
    transition: all 0.3s ease;
}

.social-link:hover {
    background: #5a6fd8;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
</style>

<?= $this->endSection() ?>
