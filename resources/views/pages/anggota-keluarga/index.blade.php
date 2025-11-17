@extends('layouts.guest.app')

@section('title', 'Anggota Keluarga - Sistem Kependudukan')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Manajemen Anggota</h4>
            <h1 class="mb-5 display-4">Anggota Keluarga - {{ $keluarga->kk_nomor }}</h1>
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

                    <!-- Header Info KK -->
                    <div class="card mb-4 border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-home me-2"></i>Informasi Kartu Keluarga
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Nomor KK:</strong> {{ $keluarga->kk_nomor }}</p>
                                    <p><strong>Kepala Keluarga:</strong> {{ $keluarga->kepalaKeluarga->nama }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Alamat:</strong> {{ $keluarga->alamat }}</p>
                                    <p><strong>RT/RW:</strong> {{ $keluarga->rt }}/{{ $keluarga->rw }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search dan Filter -->
                    <div class="card mb-4 border-primary">
                        <div class="card-body">
                            <!-- Search Bar -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label"><i class="fas fa-search me-2"></i>Cari Anggota</label>
                                    <form action="{{ route('anggota-keluarga.index', $keluarga->kk_id) }}" method="GET" id="searchForm">
                                        <div class="input-group">
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="search" 
                                                   id="searchAnggota" 
                                                   placeholder="Cari berdasarkan nama atau NIK..."
                                                   value="{{ request('search') }}">
                                            <button class="btn btn-primary" type="submit" id="btnSearch">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            @if(request('search'))
                                            <a href="{{ route('anggota-keluarga.index', $keluarga->kk_id) }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-times"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <form action="{{ route('anggota-keluarga.index', $keluarga->kk_id) }}" method="GET" id="filterForm">
                                @if(request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                <div class="row g-3">
                                    <div class="col-md-6">
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
                                    <div class="col-md-6">
                                        <label class="form-label"><i class="fas fa-list me-2"></i>Data Per Halaman</label>
                                        <select class="form-select" name="per_page" id="perPage" onchange="this.form.submit()">
                                            <option value="12" {{ request('per_page', 12) == 12 ? 'selected' : '' }}>12 Data</option>
                                            <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24 Data</option>
                                            <option value="36" {{ request('per_page') == 36 ? 'selected' : '' }}>36 Data</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Info Pencarian -->
                    @if(request('search') || request('hubungan'))
                    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                        <strong><i class="fas fa-info-circle me-2"></i>Filter Aktif:</strong>
                        @if(request('search'))
                            <span class="badge bg-primary me-2">Pencarian: "{{ request('search') }}"</span>
                        @endif
                        @if(request('hubungan'))
                            <span class="badge bg-warning me-2">Hubungan: 
                                @if(request('hubungan') == 'kepala_keluarga') Kepala Keluarga
                                @elseif(request('hubungan') == 'istri') Istri
                                @elseif(request('hubungan') == 'anak') Anak
                                @elseif(request('hubungan') == 'menantu') Menantu
                                @elseif(request('hubungan') == 'cucu') Cucu
                                @elseif(request('hubungan') == 'orang_tua') Orang Tua
                                @endif
                            </span>
                        @endif
                        <a href="{{ route('anggota-keluarga.index', $keluarga->kk_id) }}" class="btn btn-sm btn-outline-info ms-2">Hapus Filter</a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <a href="{{ route('anggota-keluarga.create', $keluarga->kk_id) }}" class="btn btn-primary me-2">
                                <i class="fas fa-user-plus me-2"></i>Tambah Anggota
                            </a>
                            <a href="{{ route('keluarga.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke KK
                            </a>
                        </div>
                        
                        <div class="text-muted">
                            <i class="fas fa-users me-2 text-primary"></i>
                            Total Anggota: <strong>{{ $anggota->total() }}</strong>
                        </div>
                    </div>

                    <!-- Card Layout untuk Anggota -->
                    <div class="row g-4">
                        @forelse ($anggota as $anggotaItem)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                            <div class="card h-100 shadow-sm border-primary anggota-card">
                                <div class="card-header bg-primary text-white py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">
                                            <i class="fas fa-user me-2"></i>{{ $anggotaItem->warga->nama }}
                                        </h6>
                                        @if($anggotaItem->hubungan == 'kepala_keluarga')
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-crown me-1"></i>Kepala
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <i class="fas fa-id-card me-2 text-muted"></i>
                                        <span>{{ $anggotaItem->warga->no_ktp }}</span>
                                    </div>
                                    
                                    <div class="mb-2">
                                        <i class="fas fa-venus-mars me-2 text-muted"></i>
                                        @if($anggotaItem->warga->jenis_kelamin == 'L')
                                            <span class="badge bg-info">Laki-laki</span>
                                        @else
                                            <span class="badge bg-pink">Perempuan</span>
                                        @endif
                                    </div>
                                    
                                    <div class="mb-2">
                                        <i class="fas fa-link me-2 text-muted"></i>
                                        <span class="badge bg-primary">{{ $anggotaItem->hubungan_label }}</span>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="btn-group w-100">
                                        <a href="{{ route('anggota-keluarga.show', ['keluarga' => $keluarga->kk_id, 'anggota' => $anggotaItem->anggota_id]) }}" 
                                           class="btn btn-info btn-sm" 
                                           data-bs-toggle="tooltip" 
                                           title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('anggota-keluarga.edit', ['keluarga' => $keluarga->kk_id, 'anggota' => $anggotaItem->anggota_id]) }}" 
                                           class="btn btn-warning btn-sm" 
                                           data-bs-toggle="tooltip" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('anggota-keluarga.destroy', ['keluarga' => $keluarga->kk_id, 'anggota' => $anggotaItem->anggota_id]) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-danger btn-sm" 
                                                    data-bs-toggle="tooltip" 
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
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
                                            @if(request('search') || request('hubungan'))
                                                Data anggota tidak ditemukan
                                            @else
                                                Belum ada anggota keluarga
                                            @endif
                                        </h4>
                                        <p class="mb-4">
                                            @if(request('search') || request('hubungan'))
                                                Coba ubah kata kunci pencarian atau filter yang digunakan
                                            @else
                                                Silakan tambah anggota keluarga dengan mengklik tombol di atas.
                                            @endif
                                        </p>
                                        @if(request('search') || request('hubungan'))
                                        <a href="{{ route('anggota-keluarga.index', $keluarga->kk_id) }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-refresh me-2"></i>Tampilkan Semua Data
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
    .btn-group form {
        flex: 1;
        display: flex;
    }
    .btn-group form button {
        width: 100%;
        border-radius: 0;
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