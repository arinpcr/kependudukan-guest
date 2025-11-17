@extends('layouts.guest.app')

@section('title', 'Detail Warga - Sistem Kependudukan')

@section('content')
<div class="container-fluid py-5">
    <div class="container">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Detail Data</h4>
            <h1 class="mb-5 display-4">Detail Data Warga</h1>
        </div>

        <div class="row justify-content-center wow fadeIn" data-wow-delay="0.3s">
            <div class="col-lg-8">
                <div class="bg-light border border-primary rounded p-5">
                    
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-check-circle me-2"></i>Sukses!</strong>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Card Detail Warga -->
                    <div class="card shadow-sm border-primary">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">
                                    <i class="fas fa-user-circle me-2"></i>Informasi Pribadi
                                </h4>
                                <span class="badge bg-light text-dark fs-6">ID: {{ $warga->id }}</span>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="row">
                                <!-- Kolom Kiri -->
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-primary">
                                            <i class="fas fa-id-card me-2"></i>No. KTP
                                        </label>
                                        <p class="fs-5">{{ $warga->no_ktp }}</p>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-primary">
                                            <i class="fas fa-user me-2"></i>Nama Lengkap
                                        </label>
                                        <p class="fs-5">{{ $warga->nama }}</p>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-primary">
                                            <i class="fas fa-venus-mars me-2"></i>Jenis Kelamin
                                        </label>
                                        <p class="fs-5">
                                            @if($warga->jenis_kelamin == 'L')
                                                <span class="badge bg-primary fs-6">
                                                    <i class="fas fa-mars me-1"></i>Laki-laki
                                                </span>
                                            @else
                                                <span class="badge bg-pink fs-6">
                                                    <i class="fas fa-venus me-1"></i>Perempuan
                                                </span>
                                            @endif
                                        </p>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-primary">
                                            <i class="fas fa-pray me-2"></i>Agama
                                        </label>
                                        <p class="fs-5">{{ $warga->agama ?? '-' }}</p>
                                    </div>
                                </div>

                                <!-- Kolom Kanan -->
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-primary">
                                            <i class="fas fa-briefcase me-2"></i>Pekerjaan
                                        </label>
                                        <p class="fs-5">{{ $warga->pekerjaan ?? '-' }}</p>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-primary">
                                            <i class="fas fa-phone me-2"></i>No. Telepon
                                        </label>
                                        <p class="fs-5">{{ $warga->telp ?? '-' }}</p>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-primary">
                                            <i class="fas fa-envelope me-2"></i>Email
                                        </label>
                                        <p class="fs-5">
                                            @if($warga->email)
                                                {{ $warga->email }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </p>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-primary">
                                            <i class="fas fa-calendar me-2"></i>Tanggal Dibuat
                                        </label>
                                        <p class="fs-5">
                                            {{ $warga->created_at->format('d F Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Tambahan -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="border-top pt-4">
                                        <h5 class="text-primary mb-3">
                                            <i class="fas fa-info-circle me-2"></i>Informasi Tambahan
                                        </h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-sync-alt me-2 text-primary"></i>
                                                    <span class="fw-bold">Terakhir Diupdate:</span>
                                                </div>
                                                <p class="ms-4">{{ $warga->updated_at->format('d F Y H:i') }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-database me-2 text-primary"></i>
                                                    <span class="fw-bold">Status Data:</span>
                                                </div>
                                                <p class="ms-4">
                                                    <span class="badge bg-success fs-6">
                                                        <i class="fas fa-check me-1"></i>Aktif
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-transparent">
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('warga.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
        </a>
        
        <div class="btn-group">
            <a href="{{ route('warga.edit', $warga) }}" 
               class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit Data
            </a>
            
            <form action="{{ route('warga.destroy', $warga) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="btn btn-danger"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus data warga {{ $warga->nama }}?')">
                    <i class="fas fa-trash me-2"></i>Hapus
                </button>
            </form>
        </div>
    </div>
</div>                    </div>
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
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
    }
    .bg-pink {
        background-color: #e83e8c !important;
    }
    .form-label {
        font-size: 1.1rem;
    }
    .fs-5 {
        font-size: 1.2rem !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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

        console.log('Warga detail page loaded');
    });
</script>
@endpush