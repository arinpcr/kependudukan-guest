@extends('layouts.guest.app')

@section('title', 'Data Kartu Keluarga - Sistem Kependudukan')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Manajemen Data</h4>
            <h1 class="mb-5 display-4">Data Kartu Keluarga</h1>
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
                        <a href="{{ route('keluarga.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Data KK Baru
                        </a>
                        
                        <div class="text-muted">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            Total Data: <strong>{{ $keluarga->total() }}</strong>
                        </div>
                    </div>
<!-- Tambahkan bagian ini setelah alert success dan sebelum card layout -->

<!-- Search dan Filter Options -->
<div class="card mb-4 border-primary">
    <div class="card-body">
        <!-- Search Bar -->
        <div class="row mb-3">
            <div class="col-12">
                <label class="form-label"><i class="fas fa-search me-2"></i>Cari Kartu Keluarga</label>
                <form action="{{ route('keluarga.index') }}" method="GET" id="searchForm">
                    <div class="input-group">
                        <input type="text" 
                               class="form-control" 
                               name="search" 
                               id="searchKeluarga" 
                               placeholder="Cari berdasarkan nomor KK, alamat, RT/RW, atau nama kepala keluarga..."
                               value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit" id="btnSearch">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search'))
                        <a href="{{ route('keluarga.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <form action="{{ route('keluarga.index') }}" method="GET" id="filterForm">
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-filter me-2"></i>Filter RT</label>
                    <select class="form-select" name="rt" id="filterRT" onchange="this.form.submit()">
                        <option value="">Semua RT</option>
                        @foreach($keluarga->pluck('rt')->unique()->sort() as $rt)
                            <option value="{{ $rt }}" {{ request('rt') == $rt ? 'selected' : '' }}>RT {{ $rt }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-filter me-2"></i>Filter RW</label>
                    <select class="form-select" name="rw" id="filterRW" onchange="this.form.submit()">
                        <option value="">Semua RW</option>
                        @foreach($keluarga->pluck('rw')->unique()->sort() as $rw)
                            <option value="{{ $rw }}" {{ request('rw') == $rw ? 'selected' : '' }}>RW {{ $rw }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-sort me-2"></i>Urutkan</label>
                    <select class="form-select" name="sort" id="sortBy" onchange="this.form.submit()">
                        <option value="kk_nomor" {{ request('sort') == 'kk_nomor' ? 'selected' : '' }}>Nomor KK A-Z</option>
                        <option value="kk_nomor_desc" {{ request('sort') == 'kk_nomor_desc' ? 'selected' : '' }}>Nomor KK Z-A</option>
                        <option value="alamat" {{ request('sort') == 'alamat' ? 'selected' : '' }}>Alamat A-Z</option>
                        <option value="alamat_desc" {{ request('sort') == 'alamat_desc' ? 'selected' : '' }}>Alamat Z-A</option>
                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-list me-2"></i>Data Per Halaman</label>
                    <select class="form-select" name="per_page" id="perPage" onchange="this.form.submit()">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 Data</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20 Data</option>
                        <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30 Data</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 Data</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Info Pencarian -->
@if(request('search') || request('rt') || request('rw') || request('sort'))
<div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
    <strong><i class="fas fa-info-circle me-2"></i>Filter Aktif:</strong>
    @if(request('search'))
        <span class="badge bg-primary me-2">Pencarian: "{{ request('search') }}"</span>
    @endif
    @if(request('rt'))
        <span class="badge bg-success me-2">RT: {{ request('rt') }}</span>
    @endif
    @if(request('rw'))
        <span class="badge bg-success me-2">RW: {{ request('rw') }}</span>
    @endif
    @if(request('sort'))
        <span class="badge bg-warning me-2">Urutan: 
            @if(request('sort') == 'kk_nomor') Nomor KK A-Z
            @elseif(request('sort') == 'kk_nomor_desc') Nomor KK Z-A
            @elseif(request('sort') == 'alamat') Alamat A-Z
            @elseif(request('sort') == 'alamat_desc') Alamat Z-A
            @elseif(request('sort') == 'terbaru') Terbaru
            @elseif(request('sort') == 'terlama') Terlama
            @endif
        </span>
    @endif
    <a href="{{ route('keluarga.index') }}" class="btn btn-sm btn-outline-info ms-2">Hapus Filter</a>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
                    <!-- Card Layout -->
                    <div class="row g-4">
                        @forelse ($keluarga as $index => $item)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-primary">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <i class="fas fa-home me-2"></i>Kartu Keluarga
                                    </h6>
                                    <span class="badge bg-light text-dark">#{{ $keluarga->firstItem() + $index }}</span>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-id-card me-2 text-primary"></i>
                                            <span class="fw-bold">Nomor KK:</span>
                                        </div>
                                        <p class="ms-4 mb-0">{{ $item->kk_nomor }}</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-user me-2 text-primary"></i>
                                            <span class="fw-bold">Kepala Keluarga:</span>
                                        </div>
                                        <p class="ms-4 mb-0">{{ $item->kepalaKeluarga ? $item->kepalaKeluarga->nama : 'Warga tidak ditemukan' }}</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                            <span class="fw-bold">Alamat:</span>
                                        </div>
                                        <p class="ms-4 mb-0">{{ $item->alamat }}</p>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-map-pin me-2 text-primary"></i>
                                                <span class="fw-bold">RT:</span>
                                            </div>
                                            <p class="ms-4 mb-0">
                                                <span class="badge bg-secondary">{{ $item->rt }}</span>
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-map-pin me-2 text-primary"></i>
                                                <span class="fw-bold">RW:</span>
                                            </div>
                                            <p class="ms-4 mb-0">
                                                <span class="badge bg-secondary">{{ $item->rw }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top-0">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('keluarga.edit', $item->kk_id) }}" 
                                           class="btn btn-warning btn-sm" 
                                           data-bs-toggle="tooltip" 
                                           title="Edit Data">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                        <form action="{{ route('keluarga.destroy', $item->kk_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-danger btn-sm" 
                                                    data-bs-toggle="tooltip" 
                                                    title="Hapus Data"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data KK ini?')">
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
                                    <h5>Tidak ada data Kartu Keluarga</h5>
                                    <p>Silakan tambah data KK baru dengan mengklik tombol di atas.</p>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    @if($keluarga->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Menampilkan {{ $keluarga->firstItem() }} sampai {{ $keluarga->lastItem() }} dari {{ $keluarga->total() }} data
                        </div>
                        <nav>
                            {{ $keluarga->links('pagination::bootstrap-5') }}
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

        console.log('Keluarga index page loaded with enhanced features');
    });
</script>
@endpush