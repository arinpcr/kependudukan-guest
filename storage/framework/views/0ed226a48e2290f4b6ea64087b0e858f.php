<?php $__env->startSection('title', 'Login - Sistem Kependudukan'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-page-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <img src="<?php echo e(asset('assets-guest/img/logo2.png')); ?>" alt="Logo">
            <h2>Login</h2>
            <small>Sistem Kependudukan</small>
        </div>

        <div class="auth-body">
            <a href="<?php echo e(url('/')); ?>" class="back-link">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
            </a>

            <?php if(session('error') || $errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show error-shake" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?php echo e(session('error') ?? 'Periksa kembali email dan password Anda.'); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('auth.login.post')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control auth-form-control" id="email" placeholder="name@example.com" required autofocus>
                    <label for="email"><i class="fas fa-envelope me-2 text-primary"></i>Email</label>
                </div>

                <div class="form-floating mb-4">
                    <input type="password" name="password" class="form-control auth-form-control" id="password" placeholder="Password" required>
                    <label for="password"><i class="fas fa-lock me-2 text-primary"></i>Password</label>
                </div>

                <button type="submit" class="btn-auth-submit mb-3">
                    <i class="fas fa-sign-in-alt me-2"></i>Login Masuk
                </button>
            </form>

            <div class="text-center">
                <a href="#" class="text-muted small text-decoration-none">Lupa Password?</a>
            </div>

            <div class="register-section">
                <p class="text-muted small">Belum punya akun?</p>
                <a href="<?php echo e(route('auth.register')); ?>" class="text-primary fw-bold text-decoration-none">
                    <i class="fas fa-user-plus me-1"></i>Daftar Akun Baru
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.guest.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\arin\laragon-6.0-minimal\www\kependudukan-guest\resources\views/pages/auth/login-form.blade.php ENDPATH**/ ?>