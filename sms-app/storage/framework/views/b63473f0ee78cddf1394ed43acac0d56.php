<?php $__env->startSection('title', 'Fee Invoices | EduCore SMS'); ?>
<?php $__env->startSection('page_title', 'Fee Invoices'); ?>
<?php $__env->startSection('breadcrumb', '/ Fees / Invoices'); ?>

<?php $__env->startSection('topbar_actions'); ?>
    <a class="btn-primary-sms" href="<?php echo e(route('admin.fee-invoices.create')); ?>"><i class="bi bi-lightning-charge"></i> Bulk Generate</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert-box" style="background:var(--success-bg);border-color:var(--success);color:var(--success);">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <form class="list-toolbar" method="GET" action="<?php echo e(route('admin.fee-invoices.index')); ?>">
        <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input class="search-input" type="text" name="q" value="<?php echo e($filters['q'] ?? ''); ?>" placeholder="Search Challan # or Student">
        </div>
        <select class="filter-select" name="status">
            <option value="">All Status</option>
            <option value="unpaid" <?php if(($filters['status'] ?? '') === 'unpaid'): echo 'selected'; endif; ?>>Unpaid</option>
            <option value="partially_paid" <?php if(($filters['status'] ?? '') === 'partially_paid'): echo 'selected'; endif; ?>>Partially Paid</option>
            <option value="paid" <?php if(($filters['status'] ?? '') === 'paid'): echo 'selected'; endif; ?>>Paid</option>
        </select>
        <button class="btn-primary-sms" type="submit"><i class="bi bi-funnel"></i> Filter</button>
    </form>

    <div class="data-card">
        <table class="sms-table">
            <thead>
            <tr>
                <th>Challan #</th>
                <th>Student</th>
                <th>Month</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="mono"><?php echo e($invoice->challan_no); ?></td>
                    <td style="font-weight:700;"><?php echo e($invoice->student->user->name); ?></td>
                    <td class="mono"><?php echo e($invoice->billing_month->format('M Y')); ?></td>
                    <td class="mono">Rs. <?php echo e(number_format($invoice->net_amount, 2)); ?></td>
                    <td>
                        <span class="status-pill <?php echo e($invoice->status->value === 'paid' ? 'pill-active' : ($invoice->status->value === 'unpaid' ? 'pill-inactive' : 'pill-partial')); ?>">
                            <?php echo e(ucfirst($invoice->status->value)); ?>

                        </span>
                    </td>
                    <td class="mono"><?php echo e($invoice->due_date->format('M d, Y')); ?></td>
                    <td>
                        <div style="display:flex;gap:.5rem;">
                            <a class="btn-outline-sms" href="<?php echo e(route('admin.fee-invoices.show', $invoice)); ?>"><i class="bi bi-eye"></i></a>
                            <button class="btn-outline-sms" type="button" title="Print Challan"><i class="bi bi-printer"></i></button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" style="text-align:center;padding:2rem;color:var(--text-light);">No invoices found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
        <div class="data-footer">
            <?php echo e($invoices->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1\htdocs\SMS\codex\sms-app\resources\views/fee-invoices/index.blade.php ENDPATH**/ ?>