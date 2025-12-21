@extends('layouts.guest.app')

@section('title', 'Data Kematian - Sistem Kependudukan')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        
        {{-- HEADER JUDUL --}}
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Manajemen Data</h4>
            <h1 class="mb-5 display-4">Peristiwa Kematian</h1>
        </div>

        <div class="row justify-content-center wow fadeIn" data-wow-delay="0.3s">
            <div class="col-12">
                
                {{-- WRAPPER UTAMA --}}
                <div class="bg-light border border-primary rounded p-5">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-check-circle me-2"></i>Sukses!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="{{ route('kematian.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Catat Kematian Baru
                        </a>
                        <div class="text-muted">
                            <i class="fas fa-info-circle me-2 text-primary"></i> Total Data: <strong>{{ $data->total() }}</strong>
                        </div>
                    </div>

                    {{-- ========================================================== --}}
                    {{-- SEARCH & FILTER OPTIONS (GAYA "KELUARGA")                  --}}
                    {{-- ========================================================== --}}
                    <div class="card mb-4 border-primary">
                        <div class="card-body">
                            
                            {{-- 1. Search Bar --}}
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label"><i class="fas fa-search me-2"></i>Cari Data Kematian</label>
                                    <form action="{{ route('kematian.index') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="search" 
                                                   placeholder="Cari nama almarhum, NIK, atau sebab kematian..." 
                                                   value="{{ request('search') }}">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            @if(request('search'))
                                                <a href="{{ route('kematian.index') }}" class="btn btn-outline-secondary">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- 2. Filter Bar --}}
                            <form action="{{ route('kematian.index') }}" method="GET" id="filterForm">
                                {{-- Simpan Query Pencarian agar tidak hilang saat filter --}}
                                @if(request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif

                                <div class="row g-3">
                                    {{-- Sorting --}}
                                    <div class="col-md-6">
                                        <label class="form-label"><i class="fas fa-sort me-2"></i>Urutkan</label>
                                        <select class="form-select" name="sort" onchange="this.form.submit()">
                                            <option value="tgl_terbaru" {{ request('sort') == 'tgl_terbaru' ? 'selected' : '' }}>Tgl Kematian (Baru)</option>
                                            <option value="tgl_terlama" {{ request('sort') == 'tgl_terlama' ? 'selected' : '' }}>Tgl Kematian (Lama)</option>
                                            <option value="nama_az" {{ request('sort') == 'nama_az' ? 'selected' : '' }}>Nama (A-Z)</option>
                                            <option value="nama_za" {{ request('sort') == 'nama_za' ? 'selected' : '' }}>Nama (Z-A)</option>
                                        </select>
                                    </div>

                                    {{-- Per Page --}}
                                    <div class="col-md-6">
                                        <label class="form-label"><i class="fas fa-list me-2"></i>Data Per Halaman</label>
                                        <select class="form-select" name="per_page" onchange="this.form.submit()">
                                            <option value="12" {{ request('per_page', 12) == 12 ? 'selected' : '' }}>12 Data</option>
                                            <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24 Data</option>
                                            <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>48 Data</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Info Filter Aktif --}}
                    @if(request('search') || request('sort'))
                    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                        <strong><i class="fas fa-info-circle me-2"></i>Filter Aktif:</strong>
                        @if(request('search')) <span class="badge bg-primary me-2">Cari: "{{ request('search') }}"</span> @endif
                        <a href="{{ route('kematian.index') }}" class="btn btn-sm btn-outline-info ms-2">Reset Filter</a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    {{-- ========================================================== --}}
                    {{-- CARD DATA GRID (BIRU)                                      --}}
                    {{-- ========================================================== --}}
                    <div class="row g-4">
                        @forelse($data as $item)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-primary card-hover">
                                
                                {{-- HEADER: Nama & NIK --}}
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-start p-3">
                                    <div style="max-width: 65%;">
                                        <h6 class="mb-0 text-truncate fw-bold text-white" title="{{ $item->warga->nama ?? 'Warga Terhapus' }}">
                                            <i class="fas fa-user me-2"></i>{{ $item->warga->nama ?? 'Warga Terhapus' }}
                                        </h6>
                                        <small class="d-block text-white-50 mt-1">
                                            NIK: {{ $item->nik ?? $item->warga->no_ktp ?? '-' }}
                                        </small>
                                    </div>
                                    <span class="badge bg-light text-primary shadow-sm">
                                        <i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($item->tgl_meninggal)->format('d/m/Y') }}
                                    </span>
                                </div>

                                <div class="card-body p-3">
                                    {{-- Info Detail --}}
                                    <div class="mb-3">
                                        <small class="text-muted d-block fw-bold mb-1">Penyebab:</small>
                                        <p class="mb-0 text-danger fw-bold">
                                            <i class="fas fa-heartbeat me-2"></i>{{ $item->sebab_kematian }}
                                        </p>
                                    </div>

                                    <div class="mb-0">
                                        <small class="text-muted d-block fw-bold mb-1">Tempat Meninggal:</small>
                                        <p class="mb-0 text-dark text-truncate">
                                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>{{ $item->tempat_kematian ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                {{-- FOOTER: Tombol Aksi --}}
                                <div class="card-footer bg-transparent border-top-0 p-3">
                                    <div class="d-grid gap-2">
                                        {{-- Tombol Detail Full Width --}}
                                        <a href="{{ route('kematian.show', $item->kematian_id) }}" class="btn btn-info text-white fw-bold w-100">
                                            <i class="fas fa-file-upload me-2"></i> Detail & Upload
                                        </a>

                                        <div class="d-flex gap-2">
                                            <a href="{{ route('kematian.edit', $item->kematian_id) }}" class="btn btn-warning text-white flex-grow-1">
                                                <i class="fas fa-edit me-2"></i> Edit
                                            </a>
                                            
                                            <form action="{{ route('kematian.destroy', $item->kematian_id) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-outline-danger w-100">
                                                    <i class="fas fa-trash me-2"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <div class="bg-white rounded-circle d-inline-flex p-4 shadow-sm mb-3 border border-primary">
                                    <i class="fas fa-book-dead fa-4x text-secondary opacity-50"></i>
                                </div>
                                <h5 class="text-muted">Data tidak ditemukan</h5>
                                <p class="text-muted small">Silakan tambah data baru atau ubah filter pencarian.</p>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    {{-- ========================================================== --}}
                    {{-- PAGINATION LENGKAP (GAYA "KELUARGA")                       --}}
                    {{-- ========================================================== --}}
                    @if($data->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        
                        {{-- Teks Informasi --}}
                        <div class="text-muted small">
                            Menampilkan <strong>{{ $data->firstItem() }}</strong> sampai <strong>{{ $data->lastItem() }}</strong> dari <strong>{{ $data->total() }}</strong> data
                        </div>

                        {{-- Tombol Navigasi --}}
                        <nav aria-label="Page navigation">
                            {{ $data->withQueryString()->links('pagination::bootstrap-5') }}
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
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endpush