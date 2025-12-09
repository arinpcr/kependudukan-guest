@extends('layouts.guest.app')

@section('title', 'Data Kematian - Sistem Kependudukan')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        {{-- HEADER JUDUL (Sama dengan halaman User/Profile) --}}
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Manajemen Data</h4>
            <h1 class="mb-5 display-4">Peristiwa Kematian</h1>
        </div>

        <div class="row justify-content-center wow fadeIn" data-wow-delay="0.3s">
            <div class="col-12">
                {{-- WRAPPER UTAMA (Style standar: bg-light, border-primary) --}}
                <div class="bg-light border border-primary rounded p-5">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-check-circle me-2"></i>Sukses!</strong>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="{{ route('kematian.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Catat Kematian Baru
                        </a>

                        <div class="text-muted">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            Total Data: <strong>{{ $data->total() }}</strong>
                        </div>
                    </div>

                    {{-- SEARCH & FILTER CARD --}}
                    <div class="card mb-4 border-primary">
                        <div class="card-body">
                            <form action="{{ route('kematian.index') }}" method="GET" id="searchForm">
                                <div class="row g-3">
                                    <div class="col-md-8">
                                         <label class="form-label"><i class="fas fa-search me-2"></i>Cari Almarhum</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search" id="searchKematian"
                                                   placeholder="Cari nama, NIK, atau sebab kematian..."
                                                   value="{{ request('search') }}">
                                            <button class="btn btn-primary" type="submit" id="btnSearch">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label"><i class="fas fa-sort me-2"></i>Urutkan</label>
                                        <select class="form-select" name="sort" onchange="this.form.submit()">
                                            <option value="tgl_terbaru" {{ request('sort') == 'tgl_terbaru' ? 'selected' : '' }}>Tgl Terbaru</option>
                                            <option value="tgl_terlama" {{ request('sort') == 'tgl_terlama' ? 'selected' : '' }}>Tgl Terlama</option>
                                            <option value="nama_az" {{ request('sort') == 'nama_az' ? 'selected' : '' }}>Nama (A-Z)</option>
                                            <option value="nama_za" {{ request('sort') == 'nama_za' ? 'selected' : '' }}>Nama (Z-A)</option>
                                        </select>
                                    </div>
                                     <div class="col-md-2">
                                        <label class="form-label"><i class="fas fa-list me-2"></i>Tampilkan</label>
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

                    {{-- ALERT FILTER --}}
                    @if(request('search') || request('sort'))
                    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                        <strong><i class="fas fa-info-circle me-2"></i>Filter Aktif:</strong>
                        @if(request('search'))
                            <span class="badge bg-primary me-2">Pencarian: "{{ request('search') }}"</span>
                        @endif
                        <a href="{{ route('kematian.index') }}" class="btn btn-sm btn-outline-info ms-2">Reset Filter</a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    {{-- CARD LOOP --}}
                    <div class="row g-4">
                        @forelse($data as $index => $item)
                        <div class="col-12 col-md-6 col-lg-4">
                            {{-- CARD STANDAR (Border Primary, Shadow Small) --}}
                            <div class="card h-100 shadow-sm border-primary card-hover">

                                {{-- HEADER STANDAR (Bg Primary, Text White) --}}
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-start">
                                    <div style="max-width: 65%;">
                                        <h6 class="mb-0 text-truncate fw-bold" title="{{ $item->warga->nama ?? 'Warga Terhapus' }}">
                                            <i class="fas fa-user me-2"></i>{{ $item->warga->nama ?? 'Warga Terhapus' }}
                                        </h6>
                                        <small class="d-block text-white-50 mt-1">
    {{-- Kita panggil kolom 'nik' langsung dari tabel kematian --}}
    NIK: {{ $item->nik ?? $item->warga->no_ktp ?? '-' }}
</small>
                                    </div>
                                    <span class="badge bg-light text-primary">
                                        <i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($item->tgl_meninggal)->format('d/m/Y') }}
                                    </span>
                                </div>

                                <div class="card-body">
                                    <div class="mb-3">
                                        <small class="text-muted d-block fw-bold">Penyebab:</small>
                                        <p class="mb-0 text-danger">
                                            <i class="fas fa-heartbeat me-2"></i>{{ $item->sebab_kematian }}
                                        </p>
                                    </div>

                                    <div class="mb-0">
                                        <small class="text-muted d-block fw-bold">Tempat:</small>
                                        <p class="mb-0 text-dark">
                                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>{{ $item->tempat_kematian ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                {{-- FOOTER: Layout sesuai request (Detail panjang, Edit/Hapus sebelahan) --}}
                                <div class="card-footer bg-transparent border-top-0 p-3">
                                    <div class="d-grid gap-2">
                                        {{-- Tombol Detail (Full Width) --}}
                                        <a href="{{ route('kematian.show', $item->kematian_id) }}" class="btn btn-info text-white fw-bold w-100">
                                            <i class="fas fa-file-upload me-2"></i> Detail & Upload
                                        </a>

                                        {{-- Container Edit & Hapus (Flexbox) --}}
                                        <div class="d-flex gap-2">
                                            {{-- Tombol Edit (50% width) --}}
                                            <a href="{{ route('kematian.edit', $item->kematian_id) }}" class="btn btn-warning text-white flex-grow-1">
                                                <i class="fas fa-edit me-2"></i> Edit
                                            </a>

                                            {{-- Form Hapus (50% width) --}}
                                            <form action="{{ route('kematian.destroy', $item->kematian_id) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger w-100">
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
                                <div class="text-muted mb-3">
                                    <i class="fas fa-book-dead fa-4x text-secondary opacity-50"></i>
                                </div>
                                <h5>Belum ada data kematian</h5>
                                <p>Silakan tambahkan data baru melalui tombol di atas.</p>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    @if($data->hasPages())
                    <div class="d-flex justify-content-center mt-5">
                        {{ $data->withQueryString()->links('pagination::bootstrap-5') }}
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
    /* Efek hover standar (sedikit naik) */
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
@endpush

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
