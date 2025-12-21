@extends('layouts.guest.app')

@section('title', 'Ganti Password - Sistem Kependudukan')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Keamanan Akun</h4>
            <h1 class="mb-5 display-4">Ganti Password</h1>
        </div>

        <div class="row justify-content-center wow fadeIn" data-wow-delay="0.3s">
            <div class="col-lg-6 col-md-8">
                <div class="card border-primary shadow-sm">
                    <div class="card-header bg-primary text-white p-4 text-center">
                        <i class="fas fa-lock fa-3x mb-2"></i>
                        <h5 class="mb-0 text-white">Formulir Perubahan Password</h5>
                    </div>
                    <div class="card-body p-5">

                        <a href="{{ route('profile') }}" class="btn btn-sm btn-outline-secondary mb-4">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Profile
                        </a>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong><i class="fas fa-exclamation-triangle me-2"></i>Terjadi Kesalahan:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('profile.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-floating mb-4 position-relative">
                                <input type="password" class="form-control password-input @error('current_password') is-invalid @enderror" 
                                       id="current_password" name="current_password" placeholder="Password Saat Ini" required>
                                <label for="current_password">
                                    <i class="fas fa-key me-2 text-primary"></i>Password Saat Ini
                                </label>
                                <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer toggle-password" 
                                      onclick="togglePassword('current_password', this)">
                                    <i class="fas fa-eye text-muted"></i>
                                </span>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4 text-muted">

                            <div class="form-floating mb-3 position-relative">
                                <input type="password" class="form-control password-input @error('password') is-invalid @enderror" 
                                       id="password" name="password" placeholder="Password Baru" required>
                                <label for="password">
                                    <i class="fas fa-lock me-2 text-primary"></i>Password Baru
                                </label>
                                <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer toggle-password" 
                                      onclick="togglePassword('password', this)">
                                    <i class="fas fa-eye text-muted"></i>
                                </span>
                                <small class="text-muted ms-2">Minimal 8 karakter.</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-4 position-relative">
                                <input type="password" class="form-control password-input" 
                                       id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password Baru" required>
                                <label for="password_confirmation">
                                    <i class="fas fa-check-double me-2 text-primary"></i>Ulangi Password Baru
                                </label>
                                <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer toggle-password" 
                                      onclick="togglePassword('password_confirmation', this)">
                                    <i class="fas fa-eye text-muted"></i>
                                </span>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary py-3 fw-bold title-border-radius">
                                    <i class="fas fa-save me-2"></i>Simpan Password Baru
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer bg-light text-center p-3">
                        <small class="text-muted">Pastikan Anda mengingat password baru Anda sebelum menyimpannya.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    /**
     * Fungsi untuk Toggle Password Visibility
     * @param inputId ID dari input field
     * @param iconSpan Element span pembungkus ikon
     */
    function togglePassword(inputId, iconSpan) {
        const input = document.getElementById(inputId);
        const icon = iconSpan.querySelector('i');

        // Cek tipe saat ini
        if (input.type === "password") {
            // Ubah jadi text (terlihat)
            input.type = "text";
            // Ubah ikon jadi mata dicoret
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            // Ubah balik jadi password (tersembunyi)
            input.type = "password";
            // Ubah ikon jadi mata biasa
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endpush