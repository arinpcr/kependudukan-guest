<div class="container-fluid border-bottom bg-light wow fadeIn" data-wow-delay="0.1s">
    <div class="container topbar bg-primary d-none d-lg-block py-2" style="border-radius: 0 40px">
        <div class="d-flex justify-content-between">
            <div class="top-info ps-1">
                <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">Sistem Kependudukan Desa</a></small>
                <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">admin@desa.example.com</a></small>
            </div>
            <div class="top-link pe-2">
                <a href="" class="btn btn-light btn-sm-square rounded-circle"><i class="fab fa-facebook-f text-secondary"></i></a>
                <a href="" class="btn btn-light btn-sm-square rounded-circle"><i class="fab fa-twitter text-secondary"></i></a>
                <a href="" class="btn btn-light btn-sm-square rounded-circle"><i class="fab fa-instagram text-secondary"></i></a>
                <a href="" class="btn btn-light btn-sm-square rounded-circle me-0"><i class="fab fa-linkedin-in text-secondary"></i></a>
            </div>
        </div>
    </div>
    <div class="container px-0">
        <nav class="navbar navbar-light navbar-expand-xl py-3">
            <a href="{{ url('/') }}" class="navbar-brand">
                <h1 class="text-primary display-6">Kependudukan</h1>
            </a>
            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="{{ url('/') }}" class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                    
                    <a href="{{ route('about') }}" class="nav-item nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                        <i class="fas fa-info-circle me-1"></i>About
                    </a>

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-database me-1"></i>Data
                        </a>
                        <div class="dropdown-menu m-0 bg-secondary rounded-0">
                            @auth
                                <a href="{{ route('warga.index') }}" class="dropdown-item {{ request()->routeIs('warga.index') ? 'active' : '' }}">
                                    <i class="fas fa-users me-2"></i>Data Warga
                                </a>
                                <a href="{{ route('keluarga.index') }}" class="dropdown-item {{ request()->routeIs('keluarga.index') ? 'active' : '' }}">
                                    <i class="fas fa-home me-2"></i>Data Keluarga
                                </a>
                                <a href="{{ route('anggota-keluarga.all') }}" class="dropdown-item {{ request()->routeIs('anggota-keluarga.all') ? 'active' : '' }}">
                                    <i class="fas fa-user-friends me-2"></i>Data Anggota Keluarga
                                </a>
                                <a href="{{ route('kematian.index') }}" class="dropdown-item {{ request()->routeIs('kematian.*') ? 'active' : '' }}">
                                    <i class="fas fa-book-dead me-2"></i>Data Kematian
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('user.index') }}" class="dropdown-item {{ request()->routeIs('user.index') ? 'active' : '' }}">
                                    <i class="fas fa-user-cog me-2"></i>Data User
                                </a>
                            @else
                                <a href="{{ route('warga.index') }}" class="dropdown-item">
                                    <i class="fas fa-users me-2"></i>Data Warga
                                </a>
                                <a href="{{ route('keluarga.index') }}" class="dropdown-item">
                                    <i class="fas fa-home me-2"></i>Data Keluarga
                                </a>
                                <a href="{{ route('anggota-keluarga.all') }}" class="dropdown-item">
                                    <i class="fas fa-user-friends me-2"></i>Data Anggota Keluarga
                                </a>
                                <a href="{{ route('kematian.index') }}" class="dropdown-item">
                                    <i class="fas fa-book-dead me-2"></i>Data Kematian
                                </a>
                            @endauth
                        </div>
                    </div>

                    @auth
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-plus-circle me-1"></i>Tambah Data
                        </a>
                        <div class="dropdown-menu m-0 bg-secondary rounded-0">
                            <a href="{{ route('warga.create') }}" class="dropdown-item {{ request()->routeIs('warga.create') ? 'active' : '' }}">
                                <i class="fas fa-user-plus me-2"></i>Tambah Warga
                            </a>
                            <a href="{{ route('keluarga.create') }}" class="dropdown-item {{ request()->routeIs('keluarga.create') ? 'active' : '' }}">
                                <i class="fas fa-house-user me-2"></i>Tambah Keluarga
                            </a>
                            <a href="{{ route('kematian.create') }}" class="dropdown-item {{ request()->routeIs('kematian.create') ? 'active' : '' }}">
                                <i class="fas fa-file-medical me-2"></i>Tambah Kematian
                            </a>
                            <a href="{{ route('user.create') }}" class="dropdown-item {{ request()->routeIs('user.create') ? 'active' : '' }}">
                                <i class="fas fa-user-plus me-2"></i>Tambah User
                            </a>
                        </div>
                    </div>
                    @endauth

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-chart-bar me-1"></i>Laporan
                        </a>
                        <div class="dropdown-menu m-0 bg-secondary rounded-0">
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-file-alt me-2"></i>Laporan Warga
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-file-contract me-2"></i>Laporan Keluarga
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-users me-2"></i>Laporan Anggota
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-book-dead me-2"></i>Laporan Kematian
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-chart-pie me-2"></i>Statistik
                            </a>
                        </div>
                    </div>

                    <a href="#" class="nav-item nav-link">
                        <i class="fas fa-phone me-1"></i>Kontak
                    </a>
                </div>

                <div class="d-flex align-items-center">
                    @auth
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                                <div class="user-avatar me-2">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ Auth::user()->avatar_url }}" 
                                             alt="{{ Auth::user()->name }}" 
                                             class="rounded-circle"
                                             style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #0d6efd;">
                                    @else
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="user-info">
                                    <div class="user-name small fw-bold">{{ Auth::user()->name }}</div>
                                    <div class="user-role small text-muted">
                                        @if(Auth::user()->role ?? false)
                                            {{ ucfirst(Auth::user()->role) }}
                                        @else
                                            User
                                        @endif
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0 dropdown-menu-end">
                                <a href="{{ route('dashboard') }}" class="dropdown-item">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                                
                                <a href="{{ route('profile') }}" class="dropdown-item">
                                    <i class="fas fa-user me-2"></i>Profile Saya
                                </a>
                                
                                <div class="dropdown-divider"></div>
                                
                                <form method="POST" action="{{ route('auth.logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item border-0 bg-transparent">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('auth.login') }}" class="btn btn-primary btn-sm rounded-pill px-3 me-2">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    @endauth

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

@auth
<div class="position-fixed bottom-0 start-0 p-3 bg-warning text-dark small" style="z-index: 9999; display: none;" id="debugPanel">
    <strong>Debug Avatar:</strong><br>
    User: {{ Auth::user()->name }}<br>
    Avatar: {{ Auth::user()->avatar ?? 'NULL' }}<br>
    Avatar URL: {{ Auth::user()->avatar_url }}<br>
    <button class="btn btn-sm btn-danger mt-1" onclick="document.getElementById('debugPanel').style.display='none'">Tutup</button>
</div>
@endauth

@push('styles')
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
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle debug panel dengan shortcut Ctrl+D
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'd') {
                e.preventDefault();
                const debugPanel = document.getElementById('debugPanel');
                if (debugPanel) {
                    debugPanel.style.display = debugPanel.style.display === 'none' ? 'block' : 'none';
                }
            }
        });

        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        console.log('Header loaded with avatar support');
    });
</script>
@endpush