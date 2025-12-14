@extends('layouts.guest.app')

@section('title', 'Tentang Kami - Sistem Kependudukan')

@push('styles')
<style>
    /* --- Hero Section --- */
    .about-hero {
        background: linear-gradient(135deg, #fff0f5 0%, #fff 100%);
        padding: 60px 0;
        margin-bottom: 50px;
        border-bottom: 1px solid #eee;
    }
    .about-hero h1 {
        font-weight: 800;
        color: var(--bs-primary);
    }

    /* --- Developer Section --- */
    .dev-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
        height: 100%;
    }
    .dev-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(255, 72, 128, 0.15);
    }
    .dev-img-wrapper {
        height: 350px;
        overflow: hidden;
        position: relative;
    }
    .dev-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center top;
        transition: transform 0.5s ease;
    }
    .dev-card:hover .dev-img-wrapper img {
        transform: scale(1.03);
    }
    .dev-info {
        padding: 25px;
        text-align: center;
        background: #fff;
    }
    .dev-name {
        font-weight: 700;
        color: #333;
        margin-bottom: 5px;
        font-size: 1.4rem;
    }
    .dev-role {
        color: var(--bs-primary);
        font-weight: 600;
        font-size: 0.9rem;
        display: block;
        margin-bottom: 15px;
    }
    .social-btn {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: #f8f9fa;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #555;
        margin: 0 5px;
        transition: all 0.3s;
        text-decoration: none;
        border: 1px solid #eee;
    }
    .social-btn:hover {
        background: var(--bs-primary);
        color: #fff;
        border-color: var(--bs-primary);
    }

    /* --- Bio & Purpose Section --- */
    .bio-content {
        padding: 20px;
    }
    .bio-title {
        font-weight: 700;
        margin-bottom: 20px;
        position: relative;
        display: inline-block;
    }
    .bio-title::after {
        content: '';
        display: block;
        width: 50px;
        height: 3px;
        background: var(--bs-primary);
        margin-top: 5px;
    }
    .purpose-box {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 15px;
        border-left: 4px solid var(--bs-primary);
        margin-bottom: 20px;
    }
    .skill-badge {
        display: inline-block;
        padding: 5px 15px;
        margin: 5px 5px 5px 0;
        background: #fff0f5;
        color: var(--bs-primary);
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        border: 1px solid rgba(255, 72, 128, 0.2);
    }

    /* --- Minimalist Feature Section --- */
    .feature-minimal-card {
        text-align: center;
        padding: 25px 20px;
        border-radius: 15px;
        transition: 0.3s;
        height: 100%;
        background: #fff;
        border: 1px solid #eee;
    }
    .feature-minimal-card:hover {
        background: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border-color: var(--bs-primary);
        transform: translateY(-5px);
    }
    .feature-icon-wrapper {
        width: 60px;
        height: 60px;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #fff5f8;
        color: var(--bs-primary);
        font-size: 1.5rem;
        transition: 0.3s;
    }
    .feature-minimal-card:hover .feature-icon-wrapper {
        background: var(--bs-primary);
        color: #fff;
    }
    .feature-title {
        font-weight: 700;
        margin-bottom: 10px;
        color: #333;
    }
    .feature-desc {
        color: #666;
        font-size: 0.9rem;
        line-height: 1.6;
    }

    /* --- Sleek Flow Section --- */
    .flow-container {
        position: relative;
        background: #fff;
        border-radius: 25px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.05);
        padding: 40px;
        overflow: hidden;
        border: 1px solid #eee;
    }
    .flow-container::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 5px;
        background: linear-gradient(90deg, var(--bs-primary), #ffb6c1);
    }
    .flow-step {
        display: flex;
        align-items: start;
        margin-bottom: 15px;
    }
    .step-number {
        background: var(--bs-primary);
        color: #fff;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 15px;
        flex-shrink: 0;
    }
</style>
@endpush

@section('content')

<div class="about-hero text-center">
    <div class="container">
        <h1 class="display-5 mb-3 wow fadeInUp" data-wow-delay="0.1s">Profil & Visi</h1>
        <p class="text-muted lead mb-0 wow fadeInUp" data-wow-delay="0.2s">
            Mengenal lebih dekat kreator dan visi di balik Sistem Informasi Kependudukan Desa Digital.
        </p>
    </div>
</div>

<div class="container pb-5">
    
    <div class="row align-items-center justify-content-center mb-5">
        <div class="col-lg-4 col-md-5 mb-4 mb-md-0 wow fadeInLeft" data-wow-delay="0.3s">
            <div class="dev-card mx-auto" style="max-width: 350px;">
                <div class="dev-img-wrapper">
                    <img src="{{ asset('assets-guest/img/foto-saya.jpg') }}" 
                         alt="Foto Pengembang"
                         onerror="this.src='https://ui-avatars.com/api/?name=Arin&size=500&background=ff4880&color=fff'">
                </div>
                <div class="dev-info">
                    <h3 class="dev-name">Arini Zahira Putri</h3> 
                    <span class="dev-role">NIM: 2457301017</span>
                    <div class="mt-3">
                        <a href="https://github.com/arinpcr" target="_blank" class="social-btn" title="GitHub"><i class="fab fa-github"></i></a>
                        <a href="https://www.linkedin.com/" target="_blank" class="social-btn" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://www.instagram.com/0.79990/" target="_blank" class="social-btn" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="mailto:arini24si@mahasiswa.pcr.ac.id" class="social-btn" title="Email"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-7 wow fadeInRight" data-wow-delay="0.4s">
            <div class="bio-content">
                <h2 class="bio-title">Tentang Sistem</h2>
                
                <div class="purpose-box">
                    <h5 class="fw-bold mb-2 text-dark"><i class="fas fa-bullseye me-2 text-primary"></i>Tujuan Pengembangan</h5>
                    <p class="mb-0 text-muted small">
                        Aplikasi ini dirancang untuk mendigitalkan arsip kependudukan desa yang sebelumnya manual. Tujuannya adalah mempercepat proses pencarian data warga, mempermudah rekapitulasi laporan kelahiran/kematian, serta menyediakan data statistik yang akurat bagi perangkat desa untuk pengambilan keputusan.
                    </p>
                </div>

                <p class="text-muted" style="font-size: 1rem; line-height: 1.7;">
                    Sebagai mahasiswa <strong>Sistem Informasi</strong>, saya mengembangkan aplikasi ini dengan fokus pada kemudahan penggunaan (User Experience) dan keamanan data. Modul-modul yang tersedia saling terintegrasi untuk menciptakan ekosistem administrasi desa yang efisien.
                </p>

                <div class="mb-3 mt-4">
                    <h6 class="fw-bold mb-3 text-dark small text-uppercase">Teknologi Pendukung:</h6>
                    <span class="skill-badge"><i class="fab fa-laravel me-2"></i>Laravel 10</span>
                    <span class="skill-badge"><i class="fab fa-php me-2"></i>PHP 8</span>
                    <span class="skill-badge"><i class="fab fa-bootstrap me-2"></i>Bootstrap 5</span>
                    <span class="skill-badge"><i class="fas fa-database me-2"></i>MySQL</span>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-5" style="border-top: 1px dashed #ddd;">

    <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
        <h4 class="text-primary fw-bold text-uppercase ls-1">Modul & Fungsionalitas</h4>
        <h2 class="fw-bold">Fitur Utama Sistem</h2>
        <p class="text-muted mx-auto" style="max-width: 600px;">
            Sistem terdiri dari 4 modul inti yang menangani aspek vital kependudukan.
        </p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.2s">
            <div class="feature-minimal-card">
                <div class="feature-icon-wrapper">
                    <i class="fas fa-users"></i>
                </div>
                <h5 class="feature-title">Data Penduduk</h5>
                <p class="feature-desc">Modul untuk mengelola database seluruh warga. Memungkinkan tambah, edit, hapus, dan pencarian data berdasarkan NIK atau Nama secara cepat.</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.3s">
            <div class="feature-minimal-card">
                <div class="feature-icon-wrapper">
                    <i class="fas fa-baby"></i>
                </div>
                <h5 class="feature-title">Kelahiran</h5>
                <p class="feature-desc">Mencatat data bayi baru lahir. Data ini otomatis terintegrasi untuk pembuatan Akta Kelahiran dan penambahan anggota baru di Kartu Keluarga (KK).</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.4s">
            <div class="feature-minimal-card">
                <div class="feature-icon-wrapper">
                    <i class="fas fa-procedures"></i>
                </div>
                <h5 class="feature-title">Kematian</h5>
                <p class="feature-desc">Mencatat warga yang meninggal dunia. Sistem akan otomatis memperbarui status kependudukan warga tersebut menjadi non-aktif untuk validasi data pemilih.</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.5s">
            <div class="feature-minimal-card">
                <div class="feature-icon-wrapper">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <h5 class="feature-title">Laporan & Statistik</h5>
                <p class="feature-desc">Menyajikan dashboard visual (grafik) mengenai pertumbuhan penduduk, rasio gender, dan rekapitulasi peristiwa penting secara real-time.</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-5 wow fadeInUp" data-wow-delay="0.6s">
        <div class="col-lg-10">
            <div class="flow-container">
                <div class="row align-items-center">
                    <div class="col-md-5 mb-4 mb-md-0">
                        <h4 class="fw-bold mb-3 text-dark">Alur Kerja Sistem</h4>
                        <p class="text-muted mb-4">
                            Berikut adalah ilustrasi bagaimana data diproses dalam aplikasi ini, mulai dari input admin hingga menjadi laporan statistik.
                        </p>
                        
                        <div class="flow-step">
                            <div class="step-number">1</div>
                            <div>
                                <h6 class="fw-bold mb-1">Input Data</h6>
                                <p class="small text-muted mb-0">Admin memasukkan data warga/keluarga baru atau mencatat peristiwa (lahir/mati).</p>
                            </div>
                        </div>
                        <div class="flow-step">
                            <div class="step-number">2</div>
                            <div>
                                <h6 class="fw-bold mb-1">Validasi & Proses</h6>
                                <p class="small text-muted mb-0">Sistem memvalidasi NIK (unik) dan menyimpan data ke database MySQL.</p>
                            </div>
                        </div>
                        <div class="flow-step">
                            <div class="step-number">3</div>
                            <div>
                                <h6 class="fw-bold mb-1">Output Laporan</h6>
                                <p class="small text-muted mb-0">Data diolah menjadi grafik statistik dan laporan rekapitulasi siap cetak.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7 text-center">
                        <div class="p-3 bg-light rounded-3 border">
                            <img src="{{ asset('assets-guest/img/flow-kependudukan.png') }}" 
                                 class="img-fluid rounded shadow-sm" 
                                 style="max-height: 400px; width: auto;"
                                 alt="Diagram Alur Sistem"
                                 onerror="this.style.display='none'">
                            <p class="text-muted small mt-2 fst-italic mb-0" onerror="this.style.display='block'">
                                *Diagram alur data sistem informasi kependudukan
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection