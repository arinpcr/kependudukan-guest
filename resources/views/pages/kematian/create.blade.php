@extends('layouts.guest.app')

@section('title', 'Input Data Kematian')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        
        {{-- Header Judul --}}
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Manajemen Data</h4>
            <h1 class="mb-5 display-4">Input Data Kematian</h1>
        </div>

        <div class="row justify-content-center wow fadeIn" data-wow-delay="0.3s">
            <div class="col-lg-8">
                <div class="card shadow-sm border-primary">
                    <div class="card-header bg-primary text-white d-flex align-items-center">
                        <i class="fas fa-edit me-2"></i>
                        <h5 class="mb-0 text-white">Formulir Pencatatan Kematian</h5>
                    </div>
                    <div class="card-body p-4">

                        {{-- Alert Error Global (Di atas) --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <strong><i class="fas fa-exclamation-triangle me-2"></i>Periksa inputan Anda:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        {{-- Alert Error System (Dari Catch Block) --}}
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                <strong>Error Sistem:</strong> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('kematian.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">
                                {{-- 1. Pilih Warga --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold">Pilih Warga (Almarhum/ah)</label>
                                    <select name="warga_id" class="form-select @error('warga_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Nama Warga --</option>
                                        @foreach($warga as $w)
                                            <option value="{{ $w->warga_id }}" {{ old('warga_id') == $w->warga_id ? 'selected' : '' }}>
                                                {{ $w->nama }} - (NIK: {{ $w->no_ktp }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('warga_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- 2. Tanggal & Sebab --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tanggal Meninggal</label>
                                    <input type="date" name="tgl_meninggal" class="form-control @error('tgl_meninggal') is-invalid @enderror" value="{{ old('tgl_meninggal') }}" required>
                                    @error('tgl_meninggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Sebab Kematian</label>
                                    <input type="text" name="sebab_kematian" class="form-control @error('sebab_kematian') is-invalid @enderror" placeholder="Contoh: Sakit Tua / Jantung" value="{{ old('sebab_kematian') }}" required>
                                    @error('sebab_kematian')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- 3. Tempat Kematian --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold">Tempat Kematian</label>
                                    <input type="text" name="tempat_kematian" class="form-control @error('tempat_kematian') is-invalid @enderror" placeholder="Contoh: RSUD Arifin Achmad / Rumah Duka" value="{{ old('tempat_kematian') }}">
                                    @error('tempat_kematian')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- 4. UPLOAD FILE --}}
                                <div class="col-12">
                                    <div class="p-3 bg-light border rounded mt-2">
                                        <label class="form-label fw-bold text-primary">
                                            <i class="fas fa-paperclip me-1"></i> Upload Bukti (Opsional)
                                        </label>
                                        <input type="file" name="files[]" class="form-control @error('files.*') is-invalid @enderror" multiple accept=".jpg,.jpeg,.png,.pdf">
                                        <div class="form-text">
                                            <i class="fas fa-info-circle"></i> Anda bisa memilih banyak file sekaligus (Surat Keterangan Dokter, Akta, dll). Format: JPG, PNG, PDF. Max: 2MB.
                                        </div>
                                        @error('files.*')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Tombol Aksi --}}
                                <div class="col-12 mt-4 d-flex justify-content-between">
                                    <a href="{{ route('kematian.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fas fa-save me-2"></i>Simpan Data
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection