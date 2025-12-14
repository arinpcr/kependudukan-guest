@extends('layouts.guest.app')

@section('title', 'Data Pindah - Sistem Kependudukan')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        
        {{-- HEADER JUDUL --}}
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Manajemen Data</h4>
            <h1 class="mb-5 display-4">Peristiwa Pindah</h1>
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
                        <a href="{{ route('pindah.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Catat Perpindahan Baru
                        </a>
                        <div class="text-muted">
                            <i class="fas fa-info-circle me-2 text-primary"></i> Total Data: <strong>{{ $data->total() }}</strong>
                        </div>
                    </div>

                    {{-- SEARCH & FILTER OPTIONS --}}
                    <div class="card mb-4 border-primary">
                        <div class="card-body">
                            {{-- Search Bar --}}
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label"><i class="fas fa-search me-2"></i>Cari Data Pindah</label>
                                    <form action="{{ route('pindah.index') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search" placeholder="Cari nama warga, alamat tujuan, atau keterangan..." value="{{ request('search') }}">
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                            @if(request('search'))
                                                <a href="{{ route('pindah.index') }}" class="btn btn-outline-secondary"><i class="fas fa-times"></i></a>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- Filter Bar --}}
                            <form action="{{ route('pindah.index') }}" method="GET">
                                @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label"><i class="fas fa-sort me-2"></i>Urutkan</label>
                                        <select class="form-select" name="sort" onchange="this.form.submit()">
                                            <option value="tgl_terbaru" {{ request('sort') == 'tgl_terbaru' ? 'selected' : '' }}>Tgl Pindah (Baru)</option>
                                            <option value="tgl_terlama" {{ request('sort') == 'tgl_terlama' ? 'selected' : '' }}>Tgl Pindah (Lama)</option>
                                            <option value="nama_az" {{ request('sort') == 'nama_az' ? 'selected' : '' }}>Nama (A-Z)</option>
                                            <option value="nama_za" {{ request('sort') == 'nama_za' ? 'selected' : '' }}>Nama (Z-A)</option>
                                        </select>
                                    </div>
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

                    {{-- CARD DATA GRID --}}
                    <div class="row g-4">
                        @forelse($data as $item)
                        
                        {{-- 
                            LOGIC PHP PEMECAH DATA STRING 
                            Tujuannya: Memisahkan "Jenis: ... | Asal: ... | Ket: ..."
                        --}}
                        @php
                            $rawAlasan = $item->alasan;
                            $tampilJenis = '-';
                            $tampilAsal = '-';
                            $tampilKet = $rawAlasan; // Default tampilkan semua kalau format tidak cocok

                            // 1. Ambil JENIS PINDAH
                            if (preg_match('/Jenis:\s*(.*?)\s*(\| |$)/i', $rawAlasan, $m)) {
                                $tampilJenis = $m[1];
                            }

                            // 2. Ambil ALAMAT ASAL
                            // Prioritas: Data Master Warga -> Data di string 'Asal:'
                            if(!empty($item->warga->alamat)) {
                                $tampilAsal = $item->warga->alamat;
                            } elseif (preg_match('/Asal:\s*(.*?)\s*(\| |$)/i', $rawAlasan, $m)) {
                                $tampilAsal = $m[1];
                            }

                            // 3. Ambil KETERANGAN MURNI (Hapus bagian Jenis & Asal)
                            if (preg_match('/Ket:\s*(.*?)\s*(\| |$)/i', $rawAlasan, $m)) {
                                $tampilKet = $m[1];
                            } elseif ($tampilJenis != '-') {
                                // Kalau formatnya ada 'Jenis:' tapi ga ada 'Ket:', 
                                // berarti sisanya dianggap keterangan atau kosong
                                $tampilKet = '-'; 
                            }
                        @endphp

                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-primary card-hover">
                                
                                {{-- HEADER: Nama & NIK --}}
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-start p-3">
                                    <div style="max-width: 65%;">
                                        <h6 class="mb-0 text-truncate fw-bold text-white" title="{{ $item->warga->nama ?? 'Warga Terhapus' }}">
                                            <i class="fas fa-user me-2"></i>{{ $item->warga->nama ?? 'Warga Terhapus' }}
                                        </h6>
                                        <small class="d-block text-white-50 mt-1">
                                            NIK: {{ $item->warga->no_ktp ?? '-' }}
                                        </small>
                                    </div>
                                    <span class="badge bg-light text-primary shadow-sm">
                                        <i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($item->tgl_pindah)->format('d/m/Y') }}
                                    </span>
                                </div>

                                <div class="card-body p-3 d-flex flex-column">
                                    
                                    {{-- BAGIAN 1: JENIS PINDAH --}}
                                    <div class="mb-2 pb-2 border-bottom border-light">
                                        <small class="text-secondary fw-bold d-block mb-1">Jenis Pindah:</small>
                                        <div class="d-flex text-dark align-items-center">
                                            <i class="fas fa-exchange-alt mt-1 me-2 text-warning"></i>
                                            <span class="fw-bold">{{ $tampilJenis }}</span>
                                        </div>
                                    </div>

                                    {{-- BAGIAN 2: ALAMAT ASAL --}}
                                    <div class="mb-2">
                                        <small class="text-secondary fw-bold d-block mb-1">Alamat Asal:</small>
                                        <div class="d-flex text-dark">
                                            <i class="fas fa-map-marker-alt mt-1 me-2 text-danger"></i>
                                            <span class="lh-sm text-truncate-2">{{ $tampilAsal }}</span>
                                        </div>
                                    </div>

                                    {{-- BAGIAN 3: ALAMAT TUJUAN --}}
                                    <div class="mb-3">
                                        <small class="text-secondary fw-bold d-block mb-1">Alamat Tujuan:</small>
                                        <div class="d-flex text-dark">
                                            <i class="fas fa-location-arrow mt-1 me-2 text-success"></i>
                                            <span class="fw-bold lh-sm text-truncate-2">{{ $item->alamat_tujuan }}</span>
                                        </div>
                                    </div>
                                    
                                    {{-- BAGIAN 4: KETERANGAN --}}
                                    <div class="mt-auto p-2 bg-light border rounded">
                                        <small class="text-muted fw-bold d-block" style="font-size: 0.75rem;">Keterangan / Alasan:</small>
                                        <p class="mb-0 fst-italic text-dark small">
                                            "{{ Str::limit($tampilKet, 60) }}"
                                        </p>
                                    </div>
                                </div>

                                {{-- FOOTER: Tombol Aksi --}}
                                <div class="card-footer bg-transparent border-top-0 p-3 pt-0">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('pindah.show', $item->pindah_id) }}" class="btn btn-info btn-sm text-white w-100">
                                            <i class="fa fa-eye me-2"></i> Detail Lengkap
                                        </a>

                                        <div class="d-flex gap-2">
                                            <a href="{{ route('pindah.edit', $item->pindah_id) }}" class="btn btn-warning btn-sm text-white flex-grow-1">
                                                <i class="fas fa-edit me-2"></i> Edit
                                            </a>
                                            
                                            <form action="{{ route('pindah.destroy', $item->pindah_id) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('Yakin ingin menghapus data kepindahan {{ $item->warga->nama ?? '' }}?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm w-100">
                                                    <i class="fas fa-trash me-2"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @empty
                        {{-- TAMPILAN JIKA DATA KOSONG --}}
                        <div class="col-12">
                            <div class="text-center py-5">
                                <div class="bg-white rounded-circle d-inline-flex p-4 shadow-sm mb-3 border border-primary">
                                    <i class="fas fa-truck-moving fa-4x text-secondary opacity-50"></i>
                                </div>
                                <h5 class="text-muted">Data tidak ditemukan</h5>
                                <p class="text-muted small">Silakan tambah data baru atau ubah filter pencarian.</p>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    @if($data->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <div class="text-muted small">
                            Menampilkan <strong>{{ $data->firstItem() }}</strong> sampai <strong>{{ $data->lastItem() }}</strong> dari <strong>{{ $data->total() }}</strong> data
                        </div>
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

@push('styles')
<style>
    .title-border-radius { border-radius: 10px; }
    .card-hover { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .card-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .text-truncate-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
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