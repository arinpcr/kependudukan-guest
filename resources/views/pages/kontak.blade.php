@extends('layouts.guest.app')

@section('title', 'Hubungi Kami - Sistem Kependudukan')

@push('styles')
<style>
    /* --- Hero Section Sederhana --- */
    .contact-hero {
        background: linear-gradient(135deg, #fff0f5 0%, #fff 100%);
        padding: 50px 0;
        text-align: center;
        margin-bottom: 40px;
    }
    .contact-hero h1 {
        font-weight: 800;
        color: var(--bs-primary);
        font-family: 'Fredoka', sans-serif;
    }

    /* --- Form Section --- */
    .form-container {
        background: #fff;
        padding: 40px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .form-title {
        font-weight: 700;
        margin-bottom: 10px;
        color: #e63e6d;
        font-family: 'Fredoka', sans-serif;
    }
    
    /* --- Map Section --- */
    .map-wrapper {
        height: 100%;
        min-height: 550px; /* Tinggi peta disesuaikan */
        position: relative;
        background: #eee;
    }
    .map-overlay {
        position: absolute;
        bottom: 20px;
        left: 20px;
        background: rgba(255, 255, 255, 0.95);
        padding: 12px 20px;
        border-radius: 15px;
        box-shadow: 0 5px 20px #e63e6d;
        backdrop-filter: blur(5px);
        z-index: 10;
    }

    /* --- Social Buttons --- */
    .social-links {
        display: flex;
        gap: 10px;
        margin-top: 15px;
        flex-wrap: wrap; /* Agar rapi jika layar kecil */
    }
    .social-btn {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #e63e6d;
        transition: all 0.3s;
        text-decoration: none;
        border: 1px solid #eee;
        font-size: 1.1rem;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .social-btn:hover {
        background: var(--bs-primary);
        color: #fff !important; /* Force white icon on hover */
        border-color: var(--bs-primary) !important;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px #e63e6d;
    }

    /* --- Inputs --- */
    .form-control:focus {
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 0.25rem #e63e6d;
    }
    .btn-send {
        background: var(--bs-primary);
        color: #fff;
        border: none;
        padding: 12px;
        border-radius: 12px;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-send:hover {
        background: #e63e6d;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 72, 128, 0.3);
        color: #fff;
    }
</style>
@endpush

@section('content')

<div class="contact-hero">
    <div class="container">
        <h1 class="display-5 mb-2 wow fadeInUp" data-wow-delay="0.1s">Kontak & Lokasi</h1>
        <p class="text-muted lead mb-0 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 600px; margin: 0 auto;">
            Kunjungi kantor kami atau kirim pesan melalui formulir di bawah ini.
        </p>
    </div>
</div>

<div class="container pb-5">
    
    <div class="row g-0 align-items-stretch shadow rounded-4 overflow-hidden border border-light wow fadeInUp" data-wow-delay="0.3s">
        
        <div class="col-lg-6">
            <div class="map-wrapper">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.81956135000001!3d-6.194741399999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5390917b759%3A0x6b45e67356080477!2sMonumen%20Nasional!5e0!3m2!1sid!2sid!4v1633023222533!5m2!1sid!2sid" 
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
                
                <div class="map-overlay d-none d-md-block">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-map-marker-alt text-primary fs-4 me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">Kantor Desa Digital</h6>
                            <small class="text-muted">Jl. Merdeka No. 45, Indonesia</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-container">
                <div>
                    <h3 class="form-title">Kirim Pesan</h3>
                    <p class="text-muted mb-4">Masukan kritik, saran, atau pertanyaan Anda.</p>

                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" placeholder="Nama Lengkap">
                                    <label for="name">Nama Lengkap</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" placeholder="Email">
                                    <label for="email">Email</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="subject" placeholder="Subjek">
                                    <label for="subject">Judul Pesan</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Pesan" id="message" style="height: 120px"></textarea>
                                    <label for="message">Isi Pesan</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-send w-100" type="submit">
                                    <i class="fas fa-paper-plane me-2"></i> Kirim Pesan
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="mt-5 pt-3 border-top">
                        <h6 class="fw-bold mb-3 text-dark small text-uppercase ls-1">Ikuti Kami di Sosial Media:</h6>
                        <div class="social-links">
                            <a href="https://github.com/arinpcr" target="_blank" class="social-btn" title="GitHub" style="color: #333; border-color: #333;">
                                <i class="fab fa-github"></i>
                            </a>

                            <a href="https://www.instagram.com/0.79990/" target="_blank" class="social-btn" title="Instagram" style="color: #E1306C; border-color: #E1306C;">
                                <i class="fab fa-instagram"></i>
                            </a>

                            <a href="https://wa.me/" target="_blank" class="social-btn" title="WhatsApp" style="color: #25D366; border-color: #25D366;">
                                <i class="fab fa-whatsapp"></i>
                            </a>

                            <a href="https://www.facebook.com/" target="_blank" class="social-btn" title="Facebook" style="color: #1877F2; border-color: #1877F2;">
                                <i class="fab fa-facebook-f"></i>
                            </a>

                            <a href="https://www.linkedin.com/" target="_blank" class="social-btn" title="LinkedIn" style="color: #0077B5; border-color: #0077B5;">
                                <i class="fab fa-linkedin-in"></i>
                            </a>

                            <a href="mailto:arini24si@mahasiswa.pcr.ac.id" class="social-btn" title="Email" style="color: #EA4335; border-color: #EA4335;">
                                <i class="fas fa-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection