<?php $__env->startSection('title', 'Dashboard | EduCore SMS'); ?>
<?php $__env->startSection('page_title', 'Dashboard'); ?>
<?php $__env->startSection('breadcrumb', '/ Overview'); ?>

<?php $__env->startSection('content'); ?>
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-label">Total Students</div>
            <div class="kpi-value"><?php echo e(number_format($metrics['students'])); ?></div>
            <div class="delta-up">Campus wide enrollment</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Today's Attendance</div>
            <div class="kpi-value"><?php echo e($metrics['attendance']['percentage']); ?>%</div>
            <div class="delta-up"><?php echo e($metrics['attendance']['present_count']); ?> present today</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Fee Collected</div>
            <div class="kpi-value">PKR <?php echo e(number_format($metrics['fees']['collected'])); ?></div>
            <div class="delta-down">PKR <?php echo e(number_format($metrics['fees']['pending'])); ?> pending</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Active Staff</div>
            <div class="kpi-value"><?php echo e(number_format($metrics['staff_count'])); ?></div>
            <div class="muted"><?php echo e($activeCampus?->name ?? 'Campus not selected'); ?></div>
        </div>
    </div>

    <div class="dashboard-grid">
        <div>
            <div class="card-sms">
                <div class="card-title">Collection by Class</div>
                <?php $__currentLoopData = $collectionByClass; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bar-row">
                        <div style="width:90px;"><?php echo e($row['name']); ?></div>
                        <div class="bar-track"><div class="bar-fill" style="width: <?php echo e($row['percentage']); ?>%;"></div></div>
                        <div style="width:48px;text-align:right;font-weight:700;"><?php echo e($row['percentage']); ?>%</div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="card-sms" style="margin-top:1.25rem;">
                <div class="card-title">Recent Fee Payments <span class="card-title-action">Live seeded data</span></div>
                <table class="sms-table">
                    <thead>
                    <tr>
                        <th>Student</th>
                        <th>Class</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $recentPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($payment->student?->user?->name ?? 'Student'); ?></td>
                            <td><?php echo e($payment->student?->currentAcademicRecord?->schoolClass?->name ?? 'N/A'); ?></td>
                            <td class="mono">PKR <?php echo e(number_format($payment->amount_paid)); ?></td>
                            <td><?php echo e($payment->payment_date?->format('M j, Y')); ?></td>
                            <td><span class="status-pill pill-paid">Paid</span></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-sms">
            <div class="card-title">Recent Activity</div>
            <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="activity-item">
                    <div class="activity-icon tone-<?php echo e($activity->tone); ?>"><i class="bi <?php echo e($activity->icon); ?>"></i></div>
                    <div>
                        <div style="font-weight:700;"><?php echo e($activity->title); ?></div>
                        <div class="muted"><?php echo e($activity->description); ?></div>
                        <div class="muted" style="font-size:.8rem;"><?php echo e($activity->logged_at->diffForHumans()); ?></div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1\htdocs\SMS\codex\sms-app\resources\views/dashboard/index.blade.php ENDPATH**/ ?>