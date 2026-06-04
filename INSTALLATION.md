# Expense Tracker - Detailed Installation Guide

This guide will walk you through the complete installation process of the Expense Tracker application.

## Prerequisites

Before you begin, ensure you have the following installed:

1. **XAMPP** (or WAMP/LAMP)
   - Download from: https://www.apachefriends.org/
   - Includes PHP 8.2+ and MySQL

2. **Composer** (PHP Dependency Manager)
   - Download from: https://getcomposer.org/download/
   - Install globally on your system

## Step-by-Step Installation

### Step 1: Download the Project

1. Download or clone the project
2. Extract to: `C:\xampp\htdocs\expense`

### Step 2: Install Composer Dependencies

1. Open Command Prompt or PowerShell
2. Navigate to project directory:
   ```bash
   cd C:\xampp\htdocs\expense
   ```

3. Install dependencies:
   ```bash
   composer install
   ```

   **Note**: If you get "composer not found" error:
   - Add Composer to your system PATH, or
   - Use full path: `C:\ProgramData\ComposerSetup\bin\composer.phar install`

### Step 3: Configure Environment

1. Copy the environment file:
   ```bash
   copy .env.example .env
   ```

2. Generate application key:
   ```bash
   php artisan key:generate
   ```

3. Open `.env` file in a text editor and configure:
   ```env
   APP_NAME="Expense Tracker"
   APP_URL=http://localhost:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=expense_tracker
   DB_USERNAME=root
   DB_PASSWORD=
   ```

### Step 4: Create Database

**Option A: Using phpMyAdmin**
1. Start XAMPP Control Panel
2. Start Apache and MySQL services
3. Open browser and go to: http://localhost/phpmyadmin
4. Click "New" in the left sidebar
5. Database name: `expense_tracker`
6. Collation: `utf8mb4_unicode_ci`
7. Click "Create"

**Option B: Using MySQL Command Line**
1. Open Command Prompt
2. Navigate to MySQL bin:
   ```bash
   cd C:\xampp\mysql\bin
   ```
3. Login to MySQL:
   ```bash
   mysql -u root -p
   ```
4. Create database:
   ```sql
   CREATE DATABASE expense_tracker;
   EXIT;
   ```

### Step 5: Run Database Migrations

1. In project directory, run:
   ```bash
   php artisan migrate
   ```

   This will create all necessary tables:
   - users
   - password_reset_tokens
   - sessions
   - categories
   - expenses
   - income
   - budgets

2. If successful, you'll see:
   ```
   Migration table created successfully.
   Migrating: 2024_01_01_000000_create_users_table
   Migrated:  2024_01_01_000000_create_users_table
   ...
   ```

### Step 6: Seed Default Data (Optional)

To add default categories:
```bash
php artisan db:seed
```

This creates 8 default categories:
- 🍔 Food
- ✈️ Travel
- ⛽ Fuel
- 🛍️ Shopping
- 📄 Bills
- 🎬 Entertainment
- 🏥 Health
- 📦 Other

### Step 7: Set Storage Permissions (If needed)

On Windows, this is usually not required. On Linux/Mac:
```bash
chmod -R 775 storage bootstrap/cache
```

### Step 8: Start the Application

**Option A: Using Laravel Development Server (Recommended)**
```bash
php artisan serve
```

Access at: http://localhost:8000

**Option B: Using XAMPP**
1. Ensure Apache is running in XAMPP
2. Access at: http://localhost/expense/public

**Option C: Configure Virtual Host (Advanced)**

Edit `C:\xampp\apache\conf\extra\httpd-vhosts.conf`:
```apache
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/expense/public"
    ServerName expense.local
    <Directory "C:/xampp/htdocs/expense/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Edit `C:\Windows\System32\drivers\etc\hosts`:
```
127.0.0.1 expense.local
```

Restart Apache and access at: http://expense.local

## First Time Setup

### 1. Register Your Account

1. Open the application in your browser
2. Click "Sign up" or "Register"
3. Fill in:
   - Full Name
   - Email Address
   - Password (minimum 8 characters)
   - Confirm Password
4. Click "Create Account"

Default categories will be automatically created for your account.

### 2. Explore the Dashboard

After registration, you'll be redirected to the dashboard showing:
- Summary cards (Income, Expenses, Savings)
- Charts (Category-wise and Monthly trends)
- Recent transactions

### 3. Add Your First Expense

1. Click "Expenses" in the sidebar
2. Click "Add Expense"
3. Fill in the form:
   - Select Category
   - Enter Amount
   - Enter Merchant (optional)
   - Select Date
   - Add Notes (optional)
4. Click "Save Expense"

### 4. Add Your First Income

1. Click "Income" in the sidebar
2. Click "Add Income"
3. Fill in:
   - Amount
   - Source (e.g., Salary, Freelance)
   - Date
   - Notes (optional)
4. Click "Save Income"

### 5. Set Up Budgets

1. Click "Budgets" in the sidebar
2. Select Month and Year
3. Click "Add Budget"
4. Choose Category and set Budget Amount
5. Track your spending against the budget

## Troubleshooting

### Problem: "Class not found" errors

**Solution**:
```bash
composer dump-autoload
```

### Problem: Database connection failed

**Solutions**:
1. Check if MySQL is running in XAMPP
2. Verify database credentials in `.env`
3. Ensure database `expense_tracker` exists
4. Test connection:
   ```bash
   php artisan migrate:status
   ```

### Problem: "Key not found" error

**Solution**:
```bash
php artisan key:generate
```

### Problem: 404 errors on all routes

**Solutions**:
1. If using `php artisan serve`, ensure it's running
2. If using XAMPP, check `.htaccess` exists in `public` folder
3. Enable mod_rewrite in Apache

### Problem: Permission denied errors

**Solution** (Linux/Mac):
```bash
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

### Problem: Blank page or 500 error

**Solutions**:
1. Check `storage/logs/laravel.log` for errors
2. Enable debug mode in `.env`:
   ```env
   APP_DEBUG=true
   ```
3. Clear cache:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```

### Problem: Charts not displaying

**Solution**:
Ensure you have internet connection as Chart.js is loaded from CDN.

## Updating the Application

To update dependencies:
```bash
composer update
```

To clear all caches:
```bash
php artisan optimize:clear
```

## Backup Your Data

### Export Database
```bash
cd C:\xampp\mysql\bin
mysqldump -u root expense_tracker > backup.sql
```

### Import Database
```bash
mysql -u root expense_tracker < backup.sql
```

## Production Deployment

For production deployment:

1. Set environment to production in `.env`:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   ```

2. Optimize application:
   ```bash
   composer install --optimize-autoloader --no-dev
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

3. Set proper permissions
4. Use HTTPS
5. Configure proper database credentials
6. Set up regular backups

## Support

If you encounter any issues:

1. Check the error logs: `storage/logs/laravel.log`
2. Review this installation guide
3. Check Laravel documentation: https://laravel.com/docs
4. Verify all prerequisites are installed correctly

## Next Steps

After successful installation:

1. ✅ Customize categories for your needs
2. ✅ Set monthly budgets
3. ✅ Start tracking expenses and income
4. ✅ Generate reports
5. ✅ Enable dark mode for comfortable viewing

---

**Installation Complete!** 🎉

You're now ready to track your expenses efficiently.