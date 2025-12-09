@extends('layouts.guest.app')

@section('title', 'Edit Data Kematian')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Manajemen Data</h4>
            <h1 class="mb-5 display-4">Edit Data Kematian</h1>
        </div>

        <div class="row justify-content-center wow fadeIn" data-wow-delay="0.3s">
            <div class="col-lg-8">
                <div class="card border-primary shadow-sm">
                    <div class="card-header bg-primary text-white p-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white"><i class="fas fa-edit me-2"></i>Formulir Perubahan Data</h5>
                    </div>
                    <div class="card-body p-5">

                        {{-- Tombol Kembali --}}
                        <a href="{{ route('kematian.index') }}" class="btn btn-secondary btn-sm mb-4">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                        </a>

                        {{-- Perhatikan route menggunakan ID dari Primary Key (kematian_id) --}}
                        <form action="{{ route('kematian.update', $kematian->kematian_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                {{-- Pilih Warga --}}
                                <div class="col-12">
                                    <div class="form-floating">
                                        <select class="form-select @error('warga_id') is-invalid @enderror" id="warga_id" name="warga_id" required>
                                            <option value="">-- Pilih Warga --</option>
                                            @foreach($warga as $w)
                                                <option value="{{ $w->warga_id }}"
                                                    {{ (old('warga_id', $kematian->warga_id) == $w->warga_id) ? 'selected' : '' }}>
                                                    {{ $w->nama }} (NIK: {{ $w->no_ktp }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="warga_id">Nama Almarhum/Almarhumah</label>
                                        @error('warga_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Tanggal Meninggal --}}
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control @error('tgl_meninggal') is-invalid @enderror"
                                               name="tgl_meninggal" id="tgl_meninggal"
                                               value="{{ old('tgl_meninggal', $kematian->tgl_meninggal) }}" required>
                                        <label for="tgl_meninggal">Tanggal Meninggal</label>
                                        @error('tgl_meninggal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Tempat Kematian --}}
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('tempat_kematian') is-invalid @enderror"
                                               name="tempat_kematian" id="tempat_kematian"
                                               value="{{ old('tempat_kematian', $kematian->tempat_kematian) }}"
                                               placeholder="Contoh: RSUD, Rumah" required>
                                        <label for="tempat_kematian">Tempat Kematian</label>
                                        @error('tempat_kematian')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Sebab Kematian --}}
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('sebab_kematian') is-invalid @enderror"
                                               name="sebab_kematian" id="sebab_kematian"
                                               value="{{ old('sebab_kematian', $kematian->sebab_kematian) }}"
                                               placeholder="Sebab" required>
                                        <label for="sebab_kematian">Penyebab Kematian</label>
                                        @error('sebab_kematian')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Keterangan --}}
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                                  name="keterangan" id="keterangan" style="height: 100px"
                                                  placeholder="Keterangan Tambahan">{{ old('keterangan', $kematian->keterangan) }}</textarea>
                                        <label for="keterangan">Keterangan (Opsional)</label>
                                        @error('keterangan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Tombol Simpan --}}
                                <div class="col-12">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="fas fa-save me-2"></i>Simpan Perubahan
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
</div>
@endsection
