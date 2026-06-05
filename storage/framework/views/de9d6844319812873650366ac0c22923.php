

<?php $__env->startSection('title', 'Budgets'); ?>
<?php $__env->startSection('page-title', 'Budgets'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title mb-0">
                <i class="bi bi-piggy-bank me-2"></i>Budget Tracking
            </h5>
            <div class="d-flex gap-2">
                <form method="GET" action="<?php echo e(route('budgets.index')); ?>" class="d-flex gap-2">
                    <select name="month" class="form-select" onchange="this.form.submit()">
                        <?php for($m = 1; $m <= 12; $m++): ?>
                            <option value="<?php echo e($m); ?>" <?php echo e($month == $m ? 'selected' : ''); ?>>
                                <?php echo e(date('F', mktime(0, 0, 0, $m, 1))); ?>

                            </option>
                        <?php endfor; ?>
                    </select>
                    <select name="year" class="form-select" onchange="this.form.submit()">
                        <?php for($y = date('Y') - 1; $y <= date('Y') + 1; $y++): ?>
                            <option value="<?php echo e($y); ?>" <?php echo e($year == $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                        <?php endfor; ?>
                    </select>
                </form>
                <a href="<?php echo e(route('budgets.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add Budget
                </a>
            </div>
        </div>

        <?php if($budgets->count() > 0): ?>
            <div class="row">
                <?php $__currentLoopData = $budgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $budget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h6 class="mb-1">
                                            <span style="font-size: 1.2rem"><?php echo e($budget->category->icon); ?></span>
                                            <?php echo e($budget->category->name); ?>

                                        </h6>
                                        <small class="text-muted">
                                            Budget: ₹<?php echo e(number_format($budget->amount, 2)); ?>

                                        </small>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-link" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="<?php echo e(route('budgets.edit', $budget)); ?>">
                                                    <i class="bi bi-pencil me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <form action="<?php echo e(route('budgets.destroy', $budget)); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="dropdown-item text-danger" 
                                                            onclick="return confirm('Are you sure?')">
                                                        <i class="bi bi-trash me-2"></i>Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Spent: ₹<?php echo e(number_format($budget->spent, 2)); ?></span>
                                        <span>Remaining: ₹<?php echo e(number_format($budget->remaining, 2)); ?></span>
                                    </div>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar <?php echo e($budget->percentage_used > 100 ? 'bg-danger' : ($budget->percentage_used > 80 ? 'bg-warning' : 'bg-success')); ?>" 
                                             role="progressbar" 
                                             style="width: <?php echo e(min($budget->percentage_used, 100)); ?>%">
                                            <?php echo e(number_format($budget->percentage_used, 1)); ?>%
                                        </div>
                                    </div>
                                </div>

                                <?php if($budget->percentage_used > 100): ?>
                                    <div class="alert alert-danger py-2 mb-0 mt-2">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        <small>Budget exceeded by ₹<?php echo e(number_format($budget->spent - $budget->amount, 2)); ?></small>
                                    </div>
                                <?php elseif($budget->percentage_used > 80): ?>
                                    <div class="alert alert-warning py-2 mb-0 mt-2">
                                        <i class="bi bi-exclamation-circle me-2"></i>
                                        <small>Approaching budget limit</small>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-3">No budgets set for <?php echo e(date('F Y', mktime(0, 0, 0, $month, 1, $year))); ?></p>
                <a href="<?php echo e(route('budgets.create')); ?>" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle me-2"></i>Create Budget
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\expense\resources\views/budgets/index.blade.php ENDPATH**/ ?>