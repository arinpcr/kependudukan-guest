@extends('layouts.guest.auth')

@section('title', 'Daftar Akun - Sistem Kependudukan')

@section('styles')
<style>
    /* KONFIGURASI WARNA UTAMA */
    :root {
        --bs-primary: #ff4880;
        --bs-secondary: #ffb6c1;
        --bs-white: #ffffff;
        --bs-dark: #000000;
    }

    /* --- BACKGROUND GAMBAR --- */
    body {
        background: linear-gradient(135deg, rgba(255, 72, 128, 0.8), rgba(255, 198, 217, 0.9)),
                    url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
        
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        background-repeat: no-repeat;
        
        font-family: 'Montserrat', sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        padding: 20px;
        animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .register-container {
        width: 100%;
        max-width: 500px;
    }

    .register-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        border: none;
        transition: transform 0.3s ease;
        backdrop-filter: blur(5px);
    }

    .register-card:hover {
        transform: translateY(-5px);
    }

    .register-header {
        background: linear-gradient(135deg, var(--bs-primary), #ff2d6d);
        color: var(--bs-white);
        padding: 30px;
        text-align: center;
        position: relative;
    }

    .register-header::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50% 20% / 10% 40%;
    }

    .register-header h2 {
        margin: 0;
        font-weight: 600;
        font-family: 'Fredoka', sans-serif;
        font-size: 1.8rem;
        position: relative;
        z-index: 2;
    }

    /* [UBAH] Style untuk Logo di Header Register */
    .register-header img {
        height: 50px; /* Ukuran disamakan dengan header home */
        width: auto;
        margin-bottom: 10px;
        display: inline-block;
        position: relative;
        z-index: 2;
        object-fit: contain;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
    }

    .register-header small {
        font-weight: 300;
        position: relative;
        z-index: 2;
        opacity: 0.9;
    }

    .register-body {
        padding: 40px;
    }

    .form-floating {
        margin-bottom: 15px;
    }

    .form-control {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 16px;
        font-size: 15px;
        font-family: 'Montserrat', sans-serif;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
    }

    .form-control:focus {
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 0.2rem rgba(255, 72, 128, 0.25);
        background-color: #fff;
    }

    .form-label {
        color: #495057;
        font-weight: 500;
        font-family: 'Montserrat', sans-serif;
    }

    .btn-register {
        background: linear-gradient(135deg, var(--bs-primary), #ff2d6d);
        border: none;
        border-radius: 10px;
        padding: 16px;
        font-weight: 600;
        font-size: 16px;
        font-family: 'Montserrat', sans-serif;
        transition: all 0.5s ease;
        width: 100%;
        position: relative;
        overflow: hidden;
        margin-top: 10px;
        color: white;
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 72, 128, 0.4);
        background: linear-gradient(135deg, #ff2d6d, var(--bs-primary));
        color: white;
    }

    .register-links {
        text-align: center;
        margin-top: 25px;
    }

    .register-links a {
        color: #6c757d;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        font-family: 'Montserrat', sans-serif;
    }

    .register-links a:hover {
        color: var(--bs-primary);
        transform: translateX(2px);
    }

    .alert {
        border-radius: 10px;
        border: none;
        margin-bottom: 25px;
        font-family: 'Montserrat', sans-serif;
    }

    .alert-danger {
        background: rgba(255, 72, 128, 0.1);
        color: #dc3545;
        border: 1px solid rgba(255, 72, 128, 0.2);
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        color: #6c757d;
        text-decoration: none;
        margin-bottom: 25px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        font-family: 'Montserrat', sans-serif;
    }

    .back-link:hover {
        color: var(--bs-primary);
        transform: translateX(-3px);
    }

    .back-link i {
        margin-right: 8px;
        transition: transform 0.3s ease;
    }

    .btn-close {
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ff4880'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
    }

    .invalid-feedback {
        color: var(--bs-primary);
        font-weight: 500;
    }

    .text-primary {
        color: var(--bs-primary) !important;
    }
</style>
@endsection

@section('content')
<div class="register-container">
    <div class="register-card">
        <div class="register-header">
            {{-- [UBAH] Menggunakan Logo PNG ukuran 50px --}}
            <img src="{{ asset('assets-guest/img/logo2.png') }}" alt="Logo">

            <h2>Daftar Akun</h2>
            <small>Bergabung dengan Sistem Kependudukan</small>
        </div>

        <div class="register-body">
            <a href="{{ route('auth.login') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali ke Login
            </a>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Mohon periksa inputan Anda:</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('auth.register.post') }}" method="POST">
                @csrf

                <div class="form-floating">
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           name="name" id="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus>
                    <label for="name">
                        <i class="fas fa-user me-2 text-primary"></i>Nama Lengkap
                    </label>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating">
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" id="email" placeholder="name@example.com" value="{{ old('email') }}" required>
                    <label for="email">
                        <i class="fas fa-envelope me-2 text-primary"></i>Email Address
                    </label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating">
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           name="password" id="password" placeholder="Password" required>
                    <label for="password">
                        <i class="fas fa-lock me-2 text-primary"></i>Password (Min. 8)
                    </label>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating">
                    <input type="password" class="form-control"
                           name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password" required>
                    <label for="password_confirmation">
                        <i class="fas fa-lock me-2 text-primary"></i>Konfirmasi Password
                    </label>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                    <label class="form-check-label text-muted" for="terms">
                        Saya setuju dengan <a href="#" class="text-primary text-decoration-none">Syarat & Ketentuan</a>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-register">
                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                </button>
            </form>

            <div class="register-links">
                <a href="{{ route('auth.login') }}">
                    <i class="fas fa-sign-in-alt me-1"></i>Sudah punya akun? Login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto focus
        const nameInput = document.getElementById('name');
        if (nameInput) nameInput.focus();

        // Loading state
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mendaftarkan...';
                }
            });
        }
    });
</script>
@endsection