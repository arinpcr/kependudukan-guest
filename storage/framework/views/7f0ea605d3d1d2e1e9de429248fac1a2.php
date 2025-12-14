
<?php $__env->startSection('title', 'Catat Kelahiran'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-baby me-2"></i>Formulir Kelahiran</h5>
                </div>
                <div class="card-body p-4">
                    
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($error); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('kelahiran.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        
                        <div class="alert alert-info small">
                            <i class="fas fa-info-circle me-1"></i> Pastikan data <strong>Bayi</strong> sudah diinput ke Data Warga dulu.
                        </div>

                        
                        <h6 class="text-primary fw-bold mb-3 border-bottom pb-2">Data Bayi</h6>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Nama Bayi</label>
                            <select name="warga_id" class="form-select" required>
                                <option value="">-- Cari Nama Bayi --</option>
                                <?php $__currentLoopData = $warga_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($w->warga_id); ?>"><?php echo e($w->nama); ?> (NIK: <?php echo e($w->no_ktp ?? '-'); ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">No. Akta (Opsional)</label>
                            <input type="text" name="no_akta" class="form-control">
                        </div>

                        
                        <h6 class="text-primary fw-bold mb-3 border-bottom pb-2 mt-4">Data Orang Tua</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ayah</label>
                                <select name="ayah_warga_id" class="form-select">
                                    <option value="">-- Pilih Ayah --</option>
                                    <?php $__currentLoopData = $ayah_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($a->warga_id); ?>"><?php echo e($a->nama); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ibu</label>
                                <select name="ibu_warga_id" class="form-select">
                                    <option value="">-- Pilih Ibu --</option>
                                    <?php $__currentLoopData = $ibu_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($i->warga_id); ?>"><?php echo e($i->nama); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        
                        <div class="p-3 bg-light border rounded mt-3">
                            <label class="form-label fw-bold text-primary"><i class="fas fa-paperclip"></i> Upload Bukti</label>
                            <input type="file" name="files[]" class="form-control" multiple>
                        </div>

                        <div class="mt-4 d-flex justify-content-between">
                            <a href="<?php echo e(route('kelahiran.index')); ?>" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.guest.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\arin\laragon-6.0-minimal\www\kependudukan-guest\resources\views/pages/kelahiran/create.blade.php ENDPATH**/ ?>