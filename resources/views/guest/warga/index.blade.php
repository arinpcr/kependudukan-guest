@extends('layouts.guest.app')

@section('title', 'Data Warga - Sistem Kependudukan')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Manajemen Data</h4>
            <h1 class="mb-5 display-4">Data Warga</h1>
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
                        <a href="{{ route('warga.create') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i>Tambah Warga Baru
                        </a>
                        
                        <div class="text-muted">
                            <i class="fas fa-users me-2 text-primary"></i>
                            Total Data: <strong>{{ $warga->total() }}</strong>
                        </div>
                    </div>

                    <!-- Card Layout -->
                    <div class="row g-4">
                        @forelse ($warga as $index => $item)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-primary">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <i class="fas fa-user me-2"></i>{{ $item->nama }}
                                    </h6>
                                    <span class="badge bg-light text-dark">#{{ $warga->firstItem() + $index }}</span>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-id-card me-2 text-primary"></i>
                                            <span class="fw-bold">No KTP:</span>
                                        </div>
                                        <p class="ms-4 mb-0">{{ $item->no_ktp }}</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-venus-mars me-2 text-primary"></i>
                                            <span class="fw-bold">Jenis Kelamin:</span>
                                        </div>
                                        <p class="ms-4 mb-0">
                                            @if($item->jenis_kelamin == 'L')
                                                <span class="badge bg-primary">
                                                    <i class="fas fa-mars me-1"></i>Laki-laki
                                                </span>
                                            @else
                                                <span class="badge bg-pink">
                                                    <i class="fas fa-venus me-1"></i>Perempuan
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-pray me-2 text-primary"></i>
                                            <span class="fw-bold">Agama:</span>
                                        </div>
                                        <p class="ms-4 mb-0">{{ $item->agama }}</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-briefcase me-2 text-primary"></i>
                                            <span class="fw-bold">Pekerjaan:</span>
                                        </div>
                                        <p class="ms-4 mb-0">{{ $item->pekerjaan }}</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-phone me-2 text-primary"></i>
                                            <span class="fw-bold">Telepon:</span>
                                        </div>
                                        <p class="ms-4 mb-0">{{ $item->telp }}</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-envelope me-2 text-primary"></i>
                                            <span class="fw-bold">Email:</span>
                                        </div>
                                        <p class="ms-4 mb-0">
                                            @if($item->email)
                                                {{ $item->email }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top-0">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('warga.edit', $item->warga_id) }}" 
                                           class="btn btn-warning btn-sm" 
                                           data-bs-toggle="tooltip" 
                                           title="Edit Data">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                        <form action="{{ route('warga.destroy', $item->warga_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-danger btn-sm" 
                                                    data-bs-toggle="tooltip" 
                                                    title="Hapus Data"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data warga ini?')">
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
                                    <i class="fas fa-user-slash fa-3x mb-3"></i>
                                    <h5>Tidak ada data warga</h5>
                                    <p>Silakan tambah data warga baru dengan mengklik tombol di atas.</p>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    @if($warga->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Menampilkan {{ $warga->firstItem() }} sampai {{ $warga->lastItem() }} dari {{ $warga->total() }} data
                        </div>
                        <nav>
                            {{ $warga->links('pagination::bootstrap-5') }}
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
    .bg-pink {
        background-color: #e83e8c !important;
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

        console.log('Warga index page loaded with enhanced features');
    });
</script>
@endpush