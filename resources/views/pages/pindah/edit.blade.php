@extends('layouts.guest.app')
@section('title', 'Edit Data Pindah')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        
        {{-- Header --}}
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <h4 class="text-primary fw-bold">Edit Data Perpindahan</h4>
                <p class="text-muted">Perbarui informasi perpindahan warga jika terdapat kesalahan input.</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-warning shadow-sm rounded-3">
                    <div class="card-header bg-warning text-white p-3 d-flex align-items-center">
                        <i class="fas fa-edit me-2"></i>
                        <h5 class="mb-0">Formulir Edit Data</h5>
                    </div>
                    <div class="card-body p-4">
                        
                        {{-- LOGIC PHP: MEMECAH DATA DARI KOLOM ALASAN --}}
                        @php
                            $rawAlasan = $pindah->alasan;
                            $valJenis  = '';
                            $valAsal   = '';
                            $valKet    = $rawAlasan; // Default isi semua

                            // 1. Ambil JENIS PINDAH
                            if (preg_match('/Jenis:\s*(.*?)\s*(\| |$)/i', $rawAlasan, $m)) {
                                $valJenis = $m[1];
                            }

                            // 2. Ambil ALAMAT ASAL
                            if (preg_match('/Asal:\s*(.*?)\s*(\| |$)/i', $rawAlasan, $m)) {
                                $valAsal = $m[1];
                            }

                            // 3. Ambil KETERANGAN MURNI
                            if (preg_match('/Ket:\s*(.*?)\s*(\| |$)/i', $rawAlasan, $m)) {
                                $valKet = $m[1];
                            } elseif ($valJenis != '') {
                                // Jika ada format 'Jenis:' tapi tidak ada 'Ket:', kosongkan ket murni
                                $valKet = ''; 
                            }
                        @endphp

                        <form action="{{ route('pindah.update', $pindah->pindah_id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            {{-- Info Warga (Readonly) --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold text-muted">Nama Warga (Tidak dapat diubah)</label>
                                <input type="text" class="form-control bg-light" value="{{ $pindah->warga->nama ?? 'Warga Terhapus' }} - NIK: {{ $pindah->warga->no_ktp ?? '-' }}" readonly>
                                {{-- Hidden ID Warga agar tidak hilang saat update --}}
                                <input type="hidden" name="warga_id" value="{{ $pindah->warga_id }}">
                            </div>

                            <div class="row g-3">
                                
                                {{-- Tanggal Pindah --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tanggal Pindah <span class="text-danger">*</span></label>
                                    <input type="date" name="tgl_pindah" class="form-control" value="{{ old('tgl_pindah', $pindah->tgl_pindah) }}" required>
                                </div>

                                {{-- Jenis Pindah --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Jenis Kepindahan <span class="text-danger">*</span></label>
                                    <select name="jenis_pindah" class="form-select" required>
                                        <option value="">-- Pilih Jenis --</option>
                                        @foreach(['Antar RT/RW', 'Keluar Desa', 'Keluar Kecamatan', 'Keluar Kab/Kota', 'Keluar Provinsi', 'Keluar Negeri'] as $option)
                                            <option value="{{ $option }}" {{ (old('jenis_pindah', $valJenis) == $option) ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Alamat Asal --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold">Alamat Asal <span class="text-danger">*</span></label>
                                    <input type="text" name="alamat_asal" class="form-control" 
                                           value="{{ old('alamat_asal', $valAsal ?: ($pindah->warga->alamat ?? '-')) }}" required>
                                </div>

                                {{-- Alamat Tujuan --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold">Alamat Tujuan <span class="text-danger">*</span></label>
                                    <textarea name="alamat_tujuan" class="form-control" rows="2" required>{{ old('alamat_tujuan', $pindah->alamat_tujuan) }}</textarea>
                                </div>

                                {{-- Alasan / Keterangan --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold">Alasan / Keterangan</label>
                                    <textarea name="alasan" class="form-control" rows="2">{{ old('alasan', $valKet) }}</textarea>
                                </div>

                                {{-- Nomor Surat --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold">Nomor Surat</label>
                                    <input type="text" name="no_surat" class="form-control" value="{{ old('no_surat', $pindah->no_surat) }}">
                                </div>

                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                                <a href="{{ route('pindah.index') }}" class="btn btn-secondary px-4">
                                    <i class="fas fa-arrow-left me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-warning text-white px-4 fw-bold shadow-sm">
                                    <i class="fas fa-save me-2"></i>Update Data
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection