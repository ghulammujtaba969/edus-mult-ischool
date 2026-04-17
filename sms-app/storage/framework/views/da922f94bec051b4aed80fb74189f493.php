<?php $__env->startSection('title', 'Students | EduCore SMS'); ?>
<?php $__env->startSection('page_title', 'Students'); ?>
<?php $__env->startSection('breadcrumb', '/ All Students'); ?>

<?php $__env->startSection('topbar_actions'); ?>
    <a class="btn-primary-sms" href="<?php echo e(route('admin.students.create')); ?>"><i class="bi bi-plus-lg"></i> Enroll Student</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert-box" style="background:var(--success-bg);border-color:var(--success);color:var(--success);">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <div class="summary-row">
        <div class="summary-pill"><span class="status-pill pill-active">Active</span> <strong><?php echo e($statusCounts['active']); ?></strong></div>
        <div class="summary-pill"><span class="status-pill pill-partial">New</span> <strong><?php echo e($statusCounts['enrolled']); ?></strong></div>
        <div class="summary-pill"><span class="status-pill pill-inactive">Left / TC</span> <strong><?php echo e($statusCounts['left']); ?></strong></div>
        <div class="summary-pill alert"><i class="bi bi-exclamation-circle"></i> <strong><?php echo e($statusCounts['defaulters']); ?></strong> fee defaulters</div>
    </div>

    <form class="list-toolbar" method="GET" action="<?php echo e(route('admin.students.index')); ?>">
        <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input class="search-input" type="text" name="q" value="<?php echo e($filters['q'] ?? ''); ?>" placeholder="Search by name, reg no, B-Form">
        </div>
        <select class="filter-select" name="class">
            <option value="">All Classes</option>
            <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($class->id); ?>" <?php if(($filters['class'] ?? '') == $class->id): echo 'selected'; endif; ?>><?php echo e($class->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <select class="filter-select" name="status">
            <option value="">All Status</option>
            <?php $__currentLoopData = ['active' => 'Active', 'enrolled' => 'Enrolled', 'left' => 'Left', 'transferred' => 'Transferred']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($value); ?>" <?php if(($filters['status'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <select class="filter-select" name="gender">
            <option value="">All Genders</option>
            <?php $__currentLoopData = ['Male', 'Female']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($gender); ?>" <?php if(($filters['gender'] ?? '') === $gender): echo 'selected'; endif; ?>><?php echo e($gender); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button class="btn-primary-sms" type="submit"><i class="bi bi-funnel"></i> Filter</button>
    </form>

    <div class="data-card">
        <div class="data-card-header">
            <div>Showing <strong><?php echo e($students->count()); ?></strong> of <strong><?php echo e($students->total()); ?></strong> students</div>
        </div>
        <table class="sms-table">
            <thead>
            <tr>
                <th>Student</th>
                <th>Reg No.</th>
                <th>Class / Section</th>
                <th>Gender</th>
                <th>Father</th>
                <th>Contact</th>
                <th>Fee Status</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php ($invoice = $student->feeInvoices->first()); ?>
                <tr>
                    <td>
                        <div style="display:flex;gap:.75rem;align-items:center;">
                            <div class="student-avatar" style="background:var(--coral-pale);color:var(--coral);"><?php echo e(str($student->user?->name ?? 'ST')->substr(0, 2)->upper()); ?></div>
                            <div>
                                <div style="font-weight:700;"><?php echo e($student->user?->name ?? 'Student'); ?></div>
                                <div class="student-reg"><?php echo e($student->b_form_no); ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="mono"><?php echo e($student->registration_no); ?></td>
                    <td><?php echo e($student->currentAcademicRecord?->schoolClass?->name); ?> / <?php echo e($student->currentAcademicRecord?->section?->name); ?></td>
                    <td><span class="status-pill <?php echo e($student->gender === 'Male' ? 'pill-male' : 'pill-female'); ?>"><?php echo e($student->gender); ?></span></td>
                    <td><?php echo e($student->guardian?->father_name); ?></td>
                    <td class="mono"><?php echo e($student->guardian?->father_phone); ?></td>
                    <td>
                        <span class="status-pill <?php echo e($invoice?->status?->value === 'paid' ? 'pill-paid' : ($invoice?->status?->value === 'partial' ? 'pill-partial' : 'pill-unpaid')); ?>">
                            <?php echo e($invoice?->status?->value ? ucfirst($invoice->status->value) : 'N/A'); ?>

                        </span>
                    </td>
                    <td><span class="status-pill <?php echo e(in_array($student->status->value, ['active', 'enrolled']) ? 'pill-active' : 'pill-inactive'); ?>"><?php echo e(ucfirst($student->status->value)); ?></span></td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="<?php echo e(route('admin.students.show', $student)); ?>" title="View Profile"><i class="bi bi-eye"></i></a>
                            <a class="btn-outline-sms" href="<?php echo e(route('admin.students.edit', $student)); ?>" title="Edit Student"><i class="bi bi-pencil"></i></a>
                            <form action="<?php echo e(route('admin.students.destroy', $student)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="btn-outline-sms" style="color:var(--danger);" type="submit" title="Delete Student"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div class="data-footer">
            <div class="muted">Page <?php echo e($students->currentPage()); ?> of <?php echo e($students->lastPage()); ?></div>
            <div style="display:flex;gap:.5rem;">
                <?php if($students->onFirstPage()): ?>
                    <span class="btn-outline-sms" style="opacity:.55;">Previous</span>
                <?php else: ?>
                    <a class="btn-outline-sms" href="<?php echo e($students->previousPageUrl()); ?>">Previous</a>
                <?php endif; ?>

                <?php if($students->hasMorePages()): ?>
                    <a class="btn-outline-sms" href="<?php echo e($students->nextPageUrl()); ?>">Next</a>
                <?php else: ?>
                    <span class="btn-outline-sms" style="opacity:.55;">Next</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1\htdocs\SMS\codex\sms-app\resources\views/students/index.blade.php ENDPATH**/ ?>