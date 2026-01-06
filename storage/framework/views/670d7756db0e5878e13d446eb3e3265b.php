<?php $__env->startSection('title', 'Data User - Sistem Kependudukan'); ?>


<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-5">
    <div class="container py-5">
        
        
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Manajemen Akun</h4>
            <h1 class="mb-5 display-4">Data User</h1>
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
                        <a href="<?php echo e(route('user.create')); ?>" class="btn btn-primary px-4 py-2 shadow-sm">
                            <i class="fas fa-plus me-2"></i>Tambah User Baru
                        </a>
                        <div class="text-muted fw-bold">
                            <i class="fas fa-users me-2 text-primary"></i>
                            Total Data: <span class="text-dark"><?php echo e($dataUser->total()); ?></span>
                        </div>
                    </div>

                    
                    <div class="card mb-5 border-0 shadow-sm" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <form action="<?php echo e(route('user.index')); ?>" method="GET" id="searchForm">
                                <?php if(request('per_page')): ?> <input type="hidden" name="per_page" value="<?php echo e(request('per_page')); ?>"> <?php endif; ?>
                                <?php if(request('sort')): ?> <input type="hidden" name="sort" value="<?php echo e(request('sort')); ?>"> <?php endif; ?>

                                <div class="row g-3">
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-muted small">Pencarian</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                            <input type="text" class="form-control border-start-0 ps-0" name="search" placeholder="Cari nama atau email..." value="<?php echo e(request('search')); ?>">
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold text-muted small">Filter Role</label>
                                        <select class="form-select" name="role" onchange="this.form.submit()">
                                            <option value="">Semua Role</option>
                                            <option value="Super Admin" <?php echo e(request('role') == 'Super Admin' ? 'selected' : ''); ?>>Super Admin</option>
                                            <option value="Admin" <?php echo e(request('role') == 'Admin' ? 'selected' : ''); ?>>Admin</option>
                                            <option value="User" <?php echo e(request('role') == 'User' ? 'selected' : ''); ?>>User</option>
                                        </select>
                                    </div>

                                    
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold text-muted small">Urutkan</label>
                                        <select class="form-select" name="sort" onchange="this.form.submit()">
                                            <option value="name" <?php echo e(request('sort') == 'name' ? 'selected' : ''); ?>>Nama A-Z</option>
                                            <option value="name_desc" <?php echo e(request('sort') == 'name_desc' ? 'selected' : ''); ?>>Nama Z-A</option>
                                            <option value="terbaru" <?php echo e(request('sort') == 'terbaru' ? 'selected' : ''); ?>>Terbaru</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    
                    <div class="row g-4">
                      <?php $__empty_1 = true; $__currentLoopData = $dataUser; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card user-card h-100">
                                    
                                    
                                    <div class="user-avatar-wrapper">
                                        <img src="<?php echo e($item->avatar_url); ?>" alt="<?php echo e($item->name); ?>" class="user-avatar-img">
                                    </div>

                                    
                                    <div class="card-body text-center pt-2">
                                        
                                        <h5 class="text-dark"><?php echo e($item->name); ?></h5>
                                        <p class="text-muted mb-3"><?php echo e($item->email); ?></p>

                                        
                                        <?php
                                            $badgeClass = match($item->role) {
                                                'Super Admin' => 'badge-super', // Merah
                                                'Admin'       => 'badge-admin', // Kuning
                                                default       => 'badge-user',  // Pink (User Biasa)
                                            };
                                        ?>
                                        
                                        <span class="badge badge-role <?php echo e($badgeClass); ?>">
                                            <?php echo e($item->role); ?>

                                        </span>

                                        <hr class="opacity-25">

                                        
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="<?php echo e(route('user.edit', $item->id)); ?>" class="btn btn-outline-warning btn-sm action-btn" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <?php if(Auth::id() != $item->id): ?>
                                            <form action="<?php echo e(route('user.destroy', $item->id)); ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-outline-danger btn-sm action-btn" title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                            <?php else: ?>
                                            <button class="btn btn-light btn-sm action-btn text-muted" disabled title="Sedang Login">
                                                <i class="fas fa-user-check"></i>
                                            </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    
                                    <div class="card-footer bg-white border-top-0 text-center pb-4 pt-0">
                                        <small class="text-muted" style="font-size: 0.75rem;">
                                            Bergabung: <?php echo e($item->created_at->format('d M Y')); ?>

                                        </small>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="fas fa-users-slash fa-4x text-muted mb-3 opacity-50"></i>
                                    <h5 class="text-muted">Data user tidak ditemukan.</h5>
                                    <a href="<?php echo e(route('user.index')); ?>" class="btn btn-outline-primary mt-2">Reset Filter</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    
                    <?php if($dataUser->hasPages()): ?>
                    <div class="d-flex justify-content-end align-items-center mt-5">
                        <?php echo e($dataUser->withQueryString()->links('pagination::bootstrap-5')); ?>

                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.guest.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Amel_2SIB\laragon-6.0-minimal\www\kependudukan-guest\resources\views/pages/user/index.blade.php ENDPATH**/ ?>