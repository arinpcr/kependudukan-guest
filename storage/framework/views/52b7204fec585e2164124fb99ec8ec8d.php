

<?php $__env->startSection('title', 'Catat Perpindahan Warga'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-5">
    <div class="container py-5">
        
        
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Manajemen Data</h4>
            <h1 class="mb-5 display-4">Catat Perpindahan Warga</h1>
        </div>

        <div class="row justify-content-center wow fadeIn" data-wow-delay="0.3s">
            <div class="col-lg-8">
                <div class="card shadow-sm border-primary">
                    <div class="card-header bg-primary text-white d-flex align-items-center">
                        <i class="fas fa-truck-moving me-2"></i>
                        <h5 class="mb-0 text-white">Formulir Perpindahan Warga</h5>
                    </div>
                    <div class="card-body p-4">

                        
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <strong><i class="fas fa-exclamation-triangle me-2"></i>Periksa inputan Anda:</strong>
                                <ul class="mb-0 mt-2">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        
                        <?php if(session('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <strong>Error Sistem:</strong> <?php echo e(session('error')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo e(route('pindah.store')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>

                            <div class="row g-3">
                                
                                
                                <div class="col-12">
                                    <label class="form-label fw-bold">Pilih Warga</label>
                                    <select name="warga_id" class="form-select <?php $__errorArgs = ['warga_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">-- Cari Nama Warga / NIK --</option>
                                        <?php $__currentLoopData = $warga; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            
                                            <option value="<?php echo e($w->warga_id); ?>" <?php echo e(old('warga_id') == $w->warga_id ? 'selected' : ''); ?> data-alamat="<?php echo e($w->alamat); ?>">
                                                <?php echo e($w->nama); ?> - (NIK: <?php echo e($w->no_ktp); ?>)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
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
                                    <div class="form-text text-muted small">Warga yang dipilih otomatis statusnya akan tercatat pindah.</div>
                                </div>

                                
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tanggal Pindah</label>
                                    <input type="date" name="tgl_pindah" class="form-control <?php $__errorArgs = ['tgl_pindah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('tgl_pindah', date('Y-m-d'))); ?>" required>
                                    <?php $__errorArgs = ['tgl_pindah'];
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
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Jenis Kepindahan</label>
                                    <select name="jenis_pindah" class="form-select <?php $__errorArgs = ['jenis_pindah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="Antar RT/RW" <?php echo e(old('jenis_pindah') == 'Antar RT/RW' ? 'selected' : ''); ?>>Antar RT/RW (Satu Desa)</option>
                                        <option value="Keluar Desa" <?php echo e(old('jenis_pindah') == 'Keluar Desa' ? 'selected' : ''); ?>>Keluar Desa</option>
                                        <option value="Keluar Kecamatan" <?php echo e(old('jenis_pindah') == 'Keluar Kecamatan' ? 'selected' : ''); ?>>Keluar Kecamatan</option>
                                        <option value="Keluar Kab/Kota" <?php echo e(old('jenis_pindah') == 'Keluar Kab/Kota' ? 'selected' : ''); ?>>Keluar Kab/Kota</option>
                                        <option value="Keluar Provinsi" <?php echo e(old('jenis_pindah') == 'Keluar Provinsi' ? 'selected' : ''); ?>>Keluar Provinsi</option>
                                        <option value="Keluar Negeri" <?php echo e(old('jenis_pindah') == 'Keluar Negeri' ? 'selected' : ''); ?>>Keluar Negeri</option>
                                    </select>
                                    <?php $__errorArgs = ['jenis_pindah'];
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

                                
                                <div class="col-12">
                                    <label class="form-label fw-bold">Alamat Asal</label>
                                    <input type="text" name="alamat_asal" id="alamat_asal" class="form-control <?php $__errorArgs = ['alamat_asal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Terisi otomatis saat warga dipilih..." value="<?php echo e(old('alamat_asal')); ?>" required>
                                    <?php $__errorArgs = ['alamat_asal'];
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

                                
                                <div class="col-12">
                                    <label class="form-label fw-bold">Alamat Tujuan</label>
                                    <textarea name="alamat_tujuan" class="form-control <?php $__errorArgs = ['alamat_tujuan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="2" placeholder="Tulis alamat lengkap tujuan pindah..." required><?php echo e(old('alamat_tujuan')); ?></textarea>
                                    <?php $__errorArgs = ['alamat_tujuan'];
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

                                
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Alasan / Keterangan</label>
                                    <textarea name="alasan" class="form-control" rows="2" placeholder="Contoh: Pindah tugas kerja, ikut keluarga, dll"><?php echo e(old('alasan')); ?></textarea>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">No. Surat Pengantar (Opsional)</label>
                                    <input type="text" name="no_surat" class="form-control" placeholder="Contoh: 470/015/Desa/2025" value="<?php echo e(old('no_surat')); ?>">
                                </div>

                                
                                <div class="col-12">
                                    <div class="p-3 bg-light border rounded mt-2">
                                        <label class="form-label fw-bold text-primary">
                                            <i class="fas fa-paperclip me-1"></i> Upload Bukti / Surat Pindah
                                        </label>
                                        <input type="file" name="files[]" class="form-control <?php $__errorArgs = ['files.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" multiple accept=".jpg,.jpeg,.png,.pdf">
                                        <div class="form-text">
                                            <i class="fas fa-info-circle"></i> Bisa upload banyak file (KTP, KK, Surat Pengantar). Max: 2MB per file.
                                        </div>
                                        <?php $__errorArgs = ['files.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                
                                <div class="col-12 mt-4 d-flex justify-content-between">
                                    <a href="<?php echo e(route('pindah.index')); ?>" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fas fa-save me-2"></i>Simpan Data
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Script Auto-Fill Alamat Asal
    document.addEventListener('DOMContentLoaded', function() {
        const selectWarga = document.querySelector('select[name="warga_id"]');
        const inputAsal = document.getElementById('alamat_asal');

        if(selectWarga && inputAsal) {
            selectWarga.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const alamat = selectedOption.getAttribute('data-alamat');
                
                // Isi otomatis jika input masih kosong atau user ingin update
                if(alamat) {
                    inputAsal.value = alamat;
                } else {
                    inputAsal.value = '-'; // Default jika alamat kosong
                }
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.guest.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\arin\laragon-6.0-minimal\www\kependudukan-guest\resources\views/pages/pindah/create.blade.php ENDPATH**/ ?>