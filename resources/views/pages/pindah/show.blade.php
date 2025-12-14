@extends('layouts.guest.app')
@section('title', 'Detail Perpindahan')

@section('content')
<div class="container py-5">

    {{-- DETAIL DATA --}}
    <div class="card mb-4 border-primary shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Detail Data Perpindahan</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr><td width="150" class="fw-bold text-muted">Nama Warga</td><td class="fw-bold">: {{ $pindah->warga->nama ?? '-' }}</td></tr>
                        <tr><td class="fw-bold text-muted">NIK</td><td>: {{ $pindah->warga->no_ktp ?? '-' }}</td></tr>
                        <tr><td class="fw-bold text-muted">Tanggal Pindah</td><td class="text-danger fw-bold">: {{ \Carbon\Carbon::parse($pindah->tgl_pindah)->format('d F Y') }}</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr><td width="150" class="fw-bold text-muted">Alamat Tujuan</td><td>: {{ $pindah->alamat_tujuan }}</td></tr>
                        <tr><td class="fw-bold text-muted">Alasan / Ket</td><td>: {{ $pindah->alasan ?? '-' }}</td></tr>
                        <tr><td class="fw-bold text-muted">Nomor Surat</td><td>: {{ $pindah->no_surat ?? '-' }}</td></tr>
                    </table>
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ route('pindah.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
            </div>
        </div>
    </div>

    {{-- UPLOAD FILE BARU --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light border-bottom">
            <h5 class="mb-0 text-primary"><i class="fas fa-paperclip me-2"></i>Dokumen Pendukung</h5>
        </div>
        <div class="card-body">

            <form action="{{ route('pindah.upload') }}" method="POST" enctype="multipart/form-data" class="row g-3 align-items-end border p-4 rounded bg-light mb-5">
                @csrf
                <input type="hidden" name="ref_id" value="{{ $pindah->pindah_id }}">

                <div class="col-md-5">
                    <label class="form-label fw-bold">Pilih File</label>
                    <input type="file" name="files[]" class="form-control" multiple required>
                    <small class="text-muted">Format: JPG, PNG, PDF (Max 2MB)</small>
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-bold">Keterangan</label>
                    <input type="text" name="caption" class="form-control" placeholder="Contoh: Surat Pengantar RT">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100 h-100"><i class="fas fa-upload me-2"></i> Upload</button>
                </div>
            </form>

            {{-- LIST DOKUMEN --}}
            <h6 class="mb-3 border-bottom pb-2 fw-bold text-primary">Daftar Dokumen Tersimpan:</h6>

            <div class="row g-4">
                @forelse($documents as $doc)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0 overflow-hidden" style="border-radius: 12px;">
                        
                        {{-- Preview File --}}
                        <div class="card-img-top d-flex flex-column justify-content-center align-items-center p-3"
                             style="height: 180px; background-color: #ffeef0;">
                            
                            @if(str_contains($doc->mime_type, 'image'))
                                <img src="{{ asset('storage/uploads/' . $doc->file_name) }}"
                                     alt="{{ $doc->caption }}"
                                     class="img-fluid rounded shadow-sm"
                                     style="max-height: 150px; object-fit: cover;">
                            @else
                                <i class="fas fa-file-pdf fa-4x text-danger mb-3"></i>
                                <span class="badge bg-danger rounded-pill px-3 py-2">Dokumen PDF</span>
                            @endif
                        </div>

                        {{-- Footer Card --}}
                        <div class="card-body p-3 text-center bg-white border-top">
                            <h6 class="fw-bold text-dark mb-1 text-truncate" title="{{ $doc->caption }}">
                                {{ $doc->caption ?? 'Tanpa Judul' }}
                            </h6>
                            <small class="text-muted d-block text-truncate mb-3" style="font-size: 0.8rem;">
                                {{ $doc->file_name }}
                            </small>

                            <div class="btn-group w-100 shadow-sm" role="group">
                                <a href="{{ asset('storage/uploads/' . $doc->file_name) }}" target="_blank" class="btn btn-outline-danger flex-grow-1 fw-bold">
                                    <i class="fas fa-eye me-2"></i>Lihat
                                </a>
                                
                                {{-- Tombol Delete Panggil Route Media Global --}}
                                <form action="{{ route('media.delete', $doc->media_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus file ini permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger rounded-0 rounded-end px-3" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                {{-- TAMPILAN JIKA KOSONG (PINK BOX) --}}
                <div class="col-12">
                    <div class="text-center py-5 rounded-3 d-flex flex-column align-items-center justify-content-center"
                         style="background-color: #ffeef0; border: 2px dashed #fadce0; min-height: 200px;">
                        <i class="fas fa-folder-open fa-5x mb-4" style="color: #6c757d; opacity: 0.5;"></i>
                        <h6 class="text-muted fw-bold mb-0" style="color: #6c757d;">Belum ada dokumen pendukung yang diupload.</h6>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection