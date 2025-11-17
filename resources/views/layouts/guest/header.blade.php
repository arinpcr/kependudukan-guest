<!-- Navbar Start -->
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
                    <!-- Menu Home & About -->
                    <a href="{{ url('/') }}" class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                    <a href="{{ route('about') }}" class="nav-item nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                        <i class="fas fa-info-circle me-1"></i>About
                    </a>

                    <!-- Menu Data -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-database me-1"></i>Data
                        </a>
                        <div class="dropdown-menu m-0 bg-secondary rounded-0">
                            @auth
                                <!-- Menu untuk user login -->
                                <a href="{{ route('warga.index') }}" class="dropdown-item {{ request()->routeIs('warga.index') ? 'active' : '' }}">
                                    <i class="fas fa-users me-2"></i>Data Warga
                                </a>
                                <a href="{{ route('keluarga.index') }}" class="dropdown-item {{ request()->routeIs('keluarga.index') ? 'active' : '' }}">
                                    <i class="fas fa-home me-2"></i>Data Keluarga
                                </a>
                                
                                <!-- ✅ ANGGOTA KELUARGA - LINK LANGSUNG KE HALAMAN ANGGOTA -->
                                <a href="{{ route('anggota-keluarga.all') }}" class="dropdown-item {{ request()->routeIs('anggota-keluarga.all') ? 'active' : '' }}">
                                    <i class="fas fa-user-friends me-2"></i>Data Anggota Keluarga
                                </a>
                                
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('user.index') }}" class="dropdown-item {{ request()->routeIs('user.index') ? 'active' : '' }}">
                                    <i class="fas fa-user-cog me-2"></i>Data User
                                </a>
                            @else
                                <!-- Menu untuk guest -->
                                <a href="{{ route('warga.index') }}" class="dropdown-item {{ request()->routeIs('warga.index') ? 'active' : '' }}">
                                    <i class="fas fa-users me-2"></i>Data Warga
                                </a>
                                <a href="{{ route('keluarga.index') }}" class="dropdown-item {{ request()->routeIs('keluarga.index') ? 'active' : '' }}">
                                    <i class="fas fa-home me-2"></i>Data Keluarga
                                </a>
                                
                                <a href="{{ route('anggota-keluarga.all') }}" class="dropdown-item {{ request()->routeIs('anggota-keluarga.all') ? 'active' : '' }}">
                                    <i class="fas fa-user-friends me-2"></i>Data Anggota Keluarga
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Menu Tambah Data - Hanya untuk user login -->
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
                            <a href="{{ route('user.create') }}" class="dropdown-item {{ request()->routeIs('user.create') ? 'active' : '' }}">
                                <i class="fas fa-user-plus me-2"></i>Tambah User
                            </a>
                        </div>
                    </div>
                    @endauth

                    <!-- Menu Laporan -->
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
                                <i class="fas fa-chart-pie me-2"></i>Statistik
                            </a>
                        </div>
                    </div>

                    <!-- Menu Kontak -->
                    <a href="#" class="nav-item nav-link">
                        <i class="fas fa-phone me-1"></i>Kontak
                    </a>
                </div>

                <!-- Auth Section -->
                <div class="d-flex align-items-center">
                    @auth
                        <!-- User sudah login -->
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                                <div class="user-avatar me-2">
                                    <i class="fas fa-user-circle fa-lg text-primary"></i>
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
                                <a href="#" class="dropdown-item">
                                    <i class="fas fa-user me-2"></i>Profile Saya
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item border-0 bg-transparent">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- User belum login -->
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm rounded-pill px-3 me-2">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </a>
                    @endauth

                    <!-- Search Button -->
                    <button class="btn-search btn btn-primary btn-md-square rounded-circle ms-2" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <i class="fas fa-search text-white"></i>
                    </button>
                </div>
            </div>
        </nav>
    </div>
</div>

<!-- Search Modal (tetap sama) -->
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
<!-- Navbar End -->