# Setup Without Composer Installed

Since Composer is not installed on your system, here are your options:

## Option 1: Install Composer (Recommended)

### Download and Install Composer:

1. Go to: https://getcomposer.org/download/
2. Download **Composer-Setup.exe** for Windows
3. Run the installer
4. Follow the installation wizard
5. Restart Command Prompt
6. Then run: `composer install`

---

## Option 2: Use PHP to Download Composer

Run these commands in your project folder:

```bash
cd C:\xampp\htdocs\expense

C:\xampp\php\php.exe -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

C:\xampp\php\php.exe composer-setup.php

C:\xampp\php\php.exe -r "unlink('composer-setup.php');"

C:\xampp\php\php.exe composer.phar install
```

---

## Option 3: Manual Setup (Without Composer Dependencies)

Since this is a Laravel application, it **requires** Composer to install dependencies. However, I can help you install Composer quickly.

### Quick Composer Installation:

**Step 1:** Download Composer
- Open browser: https://getcomposer.org/Composer-Setup.exe
- Run the downloaded file
- Click "Next" through the installer
- It will automatically detect PHP in XAMPP

**Step 2:** Restart Command Prompt
- Close current CMD window
- Open new CMD window

**Step 3:** Test Composer
```bash
composer --version
```

You should see: `Composer version 2.x.x`

**Step 4:** Now install dependencies
```bash
cd C:\xampp\htdocs\expense
composer install
```

---

## Why Composer is Required?

Laravel needs these packages:
- Laravel Framework
- Database drivers
- Security libraries
- Routing system
- Template engine

Without Composer, the application cannot run.

---

## After Installing Composer

Continue with these commands:

```bash
# 1. Install dependencies
composer install

# 2. Setup environment
copy .env.example .env
php artisan key:generate

# 3. Create database in phpMyAdmin
# Database name: expense_tracker

# 4. Run migrations
php artisan migrate
php artisan db:seed

# 5. Start server
php artisan serve
```

Then open: http://localhost:8000

---

## Alternative: Use XAMPP PHP Path

If you can't install Composer globally, use full paths:

```bash
cd C:\xampp\htdocs\expense

# Download Composer
C:\xampp\php\php.exe -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
C:\xampp\php\php.exe composer-setup.php

# Install dependencies
C:\xampp\php\php.exe composer.phar install

# Setup
copy .env.example .env
C:\xampp\php\php.exe artisan key:generate

# Migrate
C:\xampp\php\php.exe artisan migrate
C:\xampp\php\php.exe artisan db:seed

# Start
C:\xampp\php\php.exe artisan serve
```

---

## Need Help?

**Easiest Solution:** Just install Composer from https://getcomposer.org/Composer-Setup.exe

It takes 2 minutes and makes everything work smoothly!