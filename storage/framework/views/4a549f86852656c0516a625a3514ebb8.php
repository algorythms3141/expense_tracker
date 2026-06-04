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
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px 0;
            transition: all 0.3s;
            z-index: 1000;
            overflow-y: auto;
        }
        
        .sidebar .brand {
            padding: 0 20px 20px;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
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
            min-height: 100vh;
            background: #f8f9fa;
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
            padding: 30px;
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
            background: #1a1a2e;
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
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-toggle {
                display: block !important;
            }
        }
        
        .mobile-toggle {
            display: none;
        }
        
        .progress {
            height: 10px;
            border-radius: 5px;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
        }
    </style>
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="brand">
            <i class="bi bi-wallet2"></i> Expense Tracker
        </div>
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
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div>
                <button class="btn btn-link mobile-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <span class="fs-5 fw-bold"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-link" onclick="toggleTheme()" title="Toggle Dark Mode">
                    <i class="bi bi-moon-stars fs-5" id="theme-icon"></i>
                </button>
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-5"></i>
                        <span class="ms-2"><?php echo e(Auth::user()->name); ?></span>
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
        </div>

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

// Made with Bob
<?php /**PATH C:\xampp\htdocs\expense\resources\views/layouts/app.blade.php ENDPATH**/ ?>