<?php $__env->startSection('title', 'Mark Attendance | EduCore SMS'); ?>
<?php $__env->startSection('page_title', 'Mark Attendance'); ?>
<?php $__env->startSection('breadcrumb', '/ Attendance / ' . $section->schoolClass->name . ' - ' . $section->name); ?>

<?php $__env->startSection('topbar_actions'); ?>
    <a class="btn-outline-sms" href="<?php echo e(route('admin.attendance.index')); ?>"><i class="bi bi-arrow-left"></i> Back</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="data-card">
        <div class="data-card-header" style="flex-direction:column;align-items:start;gap:.5rem;">
            <div style="font-size:1.2rem;font-weight:800;"><?php echo e($section->schoolClass->name); ?> - Section <?php echo e($section->name); ?></div>
            <div class="muted"><i class="bi bi-calendar-event"></i> Date: <strong><?php echo e(\Carbon\Carbon::parse($date)->format('M d, Y')); ?></strong></div>
        </div>

        <form action="<?php echo e(route('admin.attendance.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="section_id" value="<?php echo e($section->id); ?>">
            <input type="hidden" name="attendance_date" value="<?php echo e($date); ?>">

            <table class="sms-table">
                <thead>
                <tr>
                    <th style="width:80px;">Roll #</th>
                    <th>Student Name</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php ($attendance = $existingAttendance->get($student->id)); ?>
                    <?php ($status = $attendance?->status->value ?? 'present'); ?>
                    <tr>
                        <td class="mono"><?php echo e($student->currentAcademicRecord->roll_no); ?></td>
                        <td>
                            <div style="font-weight:700;"><?php echo e($student->user->name); ?></div>
                            <div class="student-reg"><?php echo e($student->registration_no); ?></div>
                        </td>
                        <td>
                            <div class="role-tabs" style="margin:0;max-width:400px;">
                                <?php $__currentLoopData = App\Enums\AttendanceStatus::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendanceStatus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($attendanceStatus->value !== 'holiday'): ?>
                                        <label class="role-tab" style="cursor:pointer;text-align:center;flex:1;" :class="{ 'active': status === '<?php echo e($attendanceStatus->value); ?>' }" x-data="{ status: '<?php echo e($status); ?>' }">
                                            <input type="radio" name="attendance[<?php echo e($student->id); ?>]" value="<?php echo e($attendanceStatus->value); ?>" style="display:none;" @change="status = '<?php echo e($attendanceStatus->value); ?>'" <?php if($status === $attendanceStatus->value): echo 'checked'; endif; ?>>
                                            <?php echo e(ucfirst(str_replace('_', ' ', $attendanceStatus->value))); ?>

                                        </label>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div style="margin-top:2rem;display:flex;justify-content:flex-end;">
                <button class="btn-primary-sms" type="submit" style="padding:1rem 3rem;"><i class="bi bi-check-all"></i> Save Attendance</button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1\htdocs\SMS\codex\sms-app\resources\views/attendance/create.blade.php ENDPATH**/ ?>