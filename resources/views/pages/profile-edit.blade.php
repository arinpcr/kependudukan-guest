@extends('layouts.guest.app')

@section('title', 'Edit Profile - Sistem Kependudukan')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Pengaturan Akun</h4>
            <h1 class="mb-5 display-4">Edit Profile</h1>
        </div>

        <div class="row justify-content-center wow fadeIn" data-wow-delay="0.3s">
            <div class="col-lg-8">
                <div class="card border-primary shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>Form Perubahan Data</h5>
                        <a href="{{ route('profile') }}" class="btn btn-sm btn-light text-primary fw-bold">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                    
                    <div class="card-body p-4">
                        
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong><i class="fas fa-exclamation-triangle me-2"></i>Terjadi Kesalahan!</strong>
                                <ul class="mb-0 mt-2 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <div class="col-md-4 text-center">
                                    <label class="form-label fw-bold d-block mb-3">Foto Profile Saat Ini</label>
                                    
                                    <div class="position-relative d-inline-block mb-3">
                                        <img id="avatarPreview" 
                                             src="{{ $user->avatar_url }}" 
                                             alt="Preview" 
                                             class="rounded-circle img-thumbnail border-primary"
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                        
                                        <label for="avatarInput" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 shadow" style="cursor: pointer;">
                                            <i class="fas fa-camera fa-lg"></i>
                                        </label>
                                    </div>
                                    
                                    <div class="small text-muted mb-2">Klik ikon kamera untuk mengganti foto</div>
                                    
                                    <input type="file" name="avatar" id="avatarInput" class="d-none" accept="image/*" onchange="previewImage(event)">
                                </div>

                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-primary"><i class="fas fa-user"></i></span>
                                            <input type="text" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" 
                                                   name="name" 
                                                   value="{{ old('name', $user->name) }}" 
                                                   required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-bold">Alamat Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-primary"><i class="fas fa-envelope"></i></span>
                                            <input type="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email', $user->email) }}" 
                                                   required>
                                        </div>
                                        <div class="form-text">Email harus unik dan aktif.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Role / Jabatan</label>
                                        <input type="text" class="form-control bg-light" value="{{ $user->role }}" readonly disabled>
                                        <div class="form-text">Role tidak dapat diubah secara mandiri.</div>
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                        <a href="{{ route('profile') }}" class="btn btn-secondary px-4">Batal</a>
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


@push('scripts')
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('avatarPreview');
            output.src = reader.result;
        };
        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endpush