@extends('layouts.guest.app')

@section('title', 'Kependudukan')

@section('content')

    <!-- Hero Start -->
<div class="container-fluid py-5 hero-header wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-7 col-md-12">
                <h1 class="mb-3 text-primary">Selamat Datang di Sistem Kependudukan</h1>
                <h1 class="mb-5 display-1 text-white">Kelola Data Penduduk Dengan Mudah</h1>
                <a href="" class="btn btn-primary px-4 py-3 px-md-5 me-4 btn-border-radius">Mulai Sekarang</a>
                <a href="" class="btn btn-primary px-4 py-3 px-md-5 btn-border-radius">Pelajari Lebih Lanjut</a>
            </div>
            <div class="col-lg-5 col-md-12">
                <div class="position-relative">
                    
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-pattern-3 rounded"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->

    <!-- About Start -->
    <div class="container-fluid py-5 about bg-light">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5 wow fadeIn" data-wow-delay="0.1s">
                    <div class="video border">
                        <button type="button" class="btn btn-play" data-bs-toggle="modal" data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal">
                            <span></span>
                        </button>
                    </div>
                </div>
                <div class="col-lg-7 wow fadeIn" data-wow-delay="0.3s">
                    <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">About Us</h4>
                    <h1 class="text-dark mb-4 display-5">We Learn Smart Way To Build Bright Future For Your Children</h1>
                    <p class="text-dark mb-4">Lorem Ipsum is simply dummy text of the printing and typesetting industry. the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <h6 class="mb-3"><i class="fas fa-check-circle me-2"></i>Sport Activities</h6>
                            <h6 class="mb-3"><i class="fas fa-check-circle me-2 text-primary"></i>Outdoor Games</h6>
                            <h6 class="mb-3"><i class="fas fa-check-circle me-2 text-secondary"></i>Nutritious Foods</h6>
                        </div>
                        <div class="col-lg-6">
                            <h6 class="mb-3"><i class="fas fa-check-circle me-2"></i>Highly Secured</h6>
                            <h6 class="mb-3"><i class="fas fa-check-circle me-2 text-primary"></i>Friendly Environment</h6>
                            <h6><i class="fas fa-check-circle me-2 text-secondary"></i>Qualified Teacher</h6>
                        </div>
                    </div>
                    <a href="" class="btn btn-primary px-5 py-3 btn-border-radius">More Details</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Youtube Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="" id="video" allowfullscreen allowscriptaccess="always" allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Statistics Start -->
<div class="container-fluid testimonial py-5">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Statistik Data</h4>
            <h1 class="mb-5 display-3">Data Kependudukan</h1>
        </div>
        
        <!-- Main Statistics Carousel -->
        <div class="testimonial-carousel owl-carousel wow fadeIn" data-wow-delay="0.3s">
            <!-- Kartu Keluarga -->
            <div class="testimonial-item img-border-radius bg-light border border-primary p-4">
                <div class="p-4 position-relative text-center">
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <div class="border border-primary bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-home fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="border-top border-primary mt-4 pt-3">
                        <h2 class="text-dark mb-2 display-4">{{ $keluargaCount ?? 0 }}</h2>
                        <p class="mb-1 fw-bold text-primary fs-5">Kartu Keluarga</p>
                        <small class="text-muted">Total KK terdaftar</small>
                    </div>
                </div>
            </div>

            <!-- Anggota Keluarga -->
            <div class="testimonial-item img-border-radius bg-light border border-primary p-4">
                <div class="p-4 position-relative text-center">
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <div class="border border-primary bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="border-top border-primary mt-4 pt-3">
                        <h2 class="text-dark mb-2 display-4">{{ $anggotaKeluargaCount ?? 0 }}</h2>
                        <p class="mb-1 fw-bold text-primary fs-5">Anggota Keluarga</p>
                        <small class="text-muted">Total warga terdaftar</small>
                    </div>
                </div>
            </div>

            <!-- Peristiwa Kelahiran -->
            <div class="testimonial-item img-border-radius bg-light border border-primary p-4">
                <div class="p-4 position-relative text-center">
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <div class="border border-primary bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-baby fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="border-top border-primary mt-4 pt-3">
                        <h2 class="text-dark mb-2 display-4">{{ $kelahiranCount ?? 0 }}</h2>
                        <p class="mb-1 fw-bold text-primary fs-5">Kelahiran</p>
                        <small class="text-muted">Total kelahiran tercatat</small>
                    </div>
                </div>
            </div>

            <!-- Peristiwa Kematian -->
            <div class="testimonial-item img-border-radius bg-light border border-primary p-4">
                <div class="p-4 position-relative text-center">
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <div class="border border-primary bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-cross fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="border-top border-primary mt-4 pt-3">
                        <h2 class="text-dark mb-2 display-4">{{ $kematianCount ?? 0 }}</h2>
                        <p class="mb-1 fw-bold text-primary fs-5">Kematian</p>
                        <small class="text-muted">Total kematian tercatat</small>
                    </div>
                </div>
            </div>

            <!-- Peristiwa Pindah -->
            <div class="testimonial-item img-border-radius bg-light border border-primary p-4">
                <div class="p-4 position-relative text-center">
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <div class="border border-primary bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-truck-moving fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="border-top border-primary mt-4 pt-3">
                        <h2 class="text-dark mb-2 display-4">{{ $pindahCount ?? 0 }}</h2>
                        <p class="mb-1 fw-bold text-primary fs-5">Perpindahan</p>
                        <small class="text-muted">Total perpindahan tercatat</small>
                    </div>
                </div>
            </div>

            <!-- Total Penduduk -->
            <div class="testimonial-item img-border-radius bg-light border border-primary p-4">
                <div class="p-4 position-relative text-center">
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <div class="border border-primary bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-chart-line fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="border-top border-primary mt-4 pt-3">
                        <h2 class="text-dark mb-2 display-4">{{ $totalPenduduk ?? 0 }}</h2>
                        <p class="mb-1 fw-bold text-primary fs-5">Total Penduduk</p>
                        <small class="text-muted">Jumlah penduduk saat ini</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Info Section -->
        <div class="row mt-5 wow fadeIn" data-wow-delay="0.5s">
            <div class="col-12">
                <div class="testimonial-item img-border-radius bg-light border border-primary p-5 text-center">
                    <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Ringkasan Data Kependudukan</h4>
                    <div class="row">
                        <div class="col-md-3 col-6 mb-4">
                            <div class="testimonial-item img-border-radius bg-white border border-primary p-4 h-100">
                                <div class="d-flex align-items-center justify-content-center mb-3">
                                    <div class="border border-primary bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fas fa-male text-primary"></i>
                                    </div>
                                </div>
                                <h5 class="text-dark mb-1 display-6">{{ $lakiLakiCount ?? 0 }}</h5>
                                <small class="text-muted">Laki-laki</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-4">
                            <div class="testimonial-item img-border-radius bg-white border border-primary p-4 h-100">
                                <div class="d-flex align-items-center justify-content-center mb-3">
                                    <div class="border border-primary bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fas fa-female text-primary"></i>
                                    </div>
                                </div>
                                <h5 class="text-dark mb-1 display-6">{{ $perempuanCount ?? 0 }}</h5>
                                <small class="text-muted">Perempuan</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-4">
                            <div class="testimonial-item img-border-radius bg-white border border-primary p-4 h-100">
                                <div class="d-flex align-items-center justify-content-center mb-3">
                                    <div class="border border-primary bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fas fa-child text-primary"></i>
                                    </div>
                                </div>
                                <h5 class="text-dark mb-1 display-6">{{ $anakCount ?? 0 }}</h5>
                                <small class="text-muted">Anak-anak</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-4">
                            <div class="testimonial-item img-border-radius bg-white border border-primary p-4 h-100">
                                <div class="d-flex align-items-center justify-content-center mb-3">
                                    <div class="border border-primary bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fas fa-user-tie text-primary"></i>
                                    </div>
                                </div>
                                <h5 class="text-dark mb-1 display-6">{{ $dewasaCount ?? 0 }}</h5>
                                <small class="text-muted">Dewasa</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Statistics End -->

@endsection

@push('styles')
<style>
    /* Custom styles untuk carousel statistik */
    .testimonial-carousel .owl-stage {
        padding: 20px 0;
    }
    
    .testimonial-item {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin: 10px;
    }
    
    .testimonial-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .border-primary {
        border-color: var(--bs-primary) !important;
    }
    
    .display-4 {
        font-weight: 700;
        font-family: 'Fredoka', sans-serif;
    }
    
    .display-6 {
        font-weight: 600;
        font-family: 'Fredoka', sans-serif;
    }
    
    /* Owl Carousel Dots */
    .testimonial-carousel .owl-dots {
        margin-top: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .testimonial-carousel .owl-dot {
        position: relative;
        display: inline-block;
        margin: 0 5px;
        width: 15px;
        height: 15px;
        background: var(--bs-primary);
        border-radius: 10px;
        transition: 0.5s;
    }
    
    .testimonial-carousel .owl-dot.active {
        width: 30px;
        background: var(--bs-secondary);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

<script>
    $(document).ready(function() {
        console.log('Home page loaded with carousel statistics');
        
        // Initialize Owl Carousel
        $('.testimonial-carousel').owlCarousel({
            loop: true,
            margin: 20,
            nav: false,
            dots: true,
            autoplay: true,
            autoplayTimeout: 4000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                576: {
                    items: 1
                },
                768: {
                    items: 2
                },
                992: {
                    items: 3
                },
                1200: {
                    items: 3
                }
            }
        });

        // Add hover effects for statistics cards
        $('.testimonial-item').hover(
            function() {
                $(this).addClass('shadow-lg');
            },
            function() {
                $(this).removeClass('shadow-lg');
            }
        );
    });
</script>
@endpush