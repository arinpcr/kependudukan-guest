<div class="container-fluid border-bottom bg-light wow fadeIn" data-wow-delay="0.1s">
    
    <div class="container topbar bg-primary d-none d-lg-block py-2" style="border-radius: 0 0 40px 40px; margin-bottom: -20px; position: relative; z-index: 10;">
        <div class="d-flex justify-content-between">
            <div class="top-info ps-2">
                <small class="me-3">
                    <i class="fas fa-map-marker-alt me-2 text-white"></i>
                    <a href="#" class="text-white text-decoration-none">Sistem Kependudukan Desa Digital</a>
                </small>
                <small class="me-3">
                    <i class="fas fa-envelope me-2 text-white"></i>
                    <a href="#" class="text-white text-decoration-none">Arini24si@mahasiswa.pcr.ac.id</a>
                </small>
            </div>
            <div class="top-link pe-2">
                <a href="https://github.com/arinpcr" target="_blank" class="btn btn-light btn-sm-square rounded-circle" title="GitHub">
                    <i class="fab fa-github text-primary"></i>
                </a>
                <a href="https://www.instagram.com/0.79990/" target="_blank" class="btn btn-light btn-sm-square rounded-circle" title="Instagram">
                    <i class="fab fa-instagram text-primary"></i>
                </a>
                <a href="https://wa.me/" target="_blank" class="btn btn-light btn-sm-square rounded-circle" title="WhatsApp">
                    <i class="fab fa-whatsapp text-primary"></i>
                </a>
                <a href="https://www.linkedin.com/in/arini-zahira-putri-268407394/" target="_blank" class="btn btn-light btn-sm-square rounded-circle" title="LinkedIn">
                    <i class="fab fa-linkedin-in text-primary"></i>
                </a>
                <a href="mailto:Arini24si@mahasiswa.pcr.ac.id" class="btn btn-light btn-sm-square rounded-circle me-0" title="Kirim Email">
                    <i class="fas fa-envelope text-primary"></i>
                </a>
            </div>
        </div>
    </div>

    
    <div class="container px-0 pt-4"> 
        <nav class="navbar navbar-light navbar-expand-xl py-3">
            
            <a href="<?php echo e(url('/')); ?>" class="navbar-brand p-0">
                <img src="<?php echo e(asset('assets-guest/img/logo.png')); ?>" alt="Logo" style="height: 55px; width: auto; object-fit: contain;">
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
                        <div class="dropdown-menu m-0 bg-white shadow-sm rounded-3 border-0 p-2">
                            <?php if(auth()->guard()->check()): ?>
                                <a href="<?php echo e(route('warga.index')); ?>" class="dropdown-item">
                                    <i class="fas fa-users"></i>Data Warga
                                </a>
                                <a href="<?php echo e(route('keluarga.index')); ?>" class="dropdown-item">
                                    <i class="fas fa-house-user"></i>Data Keluarga
                                </a>
                                <a href="<?php echo e(route('anggota-keluarga.all')); ?>" class="dropdown-item">
                                    <i class="fas fa-user-friends"></i>Anggota Keluarga
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="<?php echo e(route('kelahiran.index')); ?>" class="dropdown-item">
                                    <i class="fas fa-baby"></i>Data Kelahiran
                                </a>
                                <a href="<?php echo e(route('kematian.index')); ?>" class="dropdown-item">
                                    <i class="fas fa-book-dead"></i>Data Kematian
                                </a>
                                <a href="<?php echo e(route('pindah.index')); ?>" class="dropdown-item">
                                    <i class="fas fa-truck-moving"></i>Data Pindah
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="<?php echo e(route('user.index')); ?>" class="dropdown-item">
                                    <i class="fas fa-user-cog"></i>Data User
                                </a>
                            <?php else: ?>
                                
                                <a href="<?php echo e(route('warga.index')); ?>" class="dropdown-item">
                                    <i class="fas fa-users"></i>Data Warga
                                </a>
                                <a href="<?php echo e(route('keluarga.index')); ?>" class="dropdown-item">
                                    <i class="fas fa-house-user"></i>Data Keluarga
                                </a>
                                <a href="<?php echo e(route('anggota-keluarga.all')); ?>" class="dropdown-item">
                                    <i class="fas fa-user-friends"></i>Anggota Keluarga
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="<?php echo e(route('kelahiran.index')); ?>" class="dropdown-item">
                                    <i class="fas fa-baby"></i>Data Kelahiran
                                </a>
                                <a href="<?php echo e(route('kematian.index')); ?>" class="dropdown-item">
                                    <i class="fas fa-book-dead"></i>Data Kematian
                                </a>
                                <a href="<?php echo e(route('pindah.index')); ?>" class="dropdown-item">
                                    <i class="fas fa-truck-moving"></i>Data Pindah
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if(auth()->guard()->check()): ?>
                    
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-plus-circle me-1"></i>Tambah Data
                        </a>
                        <div class="dropdown-menu m-0 bg-white shadow-sm rounded-3 border-0 p-2">
                            <a href="<?php echo e(route('warga.create')); ?>" class="dropdown-item">
                                <i class="fas fa-user-plus"></i>Tambah Warga
                            </a>
                            <a href="<?php echo e(route('keluarga.create')); ?>" class="dropdown-item">
                                <i class="fas fa-house-user"></i>Tambah Keluarga
                            </a>
                            
                            
                            
                            <div class="dropdown-divider"></div>
                            
                            <a href="<?php echo e(route('kelahiran.create')); ?>" class="dropdown-item">
                                <i class="fas fa-baby-carriage"></i>Tambah Kelahiran
                            </a>
                            <a href="<?php echo e(route('kematian.create')); ?>" class="dropdown-item">
                                <i class="fas fa-file-medical"></i>Tambah Kematian
                            </a>
                            <a href="<?php echo e(route('pindah.create')); ?>" class="dropdown-item">
                                <i class="fas fa-truck-loading"></i>Tambah Pindah
                            </a>
                            
                            <div class="dropdown-divider"></div>
                            
                            <a href="<?php echo e(route('user.create')); ?>" class="dropdown-item">
                                <i class="fas fa-user-shield"></i>Tambah User
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
                                             class="rounded-circle shadow-sm"
                                             style="width: 40px; height: 40px; object-fit: cover; border: 2px solid var(--bs-primary);">
                                    <?php else: ?>
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="user-info">
                                    <div class="user-name small fw-bold text-dark"><?php echo e(Auth::user()->name); ?></div>
                                    <div class="user-role small text-primary" style="font-size: 0.75rem;">
                                        <?php echo e(ucfirst(Auth::user()->role ?? 'User')); ?>

                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu m-0 bg-white shadow-sm rounded-3 border-0 p-2 dropdown-menu-end">
                                <a href="<?php echo e(route('dashboard')); ?>" class="dropdown-item">
                                    <i class="fas fa-tachometer-alt"></i>Dashboard
                                </a>
                                <a href="<?php echo e(route('profile')); ?>" class="dropdown-item">
                                    <i class="fas fa-user-circle"></i>Profile Saya
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="<?php echo e(route('auth.logout')); ?>" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route('auth.login')); ?>" class="btn btn-primary btn-sm rounded-pill px-4 py-2 me-2 shadow-sm">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    <?php endif; ?>

                    <button class="btn-search btn btn-primary btn-md-square rounded-circle ms-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#searchModal">
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
            <div class="modal-header border-0">
                <h5 class="modal-title text-primary" id="searchModalLabel">
                    <i class="fas fa-search me-2"></i>Pencarian Data Kependudukan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body d-flex align-items-center justify-content-center">
                <div class="w-100" style="max-width: 800px;">
                    
                    
                    <form action="<?php echo e(route('warga.index')); ?>" method="GET">
                        <div class="input-group input-group-lg shadow-sm border rounded-3 overflow-hidden">
                            <input type="search" 
                                   name="search" 
                                   class="form-control border-0 p-4 fs-5" 
                                   id="searchInputHeader" 
                                   placeholder="Cari warga berdasarkan Nama, NIK, atau Email..." 
                                   value="<?php echo e(request('search')); ?>"
                                   autocomplete="off">
                            
                            <button class="btn btn-primary px-5 fw-bold" type="submit">
                                <i class="fas fa-search me-2"></i> CARI
                            </button>
                        </div>
                        <div class="text-center mt-3 text-muted">
                            <small>Tekan <strong>Enter</strong> untuk mulai mencari</small>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var searchModal = document.getElementById('searchModal')
        var searchInput = document.getElementById('searchInputHeader')

        if (searchModal && searchInput) {
            searchModal.addEventListener('shown.bs.modal', function () {
                searchInput.focus();
            })
        }
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH D:\arin\laragon-6.0-minimal\www\kependudukan-guest\resources\views/layouts/guest/header.blade.php ENDPATH**/ ?>