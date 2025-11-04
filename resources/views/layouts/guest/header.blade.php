<!-- Navbar Start -->
<div class="container-fluid border-bottom bg-light wow fadeIn" data-wow-delay="0.1s">
    <div class="container topbar bg-primary d-none d-lg-block py-2" style="border-radius: 0 40px">
        <div class="d-flex justify-content-between">
            <div class="top-info ps-1">
                <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">123 Street, New York</a></small>
                <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">Email@Example.com</a></small>
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
                    <!-- Menu Home & About - Sama untuk semua -->
                    <a href="{{ url('/') }}" class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('about') }}" class="nav-item nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a>

                    <!-- Menu Data - Berubah berdasarkan login status -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Data</a>
                        <div class="dropdown-menu m-0 bg-secondary rounded-0">
                            @auth
                                <!-- Menu Data untuk user yang sudah login -->
                                {{-- <a href="{{ route('dashboard') }}" class="dropdown-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a> --}}
                                <a href="{{ route('warga.index') }}" class="dropdown-item {{ request()->routeIs('warga.index') ? 'active' : '' }}">Data Warga</a>
                                <a href="{{ route('keluarga.index') }}" class="dropdown-item {{ request()->routeIs('keluarga.index') ? 'active' : '' }}">Data Keluarga</a>
                                <a href="{{ route('user.index') }}" class="dropdown-item {{ request()->routeIs('user.index') ? 'active' : '' }}">Data User</a>
                            @else
                                <!-- Menu Data untuk guest -->
                                <a href="{{ route('warga.index') }}" class="dropdown-item {{ request()->routeIs('warga.index') ? 'active' : '' }}">Data Warga</a>
                                <a href="{{ route('keluarga.index') }}" class="dropdown-item {{ request()->routeIs('keluarga.index') ? 'active' : '' }}">Data Keluarga</a>
                            @endauth
                        </div>
                    </div>

                    <!-- Menu Tambah Data - Hanya untuk user login -->
                    @auth
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Tambah Data</a>
                        <div class="dropdown-menu m-0 bg-secondary rounded-0">
                            <a href="{{ route('warga.create') }}" class="dropdown-item {{ request()->routeIs('warga.create') ? 'active' : '' }}">Tambah Warga</a>
                            <a href="{{ route('keluarga.create') }}" class="dropdown-item {{ request()->routeIs('keluarga.create') ? 'active' : '' }}">Tambah Keluarga</a>
                            <a href="{{ route('user.create') }}" class="dropdown-item {{ request()->routeIs('user.create') ? 'active' : '' }}">Tambah User</a>
                        </div>
                    </div>

                    {{-- <a href="{{ url('/auth/success') }}" class="nav-item nav-link {{ request()->is('auth/success') ? 'active' : '' }}">Status Pengajuan</a> --}}
                    @endauth

                    <!-- Menu Kontak - Sama untuk semua -->
                    <a href="#" class="nav-item nav-link">Kontak</a>

                    <!-- Info Kontak - Tetap di posisi yang sama -->
                    <div class="d-flex me-4">
                        <div id="phone-tada" class="d-flex align-items-center justify-content-center">
                            <a href="#" class="position-relative wow tada" data-wow-delay=".9s">
                                <i class="fa fa-phone-alt text-primary fa-2x me-4"></i>
                                <div class="position-absolute" style="top: -7px; left: 20px;">
                                    <span><i class="fa fa-comment-dots text-secondary"></i></span>
                                </div>
                            </a>
                        </div>
                        <div class="d-flex flex-column pe-10 border-primary mr-2">
                            <span class="text-primary">Punya Pertanyaan?</span>
                            <a href="#"><span class="text-secondary">Telp: + 0123 456 7890</span></a>
                        </div>
                    </div>
                </div>

                <!-- Auth Section - Berubah tombol/login -->
                <div class="d-flex align-items-center">
                    @auth
                        <!-- User sudah login - tampilkan dropdown user -->
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-2"></i>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="{{ route('dashboard') }}" class="dropdown-item">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="fas fa-user me-2"></i>Profile
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
                        <!-- User belum login - tampilkan tombol login/register -->
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm rounded-pill px-3 me-2">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </a>
                    @endauth

                    <!-- Search Button - Tetap sama -->
                    <button class="btn-search btn btn-primary btn-md-square rounded-circle ms-2" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <i class="fas fa-search text-white"></i>
                    </button>
                </div>
            </div>
        </nav>
    </div>
</div>

<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cari berdasarkan kata kunci</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-center">
                <div class="input-group w-75 mx-auto d-flex">
                    <input type="search" class="form-control p-3" placeholder="kata kunci" aria-describedby="search-icon-1">
                    <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Navbar End -->
