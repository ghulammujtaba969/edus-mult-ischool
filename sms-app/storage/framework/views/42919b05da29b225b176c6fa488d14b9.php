<?php $__env->startSection('title', 'Attendance Management | EduCore SMS'); ?>
<?php $__env->startSection('page_title', 'Attendance'); ?>
<?php $__env->startSection('breadcrumb', '/ Attendance'); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert-box" style="background:var(--success-bg);border-color:var(--success);color:var(--success);">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="data-card">
        <div class="card-title">Select Section to Mark Attendance</div>
        <div class="kpi-grid" style="grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));">
            <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $class->sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="kpi-card" style="padding:1.5rem;">
                        <div style="display:flex;justify-content:space-between;align-items:start;">
                            <div>
                                <div class="kpi-label"><?php echo e($class->name); ?></div>
                                <div class="kpi-value" style="font-size:1.5rem;">Section <?php echo e($section->name); ?></div>
                            </div>
                            <div class="brand-icon" style="width:32px;height:32px;border-radius:8px;font-size:.9rem;"><?php echo e($section->name); ?></div>
                        </div>
                        <div style="margin-top:1.5rem;">
                            <form action="<?php echo e(route('admin.attendance.create')); ?>" method="GET">
                                <input type="hidden" name="section_id" value="<?php echo e($section->id); ?>">
                                <div style="display:flex;gap:.5rem;">
                                    <input class="form-control-sms" type="date" name="date" value="<?php echo e(date('Y-m-d')); ?>" style="padding:.5rem;font-size:.85rem;">
                                    <button class="btn-primary-sms" type="submit" style="padding:.5rem 1rem;"><i class="bi bi-pencil-square"></i> Mark</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1\htdocs\SMS\codex\sms-app\resources\views/attendance/index.blade.php ENDPATH**/ ?>