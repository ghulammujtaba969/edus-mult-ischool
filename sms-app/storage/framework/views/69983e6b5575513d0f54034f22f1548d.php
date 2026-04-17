<?php $__env->startSection('title', 'Subjects | EduCore SMS'); ?>
<?php $__env->startSection('page_title', 'Subjects'); ?>
<?php $__env->startSection('breadcrumb', '/ Academic Setup / Subjects'); ?>

<?php $__env->startSection('topbar_actions'); ?>
    <a class="btn-primary-sms" href="<?php echo e(route('admin.subjects.create')); ?>"><i class="bi bi-plus-lg"></i> Add Subject</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert-box" style="background:var(--success-bg);border-color:var(--success);color:var(--success);">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="data-card">
        <div class="data-card-header">
            <div>Showing <strong><?php echo e($subjects->count()); ?></strong> subjects</div>
        </div>
        <table class="sms-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Code</th>
                <th>Type</th>
                <th>Optional</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="font-weight:700;"><?php echo e($subject->name); ?></td>
                    <td class="mono"><?php echo e($subject->code ?? 'N/A'); ?></td>
                    <td><span class="status-pill pill-active"><?php echo e(ucfirst($subject->subject_type)); ?></span></td>
                    <td>
                        <?php if($subject->is_optional): ?>
                            <span class="status-pill pill-partial">Yes</span>
                        <?php else: ?>
                            <span class="status-pill pill-active">No</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="<?php echo e(route('admin.subjects.edit', $subject)); ?>"><i class="bi bi-pencil"></i></a>
                            <form action="<?php echo e(route('admin.subjects.destroy', $subject)); ?>" method="POST" onsubmit="return confirm('Are you sure?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="btn-outline-sms" style="color:var(--danger);" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" style="text-align:center;padding:2rem;color:var(--text-light);">No subjects found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1\htdocs\SMS\codex\sms-app\resources\views/subjects/index.blade.php ENDPATH**/ ?>