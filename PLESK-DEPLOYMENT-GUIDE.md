# 🚀 Deploy Laravel Expense Tracker to Plesk Hosting

## Fix: "Default Plesk Page" Issue

You're seeing the default Plesk page because Laravel files need to be in a specific location.

---

## 📁 Plesk Directory Structure

Plesk uses a different structure than cPanel:

```
/var/www/vhosts/yourdomain.com/
├── httpdocs/          ← Public web root (like public_html)
├── httpsdocs/         ← SSL web root
├── private/           ← Private files (put Laravel here)
└── logs/
```

---

## 🎯 Correct Deployment Steps for Plesk

### Step 1: Upload Laravel Files

1. **Login to Plesk**
2. **Go to:** Files → File Manager
3. **Navigate to:** `/var/www/vhosts/expensetracker.algorythms.in/`
4. **Create folder:** `laravel` (at domain root level)
5. **Upload your project** to `/var/www/vhosts/expensetracker.algorythms.in/laravel/`

**OR via Git:**
```bash
cd /var/www/vhosts/expensetracker.algorythms.in/
git clone https://github.com/YOUR_USERNAME/expense-tracker-laravel.git laravel
```

---

### Step 2: Move Public Files to httpdocs

**Important:** Plesk uses `httpdocs` instead of `public_html`

1. **Go to:** `/var/www/vhosts/expensetracker.algorythms.in/laravel/public/`
2. **Select ALL files** (index.php, .htaccess, css/, js/)
3. **Copy** (not move) to `/var/www/vhosts/expensetracker.algorythms.in/httpdocs/`
4. **Delete default Plesk files** in httpdocs (index.html, etc.)

---

### Step 3: Update index.php Paths

1. **Open:** `/var/www/vhosts/expensetracker.algorythms.in/httpdocs/index.php`
2. **Find:**
   ```php
   require __DIR__.'/../vendor/autoload.php';
   $app = require_once __DIR__.'/../bootstrap/app.php';
   ```
3. **Change to:**
   ```php
   require __DIR__.'/../laravel/vendor/autoload.php';
   $app = require_once __DIR__.'/../laravel/bootstrap/app.php';
   ```
4. **Save**

---

### Step 4: Install Composer Dependencies

#### Option A: Via Plesk Terminal (Recommended)

1. **In Plesk:** Go to **Websites & Domains** → **Web Hosting Access**
2. **Enable SSH access**
3. **Connect via SSH:**
   ```bash
   ssh username@expensetracker.algorythms.in
   ```
4. **Install dependencies:**
   ```bash
   cd /var/www/vhosts/expensetracker.algorythms.in/laravel
   composer install --optimize-autoloader --no-dev
   ```

#### Option B: Via Plesk Composer Extension

1. **In Plesk:** Extensions → Composer
2. **Install Composer extension**
3. **Navigate to laravel folder**
4. **Click "Install"**

#### Option C: Upload vendor folder

1. On local computer, ZIP the `vendor` folder
2. Upload to `/var/www/vhosts/expensetracker.algorythms.in/laravel/`
3. Extract

---

### Step 5: Create Database

1. **In Plesk:** Databases → Add Database
2. **Database name:** `expense_tracker`
3. **Create user:** `expense_user`
4. **Set password:** (strong password)
5. **Note down:**
   - Database name: `expense_tracker`
   - Database user: `expense_user`
   - Database password: `your_password`
   - Database host: `localhost`

---

### Step 6: Configure .env File

1. **Navigate to:** `/var/www/vhosts/expensetracker.algorythms.in/laravel/`
2. **Copy template:**
   ```bash
   cp .env.example .env
   ```
3. **Edit .env:**
   ```env
   APP_NAME="Expense Tracker"
   APP_ENV=production
   APP_KEY=
   APP_DEBUG=false
   APP_URL=https://expensetracker.algorythms.in
   
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=expense_tracker
   DB_USERNAME=expense_user
   DB_PASSWORD=your_password_here
   
   SESSION_DRIVER=file
   QUEUE_CONNECTION=sync
   ```

---

### Step 7: Generate Application Key

#### Via SSH:
```bash
cd /var/www/vhosts/expensetracker.algorythms.in/laravel
php artisan key:generate
```

#### Without SSH:
1. Visit: https://generate-random.org/laravel-key-generator
2. Copy the key
3. Edit `.env` and add:
   ```env
   APP_KEY=base64:xxxxxxxxxxxxx
   ```

---

### Step 8: Set Correct Permissions

#### Via SSH:
```bash
cd /var/www/vhosts/expensetracker.algorythms.in/laravel

# Set storage permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Set ownership (replace with your Plesk user)
chown -R username:psacln storage
chown -R username:psacln bootstrap/cache
```

#### Via Plesk File Manager:
1. Right-click `storage` folder → Properties
2. Set permissions: **775**
3. Check "Apply to subdirectories"
4. Repeat for `bootstrap/cache`

---

### Step 9: Run Migrations

#### Option A: Via SSH
```bash
cd /var/www/vhosts/expensetracker.algorythms.in/laravel
php artisan migrate --force
php artisan db:seed --force
```

#### Option B: Create Install Script

Create: `/var/www/vhosts/expensetracker.algorythms.in/httpdocs/install.php`

```php
<?php
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
echo "<p><strong>DELETE THIS FILE NOW!</strong></p>";
echo "<p><a href='/'>Go to Application</a></p>";
?>
```

Visit: `https://expensetracker.algorythms.in/install.php`

**DELETE install.php immediately after!**

---

### Step 10: Configure .htaccess (If Needed)

Check if `/var/www/vhosts/expensetracker.algorythms.in/httpdocs/.htaccess` exists.

If not, create it:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

---

### Step 11: Enable SSL (Recommended)

1. **In Plesk:** Websites & Domains → SSL/TLS Certificates
2. **Install Let's Encrypt certificate** (free)
3. **Enable "Redirect from HTTP to HTTPS"**
4. **Update .env:**
   ```env
   APP_URL=https://expensetracker.algorythms.in
   ```

---

## 🎯 Final Directory Structure

```
/var/www/vhosts/expensetracker.algorythms.in/
├── laravel/                    ← Your Laravel application
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── resources/
│   ├── routes/
│   ├── storage/               ← 775 permissions
│   ├── vendor/
│   └── .env                   ← Created from .env.example
├── httpdocs/                  ← Public web root
│   ├── index.php             ← Updated paths
│   ├── .htaccess
│   ├── css/
│   └── js/
└── logs/
```

---

## ✅ Verification Checklist

- [ ] Laravel files in `/laravel/` folder
- [ ] Public files copied to `/httpdocs/`
- [ ] `index.php` paths updated
- [ ] Composer dependencies installed
- [ ] Database created in Plesk
- [ ] `.env` file created and configured
- [ ] `APP_KEY` generated
- [ ] Storage permissions set (775)
- [ ] Migrations run successfully
- [ ] Database seeded
- [ ] `.htaccess` file present
- [ ] SSL certificate installed
- [ ] `install.php` deleted (if created)

---

## 🐛 Troubleshooting

### Still Seeing Default Plesk Page?

**Check:**
1. Files are in `httpdocs` not `httpdocs/public`
2. `index.php` paths are correct
3. `.htaccess` file exists
4. Apache mod_rewrite is enabled

**Clear cache:**
```bash
cd /var/www/vhosts/expensetracker.algorythms.in/laravel
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 500 Internal Server Error?

**Check:**
1. Storage permissions (775)
2. `.env` file exists
3. `APP_KEY` is set
4. Database credentials are correct
5. Check error logs: `/var/www/vhosts/expensetracker.algorythms.in/logs/error_log`

### Database Connection Error?

**Verify:**
1. Database exists in Plesk
2. User has all privileges
3. Host is `localhost`
4. Port is `3306`
5. Credentials match `.env` file

---

## 🎉 Success!

Visit: **https://expensetracker.algorythms.in**

You should now see your Laravel Expense Tracker login page! 🚀

**Test all features:**
- ✅ Register account
- ✅ Login
- ✅ Dashboard with charts
- ✅ Add expenses
- ✅ Create budgets
- ✅ Generate reports

---

## 📞 Quick Commands Reference

```bash
# Navigate to Laravel
cd /var/www/vhosts/expensetracker.algorythms.in/laravel

# Clear all caches
php artisan optimize:clear

# Run migrations
php artisan migrate --force

# Seed database
php artisan db:seed --force

# Generate key
php artisan key:generate

# Check routes
php artisan route:list

# View logs
tail -f storage/logs/laravel.log
```

---

**Your Expense Tracker is now live on Plesk!** 🎊