@extends('layouts.guest.app')
@section('title', 'Edit Data Kematian')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-primary shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Edit Data Kematian</h5>
                    </div>
                    <div class="card-body p-5">
                        <form action="{{ route('kematian.update', $kematian->kematian_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <div class="col-12">
                                    <label class="form-label fw-bold">Nama Almarhum</label>
                                    <select class="form-select" name="warga_id" required>
                                        @foreach($warga as $w)
                                            <option value="{{ $w->warga_id }}" {{ $kematian->warga_id == $w->warga_id ? 'selected' : '' }}>
                                                {{ $w->nama }} (NIK: {{ $w->no_ktp }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tanggal Meninggal</label>
                                    <input type="date" name="tgl_meninggal" class="form-control" value="{{ $kematian->tgl_meninggal }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Sebab</label>
                                    <input type="text" name="sebab" class="form-control" value="{{ $kematian->sebab }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Lokasi</label>
                                    <input type="text" name="lokasi" class="form-control" value="{{ $kematian->lokasi }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">No. Surat</label>
                                    <input type="text" name="no_surat" class="form-control" value="{{ $kematian->no_surat }}">
                                </div>

                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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