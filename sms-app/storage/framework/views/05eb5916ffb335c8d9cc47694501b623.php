<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'EduCore SMS'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('css/sms.css')); ?>">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
<div class="sms-layout">
    <?php echo $__env->make('partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="main-content">
        <div class="topbar">
            <div>
                <div class="topbar-title"><?php echo $__env->yieldContent('page_title'); ?></div>
                <div class="topbar-breadcrumb"><?php echo $__env->yieldContent('breadcrumb'); ?></div>
            </div>

            <div class="topbar-actions">
                <?php if(auth()->user()->isSuperAdmin()): ?>
                    <form action="<?php echo e(route('campus.switch')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <select class="filter-select" name="campus_id" onchange="this.form.submit()">
                            <?php $__currentLoopData = $layoutCampuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($campus->id); ?>" <?php if(optional($layoutActiveCampus)->id === $campus->id): echo 'selected'; endif; ?>><?php echo e($campus->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </form>
                <?php endif; ?>

                <?php echo $__env->yieldContent('topbar_actions'); ?>

                <form action="<?php echo e(route('logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button class="btn-outline-sms" type="submit"><i class="bi bi-box-arrow-right"></i> Logout</button>
                </form>
            </div>
        </div>

        <div class="page-body">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
</div>
</body>
</html>
<?php /**PATH D:\xampp8.1\htdocs\SMS\codex\sms-app\resources\views/layouts/app.blade.php ENDPATH**/ ?>