<?php $__env->startSection('title', 'Daftar Akun - Sistem Kependudukan'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-page-wrapper">
    <div class="auth-card" style="max-width: 500px;">
        <div class="auth-header">
            <img src="<?php echo e(asset('assets-guest/img/logo2.png')); ?>" alt="Logo">
            <h2>Daftar</h2>
            <small>Bergabung dengan kami</small>
        </div>

        <div class="auth-body">
            <a href="<?php echo e(route('auth.login')); ?>" class="back-link">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Login
            </a>

            <form action="<?php echo e(route('auth.register.post')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-floating mb-3">
                    <input type="text" name="name" class="form-control auth-form-control" id="name" placeholder="Nama" required>
                    <label for="name"><i class="fas fa-user me-2 text-primary"></i>Nama Lengkap</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control auth-form-control" id="email" placeholder="Email" required>
                    <label for="email"><i class="fas fa-envelope me-2 text-primary"></i>Email</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control auth-form-control" id="password" placeholder="Password" required>
                    <label for="password"><i class="fas fa-lock me-2 text-primary"></i>Password</label>
                </div>

                <div class="form-floating mb-4">
                    <input type="password" name="password_confirmation" class="form-control auth-form-control" id="confirm" placeholder="Konfirmasi" required>
                    <label for="confirm"><i class="fas fa-lock me-2 text-primary"></i>Konfirmasi Password</label>
                </div>

                <button type="submit" class="btn-auth-submit">
                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                </button>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                    <label class="form-check-label text-muted" for="terms">
                        Saya setuju dengan <a href="#" class="text-primary text-decoration-none">Syarat & Ketentuan</a>
                    </label>
                </div>
                
            </form>

            <div class="register-section">
                <a href="<?php echo e(route('auth.login')); ?>" class="text-muted small text-decoration-none">Sudah punya akun? Login di sini</a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.guest.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\arin\laragon-6.0-minimal\www\kependudukan-guest\resources\views/pages/auth/register.blade.php ENDPATH**/ ?>