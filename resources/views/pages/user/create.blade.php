@extends('layouts.guest.app')

@section('title', 'Tambah User - Sistem Kependudukan')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Tambah Data</h4>
            <h1 class="mb-5 display-4">Formulir Tambah User</h1>
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

                    {{-- Form Biasa (Tanpa Enctype Multipart) --}}
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf

                        <div class="row g-4">

                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           name="name" id="name" value="{{ old('name') }}"
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
                                           name="email" id="email" value="{{ old('email') }}"
                                           placeholder="Email" required>
                                    <label for="email">
                                        <i class="fas fa-envelope me-2 text-primary"></i>Email
                                    </label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- === INPUT ROLE (FITUR UTAMA) === --}}
                            <div class="col-12">
                                <div class="form-floating">
                                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="" selected disabled>-- Pilih Role Pengguna --</option>
                                        <option value="Super Admin" {{ old('role') == 'Super Admin' ? 'selected' : '' }}>Super Admin</option>
                                        <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="User" {{ old('role') == 'User' ? 'selected' : '' }}>User</option>
                                    </select>
                                    <label for="role">
                                        <i class="fas fa-user-shield me-2 text-primary"></i>Role Pengguna
                                    </label>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- =============================== --}}

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                           name="password" id="password" placeholder="Password" required>
                                    <label for="password">
                                        <i class="fas fa-lock me-2 text-primary"></i>Password
                                    </label>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                           name="password_confirmation" id="password_confirmation"
                                           placeholder="Konfirmasi Password" required>
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
                                        <i class="fas fa-save me-2"></i>Simpan Data
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
        // Password validation logic
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');

        function validatePassword() {
            if (passwordInput.value !== confirmPasswordInput.value) {
                confirmPasswordInput.setCustomValidity('Password tidak cocok');
            } else {
                confirmPasswordInput.setCustomValidity('');
            }
        }

        if (passwordInput && confirmPasswordInput) {
            passwordInput.addEventListener('input', validatePassword);
            confirmPasswordInput.addEventListener('input', validatePassword);
        }

        // Loading state
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                }
            });
        }
    });
</script>
@endpush
