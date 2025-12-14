@extends('layouts.guest.app')
@section('title', 'Data Kelahiran')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        
        {{-- HEADER JUDUL --}}
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Manajemen Data</h4>
            <h1 class="mb-5 display-4">Data Kelahiran</h1>
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
                        <a href="{{ route('kelahiran.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Catat Kelahiran Baru
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
                                    <label class="form-label"><i class="fas fa-search me-2"></i>Cari Data Kelahiran</label>
                                    <form action="{{ route('kelahiran.index') }}" method="GET" id="searchForm">
                                        <div class="input-group">
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="search" 
                                                   placeholder="Cari nama bayi, orang tua, atau nomor akta..." 
                                                   value="{{ request('search') }}">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            @if(request('search'))
                                                <a href="{{ route('kelahiran.index') }}" class="btn btn-outline-secondary">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- 2. Filter Bar --}}
                            <form action="{{ route('kelahiran.index') }}" method="GET" id="filterForm">
                                {{-- Simpan Query Pencarian agar tidak hilang saat filter --}}
                                @if(request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif

                                <div class="row g-3">
                                    {{-- Filter Bulan --}}
                                    <div class="col-md-3">
                                        <label class="form-label"><i class="fas fa-calendar-alt me-2"></i>Bulan Lahir</label>
                                        <select class="form-select" name="bulan" onchange="this.form.submit()">
                                            <option value="">Semua Bulan</option>
                                            @foreach(range(1,12) as $m)
                                                <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Filter Tahun --}}
                                    <div class="col-md-3">
                                        <label class="form-label"><i class="fas fa-calendar me-2"></i>Tahun Lahir</label>
                                        <select class="form-select" name="tahun" onchange="this.form.submit()">
                                            <option value="">Semua Tahun</option>
                                            @for($y = date('Y'); $y >= 2000; $y--)
                                                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    {{-- Sorting --}}
                                    <div class="col-md-3">
                                        <label class="form-label"><i class="fas fa-sort me-2"></i>Urutkan</label>
                                        <select class="form-select" name="sort" onchange="this.form.submit()">
                                            <option value="tgl_terbaru" {{ request('sort') == 'tgl_terbaru' ? 'selected' : '' }}>Tgl Lahir (Baru)</option>
                                            <option value="tgl_terlama" {{ request('sort') == 'tgl_terlama' ? 'selected' : '' }}>Tgl Lahir (Lama)</option>
                                            <option value="input_terbaru" {{ request('sort') == 'input_terbaru' ? 'selected' : '' }}>Input Terakhir</option>
                                        </select>
                                    </div>

                                    {{-- Per Page --}}
                                    <div class="col-md-3">
                                        <label class="form-label"><i class="fas fa-list me-2"></i>Data Per Halaman</label>
                                        <select class="form-select" name="per_page" onchange="this.form.submit()">
                                            <option value="6" {{ request('per_page') == 6 ? 'selected' : '' }}>6 Data</option>
                                            <option value="12" {{ request('per_page', 12) == 12 ? 'selected' : '' }}>12 Data</option>
                                            <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24 Data</option>
                                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 Data</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Info Filter Aktif --}}
                    @if(request('search') || request('bulan') || request('tahun') || request('sort'))
                    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                        <strong><i class="fas fa-info-circle me-2"></i>Filter Aktif:</strong>
                        @if(request('search')) <span class="badge bg-primary me-2">Cari: "{{ request('search') }}"</span> @endif
                        @if(request('bulan')) <span class="badge bg-success me-2">Bulan: {{ date('F', mktime(0, 0, 0, request('bulan'), 1)) }}</span> @endif
                        @if(request('tahun')) <span class="badge bg-success me-2">Tahun: {{ request('tahun') }}</span> @endif
                        <a href="{{ route('kelahiran.index') }}" class="btn btn-sm btn-outline-info ms-2">Hapus Filter</a>
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
                                
                                {{-- Header Biru --}}
                                <div class="card-header bg-primary text-white p-3 border-0 d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-box bg-white text-primary fw-bold rounded-circle d-flex align-items-center justify-content-center shadow-sm">
                                            {{ substr($item->bayi->nama ?? 'X', 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h6 class="mb-1 text-white fw-bold text-truncate" title="{{ $item->bayi->nama ?? 'Data Terhapus' }}">
                                            {{ $item->bayi->nama ?? 'Data Terhapus' }}
                                        </h6>
                                        <small class="text-white-50 d-block">
                                            NIK: {{ $item->bayi->no_ktp ?? '-' }}
                                        </small>
                                    </div>
                                </div>

                                <div class="card-body p-3">
                                    {{-- Info Utama --}}
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="me-2 text-center" style="width: 25px;">
                                                <i class="fas fa-calendar-alt text-primary"></i>
                                            </div>
                                            <span class="fw-bold text-dark">
                                                {{ \Carbon\Carbon::parse($item->tgl_lahir)->format('d F Y') }}
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2 text-center" style="width: 25px;">
                                                <i class="fas fa-map-marker-alt text-primary"></i>
                                            </div>
                                            <span class="text-muted text-truncate">
                                                {{ $item->tempat_lahir }}
                                            </span>
                                        </div>
                                    </div>

                                    <hr class="my-2 text-primary opacity-25">

                                    {{-- Info Detail --}}
                                    <div class="small mt-3">
                                        <div class="row py-1">
                                            <div class="col-4 text-muted fw-bold">Ayah</div>
                                            <div class="col-8 text-end text-dark text-truncate">{{ $item->ayah->nama ?? '-' }}</div>
                                        </div>
                                        <div class="row py-1">
                                            <div class="col-4 text-muted fw-bold">Ibu</div>
                                            <div class="col-8 text-end text-dark text-truncate">{{ $item->ibu->nama ?? '-' }}</div>
                                        </div>
                                        <div class="row py-2 align-items-center mt-2 border-top border-light">
                                            <div class="col-4 text-muted fw-bold">Status</div>
                                            <div class="col-8 text-end">
                                                @if($item->no_akta)
                                                    <span class="badge bg-success shadow-sm"><i class="fas fa-check me-1"></i>Akta OK</span>
                                                @else
                                                    <span class="badge bg-warning text-dark shadow-sm"><i class="fas fa-clock me-1"></i>Proses</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Footer Tombol --}}
                                <div class="card-footer bg-transparent border-top-0 p-3">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('kelahiran.show', $item->kelahiran_id) }}" class="btn btn-info text-white fw-bold w-100">
                                            <i class="fas fa-file-upload me-2"></i> Detail & Bukti
                                        </a>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('kelahiran.edit', $item->kelahiran_id) }}" class="btn btn-warning text-white flex-grow-1">
                                                <i class="fas fa-edit me-2"></i> Edit
                                            </a>
                                            <form action="{{ route('kelahiran.destroy', $item->kelahiran_id) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('Hapus data ini?')">
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
                                    <i class="fas fa-baby fa-3x text-primary opacity-50"></i>
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
                        
                        {{-- Teks Informasi (Menampilkan 1 sampai 12 dari 105 data) --}}
                        <div class="text-muted small">
                            Menampilkan <strong>{{ $data->firstItem() }}</strong> sampai <strong>{{ $data->lastItem() }}</strong> dari <strong>{{ $data->total() }}</strong> data
                        </div>

                        {{-- Tombol Navigasi Pagination --}}
                        <nav aria-label="Page navigation">
                            {{ $data->links('pagination::bootstrap-5') }}
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
    .title-border-radius { border-radius: 10px; }
    .avatar-box {
        width: 45px; height: 45px; font-size: 1.2rem;
        border: 2px solid rgba(255,255,255,0.8);
    }
    .card-hover { 
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-hover:hover { 
        transform: translateY(-5px); 
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; 
    }
</style>
@endpush