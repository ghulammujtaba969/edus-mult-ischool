<?php $__env->startSection('title', 'Set Class Fees | EduCore SMS'); ?>
<?php $__env->startSection('page_title', 'Set Class Fees'); ?>
<?php $__env->startSection('breadcrumb', '/ Fees / Structures / Create'); ?>

<?php $__env->startSection('content'); ?>
    <div class="data-card" style="max-width:700px;margin:0 auto;">
        <div class="card-title">Fee Amount Assignment</div>
        <form action="<?php echo e(route('admin.fee-structures.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="academic_year_id">Academic Year</label>
                    <select class="filter-select <?php $__errorArgs = ['academic_year_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="academic_year_id" name="academic_year_id" required>
                        <?php $__currentLoopData = $academicYears; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($year->id); ?>" <?php if(old('academic_year_id') == $year->id || $year->is_current): echo 'selected'; endif; ?>><?php echo e($year->name); ?> <?php if($year->is_current): ?> (Current) <?php endif; ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="form-label-sms" for="school_class_id">Class</label>
                    <select class="filter-select <?php $__errorArgs = ['school_class_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="school_class_id" name="school_class_id" required>
                        <option value="">Select Class</option>
                        <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($class->id); ?>" <?php if(old('school_class_id') == $class->id): echo 'selected'; endif; ?>><?php echo e($class->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <div class="info-grid-2" style="margin-bottom:1.5rem;">
                <div>
                    <label class="form-label-sms" for="fee_type_id">Fee Type</label>
                    <select class="filter-select <?php $__errorArgs = ['fee_type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="fee_type_id" name="fee_type_id" required>
                        <option value="">Select Fee Type</option>
                        <?php $__currentLoopData = $feeTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($type->id); ?>" <?php if(old('fee_type_id') == $type->id): echo 'selected'; endif; ?>><?php echo e($type->name); ?> (<?php echo e(ucfirst($type->frequency)); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="form-label-sms" for="amount">Fee Amount (Rs.)</label>
                    <input class="form-control-sms <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="number" step="0.01" id="amount" name="amount" value="<?php echo e(old('amount')); ?>" placeholder="e.g. 5000" required>
                </div>
            </div>

            <div class="info-grid-2" style="margin-bottom:2rem;">
                <div>
                    <label class="form-label-sms" for="due_day">Monthly Due Day</label>
                    <input class="form-control-sms <?php $__errorArgs = ['due_day'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="number" min="1" max="31" id="due_day" name="due_day" value="<?php echo e(old('due_day', 5)); ?>" required>
                    <div class="muted" style="font-size:.75rem;margin-top:.35rem;">Day of month when fee becomes due.</div>
                </div>
                <div>
                    <label class="form-label-sms" for="effective_from">Effective From (Optional)</label>
                    <input class="form-control-sms" type="date" id="effective_from" name="effective_from" value="<?php echo e(old('effective_from')); ?>">
                </div>
            </div>

            <div style="display:flex;gap:1rem;">
                <button class="btn-primary-sms" type="submit"><i class="bi bi-save"></i> Save Structure</button>
                <a class="btn-outline-sms" href="<?php echo e(route('admin.fee-structures.index')); ?>">Cancel</a>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1\htdocs\SMS\codex\sms-app\resources\views/fee-structures/create.blade.php ENDPATH**/ ?>