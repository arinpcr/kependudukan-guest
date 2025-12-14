
<?php $__env->startSection('title', 'Edit Data Pindah'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-5">
    <div class="container py-5">
        
        
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <h4 class="text-primary fw-bold">Edit Data Perpindahan</h4>
                <p class="text-muted">Perbarui informasi perpindahan warga jika terdapat kesalahan input.</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-warning shadow-sm rounded-3">
                    <div class="card-header bg-warning text-white p-3 d-flex align-items-center">
                        <i class="fas fa-edit me-2"></i>
                        <h5 class="mb-0">Formulir Edit Data</h5>
                    </div>
                    <div class="card-body p-4">
                        
                        
                        <?php
                            $rawAlasan = $pindah->alasan;
                            $valJenis  = '';
                            $valAsal   = '';
                            $valKet    = $rawAlasan; // Default isi semua

                            // 1. Ambil JENIS PINDAH
                            if (preg_match('/Jenis:\s*(.*?)\s*(\| |$)/i', $rawAlasan, $m)) {
                                $valJenis = $m[1];
                            }

                            // 2. Ambil ALAMAT ASAL
                            if (preg_match('/Asal:\s*(.*?)\s*(\| |$)/i', $rawAlasan, $m)) {
                                $valAsal = $m[1];
                            }

                            // 3. Ambil KETERANGAN MURNI
                            if (preg_match('/Ket:\s*(.*?)\s*(\| |$)/i', $rawAlasan, $m)) {
                                $valKet = $m[1];
                            } elseif ($valJenis != '') {
                                // Jika ada format 'Jenis:' tapi tidak ada 'Ket:', kosongkan ket murni
                                $valKet = ''; 
                            }
                        ?>

                        <form action="<?php echo e(route('pindah.update', $pindah->pindah_id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold text-muted">Nama Warga (Tidak dapat diubah)</label>
                                <input type="text" class="form-control bg-light" value="<?php echo e($pindah->warga->nama ?? 'Warga Terhapus'); ?> - NIK: <?php echo e($pindah->warga->no_ktp ?? '-'); ?>" readonly>
                                
                                <input type="hidden" name="warga_id" value="<?php echo e($pindah->warga_id); ?>">
                            </div>

                            <div class="row g-3">
                                
                                
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tanggal Pindah <span class="text-danger">*</span></label>
                                    <input type="date" name="tgl_pindah" class="form-control" value="<?php echo e(old('tgl_pindah', $pindah->tgl_pindah)); ?>" required>
                                </div>

                                
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Jenis Kepindahan <span class="text-danger">*</span></label>
                                    <select name="jenis_pindah" class="form-select" required>
                                        <option value="">-- Pilih Jenis --</option>
                                        <?php $__currentLoopData = ['Antar RT/RW', 'Keluar Desa', 'Keluar Kecamatan', 'Keluar Kab/Kota', 'Keluar Provinsi', 'Keluar Negeri']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($option); ?>" <?php echo e((old('jenis_pindah', $valJenis) == $option) ? 'selected' : ''); ?>>
                                                <?php echo e($option); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                
                                <div class="col-12">
                                    <label class="form-label fw-bold">Alamat Asal <span class="text-danger">*</span></label>
                                    <input type="text" name="alamat_asal" class="form-control" 
                                           value="<?php echo e(old('alamat_asal', $valAsal ?: ($pindah->warga->alamat ?? '-'))); ?>" required>
                                </div>

                                
                                <div class="col-12">
                                    <label class="form-label fw-bold">Alamat Tujuan <span class="text-danger">*</span></label>
                                    <textarea name="alamat_tujuan" class="form-control" rows="2" required><?php echo e(old('alamat_tujuan', $pindah->alamat_tujuan)); ?></textarea>
                                </div>

                                
                                <div class="col-12">
                                    <label class="form-label fw-bold">Alasan / Keterangan</label>
                                    <textarea name="alasan" class="form-control" rows="2"><?php echo e(old('alasan', $valKet)); ?></textarea>
                                </div>

                                
                                <div class="col-12">
                                    <label class="form-label fw-bold">Nomor Surat</label>
                                    <input type="text" name="no_surat" class="form-control" value="<?php echo e(old('no_surat', $pindah->no_surat)); ?>">
                                </div>

                            </div>

                            
                            <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                                <a href="<?php echo e(route('pindah.index')); ?>" class="btn btn-secondary px-4">
                                    <i class="fas fa-arrow-left me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-warning text-white px-4 fw-bold shadow-sm">
                                    <i class="fas fa-save me-2"></i>Update Data
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.guest.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\arin\laragon-6.0-minimal\www\kependudukan-guest\resources\views/pages/pindah/edit.blade.php ENDPATH**/ ?>