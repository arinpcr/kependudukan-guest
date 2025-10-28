@extends('layouts.guest.app')

@push('styles')
<style>
/* Styling untuk halaman About */
.about-section {
    padding: 60px 20px;
    text-align: center;
    background: #fdf3f5;
}

.about-section h1 {
    color: #ff4081;
    font-weight: 700;
    margin-bottom: 10px;
}

.about-section p.lead {
    color: #444;
    font-size: 17px;
    max-width: 800px;
    margin: 0 auto 40px;
}

.modules {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    justify-content: center;
    padding: 30px 0;
}

.module-card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    padding: 25px;
    transition: transform 0.3s ease;
}

.module-card:hover {
    transform: translateY(-5px);
}

.module-card img {
    width: 80px;
    margin-bottom: 15px;
}

.module-card h3 {
    color: #ff4081;
    font-size: 20px;
    margin-bottom: 10px;
}

.module-card p {
    font-size: 15px;
    color: #555;
}

.flow-section {
    background: #fff;
    padding: 60px 20px;
    text-align: center;
}

.flow-section img {
    max-width: 700px;
    width: 90%;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
</style>
@endpush

@section('content')
<section class="about-section">
    <h1>Tentang Sistem Kependudukan</h1>
    <p class="lead">
        Sistem ini dibuat untuk mempermudah pengelolaan data kependudukan, mulai dari data warga, kelahiran, kematian, hingga pelaporan secara digital.
        Dengan sistem ini, proses administrasi menjadi lebih cepat, efisien, dan akurat.
    </p>

    <div class="modules">
        <div class="module-card">
            <img src="https://cdn-icons-png.flaticon.com/512/1256/1256650.png" alt="Penduduk">
            <h3>Modul Data Penduduk</h3>
            <p>
                Modul ini digunakan untuk mengelola seluruh informasi penduduk.
                Pengguna dapat menambah, mengubah, atau menghapus data seperti NIK, nama, alamat, dan status keluarga.
            </p>
        </div>

        <div class="module-card">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Kelahiran">
            <h3>Modul Kelahiran</h3>
            <p>
                Berfungsi mencatat data bayi yang baru lahir serta menautkannya dengan data keluarga.
                Sistem otomatis menambahkan ke daftar penduduk setelah verifikasi.
            </p>
        </div>

        <div class="module-card">
            <img src="https://cdn-icons-png.flaticon.com/512/1027/1027912.png" alt="Kematian">
            <h3>Modul Kematian</h3>
            <p>
                Mencatat data warga yang telah meninggal dunia, lengkap dengan tanggal dan penyebab kematian.
                Data akan otomatis diperbarui agar tidak muncul di statistik aktif.
            </p>
        </div>

        <div class="module-card">
            <img src="https://cdn-icons-png.flaticon.com/512/4436/4436481.png" alt="Pelaporan">
            <h3>Modul Pelaporan</h3>
            <p>
                Menyediakan ringkasan laporan seperti jumlah penduduk aktif, data kelahiran, kematian, dan perpindahan.
                Bisa diekspor untuk kebutuhan administrasi.
            </p>
        </div>
    </div>
</section>

<section class="flow-section">
    <h2>Alur Penggunaan Sistem</h2>
    <p style="max-width: 700px; margin: 10px auto 40px; color: #444;">
        Berikut ilustrasi sederhana alur penggunaan sistem kependudukan dari mulai input data hingga laporan akhir.
    </p>
    <img src="https://i.ibb.co/Z6qDMFZ/flow-kependudukan.png" alt="Alur Sistem Kependudukan">
</section>
@endsection
