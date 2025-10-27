@extends('layouts.auth')

@section('title', 'Login Berhasil - Sistem Kependudukan')

@section('styles')
<style>
    :root {
        --bs-primary: #ff4880;
        --bs-secondary: #ffb6c1;
        --bs-white: #ffffff;
        --bs-dark: #000000;
    }

    body {
        background: linear-gradient(135deg, #ffe6f0, #ffc6d9);
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

    .success-container {
        width: 100%;
        max-width: 450px;
    }

    .success-card {
        background: var(--bs-white);
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(255, 72, 128, 0.1);
        overflow: hidden;
        border: none;
        transition: transform 0.3s ease;
    }

    .success-card:hover {
        transform: translateY(-5px);
    }

    .success-header {
        background: linear-gradient(135deg, var(--bs-primary), #ff2d6d);
        color: var(--bs-white);
        padding: 40px 30px;
        text-align: center;
        position: relative;
    }

    .success-header::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50% 20% / 10% 40%;
    }

    .success-header h2 {
        margin: 0;
        font-weight: 600;
        font-family: 'Fredoka', sans-serif;
        font-size: 2rem;
        position: relative;
        z-index: 2;
    }

    .success-header i {
        font-size: 3rem;
        margin-bottom: 20px;
        display: block;
        position: relative;
        z-index: 2;
    }

    .success-header small {
        font-weight: 300;
        position: relative;
        z-index: 2;
        opacity: 0.9;
    }

    .success-body {
        padding: 40px;
        text-align: center;
    }

    .success-icon {
        font-size: 4rem;
        color: var(--bs-primary);
        margin-bottom: 20px;
        animation: bounce 1s ease-in-out;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-20px);
        }
        60% {
            transform: translateY(-10px);
        }
    }

    .welcome-text {
        font-size: 1.2rem;
        color: #495057;
        margin-bottom: 10px;
        font-weight: 500;
    }

    .username {
        color: var(--bs-primary);
        font-weight: 700;
        font-size: 1.4rem;
        font-family: 'Fredoka', sans-serif;
        margin-bottom: 25px;
        display: block;
    }

    .btn-success {
        background: linear-gradient(135deg, var(--bs-primary), #ff2d6d);
        border: none;
        border-radius: 12px;
        padding: 15px 30px;
        font-weight: 600;
        font-size: 16px;
        font-family: 'Montserrat', sans-serif;
        transition: all 0.5s ease;
        text-decoration: none;
        color: var(--bs-white);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .btn-success:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(255, 72, 128, 0.4);
        background: linear-gradient(135deg, #ff2d6d, var(--bs-primary));
        color: var(--bs-white);
    }

    .btn-success:active {
        transform: translateY(-1px);
    }

    .additional-info {
        margin-top: 20px;
        color: #6c757d;
        font-size: 0.9rem;
    }

    /* Button styles matching your CSS */
    .btn {
        font-weight: 600;
        transition: .5s;
    }

    .btn.btn-primary {
        border: 0;
        color: var(--bs-white);
    }

    .btn.btn-primary:hover {
        background: var(--bs-secondary);
        color: var(--bs-primary);
    }
</style>
@endsection

@section('content')
<div class="success-container">
    <div class="success-card">
        <div class="success-header">
            <i class="fas fa-check-circle"></i>
            <h2>Login Berhasil!</h2>
            <small>Sistem Kependudukan</small>
        </div>
        
        <div class="success-body">
            <div class="success-icon">
                <i class="fas fa-party-horn"></i>
            </div>
            
            <div class="welcome-text">Selamat datang</div>
            <span class="username">{{ $username }}</span>
            
            <p class="text-muted mb-4">
                Anda telah berhasil login ke sistem kependudukan. 
                Silakan lanjut ke dashboard untuk mengelola data.
            </p>

            <a href="{{ url('/dashboard') }}" class="btn btn-success">
                <i class="fas fa-tachometer-alt me-2"></i>Lanjut ke Dashboard
            </a>

            <div class="additional-info">
                <small>
                    <i class="fas fa-clock me-1"></i>
                    Login berhasil: {{ now()->format('d/m/Y H:i') }}
                </small>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto redirect after 5 seconds
        setTimeout(() => {
            window.location.href = "{{ url('/dashboard-guest') }}";
        }, 5000);
        
        // Add click event for manual redirect
        const redirectBtn = document.querySelector('.btn-success');
        if (redirectBtn) {
            redirectBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengalihkan...';
                this.disabled = true;
                
                setTimeout(() => {
                    window.location.href = this.href;
                }, 1000);
            });
        }

        // Celebration effect
        const successIcon = document.querySelector('.success-icon');
        if (successIcon) {
            setTimeout(() => {
                successIcon.style.transform = 'scale(1.1)';
                successIcon.style.color = '#ff2d6d';
                setTimeout(() => {
                    successIcon.style.transform = 'scale(1)';
                    successIcon.style.color = 'var(--bs-primary)';
                }, 300);
            }, 1000);
        }
    });
</script>
@endsection