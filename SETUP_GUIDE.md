# Jacket Store - Complete Setup Guide

## 🚀 Quick Start

### 1. Prerequisites
- XAMPP/WAMP/MAMP installed and running
- PHP 8.0+ 
- MySQL 5.7+
- Apache web server

### 2. Installation Steps

#### Step 1: Download/Clone Project
```bash
# If using git
git clone [repository-url]
cd jacket

# Or download and extract to your web server directory
# e.g., C:\xampp\htdocs\jacket\
```

#### Step 2: Database Setup
Run the database setup script:
```bash
php setup_database.php
```

This will:
- ✅ Create `jacket_store` database
- ✅ Create all necessary tables
- ✅ Insert admin user (admin/chor)
- ✅ Seed sample data (categories, pages, settings)

#### Step 3: Web Server Configuration
Ensure your web server points to the `public` directory as document root.

**For XAMPP:**
- Place project in `C:\xampp\htdocs\jacket\`
- Access via: `http://localhost/jacket/`

**For Virtual Host (Recommended):**
```apache
<VirtualHost *:80>
    ServerName jacketstore.local
    DocumentRoot "C:/xampp/htdocs/jacket/public"
    <Directory "C:/xampp/htdocs/jacket/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

#### Step 4: Access the Application
- **Frontend**: `http://localhost/jacket/` or `http://jacketstore.local/`
- **Admin Panel**: `http://localhost/jacket/admin/login` or `http://jacketstore.local/admin/login`

## 🔐 Admin Access

- **Username**: `admin`
- **Password**: `chor`
- **URL**: `/admin/login`

## 📁 Project Structure

```
jacket/
├── app/                          # Application code
│   ├── Controllers/             # Controllers
│   │   ├── Admin/              # Admin controllers
│   │   ├── Home.php            # Home page controller
│   │   ├── Shop.php            # Shop controller
│   │   └── Page.php            # CMS page controller
│   ├── Models/                  # Database models
│   ├── Views/                   # Views
│   │   ├── admin/              # Admin views
│   │   ├── layouts/            # Base layout
│   │   ├── partials/           # Header/footer
│   │   ├── shop/               # Shop views
│   │   └── page/               # Page views
│   └── Database/                # Database files
│       ├── Migrations/         # Database migrations
│       └── Seeds/              # Data seeders
├── html/                        # Theme assets (index-15.html)
├── public/                      # Web root
│   ├── .htaccess               # URL rewriting
│   ├── robots.txt              # SEO robots file
│   └── index.php               # Entry point
├── setup_database.php           # Database setup script
├── README.md                    # Project documentation
└── SETUP_GUIDE.md              # This file
```

## 🛠️ Configuration

### Database Configuration
File: `app/Config/Database.php`
```php
'hostname' => 'localhost',
'username' => 'root',
'password' => '',
'database' => 'jacket_store',
```

### Site Settings
Access `/admin/settings` to configure:
- Site name and description
- Contact information
- Social media links
- WhatsApp number
- Google Analytics ID
- Facebook Pixel ID

## 🎨 Customization

### Adding Products
1. Login to admin panel (`/admin/login`)
2. Navigate to Products section
3. Click "Add New Product"
4. Fill in product details and SEO information
5. Upload product images
6. Set pricing and inventory

### Managing Categories
1. Go to Categories section in admin
2. Create/edit categories with SEO fields
3. Set parent categories for hierarchy
4. Upload category images

### Content Management
1. Access Pages section
2. Edit static pages (About, Contact, etc.)
3. Update SEO meta information
4. Manage blog posts and FAQs

## 🔍 SEO Features

### Meta Tags
- Every page has optimized meta titles and descriptions
- Open Graph and Twitter Card support
- Schema.org structured data markup

### Performance
- Asset preloading for critical resources
- Gzip compression enabled
- Browser caching for static assets
- Optimized images and CSS/JS

### Technical SEO
- Clean URLs with .htaccess rewriting
- Canonical URLs to prevent duplicate content
- XML sitemap support
- Robots.txt for search engine guidance

## 🚀 Performance Optimization

### Frontend
- CSS and JavaScript minification
- Image optimization and lazy loading
- Critical CSS inlining
- CDN-ready asset structure

### Backend
- Database query optimization
- Session management
- Input validation and sanitization
- Security headers

## 🔒 Security Features

- Password hashing with PHP's built-in functions
- Session-based authentication
- SQL injection protection
- XSS protection
- CSRF protection
- Input validation and sanitization

## 📱 Mobile Optimization

- Responsive design based on Bootstrap 5
- Mobile-first approach
- Touch-friendly navigation
- Optimized for mobile search engines

## 🛍️ E-commerce Features

### Product Management
- Product categories and subcategories
- Product images with alt text
- Inventory tracking
- Featured products
- Sale pricing

### Order Management
- Cash on delivery orders
- Order status tracking
- Customer information management
- Order history

### Shopping Experience
- Product filtering and search
- Shopping cart functionality
- Wishlist support
- Customer reviews (can be added)

## 📊 Analytics & Tracking

### Google Analytics
- Built-in Google Analytics integration
- Configurable via admin settings
- Event tracking support

### Facebook Pixel
- Conversion tracking
- Custom audience creation
- Retargeting capabilities

## 🆘 Troubleshooting

### Common Issues

#### Database Connection Error
```bash
# Check if MySQL is running
# Verify database credentials in app/Config/Database.php
# Ensure database 'jacket_store' exists
```

#### 404 Errors
```bash
# Check .htaccess file exists in public/ directory
# Ensure mod_rewrite is enabled in Apache
# Verify document root points to public/ directory
```

#### Admin Login Issues
```bash
# Verify admin user exists in database
# Check password hash in database
# Clear browser cookies and cache
```

#### Image Display Issues
```bash
# Check image paths in views
# Ensure images exist in assets/ directory
# Verify file permissions
```

### Debug Mode
Enable debug mode in `app/Config/Boot/production.php`:
```php
error_reporting(E_ALL);
ini_set('display_errors', '1');
```

## 🔄 Updates & Maintenance

### Regular Tasks
- Update product inventory
- Review and respond to orders
- Update content and SEO information
- Monitor analytics and performance
- Backup database regularly

### Security Updates
- Keep CodeIgniter framework updated
- Monitor security advisories
- Update dependencies regularly
- Review access logs

## 📞 Support

For technical support:
- **Email**: info@jacketstore.com
- **Documentation**: Check README.md and this guide
- **Issues**: Create an issue in the repository

## 🎯 Next Steps

After setup, consider:
1. **Customizing the theme** - Modify CSS and layouts
2. **Adding more products** - Populate your inventory
3. **Setting up payment methods** - Integrate payment gateways
4. **Email marketing** - Newsletter signup and automation
5. **Social media integration** - Connect social platforms
6. **Performance monitoring** - Set up monitoring tools

---

**🎉 Congratulations! Your Jacket Store is now ready to use.**

**Admin Access**: `/admin/login` (admin/chor)
**Frontend**: `/` (homepage)

For any questions or issues, refer to this guide or contact support.
