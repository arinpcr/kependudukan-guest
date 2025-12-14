<?php $__env->startSection('title', 'Login Guest - Sistem Kependudukan'); ?>

<?php $__env->startSection('styles'); ?>

<style>
    :root {
        --bs-primary: #ff4880;
        --bs-secondary: #ffb6c1;
        --bs-white: #ffffff;
        --bs-dark: #000000;
    }

    body {
        background: linear-gradient(135deg, #ffe6f0, #ffc6d9);
        font-family: 'Montserrat', sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        padding: 20px;
        animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .login-container {
        width: 100%;
        max-width: 450px;
    }

    .login-card {
        background: var(--bs-white);
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(255, 72, 128, 0.1);
        overflow: hidden;
        border: none;
        transition: transform 0.3s ease;
    }

    .login-card:hover {
        transform: translateY(-5px);
    }

    .login-header {
        background: linear-gradient(135deg, var(--bs-primary), #ff2d6d);
        color: var(--bs-white);
        padding: 40px 30px;
        text-align: center;
        position: relative;
    }

    .login-header::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50% 20% / 10% 40%;
    }

    .login-header h2 {
        margin: 0;
        font-weight: 600;
        font-family: 'Fredoka', sans-serif;
        font-size: 2rem;
        position: relative;
        z-index: 2;
    }

    .login-header i {
        font-size: 3rem;
        margin-bottom: 20px;
        display: block;
        position: relative;
        z-index: 2;
    }

    .login-header small {
        font-weight: 300;
        position: relative;
        z-index: 2;
        opacity: 0.9;
    }

    .login-body {
        padding: 40px;
    }

    .form-floating {
        margin-bottom: 25px;
    }

    .form-control {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 16px;
        font-size: 15px;
        font-family: 'Montserrat', sans-serif;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 0.2rem rgba(255, 72, 128, 0.25);
    }

    .form-label {
        color: #495057;
        font-weight: 500;
        font-family: 'Montserrat', sans-serif;
    }

    .btn-login {
        background: linear-gradient(135deg, var(--bs-primary), #ff2d6d);
        border: none;
        border-radius: 10px;
        padding: 16px;
        font-weight: 600;
        font-size: 16px;
        font-family: 'Montserrat', sans-serif;
        transition: all 0.5s ease;
        width: 100%;
        position: relative;
        overflow: hidden;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 72, 128, 0.4);
        background: linear-gradient(135deg, #ff2d6d, var(--bs-primary));
    }

    .btn-login:active {
        transform: translateY(0);
    }

    .login-links {
        text-align: center;
        margin-top: 25px;
    }

    .login-links a {
        color: #6c757d;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        font-family: 'Montserrat', sans-serif;
    }

    .login-links a:hover {
        color: var(--bs-primary);
        transform: translateX(2px);
    }

    .alert {
        border-radius: 10px;
        border: none;
        margin-bottom: 25px;
        font-family: 'Montserrat', sans-serif;
    }

    .alert-danger {
        background: rgba(255, 72, 128, 0.1);
        color: #dc3545;
        border: 1px solid rgba(255, 72, 128, 0.2);
    }

    .error-message {
        animation: shake 0.5s ease-in-out;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        50% { transform: translateX(5px); }
        75% { transform: translateX(-5px); }
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        color: #6c757d;
        text-decoration: none;
        margin-bottom: 25px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        font-family: 'Montserrat', sans-serif;
    }

    .back-link:hover {
        color: var(--bs-primary);
        transform: translateX(-3px);
    }

    .back-link i {
        margin-right: 8px;
        transition: transform 0.3s ease;
    }

    .back-link:hover i {
        transform: translateX(-3px);
    }

    .btn-close {
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ff4880'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
    }

    .invalid-feedback {
        color: var(--bs-primary);
        font-weight: 500;
    }

    .text-primary {
        color: var(--bs-primary) !important;
    }

    .border-primary {
        border-color: var(--bs-primary) !important;
    }

    /* Spinner styles matching your CSS */
    #spinner {
        opacity: 0;
        visibility: hidden;
        transition: opacity .8s ease-out, visibility 0s linear .5s;
        z-index: 99999;
    }

    #spinner.show {
        transition: opacity .8s ease-out, visibility 0s linear .0s;
        visibility: visible;
        opacity: 1;
    }

    /* Button styles matching your CSS */
    .btn {
        font-weight: 600;
        transition: .5s;
    }

    .btn.btn-primary {
        border: 0;
        color: var(--bs-white);
    }

    .btn.btn-primary:hover {
        background: var(--bs-secondary);
        color: var(--bs-primary);
    }

    .btn-border-radius {
        border-radius: 25% 10%;
    }

    /* Register link section */
    .register-section {
        text-align: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }

    .register-section p {
        margin-bottom: 15px;
        color: #6c757d;
        font-size: 15px;
    }

    .register-link {
        color: var(--bs-primary) !important;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
    }

    .register-link:hover {
        color: #ff2d6d !important;
        transform: translateY(-2px);
    }

    .register-link i {
        margin-right: 8px;
        transition: transform 0.3s ease;
    }

    .register-link:hover i {
        transform: translateX(3px);
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <i class="fas fa-user-lock"></i>
            <h2>Login Guest</h2>
            <small>Sistem Kependudukan</small>
        </div>

        <div class="login-body">
            <a href="<?php echo e(url('/')); ?>" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show error-message" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong><?php echo e(session('error')); ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show error-message" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2" style="padding-left: 20px;">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong><?php echo e(session('success')); ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('auth.login.post')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="form-floating">
                    <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           name="email" id="email" value="<?php echo e(old('email')); ?>"
                           placeholder="name@example.com" required autofocus>
                    <label for="email">
                        <i class="fas fa-envelope me-2 text-primary"></i>Email
                    </label>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-floating">
                    <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           name="password" id="password" placeholder="Password" required>
                    <label for="password">
                        <i class="fas fa-lock me-2 text-primary"></i>Password
                    </label>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <button type="submit" class="btn btn-primary btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Login Masuk
                </button>
            </form>

            <div class="login-links">
                <a href="#">
                    <i class="fas fa-key me-1"></i>Lupa Password?
                </a>
            </div>

            <div class="register-section text-center mt-4 pt-3 border-top">
    <p class="mb-2 text-muted">Belum punya akun?</p>
    <a href="<?php echo e(route('auth.register')); ?>" class="register-link text-decoration-none fw-bold text-primary">
        <i class="fas fa-user-plus me-1"></i>Daftar Akun Baru di sini
    </a>
</div>

            </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto focus on email field
        const emailInput = document.getElementById('email');
        if (emailInput) {
            emailInput.focus();
        }

        // Form submission loading state
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                }
            });
        }

        // Auto-dismiss alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });

        // Show success message from register redirect
        <?php if(session('success')): ?>
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(successAlert);
                    bsAlert.close();
                }, 5000);
            }
        <?php endif; ?>
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.guest.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\arin\laragon-6.0-minimal\www\kependudukan-guest\resources\views/pages/auth/login-form.blade.php ENDPATH**/ ?>