

<?php $__env->startSection('title', 'Expenses'); ?>
<?php $__env->startSection('page-title', 'Expenses'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title mb-0">
                <i class="bi bi-cash-coin me-2"></i>Expense List
            </h5>
            <a href="<?php echo e(route('expenses.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add Expense
            </a>
        </div>

        <!-- Search and Filter -->
        <form method="GET" action="<?php echo e(route('expenses.index')); ?>" class="mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search..." value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-3">
                    <select name="category_id" class="form-select">
                        <option value="">All Categories</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" 
                                <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>>
                                <?php echo e($category->icon); ?> <?php echo e($category->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="start_date" class="form-control" 
                           placeholder="Start Date" value="<?php echo e(request('start_date')); ?>">
                </div>
                <div class="col-md-2">
                    <input type="date" name="end_date" class="form-control" 
                           placeholder="End Date" value="<?php echo e(request('end_date')); ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-2"></i>Filter
                    </button>
                </div>
            </div>
        </form>

        <?php if($expenses->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Category</th>
                            <th>Merchant</th>
                            <th>Notes</th>
                            <th class="text-end">Amount</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($expense->date->format('M d, Y')); ?></td>
                                <td>
                                    <span class="badge" style="background-color: <?php echo e($expense->category->color); ?>">
                                        <?php echo e($expense->category->icon); ?> <?php echo e($expense->category->name); ?>

                                    </span>
                                </td>
                                <td><?php echo e($expense->merchant ?? '-'); ?></td>
                                <td><?php echo e(Str::limit($expense->notes ?? '-', 30)); ?></td>
                                <td class="text-end fw-bold">₹<?php echo e(number_format($expense->amount, 2)); ?></td>
                                <td class="text-center">
                                    <a href="<?php echo e(route('expenses.edit', $expense)); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?php echo e(route('expenses.destroy', $expense)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Are you sure you want to delete this expense?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total:</th>
                            <th class="text-end">₹<?php echo e(number_format($expenses->sum('amount'), 2)); ?></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-3">
                <?php echo e($expenses->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-3">No expenses found. Start by adding your first expense!</p>
                <a href="<?php echo e(route('expenses.create')); ?>" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle me-2"></i>Add Expense
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

// Made with Bob

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\expense\resources\views/expenses/index.blade.php ENDPATH**/ ?>