@extends('layouts.guest.app')

@section('title', 'Data User - Sistem Kependudukan')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Manajemen Data</h4>
            <h1 class="mb-5 display-4">Data User</h1>
        </div>

        <div class="row justify-content-center wow fadeIn" data-wow-delay="0.3s">
            <div class="col-12">
                <div class="bg-light border border-primary rounded p-5">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-check-circle me-2"></i>Sukses!</strong>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="{{ route('user.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah User Baru
                        </a>

                        <div class="text-muted">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            Total Data: <strong>{{ $dataUser->total() }}</strong>
                        </div>
                    </div>

                    <div class="card mb-4 border-primary">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label"><i class="fas fa-search me-2"></i>Cari User</label>
                                    <form action="{{ route('user.index') }}" method="GET" id="searchForm">
                                        @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                                        @if(request('role')) <input type="hidden" name="role" value="{{ request('role') }}"> @endif
                                        @if(request('per_page')) <input type="hidden" name="per_page" value="{{ request('per_page') }}"> @endif

                                        <div class="input-group">
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="search" 
                                                   id="searchUser" 
                                                   placeholder="Cari berdasarkan nama atau email..."
                                                   value="{{ request('search') }}">
                                            <button class="btn btn-primary" type="submit" id="btnSearch">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            @if(request('search'))
                                            <a href="{{ route('user.index') }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-times"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <form action="{{ route('user.index') }}" method="GET" id="filterForm">
                                @if(request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label"><i class="fas fa-filter me-2"></i>Filter Role</label>
                                        <select class="form-select" name="role" onchange="this.form.submit()">
                                            <option value="">Semua Role</option>
                                            <option value="Super Admin" {{ request('role') == 'Super Admin' ? 'selected' : '' }}>Super Admin</option>
                                            <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="User" {{ request('role') == 'User' ? 'selected' : '' }}>User</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label"><i class="fas fa-sort me-2"></i>Urutkan</label>
                                        <select class="form-select" name="sort" id="sortBy" onchange="this.form.submit()">
                                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                                            <option value="email" {{ request('sort') == 'email' ? 'selected' : '' }}>Email A-Z</option>
                                            <option value="email_desc" {{ request('sort') == 'email_desc' ? 'selected' : '' }}>Email Z-A</option>
                                            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                            <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label"><i class="fas fa-list me-2"></i>Tampilkan</label>
                                        <select class="form-select" name="per_page" id="perPage" onchange="this.form.submit()">
                                            <option value="12" {{ request('per_page', 12) == 12 ? 'selected' : '' }}>12 Data</option>
                                            <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24 Data</option>
                                            <option value="36" {{ request('per_page') == 36 ? 'selected' : '' }}>36 Data</option>
                                            <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>48 Data</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if(request('search') || request('sort') || request('role'))
                    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                        <strong><i class="fas fa-info-circle me-2"></i>Filter Aktif:</strong>
                        
                        @if(request('search'))
                            <span class="badge bg-primary me-2">Pencarian: "{{ request('search') }}"</span>
                        @endif
                        
                        @if(request('role'))
                            <span class="badge bg-success me-2">Role: {{ request('role') }}</span>
                        @endif

                        @if(request('sort'))
                            <span class="badge bg-warning text-dark me-2">Urutan: 
                                @if(request('sort') == 'name') Nama A-Z
                                @elseif(request('sort') == 'name_desc') Nama Z-A
                                @elseif(request('sort') == 'email') Email A-Z
                                @elseif(request('sort') == 'email_desc') Email Z-A
                                @elseif(request('sort') == 'terbaru') Terbaru
                                @elseif(request('sort') == 'terlama') Terlama
                                @endif
                            </span>
                        @endif
                        
                        <a href="{{ route('user.index') }}" class="btn btn-sm btn-outline-info ms-2">Reset Filter</a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="row g-4">
                        @forelse ($dataUser as $index => $item)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-primary">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <i class="fas fa-user me-2"></i>{{ $item->name }}
                                    </h6>
                                    <span class="badge bg-light text-dark">#{{ $dataUser->firstItem() + $index }}</span>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-id-badge me-2 text-primary"></i>
                                            <span class="fw-bold">Role:</span>
                                        </div>
                                        <p class="ms-4 mb-0">
                                            @if($item->role == 'Super Admin')
                                                <span class="badge bg-danger rounded-pill px-3">
                                                    <i class="fas fa-crown me-1"></i> Super Admin
                                                </span>
                                            @elseif($item->role == 'Admin')
                                                <span class="badge bg-warning text-dark rounded-pill px-3">
                                                    <i class="fas fa-user-shield me-1"></i> Admin
                                                </span>
                                            @else
                                                <span class="badge bg-info text-dark rounded-pill px-3">
                                                    <i class="fas fa-user me-1"></i> User
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                    <hr>

                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-envelope me-2 text-primary"></i>
                                            <span class="fw-bold">Email:</span>
                                        </div>
                                        <p class="ms-4 mb-0 text-break">{{ $item->email }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-calendar me-2 text-primary"></i>
                                            <span class="fw-bold">Tanggal Dibuat:</span>
                                        </div>
                                        <p class="ms-4 mb-0">{{ $item->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top-0">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('user.edit', $item->id) }}"
                                           class="btn btn-warning btn-sm"
                                           data-bs-toggle="tooltip"
                                           title="Edit Data">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                        <form action="{{ route('user.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-danger btn-sm"
                                                    data-bs-toggle="tooltip"
                                                    title="Hapus Data"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                <i class="fas fa-trash me-1"></i>Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <h5>Data user tidak ditemukan</h5>
                                    <p>Coba ubah filter pencarian atau role.</p>
                                    <a href="{{ route('user.index') }}" class="btn btn-primary mt-2">
                                        <i class="fas fa-refresh me-2"></i>Reset Filter
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    @if($dataUser->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Menampilkan {{ $dataUser->firstItem() }} sampai {{ $dataUser->lastItem() }} dari {{ $dataUser->total() }} data
                        </div>
                        <nav>
                            {{ $dataUser->withQueryString()->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
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
    .text-break {
        word-break: break-all;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Auto-dismiss alerts
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });
</script>
@endpush