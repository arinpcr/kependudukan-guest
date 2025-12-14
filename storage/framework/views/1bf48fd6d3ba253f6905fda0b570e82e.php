<?php $__env->startSection('content'); ?>
<div class="container py-5">

    
    <div class="card mb-4 border-primary shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Detail Peristiwa Kematian</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150" class="fw-bold text-muted">Nama Almarhum</td>
                            <td class="fw-bold">: <?php echo e($kematian->warga->nama ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">NIK</td>
                            <td>: <?php echo e($kematian->nik ?? $kematian->warga->no_ktp ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Jenis Kelamin</td>
                            <td>: <?php echo e($kematian->warga->jenis_kelamin ?? '-'); ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150" class="fw-bold text-muted">Tanggal Meninggal</td>
                            <td class="text-danger fw-bold">: <?php echo e(\Carbon\Carbon::parse($kematian->tgl_meninggal)->format('d F Y')); ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Sebab Kematian</td>
                            <td>: <?php echo e($kematian->sebab_kematian); ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Tempat</td>
                            <td>: <?php echo e($kematian->tempat_kematian); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="mt-3">
                <a href="<?php echo e(route('kematian.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light border-bottom">
            <h5 class="mb-0 text-primary"><i class="fas fa-paperclip me-2"></i>File Pendukung (Bukti)</h5>
        </div>
        <div class="card-body">

            
            <form action="<?php echo e(route('kematian.upload')); ?>" method="POST" enctype="multipart/form-data" class="row g-3 align-items-end border p-4 rounded bg-light mb-5">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="ref_table" value="peristiwa_kematian">
                <input type="hidden" name="ref_id" value="<?php echo e($kematian->kematian_id); ?>">

                <div class="col-md-5">
                    <label class="form-label fw-bold">Pilih File (Bisa Banyak)</label>
                    <input type="file" name="files[]" class="form-control" multiple required>
                    <small class="text-muted">Format: JPG, PNG, PDF (Max 2MB)</small>
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-bold">Keterangan File</label>
                    <input type="text" name="caption" class="form-control" placeholder="Contoh: Surat Keterangan Dokter">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100 h-100">
                        <i class="fas fa-upload me-2"></i> Upload
                    </button>
                </div>
            </form>

            <h6 class="mb-3 border-bottom pb-2">Daftar Dokumen Tersimpan:</h6>
            
            <div class="row g-3">
                <?php $__empty_1 = true; $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-6 col-md-3">
                    <div class="card h-100 shadow-sm">
                        
                        
                        <div class="card-img-top bg-light position-relative overflow-hidden" style="height: 180px;">
                            
                            <?php if(str_contains($doc->mime_type, 'image')): ?>
                                
                                
                                
                                <img src="<?php echo e(asset('storage/uploads/'.$doc->file_name)); ?>" 
                                     class="img-fluid w-100 h-100" 
                                     style="object-fit: cover;" 
                                     alt="preview"
                                     
                                     onerror="this.style.display='none'; this.nextElementSibling.classList.remove('d-none'); this.nextElementSibling.classList.add('d-flex');">

                                
                                <div class="d-none w-100 h-100 flex-column justify-content-center align-items-center bg-light text-muted">
                                    <i class="fas fa-image fa-3x mb-2 opacity-25"></i>
                                    <span class="small fw-bold">Foto Tidak Tersedia</span>
                                </div>

                            <?php else: ?>
                                
                                <div class="w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                                    <i class="fas fa-file-pdf fa-4x text-danger mb-2"></i>
                                    <span class="badge bg-danger">Dokumen PDF</span>
                                </div>
                            <?php endif; ?>

                        </div>

                        <div class="card-body p-2 text-center bg-white">
                            <small class="fw-bold d-block text-truncate text-dark mb-1" title="<?php echo e($doc->caption); ?>">
                                <?php echo e($doc->caption ?: 'Tanpa Keterangan'); ?>

                            </small>
                            <small class="text-muted d-block text-truncate" style="font-size: 10px;">
                                <?php echo e($doc->file_name); ?>

                            </small>

                            <div class="mt-2 btn-group w-100 shadow-sm" role="group">
                                <a href="<?php echo e(asset('storage/uploads/'.$doc->file_name)); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>

                                <form action="<?php echo e(route('media.delete', $doc->media_id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus file ini permanen?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12 text-center py-5 bg-light rounded border border-dashed">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3 opacity-50"></i>
                    <p class="text-muted mb-0">Belum ada dokumen pendukung yang diupload.</p>
                </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.guest.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\arin\laragon-6.0-minimal\www\kependudukan-guest\resources\views/pages/kematian/show.blade.php ENDPATH**/ ?>