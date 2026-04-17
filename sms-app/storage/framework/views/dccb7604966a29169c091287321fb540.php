<?php $__env->startSection('title', 'Fee Structures | EduCore SMS'); ?>
<?php $__env->startSection('page_title', 'Fee Structures'); ?>
<?php $__env->startSection('breadcrumb', '/ Fees / Structures'); ?>

<?php $__env->startSection('topbar_actions'); ?>
    <a class="btn-primary-sms" href="<?php echo e(route('admin.fee-structures.create')); ?>"><i class="bi bi-plus-lg"></i> Set Class Fees</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert-box" style="background:var(--success-bg);border-color:var(--success);color:var(--success);">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Academic Year</th>
                <th>Class</th>
                <th>Fee Type</th>
                <th>Amount</th>
                <th>Due Day</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $structures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $structure): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="mono"><?php echo e($structure->academicYear->name); ?></td>
                    <td style="font-weight:700;"><?php echo e($structure->schoolClass->name); ?></td>
                    <td><span class="status-pill pill-active"><?php echo e($structure->feeType->name); ?></span></td>
                    <td class="mono">Rs. <?php echo e(number_format($structure->amount, 2)); ?></td>
                    <td class="mono">Day <?php echo e($structure->due_day); ?></td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="<?php echo e(route('admin.fee-structures.edit', $structure)); ?>"><i class="bi bi-pencil"></i></a>
                            <form action="<?php echo e(route('admin.fee-structures.destroy', $structure)); ?>" method="POST" onsubmit="return confirm('Are you sure?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="btn-outline-sms" style="color:var(--danger);" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light);">No fee structures defined.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1\htdocs\SMS\codex\sms-app\resources\views/fee-structures/index.blade.php ENDPATH**/ ?>