# Expense Tracker - Laravel 12 Application

A professional, responsive expense tracking web application built with Laravel 12, MySQL, Bootstrap 5, and Chart.js.

## Features

### 🔐 Authentication
- User Registration
- Login/Logout
- Password Management
- Profile Management

### 📊 Dashboard
- Total Income, Expenses, and Savings Summary
- Current Month Expenses
- Category-wise Expense Pie Chart
- Monthly Expense Trend Line Chart
- Recent Transactions List

### 💰 Expense Management
- Add, Edit, Delete Expenses
- Search Expenses
- Filter by Category
- Filter by Date Range
- Pagination

### 💵 Income Management
- Add, Edit, Delete Income
- Track Income Sources
- View Income History

### 🏷️ Category Management
- 8 Default Categories (Food, Travel, Fuel, Shopping, Bills, Entertainment, Health, Other)
- Add Custom Categories
- Edit/Delete Categories
- Color-coded Categories with Icons

### 🎯 Budget Tracking
- Create Monthly Budgets per Category
- Track Budget Usage with Progress Bars
- Visual Warnings for Budget Limits
- Budget vs Actual Spending

### 📈 Reports
- Monthly Expense Reports
- Category-wise Reports
- Export to CSV
- Financial Summaries

### 🎨 UI/UX Features
- Professional Fintech Design
- Responsive Layout (Mobile, Tablet, Desktop)
- Dark Mode Support
- Bootstrap 5 Components
- Interactive Charts (Chart.js)
- Sidebar Navigation
- Clean and Modern Interface

## Technology Stack

- **Backend**: Laravel 12
- **Database**: MySQL
- **Frontend**: Bootstrap 5, Chart.js
- **PHP Version**: 8.2+
- **Authentication**: Laravel Built-in Auth

## Installation Guide

### Prerequisites

- PHP 8.2 or higher
- MySQL 5.7 or higher
- Composer
- XAMPP/WAMP/LAMP (or any PHP development environment)

### Step 1: Clone or Download

Download the project to your local machine and place it in your web server directory:
```
c:/xampp/htdocs/expense
```

### Step 2: Install Dependencies

Open terminal/command prompt in the project directory and run:

```bash
composer install
```

If you don't have Composer installed globally, download it from https://getcomposer.org/

### Step 3: Environment Configuration

1. Copy `.env.example` to `.env`:
```bash
copy .env.example .env
```

2. Generate application key:
```bash
php artisan key:generate
```

3. Configure database in `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=expense_tracker
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4: Create Database

1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Create a new database named `expense_tracker`
3. Or use MySQL command:
```sql
CREATE DATABASE expense_tracker;
```

### Step 5: Run Migrations

Run database migrations to create tables:

```bash
php artisan migrate
```

### Step 6: Seed Default Data (Optional)

Seed default categories:

```bash
php artisan db:seed
```

### Step 7: Start Development Server

Start the Laravel development server:

```bash
php artisan serve
```

The application will be available at: http://localhost:8000

### Alternative: Using XAMPP

If using XAMPP without `php artisan serve`:

1. Place project in `c:/xampp/htdocs/expense`
2. Access via: http://localhost/expense/public
3. Or configure virtual host for cleaner URL

## Default Login Credentials

After registration, you can create your own account. There are no default credentials.

## Project Structure

```
expense/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AuthController.php
│   │       ├── DashboardController.php
│   │       ├── ExpenseController.php
│   │       ├── IncomeController.php
│   │       ├── CategoryController.php
│   │       ├── BudgetController.php
│   │       └── ReportController.php
│   └── Models/
│       ├── User.php
│       ├── Expense.php
│       ├── Income.php
│       ├── Category.php
│       └── Budget.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── layouts/
│       ├── auth/
│       ├── dashboard/
│       ├── expenses/
│       ├── income/
│       ├── categories/
│       ├── budgets/
│       └── reports/
├── routes/
│   └── web.php
└── public/
    └── index.php
```

## Usage Guide

### 1. Register an Account
- Navigate to the registration page
- Fill in your details
- Default categories will be created automatically

### 2. Add Expenses
- Go to Expenses → Add Expense
- Select category, enter amount, merchant, date, and notes
- Submit to save

### 3. Add Income
- Go to Income → Add Income
- Enter amount, source, date, and notes
- Submit to save

### 4. Set Budgets
- Go to Budgets
- Select month and year
- Create budget for each category
- Track spending against budget

### 5. View Reports
- Go to Reports
- Select month and year
- View category-wise breakdown
- Export to CSV for external analysis

### 6. Manage Categories
- Go to Categories
- Add custom categories with icons and colors
- Edit or delete existing categories

## Security Features

- CSRF Protection
- Password Hashing (bcrypt)
- SQL Injection Prevention (Eloquent ORM)
- XSS Protection
- Input Validation
- Authentication Middleware

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

## Troubleshooting

### Issue: "Class not found" errors
**Solution**: Run `composer dump-autoload`

### Issue: Database connection error
**Solution**: Check `.env` database credentials and ensure MySQL is running

### Issue: Permission denied errors
**Solution**: Set proper permissions on storage and bootstrap/cache:
```bash
chmod -R 775 storage bootstrap/cache
```

### Issue: 404 errors on routes
**Solution**: Ensure `.htaccess` exists in public folder or use `php artisan serve`

## Contributing

This is a demonstration project. Feel free to fork and modify for your needs.

## License

This project is open-source and available under the MIT License.

## Support

For issues or questions, please create an issue in the repository.

## Credits

- **Framework**: Laravel 12
- **UI Framework**: Bootstrap 5
- **Charts**: Chart.js
- **Icons**: Bootstrap Icons

---

**Developed with ❤️ using Laravel**

Last Updated: June 2026