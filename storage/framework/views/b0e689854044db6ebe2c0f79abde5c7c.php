
<?php $__env->startSection('content'); ?>
<div class="container py-5">

    
    <div class="card mb-4 border-primary shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Detail Peristiwa Kelahiran</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr><td width="150" class="fw-bold text-muted">Nama Bayi</td><td class="fw-bold">: <?php echo e($kelahiran->bayi->nama ?? '-'); ?></td></tr>
                        <tr><td class="fw-bold text-muted">Tgl Lahir</td><td class="text-primary fw-bold">: <?php echo e(\Carbon\Carbon::parse($kelahiran->tgl_lahir)->format('d F Y')); ?></td></tr>
                        <tr><td class="fw-bold text-muted">Tempat Lahir</td><td>: <?php echo e($kelahiran->tempat_lahir); ?></td></tr>
                        <tr><td class="fw-bold text-muted">No. Akta</td><td>: <?php echo e($kelahiran->no_akta ?? '-'); ?></td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr><td width="150" class="fw-bold text-muted">Nama Ayah</td><td>: <?php echo e($kelahiran->ayah->nama ?? '-'); ?></td></tr>
                        <tr><td class="fw-bold text-muted">Nama Ibu</td><td>: <?php echo e($kelahiran->ibu->nama ?? '-'); ?></td></tr>
                        <tr><td class="fw-bold text-muted">NIK Bayi</td><td>: <?php echo e($kelahiran->bayi->no_ktp ?? '-'); ?></td></tr>
                    </table>
                </div>
            </div>
            <div class="mt-3">
                <a href="<?php echo e(route('kelahiran.index')); ?>" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
            </div>
        </div>
    </div>

    
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light border-bottom">
            <h5 class="mb-0 text-primary"><i class="fas fa-paperclip me-2"></i>File Pendukung (Akta/Surat)</h5>
        </div>
        <div class="card-body">

            
            <form action="<?php echo e(route('kelahiran.upload')); ?>" method="POST" enctype="multipart/form-data" class="row g-3 align-items-end border p-4 rounded bg-light mb-5">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="ref_table" value="peristiwa_kelahiran">
                <input type="hidden" name="ref_id" value="<?php echo e($kelahiran->kelahiran_id); ?>">

                <div class="col-md-5">
                    <label class="form-label fw-bold">Pilih File</label>
                    <input type="file" name="files[]" class="form-control" multiple required>
                    <small class="text-muted">JPG, PNG, PDF (Max 2MB)</small>
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-bold">Keterangan</label>
                    <input type="text" name="caption" class="form-control" placeholder="Contoh: Akta Kelahiran">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100 h-100"><i class="fas fa-upload me-2"></i> Upload</button>
                </div>
            </form>

            <h6 class="mb-3 border-bottom pb-2 fw-bold text-primary">Daftar Dokumen Tersimpan:</h6>

            <div class="row g-4">
                
                <?php $__empty_1 = true; $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0 overflow-hidden" style="border-radius: 12px;">

                        
                        <div class="card-img-top d-flex flex-column justify-content-center align-items-center p-3"
                             style="height: 180px; background-color: #ffeef0;">
                            
                            <?php if(str_contains($doc->mime_type, 'image')): ?>
                                
                                <img src="<?php echo e(asset('storage/uploads/' . $doc->file_name)); ?>"
                                     alt="<?php echo e($doc->caption); ?>"
                                     class="img-fluid rounded shadow-sm"
                                     style="max-height: 150px; object-fit: cover;">
                            <?php else: ?>
                                
                                <i class="fas fa-file-pdf fa-4x text-danger mb-3"></i>
                                <span class="badge bg-danger rounded-pill px-3 py-2">Dokumen PDF</span>
                            <?php endif; ?>
                        </div>

                        
                        <div class="card-body p-3 text-center bg-white border-top">
                            <h6 class="fw-bold text-dark mb-1 text-truncate" title="<?php echo e($doc->caption); ?>">
                                <?php echo e($doc->caption ?? 'Tanpa Judul'); ?>

                            </h6>
                            <small class="text-muted d-block text-truncate mb-3" style="font-size: 0.8rem;">
                                <?php echo e($doc->file_name); ?>

                            </small>

                            <div class="btn-group w-100 shadow-sm" role="group">
                                
                                <a href="<?php echo e(asset('storage/uploads/' . $doc->file_name)); ?>" target="_blank" class="btn btn-outline-danger flex-grow-1 fw-bold">
                                    <i class="fas fa-eye me-2"></i>Lihat
                                </a>

                                
                                <form action="<?php echo e(route('media.delete', $doc->media_id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus file ini permanen?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger rounded-0 rounded-end px-3" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                
                <div class="col-12">
                    <div class="text-center py-5 rounded-3 d-flex flex-column align-items-center justify-content-center"
                         style="background-color: #ffeef0; border: 2px dashed #fadce0; min-height: 200px;">
                        <i class="fas fa-folder-open fa-5x mb-4" style="color: #6c757d; opacity: 0.5;"></i>
                        <h6 class="text-muted fw-bold mb-0" style="color: #6c757d;">Belum ada dokumen pendukung yang diupload.</h6>
                    </div>
                </div>
                <?php endif; ?>

            </div> 
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.guest.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\arin\laragon-6.0-minimal\www\kependudukan-guest\resources\views/pages/kelahiran/show.blade.php ENDPATH**/ ?>