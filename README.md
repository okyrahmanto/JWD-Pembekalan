# 🏪 UMKM Product Management System

A comprehensive web-based product management system designed for Small and Medium Enterprises (UMKM) with dual storage support (MySQL + JSON) and advanced analytics.

## 📋 Table of Contents

- [Features](#-features)
- [Technology Stack](#-technology-stack)
- [Project Structure](#-project-structure)
- [Installation](#-installation)
- [Database Setup](#-database-setup)
- [Configuration](#-configuration)
- [Usage](#-usage)
- [API Routes](#-api-routes)
- [Features Overview](#-features-overview)
- [Troubleshooting](#-troubleshooting)
- [Contributing](#-contributing)
- [License](#-license)

## ✨ Features

### 🛍️ **Product Management**
- **CRUD Operations**: Create, Read, Update, Delete products
- **Dual Storage**: MySQL database with JSON backup
- **Real-time Statistics**: Product counts, stock levels, total values
- **Category Management**: Organize products by categories
- **Price & Stock Tracking**: Monitor inventory and pricing

### 📊 **Analytics & Reporting**
- **Interactive Charts**: Stock levels, product values, category distribution
- **Dashboard**: Real-time statistics and insights
- **Data Visualization**: Multiple chart types (Bar, Line, Doughnut)
- **Export Capabilities**: Data export functionality

### 🎨 **User Interface**
- **Responsive Design**: Works on desktop, tablet, and mobile
- **Bootstrap 5**: Modern, clean interface
- **Loading States**: User-friendly loading indicators
- **Form Validation**: Client-side and server-side validation
- **Modal Dialogs**: Clean form interfaces

### 🔧 **Technical Features**
- **Routing System**: Clean URL structure
- **Error Handling**: Graceful fallbacks and error recovery
- **Performance**: Database indexing and optimized queries
- **Security**: SQL injection prevention with prepared statements
- **PSR-12 Compliance**: Follows PHP coding standards

## 🛠️ Technology Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+ / MariaDB 10.2+
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **UI Framework**: Bootstrap 5.3.7
- **Charts**: Chart.js 3.x
- **Storage**: MySQL + JSON (dual storage)

## 📁 Project Structure

```
umkm/
├── assets/
│   ├── css/
│   │   └── csslist.css          # Custom styles and animations
│   └── js/
│       ├── scriptlist.js        # Product list functionality
│       └── scriptchart.js       # Chart initialization
├── config/
│   ├── database.php             # Database configuration
│   ├── dbloader.php             # Database manager class
│   ├── jsonloader.php           # JSON file operations
│   └── test_db.php              # Database connection test
├── database/
│   └── setup.sql                # Database schema and sample data
├── produk/
│   ├── add.php                  # Add product handler
│   ├── update.php               # Update product handler
│   ├── list.php                 # Product listing page
│   ├── chart.php                # Analytics dashboard
│   ├── products.json            # JSON backup storage
│   └── proses.php               # Additional processing
├── index.php                    # Main routing controller
└── README.md                    # This file
```

## 🚀 Installation

### Prerequisites

- **Web Server**: Apache/Nginx with PHP support
- **PHP**: 7.4 or higher
- **MySQL**: 5.7 or higher / MariaDB 10.2 or higher
- **PHP Extensions**: PDO, PDO_MySQL, JSON

### Step 1: Clone/Download Project

```bash
# Clone the repository
git clone <repository-url>
cd umkm

# Or download and extract the ZIP file
```

### Step 2: Web Server Setup

1. **Apache Configuration** (if using .htaccess):
   ```apache
   RewriteEngine On
   RewriteCond %{REQUEST_FILENAME} !-f
   RewriteCond %{REQUEST_FILENAME} !-d
   RewriteRule ^(.*)$ index.php/$1 [L]
   ```

2. **Nginx Configuration**:
   ```nginx
   location / {
       try_files $uri $uri/ /index.php?$query_string;
   }
   ```

### Step 3: File Permissions

```bash
# Set proper permissions for JSON file
chmod 644 produk/products.json
chmod 755 produk/
```

## 🗄️ Database Setup

### Option 1: Using SQL File (Recommended)

1. **Create Database**:
   ```sql
   CREATE DATABASE umkm_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. **Import Schema**:
   ```bash
   mysql -u your_username -p umkm_db < database/setup.sql
   ```

### Option 2: Manual Setup

1. **Create Database**:
   ```sql
   CREATE DATABASE umkm_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   USE umkm_db;
   ```

2. **Create Table**:
   ```sql
   CREATE TABLE products (
       id BIGINT PRIMARY KEY,
       name VARCHAR(255) NOT NULL,
       category VARCHAR(255) NOT NULL,
       price DECIMAL(10,2) NOT NULL,
       stock INT NOT NULL,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
   ```

3. **Create Indexes**:
   ```sql
   CREATE INDEX idx_products_category ON products(category);
   CREATE INDEX idx_products_created_at ON products(created_at);
   ```

## ⚙️ Configuration

### Database Configuration

Edit `config/database.php`:

```php
// Database configuration
define('DB_HOST', 'localhost');        // Database host
define('DB_NAME', 'umkm_db');          // Database name
define('DB_USER', 'your_username');    // Database username
define('DB_PASS', 'your_password');    // Database password
```

### Testing Configuration

1. **Test Database Connection**:
   ```
   http://your-domain.com/config/test_db.php
   ```

2. **Expected Output**:
   ```
   ✅ Database connection successful!
   ✅ Database tables initialized successfully!
   ✅ ProductManager loaded X products
   ✅ Statistics generated successfully!
   ```

## 📖 Usage

### Accessing the Application

- **Main Application**: `http://your-domain.com/`
- **Product List**: `http://your-domain.com/index.php/list`
- **Add Product**: `http://your-domain.com/index.php/add`
- **Analytics**: `http://your-domain.com/index.php/chart`

### Adding Products

1. Navigate to the product list page
2. Click "Tambah" button
3. Fill in the product details:
   - **Name**: Product name
   - **Category**: Product category
   - **Price**: Product price (numeric)
   - **Stock**: Available stock quantity
4. Click "Submit"

### Editing Products

1. In the product list, click "Edit" button
2. Modify the product details
3. Click "Update"

### Viewing Analytics

1. Click "Grafik" button from the product list
2. View multiple charts:
   - **Stock Chart**: Bar chart showing stock levels
   - **Value Chart**: Line chart showing total product values
   - **Category Chart**: Doughnut chart showing category distribution

## 🛣️ API Routes

| Route | Method | Description | Handler |
|-------|--------|-------------|---------|
| `/` | GET | Default redirect to list | `index.php` |
| `/list` | GET | Product listing page | `produk/list.php` |
| `/add` | POST | Add new product | `produk/add.php` |
| `/update` | POST | Update existing product | `produk/update.php` |
| `/chart` | GET | Analytics dashboard | `produk/chart.php` |

## 📊 Features Overview

### Product Management
- ✅ Create new products with validation
- ✅ Update existing product information
- ✅ Delete products (planned feature)
- ✅ View product statistics
- ✅ Category-based organization

### Data Storage
- ✅ MySQL database (primary storage)
- ✅ JSON file (backup storage)
- ✅ Automatic synchronization
- ✅ Error recovery and fallback

### Analytics & Reporting
- ✅ Real-time product statistics
- ✅ Interactive charts and graphs
- ✅ Category distribution analysis
- ✅ Stock level monitoring
- ✅ Total value calculations

### User Interface
- ✅ Responsive Bootstrap design
- ✅ Loading indicators and animations
- ✅ Form validation and error handling
- ✅ Modal dialogs for forms
- ✅ Clean and intuitive navigation

## 🔧 Troubleshooting

### PSR-12 Compliance

The project follows PSR-12 coding standards. To check compliance:

```bash
# Run the PSR-12 checker
php config/psr12_check.php

# Or visit in browser
http://your-domain.com/config/psr12_check.php?check=1
```

### Common Issues

#### 1. Database Connection Failed
**Error**: "Database connection failed"
**Solution**:
- Verify database credentials in `config/database.php`
- Ensure MySQL service is running
- Check database exists: `umkm_db`

#### 2. Permission Denied
**Error**: "Permission denied" for JSON file
**Solution**:
```bash
chmod 644 produk/products.json
chmod 755 produk/
```

#### 3. Charts Not Loading
**Error**: Charts don't display
**Solution**:
- Check browser console for JavaScript errors
- Ensure Chart.js is loaded properly
- Verify data is being passed to charts

#### 4. Routing Not Working
**Error**: 404 errors on routes
**Solution**:
- Enable URL rewriting in web server
- Check `.htaccess` file (Apache)
- Verify `mod_rewrite` is enabled

### Debug Mode

Enable debug mode by adding to `config/database.php`:

```php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### Log Files

Check web server error logs:
- **Apache**: `/var/log/apache2/error.log`
- **Nginx**: `/var/log/nginx/error.log`
- **XAMPP**: `xampp/apache/logs/error.log`

## 🤝 Contributing

1. **Fork** the repository
2. **Create** a feature branch (`git checkout -b feature/AmazingFeature`)
3. **Commit** your changes (`git commit -m 'Add some AmazingFeature'`)
4. **Push** to the branch (`git push origin feature/AmazingFeature`)
5. **Open** a Pull Request

### Development Guidelines

- Follow PSR-4 autoloading standards
- Use prepared statements for database queries
- Add proper error handling
- Include comments for complex logic
- Test thoroughly before submitting

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- **Bootstrap** for the responsive UI framework
- **Chart.js** for interactive data visualization
- **PHP PDO** for secure database operations
- **MySQL** for reliable data storage

## 📞 Support

For support and questions:

- **Email**: [your-email@domain.com]
- **Issues**: [GitHub Issues Page]
- **Documentation**: [Project Wiki]

---

**Made with ❤️ for UMKM businesses**

*Last updated: December 2024* 