

<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card income">
            <h6>Total Income</h6>
            <h3>₹<?php echo e(number_format($totalIncome, 2)); ?></h3>
            <small><i class="bi bi-arrow-up-circle"></i> All time</small>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card expense">
            <h6>Total Expenses</h6>
            <h3>₹<?php echo e(number_format($totalExpenses, 2)); ?></h3>
            <small><i class="bi bi-arrow-down-circle"></i> All time</small>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card savings">
            <h6>Total Savings</h6>
            <h3>₹<?php echo e(number_format($totalSavings, 2)); ?></h3>
            <small><i class="bi bi-piggy-bank"></i> Net balance</small>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card monthly">
            <h6>This Month</h6>
            <h3>₹<?php echo e(number_format($currentMonthExpenses, 2)); ?></h3>
            <small><i class="bi bi-calendar-month"></i> <?php echo e(now()->format('F Y')); ?></small>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="bi bi-pie-chart me-2"></i>Category-wise Expenses
                </h5>
                <div style="position: relative; height: 300px;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="bi bi-graph-up me-2"></i>Monthly Expense Trend
                </h5>
                <div style="position: relative; height: 300px;">
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
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Category</th>
                            <th>Merchant/Source</th>
                            <th>Type</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(\Carbon\Carbon::parse($transaction['date'])->format('M d, Y')); ?></td>
                                <td>
                                    <span class="badge" style="background-color: <?php echo e($transaction['color']); ?>">
                                        <?php echo e($transaction['category']); ?>

                                    </span>
                                </td>
                                <td><?php echo e($transaction['merchant']); ?></td>
                                <td>
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

// Made with Bob

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\expense\resources\views/dashboard/index.blade.php ENDPATH**/ ?>