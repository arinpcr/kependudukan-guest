@extends('layouts.guest.auth')

@section('title', 'Login Guest - Sistem Kependudukan')

@section('styles')
<style>
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

    .login-container {
        width: 100%;
        max-width: 450px;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        border: none;
        transition: transform 0.3s ease;
        backdrop-filter: blur(5px);
    }

    .login-card:hover {
        transform: translateY(-5px);
    }

    .login-header {
        background: linear-gradient(135deg, var(--bs-primary), #ff2d6d);
        color: var(--bs-white);
        padding: 40px 30px;
        text-align: center;
        position: relative;
    }

    .login-header::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50% 20% / 10% 40%;
    }

    .login-header h2 {
        margin: 0;
        font-weight: 600;
        font-family: 'Fredoka', sans-serif;
        font-size: 2rem;
        position: relative;
        z-index: 2;
    }

    /* [UBAH] Style untuk Logo di Header Login */
    .login-header img {
        height: 50px; /* Ukuran disamakan dengan header home */
        width: auto;
        margin-bottom: 20px;
        display: inline-block; /* Agar bisa di-center text-align */
        position: relative;
        z-index: 2;
        object-fit: contain;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1)); /* Sedikit bayangan agar pop-up */
    }

    .login-header small {
        font-weight: 300;
        position: relative;
        z-index: 2;
        opacity: 0.9;
    }

    .login-body {
        padding: 40px;
    }

    .form-floating {
        margin-bottom: 25px;
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

    .btn-login {
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
        color: white;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 72, 128, 0.4);
        background: linear-gradient(135deg, #ff2d6d, var(--bs-primary));
        color: white;
    }

    .btn-login:active {
        transform: translateY(0);
    }

    .login-links {
        text-align: center;
        margin-top: 25px;
    }

    .login-links a {
        color: #6c757d;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        font-family: 'Montserrat', sans-serif;
    }

    .login-links a:hover {
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

    .error-message {
        animation: shake 0.5s ease-in-out;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        50% { transform: translateX(5px); }
        75% { transform: translateX(-5px); }
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

    .register-section {
        text-align: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }

    .register-section p {
        margin-bottom: 15px;
        color: #6c757d;
        font-size: 15px;
    }

    .register-link {
        color: var(--bs-primary) !important;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
    }

    .register-link:hover {
        color: #ff2d6d !important;
        transform: translateY(-2px);
    }

    .register-link i {
        margin-right: 8px;
        transition: transform 0.3s ease;
    }

    .register-link:hover i {
        transform: translateX(3px);
    }
</style>
@endsection

@section('content')
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            {{-- [UBAH] Menggunakan Logo PNG ukuran 50px --}}
            <img src="{{ asset('assets-guest/img/logo2.png') }}" alt="Logo">
            
            <h2>Login</h2>
            <small>Sistem Kependudukan</small>
        </div>

        <div class="login-body">
            <a href="{{ url('/') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show error-message" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>{{ session('error') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show error-message" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2" style="padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('auth.login.post') }}" method="POST">
                @csrf

                <div class="form-floating">
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" id="email" value="{{ old('email') }}"
                           placeholder="name@example.com" required autofocus>
                    <label for="email">
                        <i class="fas fa-envelope me-2 text-primary"></i>Email
                    </label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

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

                <button type="submit" class="btn btn-primary btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Login Masuk
                </button>
            </form>

            <div class="login-links">
                <a href="#">
                    <i class="fas fa-key me-1"></i>Lupa Password?
                </a>
            </div>

            <div class="register-section">
                <p>Belum punya akun?</p>
                <a href="{{ route('auth.register') }}" class="register-link">
                    <i class="fas fa-user-plus me-1"></i>Daftar Akun Baru di sini
                </a>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto focus on email field
        const emailInput = document.getElementById('email');
        if (emailInput) {
            emailInput.focus();
        }

        // Form submission loading state
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                }
            });
        }

        // Auto-dismiss alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });

        // Show success message from register redirect
        @if(session('success'))
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(successAlert);
                    bsAlert.close();
                }, 5000);
            }
        @endif
    });
</script>
@endsection