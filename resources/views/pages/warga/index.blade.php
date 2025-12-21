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

                    <div class="card mb-4 border-primary">
                        <div class="card-body">
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
                                        <label class="form-label"><i class="fas fa-filter me-2"></i>Filter Gender</label>
                                        <select class="form-select" name="jenis_kelamin" id="filterJenisKelamin" onchange="this.form.submit()">
                                            <option value="">Semua Gender</option>
                                            <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label"><i class="fas fa-sort me-2"></i>Urutkan</label>
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

                    @if(request('search') || request('jenis_kelamin') || request('sort'))
                    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                        <strong><i class="fas fa-info-circle me-2"></i>Filter Aktif:</strong>
                        @if(request('search'))
                            <span class="badge bg-primary me-2">Pencarian: "{{ request('search') }}"</span>
                        @endif
                        @if(request('jenis_kelamin'))
                            <span class="badge bg-success me-2">Gender: {{ request('jenis_kelamin') == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                        @endif
                        <a href="{{ route('warga.index') }}" class="btn btn-sm btn-outline-info ms-2">Hapus Filter</a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="row g-4">
                        @forelse ($warga as $index => $item)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-primary">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 text-truncate" style="max-width: 80%;">
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
                                    
                                    <hr>

                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-venus-mars me-2 text-primary"></i>
                                            <span class="fw-bold">Jenis Kelamin:</span>
                                        </div>
                                        <p class="ms-4 mb-0">
                                            @if($item->jenis_kelamin == 'L')
                                                <span class="badge bg-primary rounded-pill px-3">
                                                    <i class="fas fa-mars me-1"></i> Laki-laki
                                                </span>
                                            @else
                                                <span class="badge bg-pink rounded-pill px-3">
                                                    <i class="fas fa-venus me-1"></i> Perempuan
                                                </span>
                                            @endif
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-briefcase me-2 text-primary"></i>
                                            <span class="fw-bold">Info:</span>
                                        </div>
                                        <div class="ms-4">
                                            <small class="d-block text-muted">Agama: {{ $item->agama }}</small>
                                            <small class="d-block text-muted">Pekerjaan: {{ $item->pekerjaan }}</small>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-envelope me-2 text-primary"></i>
                                            <span class="fw-bold">Email:</span>
                                        </div>
                                        <p class="ms-4 mb-0 text-break">
                                            {{ $item->email ?: '-' }}
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
                                    <h5>Data warga tidak ditemukan</h5>
                                    <p>Coba ubah filter pencarian.</p>
                                    <a href="{{ route('warga.index') }}" class="btn btn-primary mt-2">
                                        <i class="fas fa-refresh me-2"></i>Reset Filter
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    @if($warga->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted small">
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

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