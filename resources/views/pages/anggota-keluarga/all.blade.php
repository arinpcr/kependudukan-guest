@extends('layouts.guest.app')

@section('title', 'Data Semua Anggota Keluarga - Sistem Kependudukan')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Data Lengkap</h4>
            <h1 class="mb-5 display-4">Semua Anggota Keluarga</h1>
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

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-exclamation-triangle me-2"></i>Error!</strong>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <a href="{{ route('keluarga.index') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke KK
                            </a>
                            <a href="{{ route('warga.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-users me-2"></i>Data Warga
                            </a>
                        </div>
                        
                        <div class="text-muted">
                            <i class="fas fa-users me-2 text-primary"></i>
                            Total Data: <strong>{{ $anggota->total() }}</strong>
                        </div>
                    </div>

                    <!-- Search dan Filter Options -->
                    <div class="card mb-4 border-primary">
                        <div class="card-body">
                            <!-- Search Bar -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label"><i class="fas fa-search me-2"></i>Cari Anggota</label>
                                    <form action="{{ route('anggota-keluarga.all') }}" method="GET" id="searchForm">
                                        <div class="input-group">
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="search" 
                                                   id="searchAnggota" 
                                                   placeholder="Cari berdasarkan nama, NIK, atau nomor KK..."
                                                   value="{{ request('search') }}">
                                            <button class="btn btn-primary" type="submit" id="btnSearch">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            @if(request('search'))
                                            <a href="{{ route('anggota-keluarga.all') }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-times"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <form action="{{ route('anggota-keluarga.all') }}" method="GET" id="filterForm">
                                @if(request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label"><i class="fas fa-filter me-2"></i>Filter KK</label>
                                        <select class="form-select" name="kk_id" id="filterKK" onchange="this.form.submit()">
                                            <option value="">Semua Kartu Keluarga</option>
                                            @foreach($keluargas as $keluarga)
                                                <option value="{{ $keluarga->kk_id }}" {{ request('kk_id') == $keluarga->kk_id ? 'selected' : '' }}>
                                                    {{ $keluarga->kk_nomor }} - {{ $keluarga->kepalaKeluarga->nama ?? '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label"><i class="fas fa-link me-2"></i>Filter Hubungan</label>
                                        <select class="form-select" name="hubungan" id="filterHubungan" onchange="this.form.submit()">
                                            <option value="">Semua Hubungan</option>
                                            <option value="kepala_keluarga" {{ request('hubungan') == 'kepala_keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                                            <option value="istri" {{ request('hubungan') == 'istri' ? 'selected' : '' }}>Istri</option>
                                            <option value="anak" {{ request('hubungan') == 'anak' ? 'selected' : '' }}>Anak</option>
                                            <option value="menantu" {{ request('hubungan') == 'menantu' ? 'selected' : '' }}>Menantu</option>
                                            <option value="cucu" {{ request('hubungan') == 'cucu' ? 'selected' : '' }}>Cucu</option>
                                            <option value="orang_tua" {{ request('hubungan') == 'orang_tua' ? 'selected' : '' }}>Orang Tua</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label"><i class="fas fa-sort me-2"></i>Urutkan</label>
                                        <select class="form-select" name="sort" id="sortBy" onchange="this.form.submit()">
                                            <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama A-Z</option>
                                            <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama Z-A</option>
                                            <option value="kk" {{ request('sort') == 'kk' ? 'selected' : '' }}>Nomor KK</option>
                                            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                            <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
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
                    @if(request('search') || request('kk_id') || request('hubungan') || request('sort'))
                    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                        <strong><i class="fas fa-info-circle me-2"></i>Filter Aktif:</strong>
                        @if(request('search'))
                            <span class="badge bg-primary me-2">Pencarian: "{{ request('search') }}"</span>
                        @endif
                        @if(request('kk_id'))
                            @php
                                $selectedKK = $keluargas->where('kk_id', request('kk_id'))->first();
                            @endphp
                            <span class="badge bg-success me-2">KK: {{ $selectedKK->kk_nomor ?? request('kk_id') }}</span>
                        @endif
                        @if(request('hubungan'))
                            <span class="badge bg-warning me-2">Hubungan: {{ $hubunganOptions[request('hubungan')] ?? request('hubungan') }}</span>
                        @endif
                        @if(request('sort'))
                            <span class="badge bg-info me-2">Urutan: 
                                @if(request('sort') == 'nama') Nama A-Z
                                @elseif(request('sort') == 'nama_desc') Nama Z-A
                                @elseif(request('sort') == 'kk') Nomor KK
                                @elseif(request('sort') == 'terbaru') Terbaru
                                @elseif(request('sort') == 'terlama') Terlama
                                @endif
                            </span>
                        @endif
                        <a href="{{ route('anggota-keluarga.all') }}" class="btn btn-sm btn-outline-info ms-2">Hapus Filter</a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <!-- Card Layout untuk Semua Anggota -->
                    <div class="row g-4">
                        @forelse ($anggota as $item)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                            <div class="card h-100 shadow-sm border-primary anggota-card">
                                <div class="card-header bg-primary text-white py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">
                                            <i class="fas fa-user me-2"></i>{{ $item->warga->nama ?? 'Data warga tidak ditemukan' }}
                                        </h6>
                                        @if($item->hubungan == 'kepala_keluarga')
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-crown me-1"></i>Kepala
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <small class="text-muted d-block">
                                            <i class="fas fa-home me-2"></i>
                                            <strong>KK:</strong> {{ $item->keluarga->kk_nomor ?? 'N/A' }}
                                        </small>
                                        <small class="text-muted">
                                            <i class="fas fa-user-tie me-2"></i>
                                            {{ $item->keluarga->kepalaKeluarga->nama ?? 'Kepala KK Tidak Ditemukan' }}
                                        </small>
                                    </div>
                                    
                                    <div class="mb-2">
                                        <i class="fas fa-id-card me-2 text-muted"></i>
                                        <span>{{ $item->warga->no_ktp ?? '-' }}</span>
                                    </div>
                                    
                                    <div class="mb-2">
                                        <i class="fas fa-venus-mars me-2 text-muted"></i>
                                        @if(($item->warga->jenis_kelamin ?? '') == 'L')
                                            <span class="badge bg-info">Laki-laki</span>
                                        @elseif(($item->warga->jenis_kelamin ?? '') == 'P')
                                            <span class="badge bg-pink">Perempuan</span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </div>
                                    
                                    <div class="mb-3">
                                        <i class="fas fa-link me-2 text-muted"></i>
                                        <span class="badge bg-primary">{{ $item->hubungan_label }}</span>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="btn-group w-100">
                                        <a href="{{ route('anggota-keluarga.show', ['keluarga' => $item->kk_id, 'anggota' => $item->anggota_id]) }}" 
                                           class="btn btn-info btn-sm" 
                                           data-bs-toggle="tooltip" 
                                           title="Detail Anggota">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('anggota-keluarga.edit', ['keluarga' => $item->kk_id, 'anggota' => $item->anggota_id]) }}" 
                                           class="btn btn-warning btn-sm" 
                                           data-bs-toggle="tooltip" 
                                           title="Edit Hubungan">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('anggota-keluarga.index', $item->kk_id) }}" 
                                           class="btn btn-secondary btn-sm" 
                                           data-bs-toggle="tooltip" 
                                           title="Lihat Anggota KK">
                                            <i class="fas fa-users"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="card border-warning">
                                <div class="card-body text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-users fa-3x mb-3"></i>
                                        <h4>
                                            @if(request('search') || request('kk_id') || request('hubungan'))
                                                Data anggota keluarga tidak ditemukan
                                            @else
                                                Belum ada data anggota keluarga
                                            @endif
                                        </h4>
                                        <p class="mb-4">
                                            @if(request('search') || request('kk_id') || request('hubungan'))
                                                Coba ubah kata kunci pencarian atau filter yang digunakan
                                            @else
                                                Silakan tambah data keluarga terlebih dahulu.
                                            @endif
                                        </p>
                                        @if(request('search') || request('kk_id') || request('hubungan'))
                                        <a href="{{ route('anggota-keluarga.all') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-refresh me-2"></i>Tampilkan Semua Data
                                        </a>
                                        @else
                                        <a href="{{ route('keluarga.create') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-plus me-2"></i>Tambah Keluarga
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($anggota->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Menampilkan {{ $anggota->firstItem() }} sampai {{ $anggota->lastItem() }} dari {{ $anggota->total() }} data
                        </div>
                        <nav>
                            {{ $anggota->withQueryString()->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                    @endif

                    <!-- Summary -->
                    <div class="card mt-4 border-success">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Ringkasan Data</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-3">
                                    <div class="text-primary fw-bold fs-4">{{ $anggota->total() }}</div>
                                    <small class="text-muted">Total Anggota</small>
                                </div>
                                <div class="col-md-3">
                                    @php
                                        $kepalaKeluarga = $anggota->getCollection()->where('hubungan', 'kepala_keluarga')->count();
                                    @endphp
                                    <div class="text-warning fw-bold fs-4">{{ $kepalaKeluarga }}</div>
                                    <small class="text-muted">Kepala Keluarga</small>
                                </div>
                                <div class="col-md-3">
                                    @php
                                        $laki = $anggota->getCollection()->filter(function($item) {
                                            return ($item->warga->jenis_kelamin ?? '') == 'L';
                                        })->count();
                                    @endphp
                                    <div class="text-info fw-bold fs-4">{{ $laki }}</div>
                                    <small class="text-muted">Laki-laki</small>
                                </div>
                                <div class="col-md-3">
                                    @php
                                        $perempuan = $anggota->getCollection()->filter(function($item) {
                                            return ($item->warga->jenis_kelamin ?? '') == 'P';
                                        })->count();
                                    @endphp
                                    <div class="text-pink fw-bold fs-4">{{ $perempuan }}</div>
                                    <small class="text-muted">Perempuan</small>
                                </div>
                            </div>
                        </div>
                    </div>
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
    .bg-pink {
        background-color: #e83e8c !important;
        color: white !important;
    }
    .anggota-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .anggota-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .card-header {
        border-bottom: 2px solid rgba(255,255,255,0.2);
    }
    .btn-group .btn {
        border-radius: 0;
        flex: 1;
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

        // Search form submission on enter
        const searchInput = document.getElementById('searchAnggota');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    document.getElementById('searchForm').submit();
                }
            });
        }
    });
</script>
@endpush