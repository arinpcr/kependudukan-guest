@extends('layouts.guest.app')
@section('content')
<div class="container py-5">
    <div class="card col-md-8 mx-auto">
        <div class="card-header bg-primary text-white">Input Data Kematian</div>
        <div class="card-body">
            <form action="{{ route('kematian.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Pilih Warga</label>
                    <select name="warga_id" class="form-select" required>
                        <option value="">-- Pilih Warga --</option>
                        @foreach($warga as $w)
                            <option value="{{ $w->warga_id }}">{{ $w->nama }} - {{ $w->no_ktp }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Tanggal Meninggal</label>
                    <input type="date" name="tgl_meninggal" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Sebab Kematian</label>
                    <input type="text" name="sebab_kematian" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Tempat Kematian</label>
                    <input type="text" name="tempat_kematian" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Simpan & Lanjut ke Upload</button>
            </form>
        </div>
    </div>
</div>
@endsection
