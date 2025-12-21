@extends('layouts.guest.auth')
@section('title', 'Login - Sistem Kependudukan')

@section('content')
<div class="auth-page-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <img src="{{ asset('assets-guest/img/logo2.png') }}" alt="Logo">
            <h2>Login</h2>
            <small>Sistem Kependudukan</small>
        </div>

        <div class="auth-body">
            <a href="{{ url('/') }}" class="back-link">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
            </a>

            @if(session('error') || $errors->any())
                <div class="alert alert-danger alert-dismissible fade show error-shake" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('error') ?? 'Periksa kembali email dan password Anda.' }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('auth.login.post') }}" method="POST">
                @csrf
                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control auth-form-control" id="email" placeholder="name@example.com" required autofocus>
                    <label for="email"><i class="fas fa-envelope me-2 text-primary"></i>Email</label>
                </div>

                <div class="form-floating mb-4">
                    <input type="password" name="password" class="form-control auth-form-control" id="password" placeholder="Password" required>
                    <label for="password"><i class="fas fa-lock me-2 text-primary"></i>Password</label>
                </div>

                <button type="submit" class="btn-auth-submit mb-3">
                    <i class="fas fa-sign-in-alt me-2"></i>Login Masuk
                </button>
            </form>

            <div class="text-center">
                <a href="#" class="text-muted small text-decoration-none">Lupa Password?</a>
            </div>

            <div class="register-section">
                <p class="text-muted small">Belum punya akun?</p>
                <a href="{{ route('auth.register') }}" class="text-primary fw-bold text-decoration-none">
                    <i class="fas fa-user-plus me-1"></i>Daftar Akun Baru
                </a>
            </div>
        </div>
    </div>
</div>
@endsection