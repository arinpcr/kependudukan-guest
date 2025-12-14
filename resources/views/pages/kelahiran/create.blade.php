@extends('layouts.guest.app')
@section('title', 'Catat Kelahiran')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-baby me-2"></i>Formulir Kelahiran</h5>
                </div>
                <div class="card-body p-4">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                        </div>
                    @endif

                    <form action="{{ route('kelahiran.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="alert alert-info small">
                            <i class="fas fa-info-circle me-1"></i> Pastikan data <strong>Bayi</strong> sudah diinput ke Data Warga dulu.
                        </div>

                        {{-- BAGIAN 1: BAYI --}}
                        <h6 class="text-primary fw-bold mb-3 border-bottom pb-2">Data Bayi</h6>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Nama Bayi</label>
                            <select name="warga_id" class="form-select" required>
                                <option value="">-- Cari Nama Bayi --</option>
                                @foreach($warga_all as $w)
                                    <option value="{{ $w->warga_id }}">{{ $w->nama }} (NIK: {{ $w->no_ktp ?? '-' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">No. Akta (Opsional)</label>
                            <input type="text" name="no_akta" class="form-control">
                        </div>

                        {{-- BAGIAN 2: ORANG TUA --}}
                        <h6 class="text-primary fw-bold mb-3 border-bottom pb-2 mt-4">Data Orang Tua</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ayah</label>
                                <select name="ayah_warga_id" class="form-select">
                                    <option value="">-- Pilih Ayah --</option>
                                    @foreach($ayah_list as $a) <option value="{{ $a->warga_id }}">{{ $a->nama }}</option> @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ibu</label>
                                <select name="ibu_warga_id" class="form-select">
                                    <option value="">-- Pilih Ibu --</option>
                                    @foreach($ibu_list as $i) <option value="{{ $i->warga_id }}">{{ $i->nama }}</option> @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- UPLOAD --}}
                        <div class="p-3 bg-light border rounded mt-3">
                            <label class="form-label fw-bold text-primary"><i class="fas fa-paperclip"></i> Upload Bukti</label>
                            <input type="file" name="files[]" class="form-control" multiple>
                        </div>

                        <div class="mt-4 d-flex justify-content-between">
                            <a href="{{ route('kelahiran.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection