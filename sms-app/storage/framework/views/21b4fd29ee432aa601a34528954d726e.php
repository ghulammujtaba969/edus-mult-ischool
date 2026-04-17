<?php $__env->startSection('title', 'Exam Types | EduCore SMS'); ?>
<?php $__env->startSection('page_title', 'Exam Types'); ?>
<?php $__env->startSection('breadcrumb', '/ Exams / Exam Types'); ?>

<?php $__env->startSection('topbar_actions'); ?>
    <a class="btn-primary-sms" href="<?php echo e(route('admin.exam-types.create')); ?>"><i class="bi bi-plus-lg"></i> Add Exam Type</a>
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
                <th>Name</th>
                <th>Weightage (%)</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $examTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="font-weight:700;"><?php echo e($type->name); ?></td>
                    <td class="mono"><?php echo e($type->weightage_percent); ?>%</td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="<?php echo e(route('admin.exam-types.edit', $type)); ?>"><i class="bi bi-pencil"></i></a>
                            <form action="<?php echo e(route('admin.exam-types.destroy', $type)); ?>" method="POST" onsubmit="return confirm('Are you sure?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="btn-outline-sms" style="color:var(--danger);" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="3" style="text-align:center;padding:2rem;color:var(--text-light);">No exam types found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1\htdocs\SMS\codex\sms-app\resources\views/exam-types/index.blade.php ENDPATH**/ ?>