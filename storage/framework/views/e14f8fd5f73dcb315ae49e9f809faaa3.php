<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title><?php echo $__env->yieldContent('title', 'Sistem Kependudukan Desa'); ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Sistem Kependudukan, Desa, Data Warga" name="keywords">
    <meta content="Sistem Kependudukan Desa - Pengelolaan Data Warga Terintegrasi" name="description">
    
    <!-- ========== FAVICON ========== -->
    <!-- Basic ICO -->
    <link rel="shortcut icon" href="<?php echo e(asset('favicon_io/favicon.ico')); ?>" type="image/x-icon">
    
    <!-- PNG Favicons -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('favicon_io/favicon-32x32.png')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('favicon_io/favicon-16x16.png')); ?>">
    
    <!-- Apple Devices -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('favicon_io/apple-touch-icon.png')); ?>">
    
    <!-- Android Chrome -->
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo e(asset('favicon_io/android-chrome-192x192.png')); ?>">
    <link rel="icon" type="image/png" sizes="512x512" href="<?php echo e(asset('favicon_io/android-chrome-512x512.png')); ?>">
    
    <!-- Web Manifest (PWA) -->
    <link rel="manifest" href="<?php echo e(asset('favicon_io/site.webmanifest')); ?>">
    
    <!-- Theme Colors -->
    <meta name="theme-color" content="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <!-- ========== END FAVICON ========== -->
    
    <!-- Include CSS -->
    <?php echo $__env->make('layouts.guest.css', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <!-- Additional CSS -->
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>
    <!-- Spinner -->
    <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50 d-flex align-items-center justify-content-center" style="z-index: 9999;">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>

    <!-- Header -->
    <?php echo $__env->make('layouts.guest.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Main Content -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <?php echo $__env->make('layouts.guest.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- WhatsApp Float -->
    <a href="https://wa.me/?text=Halo%20Admin%2C%20saya%20ingin%20bertanya%20tentang%20Sistem%20Kependudukan."
       class="whatsapp-float" target="_blank" rel="noopener" title="Hubungi kami di WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- WhatsApp Button Style -->
    <style>
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 25px;
            right: 25px;
            background-color: #25D366;
            color: #fff;
            border-radius: 50%;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.3);
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: bounceIn 0.8s ease;
        }

        .whatsapp-float:hover {
            background-color: #20ba5a;
            transform: scale(1.1);
            box-shadow: 4px 4px 15px rgba(0,0,0,0.4);
        }

        @keyframes bounceIn {
            0% { transform: scale(0.5); opacity: 0; }
            60% { transform: scale(1.2); opacity: 1; }
            100% { transform: scale(1); }
        }
    </style>

    <!-- Include JavaScript -->
    <?php echo $__env->make('layouts.guest.js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <!-- Additional Scripts -->
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH D:\arin\laragon-6.0-minimal\www\kependudukan-guest\resources\views/layouts/guest/app.blade.php ENDPATH**/ ?>