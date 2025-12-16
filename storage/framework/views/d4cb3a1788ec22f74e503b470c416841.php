

<?php $__env->startSection('title', 'Ganti Password - Sistem Kependudukan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-5">
    <div class="container py-5">
        
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Keamanan Akun</h4>
            <h1 class="mb-5 display-4">Ganti Password</h1>
        </div>

        <div class="row justify-content-center wow fadeIn" data-wow-delay="0.3s">
            <div class="col-lg-6 col-md-8">
                <div class="card border-primary shadow-sm">
                    <div class="card-header bg-primary text-white p-4 text-center">
                        <i class="fas fa-lock fa-3x mb-2"></i>
                        <h5 class="mb-0 text-white">Formulir Perubahan Password</h5>
                    </div>
                    <div class="card-body p-5">

                        <a href="<?php echo e(route('profile')); ?>" class="btn btn-sm btn-outline-secondary mb-4">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Profile
                        </a>

                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong><i class="fas fa-exclamation-triangle me-2"></i>Terjadi Kesalahan:</strong>
                                <ul class="mb-0 mt-2">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo e(route('profile.password.update')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <div class="form-floating mb-4 position-relative">
                                <input type="password" class="form-control password-input <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="current_password" name="current_password" placeholder="Password Saat Ini" required>
                                <label for="current_password">
                                    <i class="fas fa-key me-2 text-primary"></i>Password Saat Ini
                                </label>
                                <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer toggle-password" 
                                      onclick="togglePassword('current_password', this)">
                                    <i class="fas fa-eye text-muted"></i>
                                </span>
                                <?php $__errorArgs = ['current_password'];
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

                            <hr class="my-4 text-muted">

                            <div class="form-floating mb-3 position-relative">
                                <input type="password" class="form-control password-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="password" name="password" placeholder="Password Baru" required>
                                <label for="password">
                                    <i class="fas fa-lock me-2 text-primary"></i>Password Baru
                                </label>
                                <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer toggle-password" 
                                      onclick="togglePassword('password', this)">
                                    <i class="fas fa-eye text-muted"></i>
                                </span>
                                <small class="text-muted ms-2">Minimal 8 karakter.</small>
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

                            <div class="form-floating mb-4 position-relative">
                                <input type="password" class="form-control password-input" 
                                       id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password Baru" required>
                                <label for="password_confirmation">
                                    <i class="fas fa-check-double me-2 text-primary"></i>Ulangi Password Baru
                                </label>
                                <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer toggle-password" 
                                      onclick="togglePassword('password_confirmation', this)">
                                    <i class="fas fa-eye text-muted"></i>
                                </span>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary py-3 fw-bold title-border-radius">
                                    <i class="fas fa-save me-2"></i>Simpan Password Baru
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer bg-light text-center p-3">
                        <small class="text-muted">Pastikan Anda mengingat password baru Anda sebelum menyimpannya.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .title-border-radius {
        border-radius: 10px;
    }
    .cursor-pointer {
        cursor: pointer;
        z-index: 10; /* Pastikan ikon di atas input */
    }
    /* Memberi jarak teks agar tidak tertabrak ikon mata */
    .password-input {
        padding-right: 40px; 
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    /**
     * Fungsi untuk Toggle Password Visibility
     * @param inputId ID dari input field
     * @param iconSpan Element span pembungkus ikon
     */
    function togglePassword(inputId, iconSpan) {
        const input = document.getElementById(inputId);
        const icon = iconSpan.querySelector('i');

        // Cek tipe saat ini
        if (input.type === "password") {
            // Ubah jadi text (terlihat)
            input.type = "text";
            // Ubah ikon jadi mata dicoret
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            // Ubah balik jadi password (tersembunyi)
            input.type = "password";
            // Ubah ikon jadi mata biasa
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.guest.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\arin\laragon-6.0-minimal\www\kependudukan-guest\resources\views/pages/profile-password.blade.php ENDPATH**/ ?>