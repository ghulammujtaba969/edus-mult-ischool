<?php $__env->startSection('title', ($student->user?->name ?? 'Student') . ' | EduCore SMS'); ?>
<?php $__env->startSection('page_title', 'Student Profile'); ?>
<?php $__env->startSection('breadcrumb', '/ ' . ($student->user?->name ?? 'Student')); ?>

<?php $__env->startSection('topbar_actions'); ?>
    <a class="btn-outline-sms" href="<?php echo e(route('admin.students.index')); ?>"><i class="bi bi-arrow-left"></i> Back</a>
    <button class="btn-outline-sms" type="button"><i class="bi bi-printer"></i> Print Card</button>
    <a class="btn-primary-sms" href="<?php echo e(route('admin.students.edit', $student)); ?>"><i class="bi bi-pencil"></i> Edit Profile</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="profile-grid" x-data="{ tab: 'info' }">
        <div>
            <div class="profile-card">
                <div class="profile-hero">
                    <div class="profile-avatar"><?php echo e(str($student->user?->name ?? 'ST')->substr(0, 2)->upper()); ?></div>
                </div>
                <div class="profile-name"><?php echo e($student->user?->name); ?></div>
                <div class="profile-class"><?php echo e($student->currentAcademicRecord?->schoolClass?->name); ?> - Section <?php echo e($student->currentAcademicRecord?->section?->name); ?></div>
                <div class="profile-reg"><?php echo e($student->registration_no); ?></div>
                <div style="display:flex;gap:.5rem;flex-wrap:wrap;margin:1rem 0;">
                    <span class="status-pill pill-active"><?php echo e(ucfirst($student->status->value)); ?></span>
                    <span class="status-pill <?php echo e($student->gender === 'Male' ? 'pill-male' : 'pill-female'); ?>"><?php echo e($student->gender); ?></span>
                    <span class="status-pill pill-partial">Roll #<?php echo e($student->currentAcademicRecord?->roll_no); ?></span>
                </div>
                <div class="profile-info-grid">
                    <div class="info-field"><label>Date of Birth</label><span><?php echo e($student->date_of_birth->format('d M, Y')); ?></span></div>
                    <div class="info-field"><label>Blood Group</label><span><?php echo e($student->blood_group); ?></span></div>
                    <div class="info-field"><label>B-Form No.</label><span class="mono"><?php echo e($student->b_form_no); ?></span></div>
                    <div class="info-field"><label>Enrolled</label><span><?php echo e($student->enrollment_date->format('M Y')); ?></span></div>
                </div>
                <div class="contact-row"><i class="bi bi-telephone-fill"></i><span><?php echo e($student->guardian?->father_phone); ?></span></div>
                <div class="contact-row"><i class="bi bi-envelope-fill"></i><span><?php echo e($student->email); ?></span></div>
                <div class="contact-row"><i class="bi bi-geo-alt-fill"></i><span><?php echo e($student->address); ?></span></div>
            </div>

            <?php ($latestInvoice = $recentInvoices->first()); ?>
            <div class="card-sms" style="margin-top:1rem;">
                <div class="card-title">Fee Status</div>
                <?php if($latestInvoice): ?>
                    <div class="summary-pill <?php echo e($latestInvoice->status->value === 'paid' ? '' : 'alert'); ?>">
                        <span class="status-pill <?php echo e($latestInvoice->status->value === 'paid' ? 'pill-paid' : ($latestInvoice->status->value === 'partial' ? 'pill-partial' : 'pill-unpaid')); ?>"><?php echo e(ucfirst($latestInvoice->status->value)); ?></span>
                        <strong>PKR <?php echo e(number_format($latestInvoice->net_amount)); ?></strong>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card-sms">
            <div class="tab-nav">
                <button class="tab-btn" :class="{ 'active': tab === 'info' }" @click="tab = 'info'">Personal Info</button>
                <button class="tab-btn" :class="{ 'active': tab === 'results' }" @click="tab = 'results'">Results</button>
                <button class="tab-btn" :class="{ 'active': tab === 'attendance' }" @click="tab = 'attendance'">Attendance</button>
                <button class="tab-btn" :class="{ 'active': tab === 'fees' }" @click="tab = 'fees'">Fee History</button>
            </div>

            <div x-show="tab === 'info'">
                <h3>Parent / Guardian Information</h3>
                <div class="info-grid-2">
                    <div class="info-field"><label>Father's Name</label><span><?php echo e($student->guardian?->father_name); ?></span></div>
                    <div class="info-field"><label>Father's CNIC</label><span class="mono"><?php echo e($student->guardian?->father_cnic); ?></span></div>
                    <div class="info-field"><label>Father's Occupation</label><span><?php echo e($student->guardian?->father_occupation); ?></span></div>
                    <div class="info-field"><label>Emergency Contact</label><span><?php echo e($student->guardian?->emergency_contact); ?></span></div>
                    <div class="info-field"><label>Mother's Name</label><span><?php echo e($student->guardian?->mother_name); ?></span></div>
                    <div class="info-field"><label>Mother's Phone</label><span><?php echo e($student->guardian?->mother_phone); ?></span></div>
                </div>

                <h3>Academic Information</h3>
                <div class="info-grid-3">
                    <div class="info-field"><label>Current Class</label><span><?php echo e($student->currentAcademicRecord?->schoolClass?->name); ?></span></div>
                    <div class="info-field"><label>Section</label><span><?php echo e($student->currentAcademicRecord?->section?->name); ?></span></div>
                    <div class="info-field"><label>Roll Number</label><span><?php echo e($student->currentAcademicRecord?->roll_no); ?></span></div>
                </div>
            </div>

            <div x-show="tab === 'results'" x-cloak>
                <div class="summary-pill"><strong><?php echo e($resultSummary['percentage']); ?>%</strong> overall academic average</div>
                <?php $__currentLoopData = $resultSummary['records']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mark): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="result-subject-row">
                        <div style="width:140px;"><?php echo e($mark->subject?->name); ?></div>
                        <div class="mono"><?php echo e($mark->obtained_marks); ?> / <?php echo e($mark->total_marks); ?></div>
                        <div class="bar-track"><div class="bar-fill" style="width: <?php echo e(round(($mark->obtained_marks / max($mark->total_marks, 1)) * 100)); ?>%;"></div></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div x-show="tab === 'attendance'" x-cloak>
                <div class="summary-row">
                    <div class="summary-pill"><strong><?php echo e($attendanceSummary['overall']); ?>%</strong> overall</div>
                    <div class="summary-pill"><strong><?php echo e($attendanceSummary['present']); ?></strong> present</div>
                    <div class="summary-pill"><strong><?php echo e($attendanceSummary['absent']); ?></strong> absent</div>
                    <div class="summary-pill"><strong><?php echo e($attendanceSummary['leave']); ?></strong> leave</div>
                </div>
                <table class="sms-table">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Method</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $student->attendanceRecords->sortByDesc('attendance_date')->take(12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($attendance->attendance_date->format('M j, Y')); ?></td>
                            <td><span class="status-pill <?php echo e(in_array($attendance->status->value, ['present', 'late', 'half_day']) ? 'pill-paid' : ($attendance->status->value === 'leave' ? 'pill-partial' : 'pill-unpaid')); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $attendance->status->value))); ?></span></td>
                            <td><?php echo e(ucfirst($attendance->method)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <div x-show="tab === 'fees'" x-cloak>
                <table class="sms-table">
                    <thead>
                    <tr>
                        <th>Month</th>
                        <th>Fee Type</th>
                        <th>Amount</th>
                        <th>Paid</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $recentInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($invoice->billing_month->format('M Y')); ?></td>
                            <td><?php echo e($invoice->feeType?->name); ?></td>
                            <td class="mono">PKR <?php echo e(number_format($invoice->net_amount)); ?></td>
                            <td class="mono">PKR <?php echo e(number_format($invoice->paid_amount)); ?></td>
                            <td><span class="status-pill <?php echo e($invoice->status->value === 'paid' ? 'pill-paid' : ($invoice->status->value === 'partial' ? 'pill-partial' : 'pill-unpaid')); ?>"><?php echo e(ucfirst($invoice->status->value)); ?></span></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1\htdocs\SMS\codex\sms-app\resources\views/students/show.blade.php ENDPATH**/ ?>