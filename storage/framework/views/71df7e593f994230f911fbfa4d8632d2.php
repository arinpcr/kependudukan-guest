<?php $__env->startSection('title', 'Data Kartu Keluarga - Sistem Kependudukan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Manajemen Data</h4>
            <h1 class="mb-5 display-4">Data Kartu Keluarga</h1>
        </div>

        <div class="row justify-content-center wow fadeIn" data-wow-delay="0.3s">
            <div class="col-12">
                <div class="bg-light border border-primary rounded p-5">
                    
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-check-circle me-2"></i>Sukses!</strong>
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="<?php echo e(route('keluarga.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Data KK Baru
                        </a>
                        
                        <div class="text-muted">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            Total Data: <strong><?php echo e($keluarga->total()); ?></strong>
                        </div>
                    </div>
<!-- Tambahkan bagian ini setelah alert success dan sebelum card layout -->

<!-- Search dan Filter Options -->
<div class="card mb-4 border-primary">
    <div class="card-body">
        <!-- Search Bar -->
        <div class="row mb-3">
            <div class="col-12">
                <label class="form-label"><i class="fas fa-search me-2"></i>Cari Kartu Keluarga</label>
                <form action="<?php echo e(route('keluarga.index')); ?>" method="GET" id="searchForm">
                    <div class="input-group">
                        <input type="text" 
                               class="form-control" 
                               name="search" 
                               id="searchKeluarga" 
                               placeholder="Cari berdasarkan nomor KK, alamat, RT/RW, atau nama kepala keluarga..."
                               value="<?php echo e(request('search')); ?>">
                        <button class="btn btn-primary" type="submit" id="btnSearch">
                            <i class="fas fa-search"></i>
                        </button>
                        <?php if(request('search')): ?>
                        <a href="<?php echo e(route('keluarga.index')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <form action="<?php echo e(route('keluarga.index')); ?>" method="GET" id="filterForm">
            <?php if(request('search')): ?>
                <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
            <?php endif; ?>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-filter me-2"></i>Filter RT</label>
                    <select class="form-select" name="rt" id="filterRT" onchange="this.form.submit()">
                        <option value="">Semua RT</option>
                        <?php $__currentLoopData = $keluarga->pluck('rt')->unique()->sort(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($rt); ?>" <?php echo e(request('rt') == $rt ? 'selected' : ''); ?>>RT <?php echo e($rt); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-filter me-2"></i>Filter RW</label>
                    <select class="form-select" name="rw" id="filterRW" onchange="this.form.submit()">
                        <option value="">Semua RW</option>
                        <?php $__currentLoopData = $keluarga->pluck('rw')->unique()->sort(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rw): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($rw); ?>" <?php echo e(request('rw') == $rw ? 'selected' : ''); ?>>RW <?php echo e($rw); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-sort me-2"></i>Urutkan</label>
                    <select class="form-select" name="sort" id="sortBy" onchange="this.form.submit()">
                        <option value="kk_nomor" <?php echo e(request('sort') == 'kk_nomor' ? 'selected' : ''); ?>>Nomor KK A-Z</option>
                        <option value="kk_nomor_desc" <?php echo e(request('sort') == 'kk_nomor_desc' ? 'selected' : ''); ?>>Nomor KK Z-A</option>
                        <option value="alamat" <?php echo e(request('sort') == 'alamat' ? 'selected' : ''); ?>>Alamat A-Z</option>
                        <option value="alamat_desc" <?php echo e(request('sort') == 'alamat_desc' ? 'selected' : ''); ?>>Alamat Z-A</option>
                        <option value="terbaru" <?php echo e(request('sort') == 'terbaru' ? 'selected' : ''); ?>>Terbaru</option>
                        <option value="terlama" <?php echo e(request('sort') == 'terlama' ? 'selected' : ''); ?>>Terlama</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-list me-2"></i>Data Per Halaman</label>
                    <select class="form-select" name="per_page" id="perPage" onchange="this.form.submit()">
                        <option value="10" <?php echo e(request('per_page', 10) == 10 ? 'selected' : ''); ?>>10 Data</option>
                        <option value="20" <?php echo e(request('per_page') == 20 ? 'selected' : ''); ?>>20 Data</option>
                        <option value="30" <?php echo e(request('per_page') == 30 ? 'selected' : ''); ?>>30 Data</option>
                        <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50 Data</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Info Pencarian -->
<?php if(request('search') || request('rt') || request('rw') || request('sort')): ?>
<div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
    <strong><i class="fas fa-info-circle me-2"></i>Filter Aktif:</strong>
    <?php if(request('search')): ?>
        <span class="badge bg-primary me-2">Pencarian: "<?php echo e(request('search')); ?>"</span>
    <?php endif; ?>
    <?php if(request('rt')): ?>
        <span class="badge bg-success me-2">RT: <?php echo e(request('rt')); ?></span>
    <?php endif; ?>
    <?php if(request('rw')): ?>
        <span class="badge bg-success me-2">RW: <?php echo e(request('rw')); ?></span>
    <?php endif; ?>
    <?php if(request('sort')): ?>
        <span class="badge bg-warning me-2">Urutan: 
            <?php if(request('sort') == 'kk_nomor'): ?> Nomor KK A-Z
            <?php elseif(request('sort') == 'kk_nomor_desc'): ?> Nomor KK Z-A
            <?php elseif(request('sort') == 'alamat'): ?> Alamat A-Z
            <?php elseif(request('sort') == 'alamat_desc'): ?> Alamat Z-A
            <?php elseif(request('sort') == 'terbaru'): ?> Terbaru
            <?php elseif(request('sort') == 'terlama'): ?> Terlama
            <?php endif; ?>
        </span>
    <?php endif; ?>
    <a href="<?php echo e(route('keluarga.index')); ?>" class="btn btn-sm btn-outline-info ms-2">Hapus Filter</a>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>
                    <!-- Card Layout -->
                    <div class="row g-4">
                        <?php $__empty_1 = true; $__currentLoopData = $keluarga; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-primary">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <i class="fas fa-home me-2"></i>Kartu Keluarga
                                    </h6>
                                    <span class="badge bg-light text-dark">#<?php echo e($keluarga->firstItem() + $index); ?></span>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-id-card me-2 text-primary"></i>
                                            <span class="fw-bold">Nomor KK:</span>
                                        </div>
                                        <p class="ms-4 mb-0"><?php echo e($item->kk_nomor); ?></p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-user me-2 text-primary"></i>
                                            <span class="fw-bold">Kepala Keluarga:</span>
                                        </div>
                                        <p class="ms-4 mb-0"><?php echo e($item->kepalaKeluarga ? $item->kepalaKeluarga->nama : 'Warga tidak ditemukan'); ?></p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                            <span class="fw-bold">Alamat:</span>
                                        </div>
                                        <p class="ms-4 mb-0"><?php echo e($item->alamat); ?></p>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-map-pin me-2 text-primary"></i>
                                                <span class="fw-bold">RT:</span>
                                            </div>
                                            <p class="ms-4 mb-0">
                                                <span class="badge bg-secondary"><?php echo e($item->rt); ?></span>
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-map-pin me-2 text-primary"></i>
                                                <span class="fw-bold">RW:</span>
                                            </div>
                                            <p class="ms-4 mb-0">
                                                <span class="badge bg-secondary"><?php echo e($item->rw); ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top-0">
                                    <div class="d-flex justify-content-between">
                                        <a href="<?php echo e(route('keluarga.edit', $item->kk_id)); ?>" 
                                           class="btn btn-warning btn-sm" 
                                           data-bs-toggle="tooltip" 
                                           title="Edit Data">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                        <form action="<?php echo e(route('keluarga.destroy', $item->kk_id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" 
                                                    class="btn btn-danger btn-sm" 
                                                    data-bs-toggle="tooltip" 
                                                    title="Hapus Data"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data KK ini?')">
                                                <i class="fas fa-trash me-1"></i>Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-12">
                            <div class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <h5>Tidak ada data Kartu Keluarga</h5>
                                    <p>Silakan tambah data KK baru dengan mengklik tombol di atas.</p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if($keluarga->hasPages()): ?>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Menampilkan <?php echo e($keluarga->firstItem()); ?> sampai <?php echo e($keluarga->lastItem()); ?> dari <?php echo e($keluarga->total()); ?> data
                        </div>
                        <nav>
                            <?php echo e($keluarga->links('pagination::bootstrap-5')); ?>

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
    .title-border-radius {
        border-radius: 10px;
    }
    .card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .card-header {
        border-bottom: 2px solid rgba(0,0,0,0.1);
    }
    .btn-group .btn {
        margin: 0 2px;
    }
    .badge {
        font-size: 0.8em;
        padding: 0.35em 0.65em;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Auto-dismiss alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });

        // Enhanced delete confirmation
        const deleteForms = document.querySelectorAll('form[action*="destroy"]');
        deleteForms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...';
                }
            });
        });

        console.log('Keluarga index page loaded with enhanced features');
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.guest.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\arin\laragon-6.0-minimal\www\kependudukan-guest\resources\views/pages/keluarga/index.blade.php ENDPATH**/ ?>