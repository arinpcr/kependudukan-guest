
<?php $__env->startSection('title', 'Edit Data Kelahiran'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-5">
    <div class="container py-5">
        
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Manajemen Data</h4>
            <h1 class="mb-5 display-4">Edit Data Kelahiran</h1>
        </div>

        <div class="row justify-content-center wow fadeIn" data-wow-delay="0.3s">
            <div class="col-lg-8">
                <div class="card shadow-sm border-primary">
                    <div class="card-header bg-primary text-white d-flex align-items-center">
                        <i class="fas fa-edit me-2"></i>
                        <h5 class="mb-0 text-white">Formulir Perubahan Data</h5>
                    </div>
                    <div class="card-body p-5">

                        <a href="<?php echo e(route('kelahiran.index')); ?>" class="btn btn-secondary btn-sm mb-4">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                        </a>

                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($error); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo e(route('kelahiran.update', $kelahiran->kelahiran_id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <div class="row g-4">
                                
                                
                                <div class="col-12 border-bottom pb-2 mb-2">
                                    <h6 class="text-primary fw-bold">Data Bayi</h6>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold">Nama Bayi</label>
                                    <select name="warga_id" class="form-select <?php $__errorArgs = ['warga_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">-- Pilih Bayi --</option>
                                        <?php $__currentLoopData = $warga_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($w->warga_id); ?>" <?php echo e(old('warga_id', $kelahiran->warga_id) == $w->warga_id ? 'selected' : ''); ?>>
                                                <?php echo e($w->nama); ?> (NIK: <?php echo e($w->no_ktp); ?>)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" class="form-control" value="<?php echo e(old('tgl_lahir', $kelahiran->tgl_lahir)); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control" value="<?php echo e(old('tempat_lahir', $kelahiran->tempat_lahir)); ?>" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Nomor Akta (Opsional)</label>
                                    <input type="text" name="no_akta" class="form-control" value="<?php echo e(old('no_akta', $kelahiran->no_akta)); ?>">
                                </div>

                                
                                <div class="col-12 border-bottom pb-2 mb-2 mt-3">
                                    <h6 class="text-primary fw-bold">Data Orang Tua</h6>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Nama Ayah</label>
                                    <select name="ayah_warga_id" class="form-select">
                                        <option value="">-- Pilih Ayah --</option>
                                        <?php $__currentLoopData = $ayah_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($a->warga_id); ?>" <?php echo e(old('ayah_warga_id', $kelahiran->ayah_warga_id) == $a->warga_id ? 'selected' : ''); ?>>
                                                <?php echo e($a->nama); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Nama Ibu</label>
                                    <select name="ibu_warga_id" class="form-select">
                                        <option value="">-- Pilih Ibu --</option>
                                        <?php $__currentLoopData = $ibu_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($i->warga_id); ?>" <?php echo e(old('ibu_warga_id', $kelahiran->ibu_warga_id) == $i->warga_id ? 'selected' : ''); ?>>
                                                <?php echo e($i->nama); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="col-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-2"></i>Simpan Perubahan</button>
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
<?php echo $__env->make('layouts.guest.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\arin\laragon-6.0-minimal\www\kependudukan-guest\resources\views/pages/kelahiran/edit.blade.php ENDPATH**/ ?>