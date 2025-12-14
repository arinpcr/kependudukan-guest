

<?php $__env->startSection('title', 'Data Pindah - Sistem Kependudukan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-5">
    <div class="container py-5">
        
        
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Manajemen Data</h4>
            <h1 class="mb-5 display-4">Peristiwa Pindah</h1>
        </div>

        <div class="row justify-content-center wow fadeIn" data-wow-delay="0.3s">
            <div class="col-12">
                
                
                <div class="bg-light border border-primary rounded p-5">

                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-check-circle me-2"></i>Sukses!</strong> <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="<?php echo e(route('pindah.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Catat Perpindahan Baru
                        </a>
                        <div class="text-muted">
                            <i class="fas fa-info-circle me-2 text-primary"></i> Total Data: <strong><?php echo e($data->total()); ?></strong>
                        </div>
                    </div>

                    
                    <div class="card mb-4 border-primary">
                        <div class="card-body">
                            
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label"><i class="fas fa-search me-2"></i>Cari Data Pindah</label>
                                    <form action="<?php echo e(route('pindah.index')); ?>" method="GET">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search" placeholder="Cari nama warga, alamat tujuan, atau keterangan..." value="<?php echo e(request('search')); ?>">
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                            <?php if(request('search')): ?>
                                                <a href="<?php echo e(route('pindah.index')); ?>" class="btn btn-outline-secondary"><i class="fas fa-times"></i></a>
                                            <?php endif; ?>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            
                            <form action="<?php echo e(route('pindah.index')); ?>" method="GET">
                                <?php if(request('search')): ?> <input type="hidden" name="search" value="<?php echo e(request('search')); ?>"> <?php endif; ?>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label"><i class="fas fa-sort me-2"></i>Urutkan</label>
                                        <select class="form-select" name="sort" onchange="this.form.submit()">
                                            <option value="tgl_terbaru" <?php echo e(request('sort') == 'tgl_terbaru' ? 'selected' : ''); ?>>Tgl Pindah (Baru)</option>
                                            <option value="tgl_terlama" <?php echo e(request('sort') == 'tgl_terlama' ? 'selected' : ''); ?>>Tgl Pindah (Lama)</option>
                                            <option value="nama_az" <?php echo e(request('sort') == 'nama_az' ? 'selected' : ''); ?>>Nama (A-Z)</option>
                                            <option value="nama_za" <?php echo e(request('sort') == 'nama_za' ? 'selected' : ''); ?>>Nama (Z-A)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label"><i class="fas fa-list me-2"></i>Data Per Halaman</label>
                                        <select class="form-select" name="per_page" onchange="this.form.submit()">
                                            <option value="12" <?php echo e(request('per_page', 12) == 12 ? 'selected' : ''); ?>>12 Data</option>
                                            <option value="24" <?php echo e(request('per_page') == 24 ? 'selected' : ''); ?>>24 Data</option>
                                            <option value="48" <?php echo e(request('per_page') == 48 ? 'selected' : ''); ?>>48 Data</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    
                    <div class="row g-4">
                        <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        
                        
                        <?php
                            $rawAlasan = $item->alasan;
                            $tampilJenis = '-';
                            $tampilAsal = '-';
                            $tampilKet = $rawAlasan; // Default tampilkan semua kalau format tidak cocok

                            // 1. Ambil JENIS PINDAH
                            if (preg_match('/Jenis:\s*(.*?)\s*(\| |$)/i', $rawAlasan, $m)) {
                                $tampilJenis = $m[1];
                            }

                            // 2. Ambil ALAMAT ASAL
                            // Prioritas: Data Master Warga -> Data di string 'Asal:'
                            if(!empty($item->warga->alamat)) {
                                $tampilAsal = $item->warga->alamat;
                            } elseif (preg_match('/Asal:\s*(.*?)\s*(\| |$)/i', $rawAlasan, $m)) {
                                $tampilAsal = $m[1];
                            }

                            // 3. Ambil KETERANGAN MURNI (Hapus bagian Jenis & Asal)
                            if (preg_match('/Ket:\s*(.*?)\s*(\| |$)/i', $rawAlasan, $m)) {
                                $tampilKet = $m[1];
                            } elseif ($tampilJenis != '-') {
                                // Kalau formatnya ada 'Jenis:' tapi ga ada 'Ket:', 
                                // berarti sisanya dianggap keterangan atau kosong
                                $tampilKet = '-'; 
                            }
                        ?>

                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-primary card-hover">
                                
                                
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-start p-3">
                                    <div style="max-width: 65%;">
                                        <h6 class="mb-0 text-truncate fw-bold text-white" title="<?php echo e($item->warga->nama ?? 'Warga Terhapus'); ?>">
                                            <i class="fas fa-user me-2"></i><?php echo e($item->warga->nama ?? 'Warga Terhapus'); ?>

                                        </h6>
                                        <small class="d-block text-white-50 mt-1">
                                            NIK: <?php echo e($item->warga->no_ktp ?? '-'); ?>

                                        </small>
                                    </div>
                                    <span class="badge bg-light text-primary shadow-sm">
                                        <i class="fas fa-calendar-alt me-1"></i> <?php echo e(\Carbon\Carbon::parse($item->tgl_pindah)->format('d/m/Y')); ?>

                                    </span>
                                </div>

                                <div class="card-body p-3 d-flex flex-column">
                                    
                                    
                                    <div class="mb-2 pb-2 border-bottom border-light">
                                        <small class="text-secondary fw-bold d-block mb-1">Jenis Pindah:</small>
                                        <div class="d-flex text-dark align-items-center">
                                            <i class="fas fa-exchange-alt mt-1 me-2 text-warning"></i>
                                            <span class="fw-bold"><?php echo e($tampilJenis); ?></span>
                                        </div>
                                    </div>

                                    
                                    <div class="mb-2">
                                        <small class="text-secondary fw-bold d-block mb-1">Alamat Asal:</small>
                                        <div class="d-flex text-dark">
                                            <i class="fas fa-map-marker-alt mt-1 me-2 text-danger"></i>
                                            <span class="lh-sm text-truncate-2"><?php echo e($tampilAsal); ?></span>
                                        </div>
                                    </div>

                                    
                                    <div class="mb-3">
                                        <small class="text-secondary fw-bold d-block mb-1">Alamat Tujuan:</small>
                                        <div class="d-flex text-dark">
                                            <i class="fas fa-location-arrow mt-1 me-2 text-success"></i>
                                            <span class="fw-bold lh-sm text-truncate-2"><?php echo e($item->alamat_tujuan); ?></span>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="mt-auto p-2 bg-light border rounded">
                                        <small class="text-muted fw-bold d-block" style="font-size: 0.75rem;">Keterangan / Alasan:</small>
                                        <p class="mb-0 fst-italic text-dark small">
                                            "<?php echo e(Str::limit($tampilKet, 60)); ?>"
                                        </p>
                                    </div>
                                </div>

                                
                                <div class="card-footer bg-transparent border-top-0 p-3 pt-0">
                                    <div class="d-grid gap-2">
                                        <a href="<?php echo e(route('pindah.show', $item->pindah_id)); ?>" class="btn btn-info btn-sm text-white w-100">
                                            <i class="fa fa-eye me-2"></i> Detail Lengkap
                                        </a>

                                        <div class="d-flex gap-2">
                                            <a href="<?php echo e(route('pindah.edit', $item->pindah_id)); ?>" class="btn btn-warning btn-sm text-white flex-grow-1">
                                                <i class="fas fa-edit me-2"></i> Edit
                                            </a>
                                            
                                            <form action="<?php echo e(route('pindah.destroy', $item->pindah_id)); ?>" method="POST" class="flex-grow-1" onsubmit="return confirm('Yakin ingin menghapus data kepindahan <?php echo e($item->warga->nama ?? ''); ?>?')">
                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                <button class="btn btn-outline-danger btn-sm w-100">
                                                    <i class="fas fa-trash me-2"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        
                        <div class="col-12">
                            <div class="text-center py-5">
                                <div class="bg-white rounded-circle d-inline-flex p-4 shadow-sm mb-3 border border-primary">
                                    <i class="fas fa-truck-moving fa-4x text-secondary opacity-50"></i>
                                </div>
                                <h5 class="text-muted">Data tidak ditemukan</h5>
                                <p class="text-muted small">Silakan tambah data baru atau ubah filter pencarian.</p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if($data->hasPages()): ?>
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <div class="text-muted small">
                            Menampilkan <strong><?php echo e($data->firstItem()); ?></strong> sampai <strong><?php echo e($data->lastItem()); ?></strong> dari <strong><?php echo e($data->total()); ?></strong> data
                        </div>
                        <nav aria-label="Page navigation">
                            <?php echo e($data->withQueryString()->links('pagination::bootstrap-5')); ?>

                        </nav>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .title-border-radius { border-radius: 10px; }
    .card-hover { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .card-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .text-truncate-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.guest.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\arin\laragon-6.0-minimal\www\kependudukan-guest\resources\views/pages/pindah/index.blade.php ENDPATH**/ ?>