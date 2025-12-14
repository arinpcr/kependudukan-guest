
<?php $__env->startSection('title', 'Data Kelahiran'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-5">
    <div class="container py-5">
        
        
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Manajemen Data</h4>
            <h1 class="mb-5 display-4">Data Kelahiran</h1>
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
                        <a href="<?php echo e(route('kelahiran.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Catat Kelahiran Baru
                        </a>
                        <div class="text-muted">
                            <i class="fas fa-info-circle me-2 text-primary"></i> Total Data: <strong><?php echo e($data->total()); ?></strong>
                        </div>
                    </div>

                    
                    
                    
                    <div class="card mb-4 border-primary">
                        <div class="card-body">
                            
                            
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label"><i class="fas fa-search me-2"></i>Cari Data Kelahiran</label>
                                    <form action="<?php echo e(route('kelahiran.index')); ?>" method="GET" id="searchForm">
                                        <div class="input-group">
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="search" 
                                                   placeholder="Cari nama bayi, orang tua, atau nomor akta..." 
                                                   value="<?php echo e(request('search')); ?>">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            <?php if(request('search')): ?>
                                                <a href="<?php echo e(route('kelahiran.index')); ?>" class="btn btn-outline-secondary">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            
                            <form action="<?php echo e(route('kelahiran.index')); ?>" method="GET" id="filterForm">
                                
                                <?php if(request('search')): ?>
                                    <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                                <?php endif; ?>

                                <div class="row g-3">
                                    
                                    <div class="col-md-3">
                                        <label class="form-label"><i class="fas fa-calendar-alt me-2"></i>Bulan Lahir</label>
                                        <select class="form-select" name="bulan" onchange="this.form.submit()">
                                            <option value="">Semua Bulan</option>
                                            <?php $__currentLoopData = range(1,12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($m); ?>" <?php echo e(request('bulan') == $m ? 'selected' : ''); ?>>
                                                    <?php echo e(date('F', mktime(0, 0, 0, $m, 1))); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    
                                    <div class="col-md-3">
                                        <label class="form-label"><i class="fas fa-calendar me-2"></i>Tahun Lahir</label>
                                        <select class="form-select" name="tahun" onchange="this.form.submit()">
                                            <option value="">Semua Tahun</option>
                                            <?php for($y = date('Y'); $y >= 2000; $y--): ?>
                                                <option value="<?php echo e($y); ?>" <?php echo e(request('tahun') == $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>

                                    
                                    <div class="col-md-3">
                                        <label class="form-label"><i class="fas fa-sort me-2"></i>Urutkan</label>
                                        <select class="form-select" name="sort" onchange="this.form.submit()">
                                            <option value="tgl_terbaru" <?php echo e(request('sort') == 'tgl_terbaru' ? 'selected' : ''); ?>>Tgl Lahir (Baru)</option>
                                            <option value="tgl_terlama" <?php echo e(request('sort') == 'tgl_terlama' ? 'selected' : ''); ?>>Tgl Lahir (Lama)</option>
                                            <option value="input_terbaru" <?php echo e(request('sort') == 'input_terbaru' ? 'selected' : ''); ?>>Input Terakhir</option>
                                        </select>
                                    </div>

                                    
                                    <div class="col-md-3">
                                        <label class="form-label"><i class="fas fa-list me-2"></i>Data Per Halaman</label>
                                        <select class="form-select" name="per_page" onchange="this.form.submit()">
                                            <option value="6" <?php echo e(request('per_page') == 6 ? 'selected' : ''); ?>>6 Data</option>
                                            <option value="12" <?php echo e(request('per_page', 12) == 12 ? 'selected' : ''); ?>>12 Data</option>
                                            <option value="24" <?php echo e(request('per_page') == 24 ? 'selected' : ''); ?>>24 Data</option>
                                            <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50 Data</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    
                    <?php if(request('search') || request('bulan') || request('tahun') || request('sort')): ?>
                    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                        <strong><i class="fas fa-info-circle me-2"></i>Filter Aktif:</strong>
                        <?php if(request('search')): ?> <span class="badge bg-primary me-2">Cari: "<?php echo e(request('search')); ?>"</span> <?php endif; ?>
                        <?php if(request('bulan')): ?> <span class="badge bg-success me-2">Bulan: <?php echo e(date('F', mktime(0, 0, 0, request('bulan'), 1))); ?></span> <?php endif; ?>
                        <?php if(request('tahun')): ?> <span class="badge bg-success me-2">Tahun: <?php echo e(request('tahun')); ?></span> <?php endif; ?>
                        <a href="<?php echo e(route('kelahiran.index')); ?>" class="btn btn-sm btn-outline-info ms-2">Hapus Filter</a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>

                    
                    
                    
                    <div class="row g-4">
                        <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-primary card-hover">
                                
                                
                                <div class="card-header bg-primary text-white p-3 border-0 d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-box bg-white text-primary fw-bold rounded-circle d-flex align-items-center justify-content-center shadow-sm">
                                            <?php echo e(substr($item->bayi->nama ?? 'X', 0, 1)); ?>

                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h6 class="mb-1 text-white fw-bold text-truncate" title="<?php echo e($item->bayi->nama ?? 'Data Terhapus'); ?>">
                                            <?php echo e($item->bayi->nama ?? 'Data Terhapus'); ?>

                                        </h6>
                                        <small class="text-white-50 d-block">
                                            NIK: <?php echo e($item->bayi->no_ktp ?? '-'); ?>

                                        </small>
                                    </div>
                                </div>

                                <div class="card-body p-3">
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="me-2 text-center" style="width: 25px;">
                                                <i class="fas fa-calendar-alt text-primary"></i>
                                            </div>
                                            <span class="fw-bold text-dark">
                                                <?php echo e(\Carbon\Carbon::parse($item->tgl_lahir)->format('d F Y')); ?>

                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2 text-center" style="width: 25px;">
                                                <i class="fas fa-map-marker-alt text-primary"></i>
                                            </div>
                                            <span class="text-muted text-truncate">
                                                <?php echo e($item->tempat_lahir); ?>

                                            </span>
                                        </div>
                                    </div>

                                    <hr class="my-2 text-primary opacity-25">

                                    
                                    <div class="small mt-3">
                                        <div class="row py-1">
                                            <div class="col-4 text-muted fw-bold">Ayah</div>
                                            <div class="col-8 text-end text-dark text-truncate"><?php echo e($item->ayah->nama ?? '-'); ?></div>
                                        </div>
                                        <div class="row py-1">
                                            <div class="col-4 text-muted fw-bold">Ibu</div>
                                            <div class="col-8 text-end text-dark text-truncate"><?php echo e($item->ibu->nama ?? '-'); ?></div>
                                        </div>
                                        <div class="row py-2 align-items-center mt-2 border-top border-light">
                                            <div class="col-4 text-muted fw-bold">Status</div>
                                            <div class="col-8 text-end">
                                                <?php if($item->no_akta): ?>
                                                    <span class="badge bg-success shadow-sm"><i class="fas fa-check me-1"></i>Akta OK</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark shadow-sm"><i class="fas fa-clock me-1"></i>Proses</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="card-footer bg-transparent border-top-0 p-3">
                                    <div class="d-grid gap-2">
                                        <a href="<?php echo e(route('kelahiran.show', $item->kelahiran_id)); ?>" class="btn btn-info text-white fw-bold w-100">
                                            <i class="fas fa-file-upload me-2"></i> Detail & Bukti
                                        </a>
                                        <div class="d-flex gap-2">
                                            <a href="<?php echo e(route('kelahiran.edit', $item->kelahiran_id)); ?>" class="btn btn-warning text-white flex-grow-1">
                                                <i class="fas fa-edit me-2"></i> Edit
                                            </a>
                                            <form action="<?php echo e(route('kelahiran.destroy', $item->kelahiran_id)); ?>" method="POST" class="flex-grow-1" onsubmit="return confirm('Hapus data ini?')">
                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                <button class="btn btn-outline-danger w-100">
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
                                    <i class="fas fa-baby fa-3x text-primary opacity-50"></i>
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
                            <?php echo e($data->links('pagination::bootstrap-5')); ?>

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
    .avatar-box {
        width: 45px; height: 45px; font-size: 1.2rem;
        border: 2px solid rgba(255,255,255,0.8);
    }
    .card-hover { 
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-hover:hover { 
        transform: translateY(-5px); 
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; 
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.guest.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\arin\laragon-6.0-minimal\www\kependudukan-guest\resources\views/pages/kelahiran/index.blade.php ENDPATH**/ ?>