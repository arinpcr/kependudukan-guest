<div class="container-fluid border-bottom bg-light wow fadeIn" data-wow-delay="0.1s">
    <div class="container topbar bg-primary d-none d-lg-block py-2" style="border-radius: 0 40px">
        <div class="d-flex justify-content-between">
            <div class="top-info ps-1">
                <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">Sistem Kependudukan Desa</a></small>
                <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">admin@desa.example.com</a></small>
            </div>
            <div class="top-link pe-2">
    
    <a href="https://github.com/arinpcr" target="_blank" class="btn btn-light btn-sm-square rounded-circle" title="GitHub">
        <i class="fab fa-github text-secondary"></i>
    </a>
    
    
    <a href="https://www.instagram.com/0.79990/" target="_blank" class="btn btn-light btn-sm-square rounded-circle" title="Instagram">
        <i class="fab fa-instagram text-secondary"></i>
    </a>
    
    
    <a href="https://wa.me/" target="_blank" class="btn btn-light btn-sm-square rounded-circle" title="WhatsApp">
        <i class="fab fa-whatsapp text-secondary"></i>
    </a>

    
    <a href="https://www.linkedin.com/in/arini-zahira-putri-268407394/" target="_blank" class="btn btn-light btn-sm-square rounded-circle" title="LinkedIn">
        <i class="fab fa-linkedin-in text-secondary"></i>
    </a>

    
    <a href="mailto:Arini24si@mahasiswa.pcr.ac.id" class="btn btn-light btn-sm-square rounded-circle me-0" title="Kirim Email">
        <i class="fas fa-envelope text-secondary"></i>
    </a>
</div>
        </div>
    </div>
    <div class="container px-0">
        <nav class="navbar navbar-light navbar-expand-xl py-3">
            
            
            <a href="<?php echo e(url('/')); ?>" class="navbar-brand p-0">
                <img src="<?php echo e(asset('assets-guest/img/logo.png')); ?>" alt="Logo" style="height: 50px; width: auto; object-fit: contain;">
            </a>

            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    
                    <a href="<?php echo e(url('/')); ?>" class="nav-item nav-link <?php echo e(request()->is('/') ? 'active' : ''); ?>">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                    
                    
                    <a href="<?php echo e(route('about')); ?>" class="nav-item nav-link <?php echo e(request()->routeIs('about') ? 'active' : ''); ?>">
                        <i class="fas fa-info-circle me-1"></i>About
                    </a>

                    
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle <?php echo e(request()->is('warga*') || request()->is('keluarga*') || request()->is('kematian*') || request()->is('kelahiran*') || request()->is('pindah*') ? 'active' : ''); ?>" data-bs-toggle="dropdown">
                            <i class="fas fa-database me-1"></i>Data
                        </a>
                        <div class="dropdown-menu m-0 bg-secondary rounded-0">
                            <?php if(auth()->guard()->check()): ?>
                                <a href="<?php echo e(route('warga.index')); ?>" class="dropdown-item">
                                    <i class="fas fa-users me-2"></i>Data Warga
                                </a>
                                <a href="<?php echo e(route('keluarga.index')); ?>" class="dropdown-item">
                                    <i class="fas fa-home me-2"></i>Data Keluarga
                                </a>
                                <a href="<?php echo e(route('anggota-keluarga.all')); ?>" class="dropdown-item">
                                    <i class="fas fa-user-friends me-2"></i>Data Anggota Keluarga
                                </a>
                                
                                
                                <a href="<?php echo e(route('kelahiran.index')); ?>" class="dropdown-item">
                                    <i class="fas fa-baby me-2"></i>Data Kelahiran
                                </a>
                                <a href="<?php echo e(route('kematian.index')); ?>" class="dropdown-item">
                                    <i class="fas fa-book-dead me-2"></i>Data Kematian
                                </a>
                                
                                <a href="<?php echo e(route('pindah.index')); ?>" class="dropdown-item">
                                    <i class="fas fa-truck-moving me-2"></i>Data Pindah
                                </a>

                                <div class="dropdown-divider"></div>
                                <a href="<?php echo e(route('user.index')); ?>" class="dropdown-item">
                                    <i class="fas fa-user-cog me-2"></i>Data User
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('warga.index')); ?>" class="dropdown-item">
                                    <i class="fas fa-users me-2"></i>Data Warga
                                </a>
                                <a href="<?php echo e(route('keluarga.index')); ?>" class="dropdown-item">
                                    <i class="fas fa-home me-2"></i>Data Keluarga
                                </a>
                                <a href="<?php echo e(route('anggota-keluarga.all')); ?>" class="dropdown-item">
                                    <i class="fas fa-user-friends me-2"></i>Data Anggota Keluarga
                                </a>
                                <a href="<?php echo e(route('kelahiran.index')); ?>" class="dropdown-item">
                                    <i class="fas fa-baby me-2"></i>Data Kelahiran
                                </a>
                                <a href="<?php echo e(route('kematian.index')); ?>" class="dropdown-item">
                                    <i class="fas fa-book-dead me-2"></i>Data Kematian
                                </a>
                                
                                <a href="<?php echo e(route('pindah.index')); ?>" class="dropdown-item">
                                    <i class="fas fa-truck-moving me-2"></i>Data Pindah
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if(auth()->guard()->check()): ?>
                    
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-plus-circle me-1"></i>Tambah Data
                        </a>
                        <div class="dropdown-menu m-0 bg-secondary rounded-0">
                            <a href="<?php echo e(route('warga.create')); ?>" class="dropdown-item">
                                <i class="fas fa-user-plus me-2"></i>Tambah Warga
                            </a>
                            <a href="<?php echo e(route('keluarga.create')); ?>" class="dropdown-item">
                                <i class="fas fa-house-user me-2"></i>Tambah Keluarga
                            </a>
                            
                            
                            <a href="<?php echo e(route('kelahiran.create')); ?>" class="dropdown-item">
                                <i class="fas fa-baby-carriage me-2"></i>Tambah Kelahiran
                            </a>
                            <a href="<?php echo e(route('kematian.create')); ?>" class="dropdown-item">
                                <i class="fas fa-file-medical me-2"></i>Tambah Kematian
                            </a>
                            
                            <a href="<?php echo e(route('pindah.create')); ?>" class="dropdown-item">
                                <i class="fas fa-truck-moving me-2"></i>Tambah Pindah
                            </a>

                            <div class="dropdown-divider"></div>
                            <a href="<?php echo e(route('user.create')); ?>" class="dropdown-item">
                                <i class="fas fa-user-plus me-2"></i>Tambah User
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>

                    
                    <a href="<?php echo e(route('laporan.index')); ?>" class="nav-item nav-link <?php echo e(request()->routeIs('laporan.index') ? 'active' : ''); ?>">
                        <i class="fas fa-chart-pie me-1"></i>Laporan
                    </a>

                    
                    <a href="<?php echo e(route('kontak')); ?>" class="nav-item nav-link <?php echo e(request()->routeIs('kontak') ? 'active' : ''); ?>">
                        <i class="fas fa-phone me-1"></i>Kontak
                    </a>
                </div>

                <div class="d-flex align-items-center">
                    <?php if(auth()->guard()->check()): ?>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                                <div class="user-avatar me-2">
                                    <?php if(Auth::user()->avatar): ?>
                                        <img src="<?php echo e(Auth::user()->avatar_url); ?>" 
                                             alt="<?php echo e(Auth::user()->name); ?>" 
                                             class="rounded-circle"
                                             style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #0d6efd;">
                                    <?php else: ?>
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="user-info">
                                    <div class="user-name small fw-bold"><?php echo e(Auth::user()->name); ?></div>
                                    <div class="user-role small text-muted">
                                        <?php echo e(ucfirst(Auth::user()->role ?? 'User')); ?>

                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0 dropdown-menu-end">
                                <a href="<?php echo e(route('dashboard')); ?>" class="dropdown-item">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                                
                                <a href="<?php echo e(route('profile')); ?>" class="dropdown-item">
                                    <i class="fas fa-user me-2"></i>Profile Saya
                                </a>
                                
                                <div class="dropdown-divider"></div>
                                
                                <form method="POST" action="<?php echo e(route('auth.logout')); ?>" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item border-0 bg-transparent">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route('auth.login')); ?>" class="btn btn-primary btn-sm rounded-pill px-3 me-2">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    <?php endif; ?>

                    <button class="btn-search btn btn-primary btn-md-square rounded-circle ms-2" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <i class="fas fa-search text-white"></i>
                    </button>
                </div>
            </div>
        </nav>
    </div>
</div>

<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="searchModalLabel">
                    <i class="fas fa-search me-2"></i>Cari Data Kependudukan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-center">
                <div class="w-100">
                    <div class="input-group input-group-lg w-75 mx-auto">
                        <input type="search" class="form-control p-3" placeholder="Cari warga, keluarga, atau data lainnya..." aria-describedby="search-icon">
                        <button class="btn btn-primary px-4" type="button" id="search-icon">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    .user-avatar img {
        transition: transform 0.3s ease;
    }
    .user-avatar:hover img {
        transform: scale(1.1);
    }
    .nav-link.dropdown-toggle:hover .user-avatar img {
        transform: scale(1.05);
    }
    .dropdown-menu {
        min-width: 200px;
    }
    .user-info {
        line-height: 1.2;
    }
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
<?php $__env->stopPush(); ?><?php /**PATH D:\arin\laragon-6.0-minimal\www\kependudukan-guest\resources\views/layouts/guest/header.blade.php ENDPATH**/ ?>