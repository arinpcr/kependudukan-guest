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

@push('styles')
<style>
    .title-border-radius {
        border-radius: 10px;
    }
    .card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .card-header {
        border-bottom: 2px solid rgba(0,0,0,0.1);
    }
    .btn-group .btn {
        margin: 0 2px;
    }
    .badge {
        font-size: 0.8em;
        padding: 0.35em 0.65em;
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