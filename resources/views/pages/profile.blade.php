@extends('layouts.guest.app')

@section('title', 'Profile Saya - Sistem Kependudukan')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Akun Saya</h4>
            <h1 class="mb-5 display-4">Profile Pengguna</h1>
        </div>

        <div class="row g-4 justify-content-center">
            
            <div class="col-lg-4 col-md-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="card border-primary shadow-sm h-100 text-center p-4">
                    <div class="card-body">
                        <div class="position-relative d-inline-block mb-4">
                            @if($user->avatar)
                                <img src="{{ $user->avatar_url }}" 
                                     alt="{{ $user->name }}" 
                                     class="rounded-circle img-thumbnail border-primary p-1"
                                     style="width: 180px; height: 180px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto border border-primary p-1" 
                                     style="width: 180px; height: 180px;">
                                    <i class="fas fa-user fa-5x text-primary"></i>
                                </div>
                            @endif
                            
                            <div class="position-absolute bottom-0 start-50 translate-middle-x">
                                @if($user->role == 'Super Admin')
                                    <span class="badge bg-danger rounded-pill px-3 py-2 shadow">
                                        <i class="fas fa-crown me-1"></i> Super Admin
                                    </span>
                                @elseif($user->role == 'Admin')
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2 shadow">
                                        <i class="fas fa-user-shield me-1"></i> Admin
                                    </span>
                                @else
                                    <span class="badge bg-info text-dark rounded-pill px-3 py-2 shadow">
                                        <i class="fas fa-user me-1"></i> User
                                    </span>
                                @endif
                            </div>
                        </div>

                        <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
                        <p class="text-muted mb-4">{{ $user->email }}</p>

                        <div class="d-grid gap-2">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary rounded-pill">
    <i class="fas fa-edit me-2"></i>Edit Profile
</a>
                            <a href="{{ route('profile.password') }}" class="btn btn-outline-secondary rounded-pill">
    <i class="fas fa-key me-2"></i>Ganti Password
</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-md-7 wow fadeInUp" data-wow-delay="0.3s">
                <div class="card border-primary shadow-sm h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Detail</h5>
                    </div>
                    <div class="card-body p-4">
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="small text-muted text-uppercase fw-bold">Nama Lengkap</label>
                                    <div class="fs-5 text-dark border-bottom pb-2">
                                        <i class="fas fa-user me-2 text-primary"></i> {{ $user->name }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="small text-muted text-uppercase fw-bold">Alamat Email</label>
                                    <div class="fs-5 text-dark border-bottom pb-2">
                                        <i class="fas fa-envelope me-2 text-primary"></i> {{ $user->email }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="small text-muted text-uppercase fw-bold">Role / Jabatan</label>
                                    <div class="fs-5 text-dark border-bottom pb-2">
                                        <i class="fas fa-id-card me-2 text-primary"></i> {{ $user->role }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="small text-muted text-uppercase fw-bold">Status Akun</label>
                                    <div class="fs-5 text-dark border-bottom pb-2">
                                        <i class="fas fa-check-circle me-2 text-success"></i> Aktif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="small text-muted text-uppercase fw-bold">Bergabung Sejak</label>
                                    <div class="fs-5 text-dark border-bottom pb-2">
                                        <i class="fas fa-calendar-alt me-2 text-primary"></i> 
                                        {{ \Carbon\Carbon::parse($user->created_at)->format('d F Y') }}
                                    </div>
                                    <small class="text-muted fst-italic">
                                        ({{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }})
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="small text-muted text-uppercase fw-bold">Terakhir Diperbarui</label>
                                    <div class="fs-5 text-dark border-bottom pb-2">
                                        <i class="fas fa-clock me-2 text-primary"></i> 
                                        {{ \Carbon\Carbon::parse($user->updated_at)->format('d F Y') }}
                                    </div>
                                    <small class="text-muted fst-italic">
                                        ({{ \Carbon\Carbon::parse($user->updated_at)->diffForHumans() }})
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mt-4 mb-0 d-flex align-items-center" role="alert">
                            <i class="fas fa-shield-alt fa-2x me-3"></i>
                            <div>
                                <strong>Keamanan Akun</strong>
                                <br>
                                <small>Jangan pernah membagikan password Anda kepada siapa pun. Admin desa tidak akan pernah meminta password Anda.</small>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .title-border-radius {
        border-radius: 10px;
    }
    .img-thumbnail {
        border-width: 3px;
    }
</style>
@endpush