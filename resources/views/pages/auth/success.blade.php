@extends('layouts.guest.auth') {{-- Gunakan layout auth agar konsisten --}}
@section('title', 'Berhasil - Sistem Kependudukan')

@section('content')
<div class="auth-page-wrapper" id="auth-success-wrapper">
    <div class="auth-card text-center">
        <div class="auth-header">
            <i class="fas fa-check-circle"></i>
            <h2>Berhasil!</h2>
            <small>Sistem Kependudukan</small>
        </div>
        
        <div class="auth-body">
            <div class="success-bounce-icon mb-4">
                <i class="fas fa-grin-beam"></i>
            </div>
            
            <h4 class="fw-bold mb-1">Selamat Datang,</h4>
            <h3 class="text-primary fw-bold mb-4" style="font-family: 'Fredoka';">{{ $username ?? 'User' }}</h3>
            
            <p class="text-muted mb-4">
                Login berhasil! Anda akan dialihkan ke dashboard dalam beberapa detik.
            </p>

            <a href="{{ url('/dashboard-guest') }}" class="btn-auth-submit text-decoration-none">
                <i class="fas fa-tachometer-alt me-2"></i>Ke Dashboard Sekarang
            </a>

            <div class="mt-4 small text-muted">
                <i class="fas fa-clock me-1"></i> {{ now()->format('d M Y, H:i') }}
            </div>
        </div>
    </div>
</div>

<script>
    // Auto redirect
    setTimeout(() => {
        window.location.href = "{{ url('/dashboard-guest') }}";
    }, 4000);
</script>
@endsection