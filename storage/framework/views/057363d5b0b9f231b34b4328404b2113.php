

<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Financial Summary Card -->
<div class="card mb-4">
    <div class="card-body p-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <i class="bi bi-graph-up-arrow text-primary fs-4 me-3"></i>
                <div>
                    <h5 class="mb-0 fw-bold">Financial Summary</h5>
                    <small class="text-muted">Quick overview of your finances</small>
                </div>
            </div>
            <a href="<?php echo e(route('reports.index')); ?>" class="btn btn-sm btn-outline-primary">
                View Full Report <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <!-- ALL TIME Section -->
        <div class="mb-4">
            <div class="d-flex align-items-center mb-3">
                <span class="badge bg-secondary me-2">ALL TIME</span>
                <small class="text-muted">Since you started tracking</small>
            </div>
            <div class="row g-3">
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="d-flex align-items-start p-3 rounded" style="background-color: #e8f5e9;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="background-color: #4caf50; width: 40px; height: 40px; min-width: 40px;">
                            <i class="bi bi-arrow-up text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <small class="text-muted d-block mb-1">Total Income</small>
                            <h4 class="mb-1 fw-bold text-success">₹<?php echo e(number_format($totalIncome, 2)); ?></h4>
                            <small class="text-success"><i class="bi bi-arrow-up"></i> 12.5% vs last period</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="d-flex align-items-start p-3 rounded" style="background-color: #ffebee;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="background-color: #f44336; width: 40px; height: 40px; min-width: 40px;">
                            <i class="bi bi-arrow-down text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <small class="text-muted d-block mb-1">Total Expenses</small>
                            <h4 class="mb-1 fw-bold text-danger">₹<?php echo e(number_format($totalExpenses, 2)); ?></h4>
                            <small class="text-danger"><i class="bi bi-arrow-up"></i> 8.3% vs last period</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="d-flex align-items-start p-3 rounded" style="background-color: #e3f2fd;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="background-color: #2196f3; width: 40px; height: 40px; min-width: 40px;">
                            <i class="bi bi-wallet2 text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <small class="text-muted d-block mb-1">Total Savings</small>
                            <h4 class="mb-1 fw-bold text-primary">₹<?php echo e(number_format($totalSavings, 2)); ?></h4>
                            <small class="text-primary"><i class="bi bi-arrow-up"></i> 24.8% vs last period</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- THIS MONTH Section -->
        <div>
            <div class="d-flex align-items-center mb-3">
                <span class="badge bg-primary me-2">THIS MONTH</span>
                <small class="text-muted"><?php echo e(now()->format('F Y')); ?></small>
            </div>
            <div class="row g-3">
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="d-flex align-items-start p-3 rounded" style="background-color: #e8f5e9;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="background-color: #4caf50; width: 40px; height: 40px; min-width: 40px;">
                            <i class="bi bi-wallet text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <small class="text-muted d-block mb-1">Income</small>
                            <h4 class="mb-1 fw-bold text-success">₹<?php echo e(number_format($currentMonthIncome, 2)); ?></h4>
                            <small class="text-muted"><i class="bi bi-dot"></i> 0% vs last month</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="d-flex align-items-start p-3 rounded" style="background-color: #ffebee;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="background-color: #f44336; width: 40px; height: 40px; min-width: 40px;">
                            <i class="bi bi-receipt text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <small class="text-muted d-block mb-1">Expenses</small>
                            <h4 class="mb-1 fw-bold text-danger">₹<?php echo e(number_format($currentMonthExpenses, 2)); ?></h4>
                            <small class="text-danger"><i class="bi bi-arrow-up"></i> 100% vs last month</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="d-flex align-items-start p-3 rounded" style="background-color: <?php echo e($currentMonthSavings < 0 ? '#ffebee' : '#fff3e0'); ?>;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="background-color: <?php echo e($currentMonthSavings < 0 ? '#f44336' : '#ff9800'); ?>; width: 40px; height: 40px; min-width: 40px;">
                            <i class="bi bi-piggy-bank text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <small class="text-muted d-block mb-1">Savings</small>
                            <h4 class="mb-1 fw-bold" style="color: <?php echo e($currentMonthSavings < 0 ? '#f44336' : '#ff9800'); ?>;">₹<?php echo e(number_format($currentMonthSavings, 2)); ?></h4>
                            <small class="<?php echo e($currentMonthSavings < 0 ? 'text-danger' : 'text-warning'); ?>"><i class="bi bi-dot"></i> <?php echo e($currentMonthSavings < 0 ? '-100%' : '100%'); ?> vs last month</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Today's Expenses Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-start border-primary border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">
                            <i class="bi bi-calendar-day text-primary"></i> Today's Expenses
                        </h5>
                        <p class="text-muted mb-0 small"><?php echo e(now()->format('l, F j, Y')); ?></p>
                    </div>
                    <div class="text-end">
                        <h2 class="mb-0 text-primary">₹<?php echo e(number_format($todayExpenses, 2)); ?></h2>
                        <a href="<?php echo e(route('expenses.create')); ?>" class="btn btn-sm btn-primary mt-2">
                            <i class="bi bi-plus-circle"></i> Add Expense
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row mb-4 g-3">
    <div class="col-lg-6 col-md-12 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="bi bi-pie-chart me-2"></i>Category-wise Expenses
                </h5>
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="bi bi-graph-up me-2"></i>Monthly Expense Trend
                </h5>
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-4">
            <i class="bi bi-clock-history me-2"></i>Recent Transactions
        </h5>
        
        <?php if($recentTransactions->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="d-none d-md-table-cell">Date</th>
                            <th>Category</th>
                            <th class="d-none d-sm-table-cell">Merchant/Source</th>
                            <th class="d-none d-lg-table-cell">Type</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="d-none d-md-table-cell">
                                    <small><?php echo e(\Carbon\Carbon::parse($transaction['date'])->format('M d, Y')); ?></small>
                                </td>
                                <td>
                                    <span class="badge" style="background-color: <?php echo e($transaction['color']); ?>; font-size: 0.75rem;">
                                        <?php echo e($transaction['category']); ?>

                                    </span>
                                    <div class="d-md-none">
                                        <small class="text-muted"><?php echo e(\Carbon\Carbon::parse($transaction['date'])->format('M d')); ?></small>
                                    </div>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <small><?php echo e($transaction['merchant']); ?></small>
                                </td>
                                <td class="d-none d-lg-table-cell">
                                    <?php if($transaction['type'] === 'Income'): ?>
                                        <span class="badge bg-success">Income</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Expense</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end fw-bold">
                                    <?php if($transaction['type'] === 'Income'): ?>
                                        <span class="text-success">+₹<?php echo e(number_format($transaction['amount'], 2)); ?></span>
                                    <?php else: ?>
                                        <span class="text-danger">-₹<?php echo e(number_format($transaction['amount'], 2)); ?></span>
                                    <?php endif; ?>
                                    <div class="d-sm-none">
                                        <small class="text-muted"><?php echo e($transaction['merchant']); ?></small>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-3">No transactions yet. Start by adding your first expense or income!</p>
                <div class="mt-3">
                    <a href="<?php echo e(route('expenses.create')); ?>" class="btn btn-primary me-2">
                        <i class="bi bi-plus-circle me-2"></i>Add Expense
                    </a>
                    <a href="<?php echo e(route('income.create')); ?>" class="btn btn-success">
                        <i class="bi bi-plus-circle me-2"></i>Add Income
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Category Pie Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryData = <?php echo json_encode($categoryExpenses, 15, 512) ?>;
    
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: categoryData.map(item => item.name),
            datasets: [{
                data: categoryData.map(item => item.total),
                backgroundColor: categoryData.map(item => item.color),
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ₹' + context.parsed.toFixed(2);
                        }
                    }
                }
            }
        }
    });

    // Monthly Trend Line Chart
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    const trendData = <?php echo json_encode($monthlyTrend, 15, 512) ?>;
    
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: trendData.map(item => item.month),
            datasets: [{
                label: 'Expenses',
                data: trendData.map(item => item.total),
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Expenses: ₹' + context.parsed.y.toFixed(2);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₹' + value;
                        }
                    }
                }
            }
        }
    });
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\expense\resources\views/dashboard/index.blade.php ENDPATH**/ ?>