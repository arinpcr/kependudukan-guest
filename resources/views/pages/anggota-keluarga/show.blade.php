@extends('layouts.guest.app')

@section('title', 'Detail Kartu Keluarga - Sistem Kependudukan')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Detail KK</h4>
            <h1 class="mb-5 display-4">Detail Kartu Keluarga</h1>
        </div>

        <div class="row justify-content-center wow fadeIn" data-wow-delay="0.3s">
            <div class="col-lg-10">
                <div class="bg-light border border-primary rounded p-5">
                    
                    <a href="{{ route('keluarga.index') }}" class="btn btn-secondary btn-sm mb-4">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar KK
                    </a>

                    <!-- Card Layout -->
                    <div class="row g-4">
                        <!-- Info KK -->
                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-home me-2"></i>Informasi Kartu Keluarga
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Nomor KK:</strong> {{ $keluarga->kk_nomor }}</p>
                                            <p><strong>Kepala Keluarga:</strong> {{ $keluarga->kepalaKeluarga->nama ?? 'Tidak ditemukan' }}</p>
                                            <p><strong>No KTP Kepala:</strong> {{ $keluarga->kepalaKeluarga->no_ktp ?? '-' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Alamat:</strong> {{ $keluarga->alamat }}</p>
                                            <p><strong>RT/RW:</strong> {{ $keluarga->rt }}/{{ $keluarga->rw }}</p>
                                            <p><strong>Dibuat:</strong> {{ $keluarga->created_at->format('d-m-Y H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Daftar Anggota Keluarga -->
                        <div class="col-12">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <i class="fas fa-users me-2"></i>Anggota Keluarga
                                    </h5>
                                    <a href="{{ route('anggota-keluarga.index', $keluarga->kk_id) }}" class="btn btn-light btn-sm">
                                        <i class="fas fa-cog me-1"></i>Kelola Anggota
                                    </a>
                                </div>
                                <div class="card-body">
                                    @if($keluarga->anggotaKeluarga->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nama</th>
                                                        <th>No KTP</th>
                                                        <th>Jenis Kelamin</th>
                                                        <th>Hubungan</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($keluarga->anggotaKeluarga as $index => $anggota)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <strong>{{ $anggota->warga->nama ?? 'Data warga tidak ditemukan' }}</strong>
                                                            @if($anggota->hubungan == 'kepala_keluarga')
                                                                <span class="badge bg-warning text-dark ms-2">Kepala</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $anggota->warga->no_ktp ?? '-' }}</td>
                                                        <td>
                                                            @if(($anggota->warga->jenis_kelamin ?? '') == 'L')
                                                                <span class="badge bg-info">Laki-laki</span>
                                                            @elseif(($anggota->warga->jenis_kelamin ?? '') == 'P')
                                                                <span class="badge bg-pink">Perempuan</span>
                                                            @else
                                                                <span class="badge bg-secondary">-</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-primary">{{ $anggota->hubungan_label }}</span>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="{{ route('anggota-keluarga.show', ['keluarga' => $keluarga->kk_id, 'anggota' => $anggota->anggota_id]) }}" 
                                                                   class="btn btn-info" 
                                                                   data-bs-toggle="tooltip" 
                                                                   title="Detail">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-users fa-2x mb-3"></i>
                                                <h5>Belum ada anggota keluarga</h5>
                                                <p>Silakan tambah anggota keluarga.</p>
                                                <a href="{{ route('anggota-keluarga.create', $keluarga->kk_id) }}" class="btn btn-primary mt-2">
                                                    <i class="fas fa-user-plus me-2"></i>Tambah Anggota
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a href="{{ route('keluarga.edit', $keluarga->kk_id) }}" 
                                       class="btn btn-warning me-2">
                                        <i class="fas fa-edit me-2"></i>Edit KK
                                    </a>
                                    <a href="{{ route('anggota-keluarga.create', $keluarga->kk_id) }}" 
                                       class="btn btn-primary">
                                        <i class="fas fa-user-plus me-2"></i>Tambah Anggota
                                    </a>
                                </div>
                                
                                <form action="{{ route('keluarga.destroy', $keluarga->kk_id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus KK ini? Semua anggota juga akan terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash me-2"></i>Hapus KK
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush