@extends('layouts.guest.app')

@section('content')
<div class="container py-5">
    
    {{-- BAGIAN 1: INFORMASI DATA --}}
    <div class="card mb-4 border-primary">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Peristiwa Kematian</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama:</strong> {{ $kematian->warga->nama ?? '-' }}</p>
                    <p><strong>NIK:</strong> {{ $kematian->warga->nik ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tanggal Meninggal:</strong> {{ $kematian->tgl_meninggal }}</p>
                    <p><strong>Sebab:</strong> {{ $kematian->sebab_kematian }}</p>
                    <p><strong>Tempat:</strong> {{ $kematian->tempat_kematian }}</p>
                </div>
            </div>
            <a href="{{ route('kematian.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
    </div>

    {{-- BAGIAN 2: FORM UPLOAD MULTIPLE FILE (MODUL) --}}
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fas fa-paperclip me-2"></i>File Pendukung (Bukti)</h5>
        </div>
        <div class="card-body">
            
            {{-- Form Upload --}}
            <form action="{{ route('kematian.upload') }}" method="POST" enctype="multipart/form-data" class="row g-3 align-items-end border p-3 rounded bg-light mb-4">
                @csrf
                
                {{-- INPUT HIDDEN PENTING (SESUAI MODUL) --}}
                <input type="hidden" name="ref_table" value="peristiwa_kematian">
                <input type="hidden" name="ref_id" value="{{ $kematian->kematian_id }}">

                <div class="col-md-5">
                    <label class="form-label fw-bold">Pilih File (Bisa Banyak)</label>
                    <input type="file" name="files[]" class="form-control" multiple required>
                    <small class="text-muted">JPG, PNG, PDF (Max 2MB)</small>
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-bold">Keterangan File</label>
                    <input type="text" name="caption" class="form-control" placeholder="Contoh: Surat Dokter">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-upload"></i> Upload
                    </button>
                </div>
            </form>

            <hr>

            {{-- List File yang Sudah Diupload --}}
            <h6 class="mb-3">Daftar Dokumen Tersimpan:</h6>
            <div class="row">
                @forelse($documents as $doc)
                <div class="col-md-3 mb-3">
                    <div class="card h-100">
                        {{-- Preview Gambar/Icon --}}
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 150px; overflow:hidden;">
                            @if(str_contains($doc->mime_type, 'image'))
                                <img src="{{ asset('storage/uploads/'.$doc->file_name) }}" class="img-fluid" alt="preview">
                            @else
                                <i class="fas fa-file-pdf fa-4x text-danger"></i>
                            @endif
                        </div>
                        
                        <div class="card-body p-2 text-center">
                            <small class="fw-bold d-block text-truncate">{{ $doc->caption }}</small>
                            <small class="text-muted" style="font-size: 10px;">{{ $doc->file_name }}</small>
                            
                            <div class="mt-2 btn-group w-100">
                                <a href="{{ asset('storage/uploads/'.$doc->file_name) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download"></i>
                                </a>
                                
                                {{-- Tombol Hapus --}}
                                <form action="{{ route('media.delete', $doc->media_id) }}" method="POST" onsubmit="return confirm('Hapus file ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-4">
                    <p class="text-muted">Belum ada file pendukung yang diupload.</p>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
@endsection