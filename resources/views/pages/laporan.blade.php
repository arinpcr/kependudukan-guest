@extends('layouts.guest.app')

@section('title', 'Laporan Statistik - Sistem Kependudukan')

@push('styles')
<style>
    /* --- HANYA MENGUBAH FONT JUDUL --- */
    h1, h2, h3, h4, h5, h6, .stat-title, .chart-title {
        font-family: 'Fredoka', sans-serif; 
    }

    /* --- Hero Section --- */
    .report-hero {
        background: linear-gradient(135deg, #fff0f5 0%, #fff 100%);
        padding: 50px 0;
        margin-bottom: 50px;
        border-bottom: 1px solid #eee;
    }
    .report-hero h1 {
        font-weight: 800;
        color: var(--bs-primary);
        font-size: 2.5rem;
    }

    /* --- Statistic Card --- */
    .stat-card {
        background: #fff;
        border-radius: 20px;
        padding: 25px 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border-left: 5px solid var(--bs-primary);
        transition: 0.3s;
        height: 100%;
        position: relative;
        overflow: hidden;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(255, 72, 128, 0.15);
    }
    .stat-title {
        font-size: 0.85rem;
        letter-spacing: 1px;
        margin-bottom: 10px;
        opacity: 0.8;
        font-weight: 700;
    }
    .stat-number {
        font-size: 2.2rem; /* Sedikit dikecilkan agar pas 5 kolom */
        margin-bottom: 5px;
        color: #333;
        font-weight: 700;
    }

    /* --- Chart Container --- */
    .chart-container {
        background: #fff;
        border-radius: 25px;
        padding: 35px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.05);
        margin-bottom: 30px;
        border: 1px solid rgba(0,0,0,0.02);
    }
    .chart-title {
        color: var(--bs-primary);
        margin-bottom: 25px;
        font-size: 1.2rem;
        font-weight: 700;
    }
</style>
@endpush

@section('content')

<div class="report-hero text-center">
    <div class="container">
        <h1 class="mb-2">Laporan Statistik</h1>
        <p class="text-muted mb-0 lead">Visualisasi data kependudukan desa secara real-time.</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4 mb-5">
        <div class="col">
            <div class="stat-card">
                <h6 class="text-uppercase text-muted stat-title">Total Penduduk</h6>
                <h2 class="stat-number">{{ $totalWarga ?? 0 }}</h2>
                <small class="text-success fw-bold"><i class="fas fa-users me-1"></i>Jiwa</small>
            </div>
        </div>
        <div class="col">
            <div class="stat-card" style="border-color: #0dcaf0;">
                <h6 class="text-uppercase text-muted stat-title">Kelahiran</h6>
                <h2 class="stat-number">{{ $totalKelahiran ?? 0 }}</h2>
                <small class="text-info fw-bold"><i class="fas fa-baby me-1"></i>Bayi</small>
            </div>
        </div>
        <div class="col">
            <div class="stat-card" style="border-color: #ffc107;">
                <h6 class="text-uppercase text-muted stat-title">Kematian</h6>
                <h2 class="stat-number">{{ $totalKematian ?? 0 }}</h2>
                <small class="text-warning fw-bold"><i class="fas fa-monument me-1"></i>Orang</small>
            </div>
        </div>
        <div class="col">
            <div class="stat-card" style="border-color: #6f42c1;"> <h6 class="text-uppercase text-muted stat-title">Pindahan</h6>
                <h2 class="stat-number">{{ $totalPindah ?? 0 }}</h2>
                <small class="fw-bold" style="color: #6f42c1;"><i class="fas fa-truck-moving me-1"></i>Warga</small>
            </div>
        </div>
        <div class="col">
            <div class="stat-card" style="border-color: #198754;">
                <h6 class="text-uppercase text-muted stat-title">Kepala Keluarga</h6>
                <h2 class="stat-number">{{ $totalKK ?? 0 }}</h2>
                <small class="text-success fw-bold"><i class="fas fa-home me-1"></i>KK</small>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="chart-container h-100">
                <h5 class="text-center chart-title">Komposisi Gender</h5>
                <div class="position-relative" style="height: 300px; display: flex; justify-content: center;">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mb-4">
            <div class="chart-container h-100">
                <h5 class="chart-title">Statistik Peristiwa (Tahun Ini)</h5>
                <canvas id="eventChart"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctxGender = document.getElementById('genderChart');
    const ctxEvent = document.getElementById('eventChart');

    // 1. Config Pie Chart (Gender)
    new Chart(ctxGender, {
        type: 'doughnut',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                data: [{{ $laki ?? 60 }}, {{ $perempuan ?? 40 }}], 
                backgroundColor: ['#36A2EB', '#ff4880'],
                hoverOffset: 10,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // 2. Config Bar Chart (Peristiwa) - Menambahkan dataset Pindahan
    new Chart(ctxEvent, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'], 
            datasets: [
                {
                    label: 'Kelahiran',
                    data: {!! json_encode($dataKelahiranBulanan ?? [12, 19, 3, 5, 2, 3, 10, 5, 8, 11, 9, 15]) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderRadius: 5
                },
                {
                    label: 'Kematian',
                    data: {!! json_encode($dataKematianBulanan ?? [2, 3, 1, 0, 1, 2, 4, 1, 2, 3, 1, 0]) !!},
                    backgroundColor: 'rgba(255, 72, 128, 0.7)',
                    borderRadius: 5
                },
                {
                    label: 'Pindahan',
                    data: {!! json_encode($dataPindahanBulanan ?? [5, 7, 2, 4, 6, 8, 3, 5, 9, 2, 4, 6]) !!},
                    backgroundColor: 'rgba(111, 66, 193, 0.7)', // Warna Ungu
                    borderRadius: 5
                }
            ]
        },
        options: {
            responsive: true,
            scales: { 
                y: { 
                    beginAtZero: true,
                    grid: { borderDash: [5, 5], color: '#f0f0f0' }
                },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endpush