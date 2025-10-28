@extends('layouts.guest.auth')

@section('title', 'Register - Sistem Kependudukan')

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

    .register-container {
        width: 100%;
        max-width: 500px;
    }

    .register-card {
        background: var(--bs-white);
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(255, 72, 128, 0.1);
        overflow: hidden;
        border: none;
        transition: transform 0.3s ease;
    }

    .register-card:hover {
        transform: translateY(-5px);
    }

    .register-header {
        background: linear-gradient(135deg, var(--bs-primary), #ff2d6d);
        color: var(--bs-white);
        padding: 40px 30px;
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
        font-size: 2rem;
        position: relative;
        z-index: 2;
    }

    .register-header i {
        font-size: 3rem;
        margin-bottom: 20px;
        display: block;
        position: relative;
        z-index: 2;
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
        margin-bottom: 20px;
    }

    .form-control {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 16px;
        font-size: 15px;
        font-family: 'Montserrat', sans-serif;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 0.2rem rgba(255, 72, 128, 0.25);
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
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 72, 128, 0.4);
        background: linear-gradient(135deg, #ff2d6d, var(--bs-primary));
    }

    .btn-register:active {
        transform: translateY(0);
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

    .alert-success {
        background: rgba(40, 167, 69, 0.1);
        color: #155724;
        border: 1px solid rgba(40, 167, 69, 0.2);
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

    .back-link:hover i {
        transform: translateX(-3px);
    }

    .btn-close {
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ff4880'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
    }

    .invalid-feedback {
        color: var(--bs-primary);
        font-weight: 500;
        font-size: 12px;
        margin-top: 5px;
    }

    .text-primary {
        color: var(--bs-primary) !important;
    }

    .password-strength {
        margin-top: 10px;
    }

    .progress {
        height: 6px;
        border-radius: 3px;
        background-color: #e9ecef;
    }

    .progress-bar {
        border-radius: 3px;
        transition: width 0.3s ease;
    }

    .toggle-password {
        cursor: pointer;
        z-index: 5;
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
    }

    .form-check-input:checked {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
    }

    .form-check-input:focus {
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 0.2rem rgba(255, 72, 128, 0.25);
    }

    .form-check-label {
        font-size: 14px;
        font-family: 'Montserrat', sans-serif;
    }

    .form-text {
        font-size: 12px;
        color: #6c757d;
    }
</style>
@endsection

@section('content')
<div class="register-container">
    <div class="register-card">
        <div class="register-header">
            <i class="fas fa-user-plus"></i>
            <h2>Daftar Akun</h2>
            <small>Sistem Kependudukan</small>
        </div>
        
        <div class="register-body">
            <!-- PERBAIKAN: Gunakan URL langsung ke dashboard -->
            <a href="{{ url('/dashboard') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show error-message" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Terjadi kesalahan!</strong>
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

            <form method="POST" action="{{ route('register.submit') }}" id="registerForm">
                @csrf
                
                <!-- Nama Lengkap -->
                <div class="form-floating">
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           placeholder="Nama Lengkap"
                           value="{{ old('name') }}"
                           required>
                    <label for="name">
                        <i class="fas fa-user me-2 text-primary"></i>Nama Lengkap
                    </label>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-floating">
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           placeholder="name@example.com"
                           value="{{ old('email') }}"
                           required>
                    <label for="email">
                        <i class="fas fa-envelope me-2 text-primary"></i>Alamat Email
                    </label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-floating position-relative">
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           placeholder="Password"
                           required
                           minlength="8">
                    <label for="password">
                        <i class="fas fa-lock me-2 text-primary"></i>Password
                    </label>
                    <span class="toggle-password">
                        <i class="fas fa-eye text-primary"></i>
                    </span>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">
                        Password minimal 8 karakter
                    </div>
                </div>

                <!-- Konfirmasi Password -->
                <div class="form-floating position-relative">
                    <input type="password" 
                           class="form-control @error('password_confirmation') is-invalid @enderror" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           placeholder="Konfirmasi Password"
                           required>
                    <label for="password_confirmation">
                        <i class="fas fa-lock me-2 text-primary"></i>Konfirmasi Password
                    </label>
                    <span class="toggle-password">
                        <i class="fas fa-eye text-primary"></i>
                    </span>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Strength Indicator -->
                <div class="password-strength">
                    <div class="progress">
                        <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                    </div>
                    <small class="text-muted" id="passwordStrengthText">Kekuatan password</small>
                </div>

                <!-- Terms and Conditions -->
                <div class="form-check mb-4">
                    <input class="form-check-input @error('terms') is-invalid @enderror" 
                           type="checkbox" 
                           id="terms" 
                           name="terms"
                           {{ old('terms') ? 'checked' : '' }}
                           required>
                    <label class="form-check-label" for="terms">
                        Saya menyetujui <a href="#" class="text-primary">Syarat & Ketentuan</a> dan <a href="#" class="text-primary">Kebijakan Privasi</a>
                    </label>
                    @error('terms')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-register" id="submitBtn">
                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                </button>
            </form>

            <div class="register-links">
                <p class="mb-2">Sudah punya akun?</p>
                <a href="{{ route('login') }}">
                    <i class="fas fa-sign-in-alt me-1"></i>Login di sini
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto focus on name field
        const nameInput = document.getElementById('name');
        if (nameInput) {
            nameInput.focus();
        }

        // Toggle password visibility
        const togglePasswordButtons = document.querySelectorAll('.toggle-password');
        
        togglePasswordButtons.forEach(button => {
            button.addEventListener('click', function() {
                const input = this.closest('.form-floating').querySelector('input');
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
        
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('passwordStrength');
        const strengthText = document.getElementById('passwordStrengthText');
        
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            let text = 'Kekuatan password';
            let color = 'bg-danger';
            
            // Check password length
            if (password.length >= 8) strength += 25;
            
            // Check for lowercase letters
            if (/[a-z]/.test(password)) strength += 25;
            
            // Check for uppercase letters
            if (/[A-Z]/.test(password)) strength += 25;
            
            // Check for numbers and special characters
            if (/[0-9]/.test(password)) strength += 15;
            if (/[^A-Za-z0-9]/.test(password)) strength += 10;
            
            // Update progress bar and text
            strengthBar.style.width = strength + '%';
            
            if (strength < 40) {
                color = 'bg-danger';
                text = 'Password lemah';
            } else if (strength < 70) {
                color = 'bg-warning';
                text = 'Password cukup';
            } else {
                color = 'bg-success';
                text = 'Password kuat';
            }
            
            strengthBar.className = 'progress-bar ' + color;
            strengthText.textContent = text;
            strengthText.className = strength < 40 ? 'text-danger' : strength < 70 ? 'text-warning' : 'text-success';
        });
        
        // Form validation
        const registerForm = document.getElementById('registerForm');
        const submitBtn = document.getElementById('submitBtn');
        
        registerForm.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const terms = document.getElementById('terms').checked;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Konfirmasi password tidak sesuai!');
                document.getElementById('password_confirmation').focus();
                return false;
            }
            
            if (!terms) {
                e.preventDefault();
                alert('Anda harus menyetujui syarat dan ketentuan!');
                return false;
            }
            
            // Disable submit button to prevent double submission
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mendaftarkan...';
        });
        
        // Real-time password confirmation check
        const confirmPasswordInput = document.getElementById('password_confirmation');
        
        confirmPasswordInput.addEventListener('input', function() {
            const password = passwordInput.value;
            const confirmPassword = this.value;
            
            if (confirmPassword && password !== confirmPassword) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            } else if (confirmPassword) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-invalid', 'is-valid');
            }
        });

        // Auto-dismiss alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });
</script>
@endsection