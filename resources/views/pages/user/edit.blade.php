@extends('layouts.guest.app')

@section('title', 'Edit User - Sistem Kependudukan')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Edit Data</h4>
            <h1 class="mb-5 display-4">Formulir Edit User</h1>
        </div>

        <div class="row justify-content-center wow fadeIn" data-wow-delay="0.3s">
            <div class="col-lg-8">
                <div class="bg-light border border-primary rounded p-5">
                    
                    <a href="{{ route('user.index') }}" class="btn btn-secondary btn-sm mb-4">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar User
                    </a>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-exclamation-triangle me-2"></i>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-check-circle me-2"></i>Sukses!</strong>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('user.update', $dataUser->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4">
                            <div class="col-12 text-center mb-4">
                                <div class="avatar-upload-container">
                                    <div class="avatar-preview mb-3">
                                        <img src="{{ $dataUser->avatar_url }}" 
                                             alt="Avatar {{ $dataUser->name }}" 
                                             class="rounded-circle shadow-sm"
                                             id="avatarPreview"
                                             style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #0d6efd;">
                                    </div>
                                    <div class="avatar-upload-controls">
                                        <input type="file" 
                                               name="avatar" 
                                               id="avatarInput" 
                                               class="d-none" 
                                               accept="image/jpg,image/jpeg,image/png">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('avatarInput').click()">
                                            <i class="fas fa-camera me-2"></i>Ubah Foto Profil
                                        </button>
                                        @if($dataUser->avatar)
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeAvatar()">
                                            <i class="fas fa-trash me-2"></i>Hapus Foto
                                        </button>
                                        @endif
                                        <small class="form-text text-muted d-block mt-2">
                                            Format: JPG, JPEG, PNG. Maksimal: 2MB
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           name="name" id="name" value="{{ old('name', $dataUser->name) }}" 
                                           placeholder="Nama User" required>
                                    <label for="name">
                                        <i class="fas fa-user me-2 text-primary"></i>Nama User
                                    </label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           name="email" id="email" value="{{ old('email', $dataUser->email) }}" 
                                           placeholder="Email" required>
                                    <label for="email">
                                        <i class="fas fa-envelope me-2 text-primary"></i>Email
                                    </label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="">-- Pilih Role --</option>
                                        <option value="Super Admin" {{ old('role', $dataUser->role) == 'Super Admin' ? 'selected' : '' }}>Super Admin</option>
                                        <option value="Admin" {{ old('role', $dataUser->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="User" {{ old('role', $dataUser->role) == 'User' ? 'selected' : '' }}>User</option>
                                    </select>
                                    <label for="role">
                                        <i class="fas fa-user-shield me-2 text-primary"></i>Role Pengguna
                                    </label>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           name="password" id="password" placeholder="Password Baru">
                                    <label for="password">
                                        <i class="fas fa-lock me-2 text-primary"></i>Password Baru
                                    </label>
                                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                           name="password_confirmation" id="password_confirmation" 
                                           placeholder="Konfirmasi Password">
                                    <label for="password_confirmation">
                                        <i class="fas fa-lock me-2 text-primary"></i>Konfirmasi Password
                                    </label>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('user.index') }}" class="btn btn-secondary me-md-2 px-4">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fas fa-save me-2"></i>Update Data
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
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Avatar preview
        const avatarInput = document.getElementById('avatarInput');
        const avatarPreview = document.getElementById('avatarPreview');

        if (avatarInput && avatarPreview) {
            avatarInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        avatarPreview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        // Password confirmation validation
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        
        function validatePassword() {
            if (passwordInput.value !== confirmPasswordInput.value) {
                confirmPasswordInput.setCustomValidity('Password tidak cocok');
                showToast('Password dan konfirmasi password tidak cocok');
            } else {
                confirmPasswordInput.setCustomValidity('');
            }
        }
        
        if (passwordInput && confirmPasswordInput) {
            passwordInput.addEventListener('input', validatePassword);
            confirmPasswordInput.addEventListener('input', validatePassword);
        }

        // Form submission loading state
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengupdate...';
                }
            });
        }
    });

    function removeAvatar() {
        if (confirm('Apakah Anda yakin ingin menghapus foto profil?')) {
            const avatarPreview = document.getElementById('avatarPreview');
            const avatarInput = document.getElementById('avatarInput');
            
            // Reset to default avatar
            avatarPreview.src = "{{ asset('img/default-avatar.jpg') }}";
            avatarInput.value = '';
            
            // Add hidden input to indicate avatar removal
            let removeInput = document.getElementById('removeAvatar');
            if (!removeInput) {
                removeInput = document.createElement('input');
                removeInput.type = 'hidden';
                removeInput.name = 'remove_avatar';
                removeInput.value = '1';
                removeInput.id = 'removeAvatar';
                document.querySelector('form').appendChild(removeInput);
            }
            
            showToast('Foto profil akan dihapus setelah update');
        }
    }

    function showToast(message) {
        const toast = new bootstrap.Toast(document.getElementById('errorToast'));
        document.getElementById('toastMessage').textContent = message;
        toast.show();
    }
</script>

<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="errorToast" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-exclamation-circle me-2"></i>
                <span id="toastMessage"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endpush