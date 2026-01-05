@extends('layouts.guest.app')
@section('title', 'Input Data Kematian')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        {{-- Header Judul --}}
        <div class="mx-auto text-center mb-5" style="max-width: 800px;">
            <h1 class="display-4">Input Data Kematian</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-primary">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Formulir Pencatatan Kematian</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('kematian.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                {{-- 1. Pilih Warga --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold">Pilih Warga (Almarhum/ah)</label>
                                    <select name="warga_id" class="form-select" required>
                                        <option value="">-- Pilih Nama Warga --</option>
                                        @foreach($warga as $w)
                                            <option value="{{ $w->warga_id }}">{{ $w->nama }} - (NIK: {{ $w->no_ktp }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- 2. Data Kematian --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tanggal Meninggal</label>
                                    <input type="date" name="tgl_meninggal" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Sebab Kematian</label>
                                    <input type="text" name="sebab" class="form-control" placeholder="Contoh: Sakit Tua" required>
                                </div>

                                {{-- 3. Lokasi & No Surat --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Lokasi Meninggal</label>
                                    <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Rumah Sakit / Rumah" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">No. Surat Kematian (Opsional)</label>
                                    <input type="text" name="no_surat" class="form-control" placeholder="Nomor Surat dari Desa/RS">
                                </div>

                                {{-- 4. Upload File --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold">Upload Bukti (Opsional)</label>
                                    <input type="file" name="files[]" class="form-control" multiple accept=".jpg,.jpeg,.png,.pdf">
                                    <small class="text-muted">Format: JPG, PNG, PDF. Max: 2MB.</small>
                                </div>

                                <div class="col-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan Data</button>
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