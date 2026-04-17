<?php $__env->startSection('title', 'Mark Entry | EduCore SMS'); ?>
<?php $__env->startSection('page_title', 'Mark Entry'); ?>
<?php $__env->startSection('breadcrumb', '/ Exams / Marks / Entry'); ?>

<?php $__env->startSection('topbar_actions'); ?>
    <a class="btn-outline-sms" href="<?php echo e(route('admin.marks.index')); ?>"><i class="bi bi-arrow-left"></i> Back</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="data-card">
        <div class="data-card-header" style="flex-direction:column;align-items:start;gap:.5rem;">
            <div style="font-size:1.2rem;font-weight:800;"><?php echo e($exam->name); ?> (<?php echo e($exam->schoolClass->name); ?>)</div>
            <div class="muted"><i class="bi bi-book"></i> Subject: <strong><?php echo e($subject->name); ?></strong></div>
        </div>

        <form action="<?php echo e(route('admin.marks.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="exam_id" value="<?php echo e($exam->id); ?>">
            <input type="hidden" name="subject_id" value="<?php echo e($subject->id); ?>">

            <table class="sms-table">
                <thead>
                <tr>
                    <th style="width:80px;">Roll #</th>
                    <th>Student Name</th>
                    <th>Obtained Marks</th>
                    <th>Total Marks</th>
                    <th>Absent</th>
                    <th>Remarks</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php ($mark = $existingMarks->get($student->id)); ?>
                    <tr>
                        <td class="mono"><?php echo e($student->currentAcademicRecord->roll_no); ?></td>
                        <td>
                            <div style="font-weight:700;"><?php echo e($student->user->name); ?></div>
                            <div class="student-reg"><?php echo e($student->registration_no); ?></div>
                        </td>
                        <td>
                            <input class="form-control-sms" type="number" step="0.01" name="marks[<?php echo e($student->id); ?>][obtained]" value="<?php echo e(old("marks.{$student->id}.obtained", $mark?->obtained_marks)); ?>" style="width:100px;">
                        </td>
                        <td>
                            <input class="form-control-sms" type="number" step="0.01" name="marks[<?php echo e($student->id); ?>][total]" value="<?php echo e(old("marks.{$student->id}.total", $mark?->total_marks ?? 100)); ?>" style="width:100px;" required>
                        </td>
                        <td style="text-align:center;">
                            <input type="checkbox" name="marks[<?php echo e($student->id); ?>][is_absent]" value="1" <?php if(old("marks.{$student->id}.is_absent", $mark?->is_absent)): echo 'checked'; endif; ?> style="width:1.2rem;height:1.2rem;">
                        </td>
                        <td>
                            <input class="form-control-sms" type="text" name="marks[<?php echo e($student->id); ?>][remarks]" value="<?php echo e(old("marks.{$student->id}.remarks", $mark?->remarks)); ?>" placeholder="e.g. Good performance">
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div style="margin-top:2rem;display:flex;justify-content:flex-end;">
                <button class="btn-primary-sms" type="submit" style="padding:1rem 3rem;"><i class="bi bi-save"></i> Save Marks</button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1\htdocs\SMS\codex\sms-app\resources\views/marks/create.blade.php ENDPATH**/ ?>