<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        $this->db->table('users')->insert([
            'username' => 'admin',
            'email' => 'admin@jacketstore.com',
            'password' => password_hash('chor', PASSWORD_DEFAULT),
            'role' => 'admin',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // Insert default settings
        $settings = [
            [
                'setting_key' => 'site_name',
                'setting_value' => 'Jacket Store',
                'setting_type' => 'text',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'site_description',
                'setting_value' => 'Premium Quality Jackets and Outerwear',
                'setting_type' => 'textarea',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'site_email',
                'setting_value' => 'info@jacketstore.com',
                'setting_type' => 'text',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'site_phone',
                'setting_value' => '+92 300 1234567',
                'setting_type' => 'text',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'site_address',
                'setting_value' => '123 Main Street, Karachi, Pakistan',
                'setting_type' => 'textarea',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'facebook_url',
                'setting_value' => 'https://facebook.com/jacketstore',
                'setting_type' => 'text',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'instagram_url',
                'setting_value' => 'https://instagram.com/jacketstore',
                'setting_type' => 'text',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'twitter_url',
                'setting_value' => 'https://twitter.com/jacketstore',
                'setting_type' => 'text',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'whatsapp_number',
                'setting_value' => '+92 300 1234567',
                'setting_type' => 'text',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'google_analytics',
                'setting_value' => 'GA_MEASUREMENT_ID',
                'setting_type' => 'text',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'facebook_pixel',
                'setting_value' => 'FB_PIXEL_ID',
                'setting_type' => 'text',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('settings')->insertBatch($settings);

        // Insert static pages
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => '<h1>About Us</h1><p>Welcome to Jacket Store, your premier destination for high-quality jackets and outerwear. We specialize in providing stylish, durable, and comfortable jackets for all seasons.</p><p>Our commitment to quality and customer satisfaction has made us a trusted name in the fashion industry.</p>',
                'page_type' => 'static',
                'meta_title' => 'About Us - Jacket Store',
                'meta_description' => 'Learn more about Jacket Store, your premier destination for high-quality jackets and outerwear.',
                'meta_keywords' => 'about us, jacket store, company information',
                'status' => 'published',
                'sort_order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact-us',
                'content' => '<h1>Contact Us</h1><p>Get in touch with us for any inquiries or support.</p><h3>Contact Information:</h3><ul><li><strong>Email:</strong> info@jacketstore.com</li><li><strong>Phone:</strong> +92 300 1234567</li><li><strong>Address:</strong> 123 Main Street, Karachi, Pakistan</li></ul>',
                'page_type' => 'static',
                'meta_title' => 'Contact Us - Jacket Store',
                'meta_description' => 'Contact Jacket Store for inquiries, support, or any questions about our products.',
                'meta_keywords' => 'contact us, customer support, jacket store contact',
                'status' => 'published',
                'sort_order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<h1>Privacy Policy</h1><p>This Privacy Policy describes how Jacket Store collects, uses, and protects your personal information.</p><h3>Information We Collect</h3><p>We collect information you provide directly to us, such as when you create an account, make a purchase, or contact us.</p>',
                'page_type' => 'static',
                'meta_title' => 'Privacy Policy - Jacket Store',
                'meta_description' => 'Read our privacy policy to understand how Jacket Store collects, uses, and protects your personal information.',
                'meta_keywords' => 'privacy policy, data protection, personal information',
                'status' => 'published',
                'sort_order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Return Policy',
                'slug' => 'return-policy',
                'content' => '<h1>Return Policy</h1><p>We want you to be completely satisfied with your purchase. If you are not satisfied, you may return your item within 30 days of delivery.</p><h3>Return Conditions</h3><ul><li>Item must be unused and in original packaging</li><li>Return within 30 days of delivery</li><li>Original receipt required</li></ul>',
                'page_type' => 'static',
                'meta_title' => 'Return Policy - Jacket Store',
                'meta_description' => 'Learn about our return policy, conditions, and process for returning items at Jacket Store.',
                'meta_keywords' => 'return policy, refund policy, returns',
                'status' => 'published',
                'sort_order' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Terms and Conditions',
                'slug' => 'terms-and-conditions',
                'content' => '<h1>Terms and Conditions</h1><p>By using our website and services, you agree to these terms and conditions.</p><h3>Use of Website</h3><p>You may use our website for lawful purposes only. You may not use our website to transmit any material that is defamatory, offensive, or otherwise objectionable.</p>',
                'page_type' => 'static',
                'meta_title' => 'Terms and Conditions - Jacket Store',
                'meta_description' => 'Read our terms and conditions to understand the rules and guidelines for using Jacket Store services.',
                'meta_keywords' => 'terms and conditions, terms of service, user agreement',
                'status' => 'published',
                'sort_order' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('pages')->insertBatch($pages);

        // Insert sample categories
        $categories = [
            [
                'name' => 'Men\'s Jackets',
                'slug' => 'mens-jackets',
                'description' => 'Stylish and comfortable jackets for men',
                'meta_title' => 'Men\'s Jackets - Jacket Store',
                'meta_description' => 'Discover our collection of stylish and comfortable men\'s jackets.',
                'meta_keywords' => 'men jackets, mens outerwear, men coats',
                'sort_order' => 1,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Women\'s Jackets',
                'slug' => 'womens-jackets',
                'description' => 'Elegant and trendy jackets for women',
                'meta_title' => 'Women\'s Jackets - Jacket Store',
                'meta_description' => 'Explore our elegant collection of women\'s jackets and outerwear.',
                'meta_keywords' => 'women jackets, womens outerwear, women coats',
                'sort_order' => 2,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Leather Jackets',
                'slug' => 'leather-jackets',
                'description' => 'Premium quality leather jackets',
                'meta_title' => 'Leather Jackets - Jacket Store',
                'meta_description' => 'Premium quality leather jackets for men and women.',
                'meta_keywords' => 'leather jackets, genuine leather, premium jackets',
                'sort_order' => 3,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('categories')->insertBatch($categories);
    }
}
