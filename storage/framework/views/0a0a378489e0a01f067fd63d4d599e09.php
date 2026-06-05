

<?php $__env->startSection('title', 'Reports'); ?>
<?php $__env->startSection('page-title', 'Reports'); ?>

<?php $__env->startSection('content'); ?>
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title mb-0">
                <i class="bi bi-bar-chart me-2"></i>Financial Reports
            </h5>
            <form method="GET" action="<?php echo e(route('reports.index')); ?>" class="d-flex gap-2">
                <select name="month" class="form-select" onchange="this.form.submit()">
                    <?php for($m = 1; $m <= 12; $m++): ?>
                        <option value="<?php echo e($m); ?>" <?php echo e($month == $m ? 'selected' : ''); ?>>
                            <?php echo e(date('F', mktime(0, 0, 0, $m, 1))); ?>

                        </option>
                    <?php endfor; ?>
                </select>
                <select name="year" class="form-select" onchange="this.form.submit()">
                    <?php for($y = date('Y') - 2; $y <= date('Y'); $y++): ?>
                        <option value="<?php echo e($y); ?>" <?php echo e($year == $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                    <?php endfor; ?>
                </select>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-card income">
                    <h6>Total Income</h6>
                    <h3>₹<?php echo e(number_format($monthlyIncome, 2)); ?></h3>
                    <small><?php echo e(date('F Y', mktime(0, 0, 0, $month, 1, $year))); ?></small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card expense">
                    <h6>Total Expenses</h6>
                    <h3>₹<?php echo e(number_format($monthlyExpenses, 2)); ?></h3>
                    <small><?php echo e(date('F Y', mktime(0, 0, 0, $month, 1, $year))); ?></small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card <?php echo e($monthlyIncome - $monthlyExpenses >= 0 ? 'savings' : 'expense'); ?>">
                    <h6>Net Savings</h6>
                    <h3>₹<?php echo e(number_format($monthlyIncome - $monthlyExpenses, 2)); ?></h3>
                    <small><?php echo e(date('F Y', mktime(0, 0, 0, $month, 1, $year))); ?></small>
                </div>
            </div>
        </div>

        <!-- Export Buttons -->
        <div class="mb-4">
            <a href="<?php echo e(route('reports.export.monthly', ['month' => $month, 'year' => $year])); ?>" class="btn btn-success">
                <i class="bi bi-file-earmark-spreadsheet me-2"></i>Export Monthly Report (CSV)
            </a>
            <a href="<?php echo e(route('reports.export.category', ['month' => $month, 'year' => $year])); ?>" class="btn btn-info">
                <i class="bi bi-file-earmark-bar-graph me-2"></i>Export Category Report (CSV)
            </a>
        </div>
    </div>
</div>

<!-- Category-wise Report -->
<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-4">
            <i class="bi bi-pie-chart me-2"></i>Category-wise Expense Report
        </h5>

        <?php if($categoryReport->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th class="text-center">Transactions</th>
                            <th class="text-end">Total Amount</th>
                            <th class="text-end">Average</th>
                            <th class="text-end">Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $totalAmount = $categoryReport->sum('total'); ?>
                        <?php $__currentLoopData = $categoryReport; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <span class="badge" style="background-color: <?php echo e($category->color); ?>">
                                        <?php echo e($category->icon); ?> <?php echo e($category->name); ?>

                                    </span>
                                </td>
                                <td class="text-center"><?php echo e($category->count); ?></td>
                                <td class="text-end fw-bold">₹<?php echo e(number_format($category->total, 2)); ?></td>
                                <td class="text-end">₹<?php echo e(number_format($category->total / $category->count, 2)); ?></td>
                                <td class="text-end">
                                    <span class="badge bg-primary">
                                        <?php echo e($totalAmount > 0 ? number_format(($category->total / $totalAmount) * 100, 1) : 0); ?>%
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold">
                            <th>Total</th>
                            <th class="text-center"><?php echo e($categoryReport->sum('count')); ?></th>
                            <th class="text-end">₹<?php echo e(number_format($totalAmount, 2)); ?></th>
                            <th></th>
                            <th class="text-end">100%</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-3">No expense data available for <?php echo e(date('F Y', mktime(0, 0, 0, $month, 1, $year))); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\expense\resources\views/reports/index.blade.php ENDPATH**/ ?>