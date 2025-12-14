

<?php $__env->startSection('title', 'Tambah Anggota Keluarga - Sistem Kependudukan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Tambah Anggota</h4>
            <h1 class="mb-5 display-4">Formulir Tambah Anggota Keluarga</h1>
        </div>

        <div class="row justify-content-center wow fadeIn" data-wow-delay="0.3s">
            <div class="col-lg-8">
                <div class="bg-light border border-primary rounded p-5">
                    
                    <!-- Info KK -->
                    <div class="card mb-4 border-primary">
                        <div class="card-header bg-primary text-white py-2">
                            <h6 class="mb-0">
                                <i class="fas fa-home me-2"></i>Kartu Keluarga: <?php echo e($keluarga->kk_nomor); ?>

                            </h6>
                        </div>
                        <div class="card-body py-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">Kepala Keluarga:</small>
                                    <p class="mb-1 fw-bold"><?php echo e($keluarga->kepalaKeluarga->nama); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Alamat:</small>
                                    <p class="mb-1 fw-bold"><?php echo e($keluarga->alamat); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="<?php echo e(route('anggota-keluarga.index', $keluarga->kk_id)); ?>" class="btn btn-secondary btn-sm mb-4">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Anggota
                    </a>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-exclamation-triangle me-2"></i>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('anggota-keluarga.store', $keluarga->kk_id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <div class="row g-4">
                            <div class="col-12">
    <div class="form-floating">
        <select class="form-select <?php $__errorArgs = ['warga_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                name="warga_id" id="warga_id" required>
            <option value="">-- Pilih Warga --</option>
            <?php $__currentLoopData = $warga; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wargaItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                <option value="<?php echo e($wargaItem->warga_id); ?>" <?php echo e(old('warga_id') == $wargaItem->warga_id ? 'selected' : ''); ?>>
                    <?php echo e($wargaItem->nama); ?> (KTP: <?php echo e($wargaItem->no_ktp); ?>) - <?php echo e($wargaItem->jenis_kelamin == 'L' ? 'L' : 'P'); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <label for="warga_id">
            <i class="fas fa-user me-2 text-primary"></i>Pilih Warga
        </label>
        <?php $__errorArgs = ['warga_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <div class="form-text">
            <i class="fas fa-info-circle me-1"></i>
            Hanya menampilkan warga yang belum menjadi anggota di KK manapun.
        </div>
    </div>
</div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <select class="form-select <?php $__errorArgs = ['hubungan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            name="hubungan" id="hubungan" required>
                                        <option value="">-- Pilih Hubungan --</option>
                                        <?php $__currentLoopData = $hubunganOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($value); ?>" <?php echo e(old('hubungan') == $value ? 'selected' : ''); ?>>
                                                <?php echo e($label); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <label for="hubungan">
                                        <i class="fas fa-link me-2 text-primary"></i>Hubungan dalam Keluarga
                                    </label>
                                    <?php $__errorArgs = ['hubungan'];
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
                            </div>

                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="<?php echo e(route('anggota-keluarga.index', $keluarga->kk_id)); ?>" class="btn btn-secondary me-md-2 px-4">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fas fa-save me-2"></i>Simpan Anggota
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form submission loading state
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                }
            });
        }

        // Search functionality for warga dropdown
        const wargaSelect = document.getElementById('warga_id');
        if (wargaSelect) {
            const originalOptions = Array.from(wargaSelect.options);
            
            // Create search input
            const searchInput = document.createElement('input');
            searchInput.type = 'text';
            searchInput.className = 'form-control mb-2';
            searchInput.placeholder = 'Cari warga...';
            wargaSelect.parentNode.insertBefore(searchInput, wargaSelect);

            searchInput.addEventListener('input', function(e) {
                const searchTerm = this.value.toLowerCase();
                
                // Clear current options
                while (wargaSelect.options.length > 1) {
                    wargaSelect.remove(1);
                }
                
                // Filter and add matching options
                originalOptions.forEach(option => {
                    if (option.value && option.text.toLowerCase().includes(searchTerm)) {
                        wargaSelect.add(option.cloneNode(true));
                    }
                });
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.guest.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\arin\laragon-6.0-minimal\www\kependudukan-guest\resources\views/pages/anggota-keluarga/create.blade.php ENDPATH**/ ?>