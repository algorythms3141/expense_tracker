# Quick Start Guide - Run in 5 Minutes! 🚀

Follow these simple steps to run the Expense Tracker application.

## Prerequisites Check

Before starting, make sure you have:
- ✅ XAMPP installed (with PHP and MySQL)
- ✅ Composer installed

**Don't have them?**
- Download XAMPP: https://www.apachefriends.org/
- Download Composer: https://getcomposer.org/

---

## Step 1: Open XAMPP Control Panel

1. Open **XAMPP Control Panel**
2. Click **Start** for:
   - ✅ Apache
   - ✅ MySQL

Wait until both show "Running" status.

---

## Step 2: Open Command Prompt

1. Press `Windows + R`
2. Type `cmd` and press Enter
3. Navigate to project folder:

```bash
cd C:\xampp\htdocs\expense
```

---

## Step 3: Install Dependencies

Run this command:

```bash
composer install
```

**Wait for it to complete** (may take 2-3 minutes)

---

## Step 4: Setup Environment

Run these commands **one by one**:

```bash
copy .env.example .env
```

```bash
php artisan key:generate
```

---

## Step 5: Create Database

**Option A: Using phpMyAdmin (Easier)**

1. Open browser: http://localhost/phpmyadmin
2. Click **"New"** on the left
3. Database name: `expense_tracker`
4. Click **"Create"**

**Option B: Using Command Line**

```bash
cd C:\xampp\mysql\bin
mysql -u root -p
```

Then type:
```sql
CREATE DATABASE expense_tracker;
EXIT;
```

Go back to project folder:
```bash
cd C:\xampp\htdocs\expense
```

---

## Step 6: Setup Database Tables

Run this command:

```bash
php artisan migrate
```

You should see:
```
Migration table created successfully.
Migrating: 2024_01_01_000000_create_users_table
Migrated:  2024_01_01_000000_create_users_table
...
```

---

## Step 7: Add Default Categories (Optional)

Run this command:

```bash
php artisan db:seed
```

This adds 8 default categories (Food, Travel, etc.)

---

## Step 8: Start the Application

Run this command:

```bash
php artisan serve
```

You should see:
```
Starting Laravel development server: http://127.0.0.1:8000
```

**Keep this window open!**

---

## Step 9: Open in Browser

Open your browser and go to:

```
http://localhost:8000
```

or

```
http://127.0.0.1:8000
```

---

## Step 10: Register Your Account

1. Click **"Sign up"** or **"Register"**
2. Fill in:
   - Your Name
   - Email
   - Password (min 8 characters)
   - Confirm Password
3. Click **"Create Account"**

**Done!** 🎉 You're now on the Dashboard!

---

## What to Do Next?

### Add Your First Expense
1. Click **"Expenses"** in sidebar
2. Click **"Add Expense"**
3. Fill the form and save

### Add Your First Income
1. Click **"Income"** in sidebar
2. Click **"Add Income"**
3. Fill the form and save

### Set a Budget
1. Click **"Budgets"** in sidebar
2. Click **"Add Budget"**
3. Choose category and amount

### View Reports
1. Click **"Reports"** in sidebar
2. Select month/year
3. Export to CSV if needed

### Try Dark Mode
- Click the moon icon (🌙) in top right corner

---

## Common Issues & Solutions

### ❌ "composer not found"

**Solution:**
```bash
C:\ProgramData\ComposerSetup\bin\composer.phar install
```

Or add Composer to PATH and restart CMD.

---

### ❌ "php not found"

**Solution:**
Use full path:
```bash
C:\xampp\php\php.exe artisan serve
```

---

### ❌ Database connection error

**Solutions:**
1. Check MySQL is running in XAMPP
2. Check database name is `expense_tracker`
3. Open `.env` file and verify:
   ```
   DB_DATABASE=expense_tracker
   DB_USERNAME=root
   DB_PASSWORD=
   ```

---

### ❌ "Address already in use"

**Solution:**
Use different port:
```bash
php artisan serve --port=8001
```

Then open: http://localhost:8001

---

### ❌ Blank page or errors

**Solution:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## Stopping the Application

To stop the server:
1. Go to the Command Prompt window
2. Press `Ctrl + C`
3. Type `Y` and press Enter

---

## Running Again Later

Next time you want to use the app:

1. Start Apache & MySQL in XAMPP
2. Open CMD in project folder
3. Run: `php artisan serve`
4. Open: http://localhost:8000

---

## Need More Help?

- Check **INSTALLATION.md** for detailed guide
- Check **README.md** for features overview
- Check `storage/logs/laravel.log` for errors

---

## Summary of All Commands

```bash
# Navigate to project
cd C:\xampp\htdocs\expense

# Install dependencies
composer install

# Setup environment
copy .env.example .env
php artisan key:generate

# Setup database (after creating it in phpMyAdmin)
php artisan migrate
php artisan db:seed

# Start server
php artisan serve
```

**That's it!** Your Expense Tracker is now running! 🎉

Open http://localhost:8000 and start tracking your expenses!