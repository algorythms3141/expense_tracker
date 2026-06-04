# 🚀 Shared Hosting Deployment Guide

## Deploy Laravel Expense Tracker to Shared Hosting (cPanel)

This guide will help you deploy your Laravel application to any shared hosting provider with cPanel.

---

## 📋 Prerequisites

Your hosting must have:
- ✅ PHP 8.2 or higher
- ✅ MySQL database
- ✅ Composer (or SSH access)
- ✅ cPanel access
- ✅ File Manager or FTP access

---

## 🎯 Step-by-Step Deployment

### Step 1: Prepare Your Application

1. **Optimize for Production**

```bash
# In your local project
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

2. **Create a ZIP file**

Compress your entire project folder into `expense-tracker.zip`

---

### Step 2: Upload to Shared Hosting

#### Option A: Using cPanel File Manager

1. Login to cPanel
2. Open **File Manager**
3. Navigate to your home directory (usually `/home/username/`)
4. Create a folder: `laravel` (outside public_html)
5. Upload `expense-tracker.zip` to `/home/username/laravel/`
6. Extract the ZIP file
7. Delete the ZIP file after extraction

#### Option B: Using FTP

1. Connect via FTP (FileZilla, WinSCP, etc.)
2. Upload all files to `/home/username/laravel/`

---

### Step 3: Move Public Folder

1. In File Manager, go to `/home/username/laravel/public/`
2. **Select all files** in the public folder
3. **Move** (not copy) them to `/home/username/public_html/`
4. Delete the empty `public` folder

---

### Step 4: Update index.php

1. Open `/home/username/public_html/index.php`
2. Find these lines:

```php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
```

3. Change to:

```php
require __DIR__.'/../laravel/vendor/autoload.php';
$app = require_once __DIR__.'/../laravel/bootstrap/app.php';
```

4. Save the file

---

### Step 5: Create Database

1. In cPanel, open **MySQL Databases**
2. Create a new database: `username_expense`
3. Create a new user: `username_expuser`
4. Set a strong password
5. Add user to database with **ALL PRIVILEGES**
6. Note down:
   - Database name
   - Database user
   - Database password
   - Database host (usually `localhost`)

---

### Step 6: Configure Environment

1. Go to `/home/username/laravel/`
2. Rename `.env.example` to `.env`
3. Edit `.env` file:

```env
APP_NAME="Expense Tracker"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=username_expense
DB_USERNAME=username_expuser
DB_PASSWORD=your_database_password

SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

4. Save the file

---

### Step 7: Generate Application Key

#### Option A: Using Terminal (SSH)

```bash
cd /home/username/laravel
php artisan key:generate
```

#### Option B: Without SSH

1. Go to: https://generate-random.org/laravel-key-generator
2. Generate a key
3. Copy the key (e.g., `base64:xxxxxxxxxxxxx`)
4. Edit `.env` and paste:
   ```
   APP_KEY=base64:xxxxxxxxxxxxx
   ```

---

### Step 8: Set Permissions

Using File Manager, set these permissions:

```
/home/username/laravel/storage/          → 755
/home/username/laravel/storage/logs/     → 755
/home/username/laravel/storage/framework/→ 755
/home/username/laravel/bootstrap/cache/  → 755
```

**Right-click folder → Change Permissions → Set to 755**

---

### Step 9: Run Migrations

#### Option A: Using Terminal (SSH)

```bash
cd /home/username/laravel
php artisan migrate --force
php artisan db:seed --force
```

#### Option B: Using PHP Script (No SSH)

1. Create file: `/home/username/public_html/install.php`

```php
<?php
// Temporary installation script - DELETE AFTER USE!
require __DIR__.'/../laravel/vendor/autoload.php';
$app = require_once __DIR__.'/../laravel/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "<h2>Running Migrations...</h2>";
$kernel->call('migrate', ['--force' => true]);
echo "<p>✅ Migrations completed!</p>";

echo "<h2>Seeding Database...</h2>";
$kernel->call('db:seed', ['--force' => true]);
echo "<p>✅ Seeding completed!</p>";

echo "<h2>✅ Installation Complete!</h2>";
echo "<p><strong>IMPORTANT: Delete this file immediately!</strong></p>";
echo "<p><a href='/'>Go to Application</a></p>";
?>
```

2. Visit: `https://yourdomain.com/install.php`
3. **DELETE `install.php` immediately after use!**

---

### Step 10: Configure .htaccess

1. Check `/home/username/public_html/.htaccess` exists
2. If not, create it with this content:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

---

### Step 11: SSL Certificate (Optional but Recommended)

1. In cPanel, go to **SSL/TLS Status**
2. Enable **AutoSSL** for your domain
3. Wait for certificate to be issued
4. Update `.env`:
   ```
   APP_URL=https://yourdomain.com
   ```

---

## 🔒 Security Checklist

After deployment:

- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Delete `install.php` if you created it
- [ ] Ensure `.env` is not publicly accessible
- [ ] Enable SSL certificate
- [ ] Set strong database password
- [ ] Test all features

---

## 🧪 Testing Your Deployment

Visit your domain: `https://yourdomain.com`

You should see the login page. Test:

1. ✅ Register a new account
2. ✅ Login successfully
3. ✅ View dashboard
4. ✅ Add expense
5. ✅ Add income
6. ✅ Create budget
7. ✅ View reports
8. ✅ Export CSV

---

## 🐛 Troubleshooting

### Issue: 500 Internal Server Error

**Solution:**
1. Check `.env` file exists and is configured correctly
2. Check file permissions (755 for folders, 644 for files)
3. Check `APP_KEY` is set
4. Enable error display temporarily:
   ```env
   APP_DEBUG=true
   ```
5. Check error logs in cPanel

### Issue: Database Connection Error

**Solution:**
1. Verify database credentials in `.env`
2. Ensure database user has all privileges
3. Check if database host is `localhost` or IP address
4. Test database connection in cPanel → phpMyAdmin

### Issue: CSS/JS Not Loading

**Solution:**
1. Check `APP_URL` in `.env` matches your domain
2. Clear browser cache (Ctrl + F5)
3. Check if files exist in `public_html/css/` and `public_html/js/`

### Issue: Routes Not Working

**Solution:**
1. Check `.htaccess` file exists in `public_html/`
2. Ensure mod_rewrite is enabled (contact hosting support)
3. Clear route cache:
   ```bash
   php artisan route:clear
   ```

---

## 📞 Need Help?

If you encounter issues:

1. Check cPanel error logs
2. Enable `APP_DEBUG=true` temporarily
3. Check Laravel logs: `/home/username/laravel/storage/logs/laravel.log`
4. Contact your hosting provider for:
   - PHP version
   - mod_rewrite status
   - File permission issues

---

## 🎉 Deployment Complete!

Your Expense Tracker is now live and accessible to users worldwide!

**Remember to:**
- Keep your `.env` file secure
- Regularly backup your database
- Monitor error logs
- Update Laravel and dependencies periodically

---

## 📁 Final Directory Structure

```
/home/username/
├── laravel/                    (Laravel application)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   └── .env
└── public_html/               (Public files)
    ├── css/
    ├── js/
    ├── index.php
    └── .htaccess
```

---

**🚀 Your application is now live and ready to use!**