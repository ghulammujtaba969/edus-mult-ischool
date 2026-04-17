<?php $__env->startSection('title', 'Classes | EduCore SMS'); ?>
<?php $__env->startSection('page_title', 'Classes'); ?>
<?php $__env->startSection('breadcrumb', '/ Academic Setup / Classes'); ?>

<?php $__env->startSection('topbar_actions'); ?>
    <a class="btn-primary-sms" href="<?php echo e(route('admin.classes.create')); ?>"><i class="bi bi-plus-lg"></i> Add Class</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert-box" style="background:var(--success-bg);border-color:var(--success);color:var(--success);">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert-box">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="data-card">
        <div class="data-card-header">
            <div>Showing <strong><?php echo e($classes->count()); ?></strong> classes</div>
        </div>
        <table class="sms-table">
            <thead>
            <tr>
                <th>Order</th>
                <th>Name</th>
                <th>Level</th>
                <th>Sections</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="mono"><?php echo e($class->order_seq); ?></td>
                    <td style="font-weight:700;"><?php echo e($class->name); ?></td>
                    <td><?php echo e($class->level); ?></td>
                    <td><span class="status-pill pill-active"><?php echo e($class->sections_count); ?> Sections</span></td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="<?php echo e(route('admin.classes.edit', $class)); ?>"><i class="bi bi-pencil"></i></a>
                            <form action="<?php echo e(route('admin.classes.destroy', $class)); ?>" method="POST" onsubmit="return confirm('Are you sure?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="btn-outline-sms" style="color:var(--danger);" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" style="text-align:center;padding:2rem;color:var(--text-light);">No classes found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1\htdocs\SMS\codex\sms-app\resources\views/classes/index.blade.php ENDPATH**/ ?>