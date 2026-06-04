# Fix: Database Connection Error ❌➡️✅

## The Error:
```
SQLSTATE[HY000] [2002] No connection could be made because the target machine actively refused it
```

This means MySQL is not running or database doesn't exist.

---

## 🔧 Quick Fix:

### Step 1: Start MySQL in XAMPP

1. Open **XAMPP Control Panel**
2. Find **MySQL** in the list
3. Click **Start** button next to MySQL
4. Wait until it shows "Running" (green highlight)

**Important:** Both Apache AND MySQL must be running!

---

### Step 2: Create Database

**Option A: Using phpMyAdmin (Easier)**

1. Make sure MySQL is running in XAMPP
2. Open browser: http://localhost/phpmyadmin
3. Click **"New"** on the left sidebar
4. Database name: `expense_tracker`
5. Collation: `utf8mb4_unicode_ci`
6. Click **"Create"**

**Option B: Using Command Line**

```bash
cd C:\xampp\mysql\bin
mysql -u root
```

Then type:
```sql
CREATE DATABASE expense_tracker;
SHOW DATABASES;
EXIT;
```

---

### Step 3: Verify .env Configuration

Open `.env` file and check:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=expense_tracker
DB_USERNAME=root
DB_PASSWORD=
```

**Important:** 
- `DB_PASSWORD=` should be empty (no password for XAMPP default)
- `DB_DATABASE=expense_tracker` must match the database you created

---

### Step 4: Clear Configuration Cache

Run these commands:

```bash
cd C:\xampp\htdocs\expense
php artisan config:clear
php artisan cache:clear
```

---

### Step 5: Run Migrations

Now try running migrations:

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

### Step 6: Seed Default Data

```bash
php artisan db:seed
```

---

### Step 7: Start Server

```bash
php artisan serve
```

Open: http://localhost:8000

---

## ✅ Checklist:

Before running the application:

- [ ] XAMPP Control Panel is open
- [ ] Apache is **Running** (green)
- [ ] MySQL is **Running** (green)
- [ ] Database `expense_tracker` exists in phpMyAdmin
- [ ] `.env` file has correct database credentials
- [ ] Migrations have been run successfully

---

## 🐛 Still Having Issues?

### Issue: MySQL won't start in XAMPP

**Solutions:**
1. Check if port 3306 is already in use
2. Click "Config" → "my.ini" and change port to 3307
3. Update `.env`: `DB_PORT=3307`
4. Restart MySQL

### Issue: "Access denied for user 'root'"

**Solution:**
Check if MySQL has a password:
1. Open phpMyAdmin
2. Go to "User accounts"
3. Check root user password
4. Update `.env`: `DB_PASSWORD=your_password`

### Issue: Database exists but still error

**Solution:**
```bash
php artisan config:clear
php artisan cache:clear
php artisan migrate:fresh
```

---

## 📋 Complete Setup Commands:

After MySQL is running and database is created:

```bash
# Navigate to project
cd C:\xampp\htdocs\expense

# Clear cache
php artisan config:clear
php artisan cache:clear

# Run migrations
php artisan migrate

# Seed default categories
php artisan db:seed

# Start server
php artisan serve
```

Then open: http://localhost:8000

---

## 🎯 Quick Summary:

**The Problem:** MySQL is not running or database doesn't exist

**The Solution:**
1. ✅ Start MySQL in XAMPP Control Panel
2. ✅ Create database `expense_tracker` in phpMyAdmin
3. ✅ Verify `.env` database settings
4. ✅ Run `php artisan migrate`
5. ✅ Run `php artisan db:seed`
6. ✅ Run `php artisan serve`

---

## 🖼️ Visual Guide:

### XAMPP Control Panel Should Look Like:
```
Apache  [Running] [Stop] [Admin] [Config] [Logs]
MySQL   [Running] [Stop] [Admin] [Config] [Logs]
```

Both should show **Running** status!

---

**After following these steps, your Expense Tracker will work perfectly!** 🎉