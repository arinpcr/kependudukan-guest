@extends('layouts.guest.app')

@section('title', 'Edit Anggota Keluarga - Sistem Kependudukan')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Edit Anggota</h4>
            <h1 class="mb-5 display-4">Formulir Edit Anggota Keluarga</h1>
        </div>

        <div class="row justify-content-center wow fadeIn" data-wow-delay="0.3s">
            <div class="col-lg-8">
                <div class="bg-light border border-primary rounded p-5">
                    
                    <!-- Info KK & Anggota -->
                    <div class="card mb-4 border-primary">
                        <div class="card-header bg-primary text-white py-2">
                            <h6 class="mb-0">
                                <i class="fas fa-home me-2"></i>Kartu Keluarga: {{ $anggota->keluarga->kk_nomor }}
                            </h6>
                        </div>
                        <div class="card-body py-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">Anggota:</small>
                                    <p class="mb-1 fw-bold">{{ $anggota->warga->nama }}</p>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">No KTP:</small>
                                    <p class="mb-1 fw-bold">{{ $anggota->warga->no_ktp }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('anggota-keluarga.index', $anggota->kk_id) }}" class="btn btn-secondary btn-sm mb-4">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Anggota
                    </a>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-exclamation-triangle me-2"></i>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('anggota-keluarga.update', [$anggota->kk_id, $anggota->anggota_id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control bg-light" 
                                           value="{{ $anggota->warga->nama }} ({{ $anggota->warga->no_ktp }})" 
                                           disabled>
                                    <label>
                                        <i class="fas fa-user me-2 text-primary"></i>Nama Warga
                                    </label>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Nama warga tidak dapat diubah. Untuk mengubah data warga, gunakan menu data warga.
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <select class="form-select @error('hubungan') is-invalid @enderror" 
                                            name="hubungan" id="hubungan" required>
                                        <option value="">-- Pilih Hubungan --</option>
                                        @foreach ($hubunganOptions as $value => $label)
                                            <option value="{{ $value }}" {{ old('hubungan', $anggota->hubungan) == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="hubungan">
                                        <i class="fas fa-link me-2 text-primary"></i>Hubungan dalam Keluarga
                                    </label>
                                    @error('hubungan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('anggota-keluarga.index', $anggota->kk_id) }}" class="btn btn-secondary me-md-2 px-4">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fas fa-save me-2"></i>Update Data
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form submission loading state
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengupdate...';
                }
            });
        }
    });
</script>
@endpush