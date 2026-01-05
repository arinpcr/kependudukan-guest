<div class="container-fluid border-bottom bg-light wow fadeIn" data-wow-delay="0.1s">
    {{-- TOPBAR --}}
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

    {{-- NAVBAR --}}
    <div class="container px-0 pt-4"> 
        <nav class="navbar navbar-light navbar-expand-xl py-3">
            
            <a href="{{ url('/') }}" class="navbar-brand p-0">
                <img src="{{ asset('assets-guest/img/logo.png') }}" alt="Logo" style="height: 55px; width: auto; object-fit: contain;">
            </a>

            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    {{-- MENU HOME --}}
                    <a href="{{ url('/') }}" class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                    
                    {{-- MENU ABOUT --}}
                    <a href="{{ route('about') }}" class="nav-item nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                        <i class="fas fa-info-circle me-1"></i>About
                    </a>

                    {{-- MENU DATA (Dropdown) --}}
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle {{ request()->is('warga*') || request()->is('keluarga*') || request()->is('kematian*') || request()->is('kelahiran*') || request()->is('pindah*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                            <i class="fas fa-database me-1"></i>Data
                        </a>
                        <div class="dropdown-menu m-0 bg-white shadow-sm rounded-3 border-0 p-2">
                            @auth
                                <a href="{{ route('warga.index') }}" class="dropdown-item">
                                    <i class="fas fa-users"></i>Data Warga
                                </a>
                                <a href="{{ route('keluarga.index') }}" class="dropdown-item">
                                    <i class="fas fa-house-user"></i>Data Keluarga
                                </a>
                                <a href="{{ route('anggota-keluarga.all') }}" class="dropdown-item">
                                    <i class="fas fa-user-friends"></i>Anggota Keluarga
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('kelahiran.index') }}" class="dropdown-item">
                                    <i class="fas fa-baby"></i>Data Kelahiran
                                </a>
                                <a href="{{ route('kematian.index') }}" class="dropdown-item">
                                    <i class="fas fa-book-dead"></i>Data Kematian
                                </a>
                                <a href="{{ route('pindah.index') }}" class="dropdown-item">
                                    <i class="fas fa-truck-moving"></i>Data Pindah
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('user.index') }}" class="dropdown-item">
                                    <i class="fas fa-user-cog"></i>Data User
                                </a>
                            @else
                                {{-- Menu untuk Guest (Tanpa Login) --}}
                                <a href="{{ route('warga.index') }}" class="dropdown-item">
                                    <i class="fas fa-users"></i>Data Warga
                                </a>
                                <a href="{{ route('keluarga.index') }}" class="dropdown-item">
                                    <i class="fas fa-house-user"></i>Data Keluarga
                                </a>
                                <a href="{{ route('anggota-keluarga.all') }}" class="dropdown-item">
                                    <i class="fas fa-user-friends"></i>Anggota Keluarga
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('kelahiran.index') }}" class="dropdown-item">
                                    <i class="fas fa-baby"></i>Data Kelahiran
                                </a>
                                <a href="{{ route('kematian.index') }}" class="dropdown-item">
                                    <i class="fas fa-book-dead"></i>Data Kematian
                                </a>
                                <a href="{{ route('pindah.index') }}" class="dropdown-item">
                                    <i class="fas fa-truck-moving"></i>Data Pindah
                                </a>
                            @endauth
                        </div>
                    </div>

                    @auth
                    {{-- MENU TAMBAH DATA (Dropdown) --}}
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-plus-circle me-1"></i>Tambah Data
                        </a>
                        <div class="dropdown-menu m-0 bg-white shadow-sm rounded-3 border-0 p-2">
                            <a href="{{ route('warga.create') }}" class="dropdown-item">
                                <i class="fas fa-user-plus"></i>Tambah Warga
                            </a>
                            <a href="{{ route('keluarga.create') }}" class="dropdown-item">
                                <i class="fas fa-house-user"></i>Tambah Keluarga
                            </a>
                            
                            {{-- Menu "Tambah Anggota" DIHAPUS karena butuh ID Keluarga --}}
                            
                            <div class="dropdown-divider"></div>
                            
                            <a href="{{ route('kelahiran.create') }}" class="dropdown-item">
                                <i class="fas fa-baby-carriage"></i>Tambah Kelahiran
                            </a>
                            <a href="{{ route('kematian.create') }}" class="dropdown-item">
                                <i class="fas fa-file-medical"></i>Tambah Kematian
                            </a>
                            <a href="{{ route('pindah.create') }}" class="dropdown-item">
                                <i class="fas fa-truck-loading"></i>Tambah Pindah
                            </a>
                            
                            <div class="dropdown-divider"></div>
                            
                            <a href="{{ route('user.create') }}" class="dropdown-item">
                                <i class="fas fa-user-shield"></i>Tambah User
                            </a>
                        </div>
                    </div>
                    @endauth

                    {{-- MENU LAPORAN --}}
                    <a href="{{ route('laporan.index') }}" class="nav-item nav-link {{ request()->routeIs('laporan.index') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie me-1"></i>Laporan
                    </a>

                    {{-- MENU KONTAK --}}
                    <a href="{{ route('kontak') }}" class="nav-item nav-link {{ request()->routeIs('kontak') ? 'active' : '' }}">
                        <i class="fas fa-phone me-1"></i>Kontak
                    </a>
                </div>

                {{-- USER PROFILE / LOGIN --}}
                <div class="d-flex align-items-center">
                    @auth
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                                <div class="user-avatar me-2">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ Auth::user()->avatar_url }}" 
                                             alt="{{ Auth::user()->name }}" 
                                             class="rounded-circle shadow-sm"
                                             style="width: 40px; height: 40px; object-fit: cover; border: 2px solid var(--bs-primary);">
                                    @else
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="user-info">
                                    <div class="user-name small fw-bold text-dark">{{ Auth::user()->name }}</div>
                                    <div class="user-role small text-primary" style="font-size: 0.75rem;">
                                        {{ ucfirst(Auth::user()->role ?? 'User') }}
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu m-0 bg-white shadow-sm rounded-3 border-0 p-2 dropdown-menu-end">
                                <a href="{{ route('dashboard') }}" class="dropdown-item">
                                    <i class="fas fa-tachometer-alt"></i>Dashboard
                                </a>
                                <a href="{{ route('profile') }}" class="dropdown-item">
                                    <i class="fas fa-user-circle"></i>Profile Saya
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('auth.logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('auth.login') }}" class="btn btn-primary btn-sm rounded-pill px-4 py-2 me-2 shadow-sm">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    @endauth

                    <button class="btn-search btn btn-primary btn-md-square rounded-circle ms-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <i class="fas fa-search text-white"></i>
                    </button>
                </div>
            </div>
        </nav>
    </div>
</div>

{{-- SEARCH MODAL --}}
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
                    
                    {{-- FORM PENCARIAN BERFUNGSI --}}
                    <form action="{{ route('warga.index') }}" method="GET">
                        <div class="input-group input-group-lg shadow-sm border rounded-3 overflow-hidden">
                            <input type="search" 
                                   name="search" 
                                   class="form-control border-0 p-4 fs-5" 
                                   id="searchInputHeader" 
                                   placeholder="Cari warga berdasarkan Nama, NIK, atau Email..." 
                                   value="{{ request('search') }}"
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

@push('scripts')
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
@endpush