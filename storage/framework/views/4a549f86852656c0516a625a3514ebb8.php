<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Expense Tracker'); ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <style>
        :root {
            --sidebar-width: 250px;
            --top-navbar-height: 60px;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            padding-top: 0;
        }
        
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        
        /* Fixed Top Navbar */
        .top-fixed-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--top-navbar-height);
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1050;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }
        
        .app-logo {
            color: #667eea;
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .app-logo i {
            font-size: 1.8rem;
        }
        
        .mobile-menu-toggle {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #667eea;
            cursor: pointer;
            padding: 5px 10px;
            display: none;
        }
        
        .sidebar {
            position: fixed;
            top: var(--top-navbar-height);
            left: 0;
            height: calc(100vh - var(--top-navbar-height));
            width: var(--sidebar-width);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px 0;
            transition: all 0.3s;
            z-index: 1000;
            overflow-y: auto;
        }
        
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        
        .sidebar .nav-link i {
            font-size: 1.2rem;
            width: 24px;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--top-navbar-height);
            min-height: calc(100vh - var(--top-navbar-height));
            background: white;
        }
        
        .top-navbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .content-area {
            padding: 1px 30px 30px 30px;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .stat-card {
            padding: 20px;
            border-radius: 12px;
            color: white;
            margin-bottom: 20px;
        }
        
        .stat-card.income {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .stat-card.expense {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .stat-card.savings {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        .stat-card.monthly {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        
        .stat-card h6 {
            opacity: 0.9;
            margin-bottom: 10px;
        }
        
        .stat-card h3 {
            font-weight: bold;
            margin: 0;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
        
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }
        
        .badge {
            padding: 6px 12px;
            border-radius: 6px;
        }
        
        /* Dark mode styles */
        [data-bs-theme="dark"] {
            --bs-body-bg: #1a1a2e;
            --bs-body-color: #eee;
        }
        
        [data-bs-theme="dark"] .main-content {
            background: #16213e;
        }
        
        [data-bs-theme="dark"] .top-navbar {
            background: #16213e;
            color: #eee;
        }
        
        [data-bs-theme="dark"] .card {
            background: #16213e;
            color: #eee;
        }
        
        /* Mobile responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
                top: var(--top-navbar-height);
            }
            
            .main-content {
                margin-left: 0;
                margin-top: var(--top-navbar-height);
            }
            
            .mobile-toggle {
                display: block !important;
            }
            
            .mobile-menu-toggle {
                display: block;
            }
            
            .app-logo {
                font-size: 1.2rem;
            }
            
            .app-logo i {
                font-size: 1.5rem;
            }
            
            .content-area {
                padding: 10px 15px 15px 15px;
            }
            
            .stat-card h3 {
                font-size: 1.5rem;
            }
            
            .stat-card h6 {
                font-size: 0.85rem;
            }
            
            .card-title {
                font-size: 1rem;
            }
            
            .table {
                font-size: 0.875rem;
            }
        }
        
        @media (max-width: 576px) {
            .content-area {
                padding: 8px 10px 10px 10px;
            }
            
            .stat-card {
                padding: 15px;
            }
            
            .stat-card h3 {
                font-size: 1.25rem;
            }
            
            .top-navbar {
                padding: 10px 15px;
            }
            
            .chart-container {
                height: 250px !important;
            }
        }
        
        .mobile-toggle {
            display: none;
        }
        
        /* Responsive chart containers */
        .chart-container canvas {
            max-width: 100%;
            height: auto !important;
        }
        
        .progress {
            height: 10px;
            border-radius: 5px;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
        }
        
        /* Pagination Styles */
        .pagination {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        
        .pagination .page-link {
            color: #667eea;
            border: 1px solid #dee2e6;
            padding: 8px 16px;
            margin: 0 2px;
            border-radius: 6px;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            line-height: 1.5;
        }
        
        .pagination .page-link:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
        }
        
        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            color: white;
        }
        
        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
            cursor: not-allowed;
        }
        
        /* Hide all SVG and icons in pagination */
        .pagination svg,
        .pagination i,
        .pagination .page-link svg,
        .pagination .page-link i,
        .pagination path,
        .pagination .page-link path {
            display: none !important;
            visibility: hidden !important;
            width: 0 !important;
            height: 0 !important;
            opacity: 0 !important;
        }
        
        /* Force pagination links to show only text */
        .pagination .page-link * {
            display: none !important;
        }
        
        .pagination .page-link {
            font-size: 0 !important;
        }
        
        .pagination .page-link::before {
            font-size: 0.875rem !important;
        }
        
        /* Show text content for Previous button */
        .pagination .page-item:first-child .page-link::before {
            content: 'Previous';
            font-size: 0.875rem;
        }
        
        /* Show text content for Next button */
        .pagination .page-item:last-child .page-link::before {
            content: 'Next';
            font-size: 0.875rem;
        }
        
        /* Show page numbers */
        .pagination .page-item:not(:first-child):not(:last-child) .page-link {
            font-size: 0.875rem !important;
        }
        
        /* Mobile pagination */
        @media (max-width: 576px) {
            .pagination .page-link {
                padding: 6px 10px;
                font-size: 0.8rem;
            }
            
            .pagination .page-item:not(.active):not(:first-child):not(:last-child) {
                display: none;
            }
        }
    </style>
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <!-- Fixed Top Navbar -->
    <nav class="top-fixed-navbar">
        <button class="mobile-menu-toggle" onclick="document.getElementById('sidebar').classList.toggle('show')">
            <i class="bi bi-list"></i>
        </button>
        <a href="<?php echo e(route('dashboard')); ?>" class="app-logo">
            <i class="bi bi-wallet2"></i>
            <span>Expense Tracker</span>
        </a>
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-link p-0" onclick="toggleTheme()" title="Toggle Dark Mode">
                <i class="bi bi-moon-stars fs-5" id="theme-icon" style="color: #667eea;"></i>
            </button>
            <div class="dropdown">
                <button class="btn btn-link p-0 dropdown-toggle text-decoration-none" type="button" data-bs-toggle="dropdown" style="color: #667eea;">
                    <i class="bi bi-person-circle fs-5"></i>
                    <span class="ms-2 d-none d-md-inline"><?php echo e(Auth::user()->name); ?></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="<?php echo e(route('profile')); ?>">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <nav class="nav flex-column">
            <a href="<?php echo e(route('dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="<?php echo e(route('expenses.index')); ?>" class="nav-link <?php echo e(request()->routeIs('expenses.*') ? 'active' : ''); ?>">
                <i class="bi bi-cash-coin"></i> Expenses
            </a>
            <a href="<?php echo e(route('income.index')); ?>" class="nav-link <?php echo e(request()->routeIs('income.*') ? 'active' : ''); ?>">
                <i class="bi bi-arrow-down-circle"></i> Income
            </a>
            <a href="<?php echo e(route('categories.index')); ?>" class="nav-link <?php echo e(request()->routeIs('categories.*') ? 'active' : ''); ?>">
                <i class="bi bi-tags"></i> Categories
            </a>
            <a href="<?php echo e(route('budgets.index')); ?>" class="nav-link <?php echo e(request()->routeIs('budgets.*') ? 'active' : ''); ?>">
                <i class="bi bi-piggy-bank"></i> Budgets
            </a>
            <a href="<?php echo e(route('reports.index')); ?>" class="nav-link <?php echo e(request()->routeIs('reports.*') ? 'active' : ''); ?>">
                <i class="bi bi-bar-chart"></i> Reports
            </a>
            <a href="<?php echo e(route('profile')); ?>" class="nav-link <?php echo e(request()->routeIs('profile') ? 'active' : ''); ?>">
                <i class="bi bi-person-circle"></i> Profile
            </a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </nav>
        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
            <?php echo csrf_field(); ?>
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Content Area -->
        <div class="content-area">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i><?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Theme toggle
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        }

        function updateThemeIcon(theme) {
            const icon = document.getElementById('theme-icon');
            icon.className = theme === 'dark' ? 'bi bi-sun fs-5' : 'bi bi-moon-stars fs-5';
        }

        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', savedTheme);
        updateThemeIcon(savedTheme);

        // Mobile sidebar toggle
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-toggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !toggle.contains(event.target) &&
                sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
        });
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>

<?php /**PATH C:\xampp\htdocs\expense\resources\views/layouts/app.blade.php ENDPATH**/ ?>