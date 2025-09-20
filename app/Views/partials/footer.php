<footer class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="widget">
                        <h4 class="widget-title">About Us</h4>
                        <p><?= $settings['site_description'] ?? 'Premium Quality Jackets and Outerwear' ?></p>
                        <div class="social-icons">
                            <?php if (isset($settings['facebook_url']) && !empty($settings['facebook_url'])): ?>
                            <a href="<?= $settings['facebook_url'] ?>" class="social-icon" target="_blank" rel="noopener">
                                <i class="icon-facebook-f"></i>
                            </a>
                            <?php endif; ?>
                            
                            <?php if (isset($settings['instagram_url']) && !empty($settings['instagram_url'])): ?>
                            <a href="<?= $settings['instagram_url'] ?>" class="social-icon" target="_blank" rel="noopener">
                                <i class="icon-instagram"></i>
                            </a>
                            <?php endif; ?>
                            
                            <?php if (isset($settings['twitter_url']) && !empty($settings['twitter_url'])): ?>
                            <a href="<?= $settings['twitter_url'] ?>" class="social-icon" target="_blank" rel="noopener">
                                <i class="icon-twitter"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-sm-6">
                    <div class="widget">
                        <h4 class="widget-title">Quick Links</h4>
                        <ul class="links">
                            <li><a href="<?= base_url('shop') ?>">Shop</a></li>
                            <li><a href="<?= base_url('cart') ?>">Cart</a></li>
                            <li><a href="<?= base_url('about-us') ?>">About Us</a></li>
                            <li><a href="<?= base_url('contact-us') ?>">Contact</a></li>
                            <li><a href="<?= base_url('blog') ?>">Blog</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2 col-sm-6">
                    <div class="widget">
                        <h4 class="widget-title">Customer Service</h4>
                        <ul class="links">
                            <li><a href="<?= base_url('privacy-policy') ?>">Privacy Policy</a></li>
                            <li><a href="<?= base_url('return-policy') ?>">Return Policy</a></li>
                            <li><a href="<?= base_url('terms-and-conditions') ?>">Terms & Conditions</a></li>
                            <li><a href="<?= base_url('faq') ?>">FAQ</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="widget">
                        <h4 class="widget-title">Contact Info</h4>
                        <ul class="contact-info">
                            <?php if (isset($settings['site_address']) && !empty($settings['site_address'])): ?>
                            <li>
                                <i class="icon-map-marker"></i>
                                <span><?= $settings['site_address'] ?></span>
                            </li>
                            <?php endif; ?>
                            
                            <?php if (isset($settings['site_phone']) && !empty($settings['site_phone'])): ?>
                            <li>
                                <i class="icon-phone"></i>
                                <a href="tel:<?= $settings['site_phone'] ?>"><?= $settings['site_phone'] ?></a>
                            </li>
                            <?php endif; ?>
                            
                            <?php if (isset($settings['site_email']) && !empty($settings['site_email'])): ?>
                            <li>
                                <i class="icon-envelope"></i>
                                <a href="mailto:<?= $settings['site_email'] ?>"><?= $settings['site_email'] ?></a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <p class="footer-copyright">
                &copy; <?= date('Y') ?> <?= $settings['site_name'] ?? 'Jacket Store' ?>. All rights reserved.
            </p>
        </div>
    </div>
</footer>
