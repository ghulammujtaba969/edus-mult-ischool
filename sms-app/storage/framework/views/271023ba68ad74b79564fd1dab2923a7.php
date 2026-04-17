<?php $__env->startSection('title', 'Staff Management | EduCore SMS'); ?>
<?php $__env->startSection('page_title', 'Staff Management'); ?>
<?php $__env->startSection('breadcrumb', '/ Staff'); ?>

<?php $__env->startSection('topbar_actions'); ?>
    <a class="btn-primary-sms" href="<?php echo e(route('admin.employees.create')); ?>"><i class="bi bi-plus-lg"></i> Add Employee</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert-box" style="background:var(--success-bg);border-color:var(--success);color:var(--success);">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <form class="list-toolbar" method="GET" action="<?php echo e(route('admin.employees.index')); ?>">
        <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input class="search-input" type="text" name="q" value="<?php echo e($filters['q'] ?? ''); ?>" placeholder="Search by name, code, CNIC">
        </div>
        <select class="filter-select" name="role">
            <option value="">All Roles</option>
            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($value); ?>" <?php if(($filters['role'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <select class="filter-select" name="status">
            <option value="">All Status</option>
            <?php $__currentLoopData = ['active' => 'Active', 'inactive' => 'Inactive', 'on_leave' => 'On Leave']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($value); ?>" <?php if(($filters['status'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button class="btn-primary-sms" type="submit"><i class="bi bi-funnel"></i> Filter</button>
    </form>

    <div class="data-card">
        <div class="data-card-header">
            <div>Showing <strong><?php echo e($employees->count()); ?></strong> of <strong><?php echo e($employees->total()); ?></strong> employees</div>
        </div>
        <table class="sms-table">
            <thead>
            <tr>
                <th>Employee</th>
                <th>Code</th>
                <th>Designation</th>
                <th>Department</th>
                <th>Role</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <div style="display:flex;gap:.75rem;align-items:center;">
                            <div class="student-avatar" style="background:var(--info-bg);color:var(--info);"><?php echo e(str($employee->user->name)->substr(0, 2)->upper()); ?></div>
                            <div style="font-weight:700;"><?php echo e($employee->user->name); ?></div>
                        </div>
                    </td>
                    <td class="mono"><?php echo e($employee->employee_code); ?></td>
                    <td><?php echo e($employee->designation); ?></td>
                    <td><?php echo e($employee->department ?? 'N/A'); ?></td>
                    <td><span class="status-pill pill-active"><?php echo e($employee->user->role->label()); ?></span></td>
                    <td class="mono"><?php echo e($employee->phone); ?></td>
                    <td><span class="status-pill <?php echo e($employee->status === 'active' ? 'pill-active' : 'pill-inactive'); ?>"><?php echo e(ucfirst($employee->status)); ?></span></td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="<?php echo e(route('admin.employees.show', $employee)); ?>"><i class="bi bi-eye"></i></a>
                            <a class="btn-outline-sms" href="<?php echo e(route('admin.employees.edit', $employee)); ?>"><i class="bi bi-pencil"></i></a>
                            <form action="<?php echo e(route('admin.employees.destroy', $employee)); ?>" method="POST" onsubmit="return confirm('Are you sure?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="btn-outline-sms" style="color:var(--danger);" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div class="data-footer">
            <div class="muted">Page <?php echo e($employees->currentPage()); ?> of <?php echo e($employees->lastPage()); ?></div>
            <div style="display:flex;gap:.5rem;">
                <?php if($employees->onFirstPage()): ?>
                    <span class="btn-outline-sms" style="opacity:.55;">Previous</span>
                <?php else: ?>
                    <a class="btn-outline-sms" href="<?php echo e($employees->previousPageUrl()); ?>">Previous</a>
                <?php endif; ?>

                <?php if($employees->hasMorePages()): ?>
                    <a class="btn-outline-sms" href="<?php echo e($employees->nextPageUrl()); ?>">Next</a>
                <?php else: ?>
                    <span class="btn-outline-sms" style="opacity:.55;">Next</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1\htdocs\SMS\codex\sms-app\resources\views/employees/index.blade.php ENDPATH**/ ?>