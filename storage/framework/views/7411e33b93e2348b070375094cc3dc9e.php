

<?php $__env->startSection('title', 'Income'); ?>
<?php $__env->startSection('page-title', 'Income'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title mb-0">
                <i class="bi bi-arrow-down-circle me-2"></i>Income List
            </h5>
            <a href="<?php echo e(route('income.create')); ?>" class="btn btn-success">
                <i class="bi bi-plus-circle me-2"></i>Add Income
            </a>
        </div>

        <?php if($income->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Source</th>
                            <th>Notes</th>
                            <th class="text-end">Amount</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $income; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($inc->date->format('M d, Y')); ?></td>
                                <td><?php echo e($inc->source); ?></td>
                                <td><?php echo e(Str::limit($inc->notes ?? '-', 40)); ?></td>
                                <td class="text-end fw-bold text-success">₹<?php echo e(number_format($inc->amount, 2)); ?></td>
                                <td class="text-center">
                                    <a href="<?php echo e(route('income.edit', $inc)); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?php echo e(route('income.destroy', $inc)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Are you sure?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total:</th>
                            <th class="text-end text-success">₹<?php echo e(number_format($income->sum('amount'), 2)); ?></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-3">
                <?php echo e($income->links('vendor.pagination.bootstrap-5')); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-3">No income records found. Start by adding your first income!</p>
                <a href="<?php echo e(route('income.create')); ?>" class="btn btn-success mt-2">
                    <i class="bi bi-plus-circle me-2"></i>Add Income
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\expense\resources\views/income/index.blade.php ENDPATH**/ ?>