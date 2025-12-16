@extends('layouts.guest.app')

@section('title', 'Kependudukan')

@section('content')

    <div class="container-fluid py-5 hero-header wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-7 col-md-12">
                <h1 class="mb-3 display-2 text-primary">Selamat Datang di Sistem Kependudukan</h1>
                <h1 class="mb-5 display-1 text-white">Kelola Data Penduduk Dengan Mudah</h1>
                <a href="{{ route('warga.index') }}" class="btn btn-primary px-4 py-3 px-md-5 me-4 btn-border-radius">Mulai Sekarang</a>
                <a href="{{ route('about') }}" class="btn btn-primary px-4 py-3 px-md-5 btn-border-radius">Pelajari Lebih Lanjut</a>
            </div>
            <div class="col-lg-5 col-md-12">
                <div class="position-relative">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-pattern-3 rounded"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid testimonial py-5">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Statistik Data</h4>
            <h1 class="mb-5 display-3">Data Kependudukan</h1>
        </div>

        <div class="testimonial-carousel owl-carousel wow fadeIn" data-wow-delay="0.3s">
            
            {{-- KARTU 1: WARGA --}}
            <div class="testimonial-item img-border-radius bg-light border border-primary p-4">
                <div class="p-4 position-relative text-center">
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <div class="border border-primary bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="border-top border-primary mt-4 pt-3">
                        <h2 class="text-dark mb-2 display-4">{{ $totalWarga ?? 0 }}</h2>
                        <p class="mb-1 fw-bold text-primary fs-5">Total Warga</p>
                        <small class="text-muted">Total warga terdaftar</small>
                    </div>
                </div>
            </div>

            {{-- KARTU 2: KK --}}
            <div class="testimonial-item img-border-radius bg-light border border-primary p-4">
                <div class="p-4 position-relative text-center">
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <div class="border border-primary bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-home fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="border-top border-primary mt-4 pt-3">
                        <h2 class="text-dark mb-2 display-4">{{ $totalKK ?? 0 }}</h2>
                        <p class="mb-1 fw-bold text-primary fs-5">Kartu Keluarga</p>
                        <small class="text-muted">Total KK terdaftar</small>
                    </div>
                </div>
            </div>

            {{-- KARTU 3: KELAHIRAN --}}
            <div class="testimonial-item img-border-radius bg-light border border-primary p-4">
                <div class="p-4 position-relative text-center">
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <div class="border border-primary bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-baby fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="border-top border-primary mt-4 pt-3">
                        <h2 class="text-dark mb-2 display-4">{{ $totalKelahiran ?? 0 }}</h2>
                        <p class="mb-1 fw-bold text-primary fs-5">Kelahiran</p>
                        <small class="text-muted">Total kelahiran tercatat</small>
                    </div>
                </div>
            </div>

            {{-- KARTU 4: KEMATIAN --}}
            <div class="testimonial-item img-border-radius bg-light border border-primary p-4">
                <div class="p-4 position-relative text-center">
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <div class="border border-primary bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-cross fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="border-top border-primary mt-4 pt-3">
                        <h2 class="text-dark mb-2 display-4">{{ $totalKematian ?? 0 }}</h2>
                        <p class="mb-1 fw-bold text-primary fs-5">Kematian</p>
                        <small class="text-muted">Total kematian tercatat</small>
                    </div>
                </div>
            </div>

            {{-- [BARU] KARTU 5: PINDAH --}}
            <div class="testimonial-item img-border-radius bg-light border border-primary p-4">
                <div class="p-4 position-relative text-center">
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <div class="border border-primary bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-truck-moving fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="border-top border-primary mt-4 pt-3">
                        <h2 class="text-dark mb-2 display-4">{{ $totalPindah ?? 0 }}</h2>
                        <p class="mb-1 fw-bold text-primary fs-5">Perpindahan</p>
                        <small class="text-muted">Total data pindah</small>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mt-5 wow fadeIn" data-wow-delay="0.5s">
            <div class="col-12">
                <div class="testimonial-item img-border-radius bg-light border border-primary p-5 text-center">
                    <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Ringkasan Gender</h4>
                    <div class="row justify-content-center">
                        <div class="col-md-4 col-6 mb-4">
                            <div class="testimonial-item img-border-radius bg-white border border-primary p-4 h-100">
                                <div class="d-flex align-items-center justify-content-center mb-3">
                                    <div class="border border-primary bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fas fa-male text-primary"></i>
                                    </div>
                                </div>
                                <h5 class="text-dark mb-1 display-6">{{ $totalLaki ?? 0 }}</h5>
                                <small class="text-muted">Laki-laki</small>
                            </div>
                        </div>
                        <div class="col-md-4 col-6 mb-4">
                            <div class="testimonial-item img-border-radius bg-white border border-primary p-4 h-100">
                                <div class="d-flex align-items-center justify-content-center mb-3">
                                    <div class="border border-primary bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fas fa-female text-primary"></i>
                                    </div>
                                </div>
                                <h5 class="text-dark mb-1 display-6">{{ $totalPerempuan ?? 0 }}</h5>
                                <small class="text-muted">Perempuan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<a href="https://wa.me/6281234567890?text=Halo%20Admin%2C%20saya%20ingin%20bertanya%20tentang%20Sistem%20Kependudukan."
   class="whatsapp-float" target="_blank" rel="noopener" title="Hubungi kami di WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

@endsection

@push('styles')
<style>
    /* Carousel Styles */
    .testimonial-carousel .owl-stage { padding: 20px 0; }
    .testimonial-item { transition: transform 0.3s ease, box-shadow 0.3s ease; margin: 10px; }
    .testimonial-item:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    .border-primary { border-color: var(--bs-primary) !important; }
    .display-4 { font-weight: 700; font-family: 'Fredoka', sans-serif; }
    .display-6 { font-weight: 600; font-family: 'Fredoka', sans-serif; }

    /* Owl Carousel Dots */
    .testimonial-carousel .owl-dots { margin-top: 30px; display: flex; align-items: center; justify-content: center; }
    .testimonial-carousel .owl-dot { position: relative; display: inline-block; margin: 0 5px; width: 15px; height: 15px; background: var(--bs-primary); border-radius: 10px; transition: 0.5s; }
    .testimonial-carousel .owl-dot.active { width: 30px; background: var(--bs-secondary); }

    /* WhatsApp Button */
    .whatsapp-float { position: fixed; width: 60px; height: 60px; bottom: 25px; right: 25px; background-color: #25D366; color: #fff; border-radius: 50%; text-align: center; font-size: 30px; box-shadow: 2px 2px 10px rgba(0,0,0,0.3); z-index: 9999; display: flex; align-items: center; justify-content: center; transition: transform 0.3s ease, box-shadow 0.3s ease; animation: bounceIn 0.8s ease; }
    .whatsapp-float:hover { background-color: #20ba5a; transform: scale(1.1); box-shadow: 4px 4px 15px rgba(0,0,0,0.4); }
    @keyframes bounceIn { 0% { transform: scale(0.5); opacity: 0; } 60% { transform: scale(1.2); opacity: 1; } 100% { transform: scale(1); } }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
<script>
    $('.testimonial-carousel').owlCarousel({
        autoplay: true,
        smartSpeed: 800,
        margin: 30,
        loop: true,
        dots: true,
        nav: false,
        responsive: {
            0: { items: 1 },
            768: { items: 2 },
            992: { items: 3 },
            1200: { items: 4 }
        }
    });
</script>
@endpush