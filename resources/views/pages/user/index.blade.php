@extends('layouts.guest.app')

@section('title', 'Data User - Sistem Kependudukan')

{{-- Panggil CSS Eksternal di sini --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        
        {{-- HEADER JUDUL --}}
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Manajemen Akun</h4>
            <h1 class="mb-5 display-4">Data User</h1>
        </div>

        <div class="row justify-content-center wow fadeIn" data-wow-delay="0.3s">
            <div class="col-12">
                
                {{-- WRAPPER UTAMA --}}
                <div class="bg-light border border-primary rounded p-5">

                    {{-- Flash Message --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-check-circle me-2"></i>Sukses!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Tombol Tambah & Info Total --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="{{ route('user.create') }}" class="btn btn-primary px-4 py-2 shadow-sm">
                            <i class="fas fa-plus me-2"></i>Tambah User Baru
                        </a>
                        <div class="text-muted fw-bold">
                            <i class="fas fa-users me-2 text-primary"></i>
                            Total Data: <span class="text-dark">{{ $dataUser->total() }}</span>
                        </div>
                    </div>

                    {{-- SEARCH & FILTER BAR --}}
                    <div class="card mb-5 border-0 shadow-sm" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <form action="{{ route('user.index') }}" method="GET" id="searchForm">
                                @if(request('per_page')) <input type="hidden" name="per_page" value="{{ request('per_page') }}"> @endif
                                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif

                                <div class="row g-3">
                                    {{-- Search Input --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-muted small">Pencarian</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                            <input type="text" class="form-control border-start-0 ps-0" name="search" placeholder="Cari nama atau email..." value="{{ request('search') }}">
                                        </div>
                                    </div>

                                    {{-- Filter Role --}}
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold text-muted small">Filter Role</label>
                                        <select class="form-select" name="role" onchange="this.form.submit()">
                                            <option value="">Semua Role</option>
                                            <option value="Super Admin" {{ request('role') == 'Super Admin' ? 'selected' : '' }}>Super Admin</option>
                                            <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="User" {{ request('role') == 'User' ? 'selected' : '' }}>User</option>
                                        </select>
                                    </div>

                                    {{-- Sorting --}}
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold text-muted small">Urutkan</label>
                                        <select class="form-select" name="sort" onchange="this.form.submit()">
                                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                                            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- GRID USER CARD --}}
                    <div class="row g-4">
                      @forelse ($dataUser as $item)
                            
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card user-card h-100">
                                    
                                    {{-- 1. Foto Profil dengan Bingkai Pink --}}
                                    <div class="user-avatar-wrapper">
                                        <img src="{{ $item->avatar_url }}" alt="{{ $item->name }}" class="user-avatar-img">
                                    </div>

                                    {{-- 2. Body Card --}}
                                    <div class="card-body text-center pt-2">
                                        {{-- Nama & Email --}}
                                        <h5 class="text-dark">{{ $item->name }}</h5>
                                        <p class="text-muted mb-3">{{ $item->email }}</p>

                                        {{-- Badge Role (Warna-warni sesuai Role) --}}
                                        @php
                                            $badgeClass = match($item->role) {
                                                'Super Admin' => 'badge-super', // Merah
                                                'Admin'       => 'badge-admin', // Kuning
                                                default       => 'badge-user',  // Pink (User Biasa)
                                            };
                                        @endphp
                                        
                                        <span class="badge badge-role {{ $badgeClass }}">
                                            {{ $item->role }}
                                        </span>

                                        <hr class="opacity-25">

                                        {{-- Tombol Aksi --}}
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('user.edit', $item->id) }}" class="btn btn-outline-warning btn-sm action-btn" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            @if(Auth::id() != $item->id)
                                            <form action="{{ route('user.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm action-btn" title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                            @else
                                            <button class="btn btn-light btn-sm action-btn text-muted" disabled title="Sedang Login">
                                                <i class="fas fa-user-check"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Footer Info --}}
                                    <div class="card-footer bg-white border-top-0 text-center pb-4 pt-0">
                                        <small class="text-muted" style="font-size: 0.75rem;">
                                            Bergabung: {{ $item->created_at->format('d M Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="fas fa-users-slash fa-4x text-muted mb-3 opacity-50"></i>
                                    <h5 class="text-muted">Data user tidak ditemukan.</h5>
                                    <a href="{{ route('user.index') }}" class="btn btn-outline-primary mt-2">Reset Filter</a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    {{-- PAGINATION --}}
                    @if($dataUser->hasPages())
                    <div class="d-flex justify-content-end align-items-center mt-5">
                        {{ $dataUser->withQueryString()->links('pagination::bootstrap-5') }}
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