@extends('layouts.guest.app')
@section('title', 'Edit Data Kelahiran')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Manajemen Data</h4>
            <h1 class="mb-5 display-4">Edit Data Kelahiran</h1>
        </div>

        <div class="row justify-content-center wow fadeIn" data-wow-delay="0.3s">
            <div class="col-lg-8">
                <div class="card shadow-sm border-primary">
                    <div class="card-header bg-primary text-white d-flex align-items-center">
                        <i class="fas fa-edit me-2"></i>
                        <h5 class="mb-0 text-white">Formulir Perubahan Data</h5>
                    </div>
                    <div class="card-body p-5">

                        <a href="{{ route('kelahiran.index') }}" class="btn btn-secondary btn-sm mb-4">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                        </a>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                            </div>
                        @endif

                        <form action="{{ route('kelahiran.update', $kelahiran->kelahiran_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                
                                {{-- 1. DATA BAYI --}}
                                <div class="col-12 border-bottom pb-2 mb-2">
                                    <h6 class="text-primary fw-bold">Data Bayi</h6>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold">Nama Bayi</label>
                                    <select name="warga_id" class="form-select @error('warga_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Bayi --</option>
                                        @foreach($warga_all as $w)
                                            <option value="{{ $w->warga_id }}" {{ old('warga_id', $kelahiran->warga_id) == $w->warga_id ? 'selected' : '' }}>
                                                {{ $w->nama }} (NIK: {{ $w->no_ktp }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" class="form-control" value="{{ old('tgl_lahir', $kelahiran->tgl_lahir) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $kelahiran->tempat_lahir) }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Nomor Akta (Opsional)</label>
                                    <input type="text" name="no_akta" class="form-control" value="{{ old('no_akta', $kelahiran->no_akta) }}">
                                </div>

                                {{-- 2. DATA ORANG TUA --}}
                                <div class="col-12 border-bottom pb-2 mb-2 mt-3">
                                    <h6 class="text-primary fw-bold">Data Orang Tua</h6>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Nama Ayah</label>
                                    <select name="ayah_warga_id" class="form-select">
                                        <option value="">-- Pilih Ayah --</option>
                                        @foreach($ayah_list as $a)
                                            <option value="{{ $a->warga_id }}" {{ old('ayah_warga_id', $kelahiran->ayah_warga_id) == $a->warga_id ? 'selected' : '' }}>
                                                {{ $a->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Nama Ibu</label>
                                    <select name="ibu_warga_id" class="form-select">
                                        <option value="">-- Pilih Ibu --</option>
                                        @foreach($ibu_list as $i)
                                            <option value="{{ $i->warga_id }}" {{ old('ibu_warga_id', $kelahiran->ibu_warga_id) == $i->warga_id ? 'selected' : '' }}>
                                                {{ $i->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-2"></i>Simpan Perubahan</button>
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