# Jacket Store - Premium Online Jacket Store

A comprehensive e-commerce website for selling premium quality jackets and outerwear, built with CodeIgniter 4 and featuring a modern admin dashboard.

## Features

### 🛍️ E-commerce Features
- **Product Management**: Add, edit, and manage jackets with categories
- **Category Management**: Hierarchical category system with SEO optimization
- **Shopping Cart**: Add to cart functionality
- **Order Management**: Cash on delivery and inquiry-based orders
- **Inventory Management**: Stock tracking and management

### 🎨 Frontend Features
- **Responsive Design**: Based on Molla theme (index-15.html)
- **SEO Optimized**: Meta tags, Open Graph, Twitter Cards, Schema markup
- **Fast Loading**: Optimized assets and preloading
- **WhatsApp Integration**: Floating WhatsApp button for customer support

### 🔧 Admin Dashboard
- **User Authentication**: Secure admin login (username: admin, password: chor)
- **Dashboard Analytics**: Sales statistics and recent activity
- **Content Management**: CMS for static pages, blog, and FAQs
- **Settings Management**: Site configuration, social media, analytics
- **Order Processing**: Order status management and tracking

### 📱 SEO & Performance
- **Meta Tags**: Complete SEO meta information
- **Open Graph**: Social media sharing optimization
- **Schema Markup**: Structured data for search engines
- **Google Analytics**: Built-in analytics integration
- **Facebook Pixel**: Conversion tracking support
- **Canonical URLs**: Duplicate content prevention
- **Performance Optimization**: Asset preloading and optimization

## Requirements

- PHP 8.0 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- XAMPP/WAMP/MAMP (for local development)

## Installation

### 1. Clone or Download
```bash
git clone [repository-url]
cd jacket
```

### 2. Database Setup
Run the database setup script to create all tables and seed initial data:

```bash
php setup_database.php
```

This script will:
- Create the `jacket_store` database
- Create all necessary tables
- Insert admin user (admin/chor)
- Seed sample data (categories, pages, settings)

### 3. Configuration
Update the database configuration in `app/Config/Database.php` if needed:

```php
'hostname' => 'localhost',
'username' => 'root',
'password' => '',
'database' => 'jacket_store',
```

### 4. Web Server Configuration
Ensure your web server points to the `public` directory as the document root.

### 5. Access the Application
- **Frontend**: `http://localhost/jacket/`
- **Admin Panel**: `http://localhost/jacket/admin/login`

## Admin Access

- **Username**: `admin`
- **Password**: `chor`
- **URL**: `/admin/login`

## Database Structure

### Core Tables
- `users` - User management and authentication
- `categories` - Product categories with SEO fields
- `products` - Product information and inventory
- `product_images` - Product image management
- `orders` - Customer orders and shipping
- `order_items` - Individual order items
- `pages` - CMS pages (static, blog, FAQ)
- `settings` - Site configuration and settings

### SEO Features
- Meta titles, descriptions, and keywords
- Open Graph and Twitter Card support
- Schema.org structured data
- Canonical URLs
- Social media integration

## File Structure

```
jacket/
├── app/
│   ├── Controllers/
│   │   ├── Admin/          # Admin controllers
│   │   └── BaseController.php
│   ├── Models/             # Database models
│   ├── Views/
│   │   ├── admin/          # Admin views
│   │   ├── layouts/        # Base layout
│   │   └── partials/       # Reusable components
│   └── Database/
│       ├── Migrations/     # Database migrations
│       └── Seeds/          # Data seeders
├── html/                   # Theme assets (index-15.html)
├── public/                 # Web root
├── setup_database.php      # Database setup script
└── README.md
```

## Customization

### Adding New Products
1. Login to admin panel
2. Navigate to Products section
3. Add new product with SEO information
4. Upload product images
5. Set pricing and inventory

### Managing Content
1. Access Pages section in admin
2. Edit static pages (About, Contact, etc.)
3. Update SEO meta information
4. Manage blog posts and FAQs

### Site Settings
1. Go to Settings section
2. Update contact information
3. Configure social media links
4. Set Google Analytics and Facebook Pixel IDs
5. Update WhatsApp number

## SEO Best Practices

- **Meta Tags**: Every page has optimized meta titles and descriptions
- **Structured Data**: Schema.org markup for better search engine understanding
- **Social Media**: Open Graph and Twitter Card optimization
- **Performance**: Asset optimization and preloading
- **Mobile**: Responsive design for mobile-first indexing

## Performance Features

- **Asset Preloading**: Critical CSS and JS files
- **Optimized Images**: Proper image sizing and formats
- **Minified CSS/JS**: Reduced file sizes
- **Caching**: Database query optimization
- **CDN Ready**: Easy integration with content delivery networks

## Security Features

- **Password Hashing**: Secure password storage
- **Session Management**: Secure admin sessions
- **Input Validation**: Form validation and sanitization
- **SQL Injection Protection**: Prepared statements
- **XSS Protection**: Output escaping

## Support

For support and questions:
- **Email**: info@jacketstore.com
- **Phone**: +92 300 1234567
- **Address**: 123 Main Street, Karachi, Pakistan

## License

This project is licensed under the MIT License.

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

---

**Built with ❤️ using CodeIgniter 4**
