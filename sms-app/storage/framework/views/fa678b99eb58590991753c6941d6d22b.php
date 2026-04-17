<?php $__env->startSection('title', 'Add Academic Year | EduCore SMS'); ?>
<?php $__env->startSection('page_title', 'Add Academic Year'); ?>
<?php $__env->startSection('breadcrumb', '/ Academic Setup / Academic Years / Add'); ?>

<?php $__env->startSection('content'); ?>
    <div class="data-card" style="max-width:600px;margin:0 auto;">
        <div class="card-title">Academic Year Information</div>
        <form action="<?php echo e(route('admin.academic-years.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms" for="name">Academic Year Name</label>
                <input class="form-control-sms <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" placeholder="e.g. 2024-2025" required>
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="start_date">Start Date</label>
                    <input class="form-control-sms <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="date" id="start_date" name="start_date" value="<?php echo e(old('start_date')); ?>" required>
                    <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label class="form-label-sms" for="end_date">End Date</label>
                    <input class="form-control-sms <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="date" id="end_date" name="end_date" value="<?php echo e(old('end_date')); ?>" required>
                    <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div style="margin-bottom:2rem;">
                <label style="display:flex;align-items:center;gap:.75rem;cursor:pointer;">
                    <input type="checkbox" name="is_current" value="1" <?php if(old('is_current')): echo 'checked'; endif; ?> style="width:1.2rem;height:1.2rem;">
                    <span style="font-weight:600;">Set as Current Academic Year</span>
                </label>
                <div style="color:var(--text-light);font-size:.75rem;margin-top:.35rem;margin-left:2rem;">Only one year can be current at a time. This will deactivate the previous current year.</div>
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit"><i class="bi bi-save"></i> Save Year</button>
                <a class="btn-outline-sms" href="<?php echo e(route('admin.academic-years.index')); ?>">Cancel</a>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1\htdocs\SMS\codex\sms-app\resources\views/academic-years/create.blade.php ENDPATH**/ ?>