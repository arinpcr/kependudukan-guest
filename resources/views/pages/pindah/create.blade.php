@extends('layouts.guest.app')

@section('title', 'Catat Perpindahan Warga')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        
        {{-- Header Judul --}}
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Manajemen Data</h4>
            <h1 class="mb-5 display-4">Catat Perpindahan Warga</h1>
        </div>

        <div class="row justify-content-center wow fadeIn" data-wow-delay="0.3s">
            <div class="col-lg-8">
                <div class="card shadow-sm border-primary">
                    <div class="card-header bg-primary text-white d-flex align-items-center">
                        <i class="fas fa-truck-moving me-2"></i>
                        <h5 class="mb-0 text-white">Formulir Perpindahan Warga</h5>
                    </div>
                    <div class="card-body p-4">

                        {{-- Alert Error Global --}}
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

                        {{-- Alert Error System --}}
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                <strong>Error Sistem:</strong> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('pindah.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">
                                
                                {{-- 1. Pilih Warga --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold">Pilih Warga</label>
                                    <select name="warga_id" class="form-select @error('warga_id') is-invalid @enderror" required>
                                        <option value="">-- Cari Nama Warga / NIK --</option>
                                        @foreach($warga as $w)
                                            {{-- Tambahkan data-alamat untuk auto-fill via JS --}}
                                            <option value="{{ $w->warga_id }}" {{ old('warga_id') == $w->warga_id ? 'selected' : '' }} data-alamat="{{ $w->alamat }}">
                                                {{ $w->nama }} - (NIK: {{ $w->no_ktp }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('warga_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text text-muted small">Warga yang dipilih otomatis statusnya akan tercatat pindah.</div>
                                </div>

                                {{-- 2. Tanggal & Jenis Pindah --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tanggal Pindah</label>
                                    <input type="date" name="tgl_pindah" class="form-control @error('tgl_pindah') is-invalid @enderror" value="{{ old('tgl_pindah', date('Y-m-d')) }}" required>
                                    @error('tgl_pindah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Jenis Kepindahan</label>
                                    <select name="jenis_pindah" class="form-select @error('jenis_pindah') is-invalid @enderror" required>
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="Antar RT/RW" {{ old('jenis_pindah') == 'Antar RT/RW' ? 'selected' : '' }}>Antar RT/RW (Satu Desa)</option>
                                        <option value="Keluar Desa" {{ old('jenis_pindah') == 'Keluar Desa' ? 'selected' : '' }}>Keluar Desa</option>
                                        <option value="Keluar Kecamatan" {{ old('jenis_pindah') == 'Keluar Kecamatan' ? 'selected' : '' }}>Keluar Kecamatan</option>
                                        <option value="Keluar Kab/Kota" {{ old('jenis_pindah') == 'Keluar Kab/Kota' ? 'selected' : '' }}>Keluar Kab/Kota</option>
                                        <option value="Keluar Provinsi" {{ old('jenis_pindah') == 'Keluar Provinsi' ? 'selected' : '' }}>Keluar Provinsi</option>
                                        <option value="Keluar Negeri" {{ old('jenis_pindah') == 'Keluar Negeri' ? 'selected' : '' }}>Keluar Negeri</option>
                                    </select>
                                    @error('jenis_pindah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- 3. Alamat Asal (Auto Fill) --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold">Alamat Asal</label>
                                    <input type="text" name="alamat_asal" id="alamat_asal" class="form-control @error('alamat_asal') is-invalid @enderror" placeholder="Terisi otomatis saat warga dipilih..." value="{{ old('alamat_asal') }}" required>
                                    @error('alamat_asal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- 4. Alamat Tujuan --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold">Alamat Tujuan</label>
                                    <textarea name="alamat_tujuan" class="form-control @error('alamat_tujuan') is-invalid @enderror" rows="2" placeholder="Tulis alamat lengkap tujuan pindah..." required>{{ old('alamat_tujuan') }}</textarea>
                                    @error('alamat_tujuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- 5. Alasan & No Surat --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Alasan / Keterangan</label>
                                    <textarea name="alasan" class="form-control" rows="2" placeholder="Contoh: Pindah tugas kerja, ikut keluarga, dll">{{ old('alasan') }}</textarea>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">No. Surat Pengantar (Opsional)</label>
                                    <input type="text" name="no_surat" class="form-control" placeholder="Contoh: 470/015/Desa/2025" value="{{ old('no_surat') }}">
                                </div>

                                {{-- 6. UPLOAD FILE --}}
                                <div class="col-12">
                                    <div class="p-3 bg-light border rounded mt-2">
                                        <label class="form-label fw-bold text-primary">
                                            <i class="fas fa-paperclip me-1"></i> Upload Bukti / Surat Pindah
                                        </label>
                                        <input type="file" name="files[]" class="form-control @error('files.*') is-invalid @enderror" multiple accept=".jpg,.jpeg,.png,.pdf">
                                        <div class="form-text">
                                            <i class="fas fa-info-circle"></i> Bisa upload banyak file (KTP, KK, Surat Pengantar). Max: 2MB per file.
                                        </div>
                                        @error('files.*')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Tombol Aksi --}}
                                <div class="col-12 mt-4 d-flex justify-content-between">
                                    <a href="{{ route('pindah.index') }}" class="btn btn-secondary">
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

@push('scripts')
<script>
    // Script Auto-Fill Alamat Asal
    document.addEventListener('DOMContentLoaded', function() {
        const selectWarga = document.querySelector('select[name="warga_id"]');
        const inputAsal = document.getElementById('alamat_asal');

        if(selectWarga && inputAsal) {
            selectWarga.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const alamat = selectedOption.getAttribute('data-alamat');
                
                // Isi otomatis jika input masih kosong atau user ingin update
                if(alamat) {
                    inputAsal.value = alamat;
                } else {
                    inputAsal.value = '-'; // Default jika alamat kosong
                }
            });
        }
    });
</script>
@endpush