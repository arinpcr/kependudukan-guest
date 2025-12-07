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
            <div class="col-lg-10">
                <div class="bg-light border border-primary rounded p-5">
                    
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-check-circle me-2"></i>Sukses!</strong>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Card Detail Warga -->
                    <div class="card shadow-sm border-primary mb-4">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">
                                    <i class="fas fa-user-circle me-2"></i>Informasi Pribadi
                                </h4>
                                <span class="badge bg-light text-dark fs-6">ID: {{ $warga->warga_id }}</span>
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
                        </div>
                    </div>

                    <!-- Card Dokumen KK -->
                    <div class="card shadow-sm border-success">
                        <div class="card-header bg-success text-white">
                            <h4 class="mb-0">
                                <i class="fas fa-file-contract me-2"></i>Dokumen Kartu Keluarga (KK)
                            </h4>
                        </div>
                        <div class="card-body">
                            @if($warga->documents->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th><i class="fas fa-file me-2"></i>Nama File</th>
                                                <th><i class="fas fa-tag me-2"></i>Tipe</th>
                                                <th><i class="fas fa-weight-hanging me-2"></i>Ukuran</th>
                                                <th><i class="fas fa-calendar me-2"></i>Upload</th>
                                                <th><i class="fas fa-cogs me-2"></i>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($warga->documents as $document)
                                            <tr>
                                                <td>
                                                    <i class="{{ $document->file_icon }} me-2"></i>
                                                    {{ $document->original_name }}
                                                </td>
                                                <td>
                                                    <span class="badge bg-info text-uppercase">
                                                        {{ pathinfo($document->file_name, PATHINFO_EXTENSION) }}
                                                    </span>
                                                </td>
                                                <td>{{ number_format($document->file_size / 1024, 2) }} KB</td>
                                                <td>{{ $document->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ $document->file_url }}" 
                                                           target="_blank" 
                                                           class="btn btn-outline-primary"
                                                           data-bs-toggle="tooltip"
                                                           title="Lihat Dokumen">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ $document->file_url }}" 
                                                           download="{{ $document->original_name }}"
                                                           class="btn btn-outline-success"
                                                           data-bs-toggle="tooltip"
                                                           title="Download">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                        <form action="{{ route('warga.document.delete', $document->document_id) }}" 
                                                              method="POST" 
                                                              class="d-inline"
                                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-outline-danger"
                                                                    data-bs-toggle="tooltip"
                                                                    title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-file-excel fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada dokumen KK</h5>
                                    <p class="text-muted">Silakan upload dokumen KK melalui form edit data warga.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer bg-transparent mt-4">
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
    .table th {
        border-top: none;
        font-weight: 600;
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

        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
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