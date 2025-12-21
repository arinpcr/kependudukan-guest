<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&family=Fredoka:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo e(asset('assets-guest/css/style.css')); ?>">
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>
    <?php echo $__env->yieldContent('content'); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\arin\laragon-6.0-minimal\www\kependudukan-guest\resources\views/layouts/guest/auth.blade.php ENDPATH**/ ?>