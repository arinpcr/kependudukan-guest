@extends('layouts.guest.app')

@section('title', 'Data Warga - Sistem Kependudukan')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Manajemen Data</h4>
            <h1 class="mb-5 display-4">Data Warga</h1>
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
                        <a href="{{ route('warga.create') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i>Tambah Warga Baru
                        </a>
                        
                        <div class="text-muted">
                            <i class="fas fa-users me-2 text-primary"></i>
                            Total Data: <strong>{{ $warga->total() }}</strong>
                        </div>
                    </div>

                    <!-- Search dan Filter Options -->
                    <div class="card mb-4 border-primary">
                        <div class="card-body">
                            <!-- Search Bar -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label"><i class="fas fa-search me-2"></i>Cari Warga</label>
                                    <form action="{{ route('warga.index') }}" method="GET" id="searchForm">
                                        <div class="input-group">
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="search" 
                                                   id="searchWarga" 
                                                   placeholder="Cari berdasarkan nama, NIK, agama, atau pekerjaan..."
                                                   value="{{ request('search') }}">
                                            <button class="btn btn-primary" type="submit" id="btnSearch">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            @if(request('search'))
                                            <a href="{{ route('warga.index') }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-times"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <form action="{{ route('warga.index') }}" method="GET" id="filterForm">
                                @if(request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label"><i class="fas fa-filter me-2"></i>Filter Jenis Kelamin</label>
                                        <select class="form-select" name="jenis_kelamin" id="filterJenisKelamin" onchange="this.form.submit()">
                                            <option value="">Semua Jenis Kelamin</option>
                                            <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label"><i class="fas fa-sort me-2"></i>Urutkan Berdasarkan</label>
                                        <select class="form-select" name="sort" id="sortBy" onchange="this.form.submit()">
                                            <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama A-Z</option>
                                            <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama Z-A</option>
                                            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                            <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label"><i class="fas fa-list me-2"></i>Data Per Halaman</label>
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

                    <!-- Info Pencarian -->
                    @if(request('search') || request('jenis_kelamin') || request('sort'))
                    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                        <strong><i class="fas fa-info-circle me-2"></i>Filter Aktif:</strong>
                        @if(request('search'))
                            <span class="badge bg-primary me-2">Pencarian: "{{ request('search') }}"</span>
                        @endif
                        @if(request('jenis_kelamin'))
                            <span class="badge bg-success me-2">Jenis Kelamin: {{ request('jenis_kelamin') == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                        @endif
                        @if(request('sort'))
                            <span class="badge bg-warning me-2">Urutan: 
                                @if(request('sort') == 'nama') Nama A-Z
                                @elseif(request('sort') == 'nama_desc') Nama Z-A
                                @elseif(request('sort') == 'terbaru') Terbaru
                                @elseif(request('sort') == 'terlama') Terlama
                                @endif
                            </span>
                        @endif
                        <a href="{{ route('warga.index') }}" class="btn btn-sm btn-outline-info ms-2">Hapus Filter</a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <!-- Card Layout - More Cards per Row -->
                    <div class="row g-4">
                        @forelse ($warga as $index => $item)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                            <div class="card h-100 shadow-sm border-primary">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <i class="fas fa-user me-2"></i>{{ $item->nama }}
                                    </h6>
                                    <span class="badge bg-light text-dark">#{{ $warga->firstItem() + $index }}</span>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-id-card me-2 text-primary"></i>
                                            <span class="fw-bold">No KTP:</span>
                                        </div>
                                        <p class="ms-4 mb-0">{{ $item->no_ktp }}</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-venus-mars me-2 text-primary"></i>
                                            <span class="fw-bold">Jenis Kelamin:</span>
                                        </div>
                                        <p class="ms-4 mb-0">
                                            @if($item->jenis_kelamin == 'L')
                                                <span class="badge bg-primary">
                                                    <i class="fas fa-mars me-1"></i>Laki-laki
                                                </span>
                                            @else
                                                <span class="badge bg-pink">
                                                    <i class="fas fa-venus me-1"></i>Perempuan
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-pray me-2 text-primary"></i>
                                            <span class="fw-bold">Agama:</span>
                                        </div>
                                        <p class="ms-4 mb-0">{{ $item->agama }}</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-briefcase me-2 text-primary"></i>
                                            <span class="fw-bold">Pekerjaan:</span>
                                        </div>
                                        <p class="ms-4 mb-0">{{ $item->pekerjaan }}</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-phone me-2 text-primary"></i>
                                            <span class="fw-bold">Telepon:</span>
                                        </div>
                                        <p class="ms-4 mb-0">{{ $item->telp ?: '-' }}</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-envelope me-2 text-primary"></i>
                                            <span class="fw-bold">Email:</span>
                                        </div>
                                        <p class="ms-4 mb-0">
                                            @if($item->email)
                                                {{ $item->email }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top-0">
    <div class="d-flex justify-content-between">
        <a href="{{ route('warga.edit', $item) }}" 
           class="btn btn-warning btn-sm" 
           data-bs-toggle="tooltip" 
           title="Edit Data">
            <i class="fas fa-edit me-1"></i>Edit
        </a>
        <a href="{{ route('warga.show', $item) }}" 
           class="btn btn-info btn-sm" 
           data-bs-toggle="tooltip" 
           title="Lihat Detail">
            <i class="fas fa-eye me-1"></i>Detail
        </a>
        <form action="{{ route('warga.destroy', $item) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="btn btn-danger btn-sm" 
                    data-bs-toggle="tooltip" 
                    title="Hapus Data"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus data warga ini?')">
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
                                    <i class="fas fa-user-slash fa-3x mb-3"></i>
                                    <h5>
                                        @if(request('search') || request('jenis_kelamin'))
                                            Data warga tidak ditemukan
                                        @else
                                            Tidak ada data warga
                                        @endif
                                    </h5>
                                    <p>
                                        @if(request('search') || request('jenis_kelamin'))
                                            Coba ubah kata kunci pencarian atau filter yang digunakan
                                        @else
                                            Silakan tambah data warga baru dengan mengklik tombol di atas.
                                        @endif
                                    </p>
                                    @if(request('search') || request('jenis_kelamin'))
                                    <a href="{{ route('warga.index') }}" class="btn btn-primary mt-2">
                                        <i class="fas fa-refresh me-2"></i>Tampilkan Semua Data
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    @if($warga->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Menampilkan {{ $warga->firstItem() }} sampai {{ $warga->lastItem() }} dari {{ $warga->total() }} data
                        </div>
                        <nav>
                            {{ $warga->withQueryString()->links('pagination::bootstrap-5') }}
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
    .bg-pink {
        background-color: #e83e8c !important;
    }
    .btn-group .btn {
        margin: 0 2px;
    }
    .badge {
        font-size: 0.8em;
        padding: 0.35em 0.65em;
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

        // Search form submission on enter
        const searchInput = document.getElementById('searchWarga');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    document.getElementById('searchForm').submit();
                }
            });
        }

        console.log('Warga index page loaded with enhanced features');
    });
</script>
@endpush