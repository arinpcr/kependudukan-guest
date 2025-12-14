@extends('layouts.guest.app')

@section('title', 'Tambah Data KK - Sistem Kependudukan')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Tambah Data</h4>
            <h1 class="mb-5 display-4">Formulir Tambah Kartu Keluarga</h1>
        </div>

        <div class="row justify-content-center wow fadeIn" data-wow-delay="0.3s">
            <div class="col-lg-8">
                <div class="bg-light border border-primary rounded p-5">
                    
                    <a href="{{ route('keluarga.index') }}" class="btn btn-secondary btn-sm mb-4">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar KK
                    </a>

                    {{-- MENAMPILKAN PESAN ERROR DARI CONTROLLER (CATCH BLOCK) --}}
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-exclamation-circle me-2"></i>Gagal!</strong>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-exclamation-triangle me-2"></i>Periksa inputan Anda:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('keluarga.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('kk_nomor') is-invalid @enderror" 
                                           name="kk_nomor" id="kk_nomor" value="{{ old('kk_nomor') }}" 
                                           placeholder="Nomor KK" required maxlength="16">
                                    <label for="kk_nomor">
                                        <i class="fas fa-id-card me-2 text-primary"></i>Nomor KK
                                    </label>
                                    @error('kk_nomor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <select class="form-select @error('kepala_keluarga_warga_id') is-invalid @enderror" 
                                            name="kepala_keluarga_warga_id" id="kepala_keluarga" required>
                                        <option value="">-- Pilih Kepala Keluarga --</option>
                                        @foreach ($warga as $w)
                                            <option value="{{ $w->warga_id }}" {{ old('kepala_keluarga_warga_id') == $w->warga_id ? 'selected' : '' }}>
                                                {{ $w->nama }} (KTP: {{ $w->no_ktp }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="kepala_keluarga">
                                        <i class="fas fa-user me-2 text-primary"></i>Kepala Keluarga
                                    </label>
                                    @error('kepala_keluarga_warga_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                              name="alamat" id="alamat" placeholder="Alamat" 
                                              style="height: 100px" required>{{ old('alamat') }}</textarea>
                                    <label for="alamat">
                                        <i class="fas fa-map-marker-alt me-2 text-primary"></i>Alamat Lengkap
                                    </label>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('rt') is-invalid @enderror" 
                                           name="rt" id="rt" value="{{ old('rt') }}" 
                                           placeholder="RT" required>
                                    <label for="rt">
                                        <i class="fas fa-home me-2 text-primary"></i>RT
                                    </label>
                                    @error('rt')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('rw') is-invalid @enderror" 
                                           name="rw" id="rw" value="{{ old('rw') }}" 
                                           placeholder="RW" required>
                                    <label for="rw">
                                        <i class="fas fa-building me-2 text-primary"></i>RW
                                    </label>
                                    @error('rw')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('keluarga.index') }}" class="btn btn-secondary me-md-2 px-4">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fas fa-save me-2"></i>Simpan Data
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
        // Format KK number input
        const kkInput = document.getElementById('kk_nomor');
        if (kkInput) {
            kkInput.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
            
            kkInput.addEventListener('blur', function() {
                if (this.value.length !== 16 && this.value.length > 0) {
                    const toastEl = document.getElementById('errorToast');
                    const toast = new bootstrap.Toast(toastEl);
                    document.getElementById('toastMessage').textContent = 'Nomor KK harus terdiri dari 16 digit';
                    toast.show();
                    
                    // [FIX] MENGHAPUS this.focus() AGAR TIDAK MENGGANGGU TOMBOL SUBMIT
                }
            });
        }

        // Format RT/RW input
        const rtInput = document.getElementById('rt');
        const rwInput = document.getElementById('rw');
        
        if (rtInput) {
            rtInput.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        }
        
        if (rwInput) {
            rwInput.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        }

        // Auto-capitalize address
        const addressInput = document.getElementById('alamat');
        if (addressInput) {
            addressInput.addEventListener('blur', function() {
                this.value = this.value.toUpperCase();
            });
        }

        // Form submission loading state
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    // Beri sedikit jeda agar form terkirim sebelum button disabled
                    setTimeout(() => {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                    }, 100);
                }
            });
        }
    });
</script>

<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="errorToast" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-exclamation-circle me-2"></i>
                <span id="toastMessage"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endpush