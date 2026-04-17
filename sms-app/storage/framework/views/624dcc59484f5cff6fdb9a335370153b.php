<?php $__env->startSection('title', 'Edit Class | EduCore SMS'); ?>
<?php $__env->startSection('page_title', 'Edit Class'); ?>
<?php $__env->startSection('breadcrumb', '/ Academic Setup / Classes / Edit'); ?>

<?php $__env->startSection('content'); ?>
    <div class="data-card" style="max-width:600px;margin:0 auto;">
        <div class="card-title">Class Information</div>
        <form action="<?php echo e(route('admin.classes.update', $class)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms" for="name">Class Name</label>
                <input class="form-control-sms <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" id="name" name="name" value="<?php echo e(old('name', $class->name)); ?>" placeholder="e.g. Class 1, Grade 9" required>
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="form-label-sms" for="level">Level (Optional)</label>
                <select class="filter-select" id="level" name="level">
                    <option value="">Select Level</option>
                    <?php $__currentLoopData = ['primary' => 'Primary', 'middle' => 'Middle', 'secondary' => 'Secondary', 'higher_secondary' => 'Higher Secondary']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value); ?>" <?php if(old('level', $class->level) === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div style="margin-bottom:2rem;">
                <label class="form-label-sms" for="order_seq">Order Sequence</label>
                <input class="form-control-sms <?php $__errorArgs = ['order_seq'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="number" id="order_seq" name="order_seq" value="<?php echo e(old('order_seq', $class->order_seq)); ?>" min="0" required>
                <div style="color:var(--text-light);font-size:.75rem;margin-top:.35rem;">Used to sort classes in lists (0 is first).</div>
                <?php $__errorArgs = ['order_seq'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:var(--danger);font-size:.78rem;margin-top:.35rem;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit"><i class="bi bi-save"></i> Update Class</button>
                <a class="btn-outline-sms" href="<?php echo e(route('admin.classes.index')); ?>">Cancel</a>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1\htdocs\SMS\codex\sms-app\resources\views/classes/edit.blade.php ENDPATH**/ ?>