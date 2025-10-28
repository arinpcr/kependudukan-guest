<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Kependudukan')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- CSS -->
    @extends('layouts.guest.css')

    <!-- Font Awesome (untuk ikon WhatsApp & About Page) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <!-- Spinner -->
    <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>

    <!-- Header -->
    @include('layouts.guest.header')

    <!-- ✅ Navigasi tambahan untuk halaman “About” -->
    <nav class="text-center py-2" style="background-color:#ffe6f0;">
        <a href="{{ route('about') }}"
           style="color:#ff4081; text-decoration:none; font-weight:600; font-size:16px;">
           <i class="fa-solid fa-circle-info me-1"></i> Tentang Sistem
        </a>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.guest.footer')

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/6281234567890?text=Halo%20Admin%2C%20saya%20ingin%20bertanya%20tentang%20Sistem%20Kependudukan."
       class="whatsapp-float" target="_blank" rel="noopener" title="Hubungi kami di WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <style>
        /* Floating WhatsApp Button */
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 25px;
            right: 25px;
            background-color: #25D366;
            color: #fff;
            border-radius: 50%;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.3);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: bounceIn 0.8s ease;
        }

        .whatsapp-float:hover {
            background-color: #20ba5a;
            transform: scale(1.1);
            box-shadow: 4px 4px 15px rgba(0,0,0,0.4);
        }

        @keyframes bounceIn {
            0% { transform: scale(0.5); opacity: 0; }
            60% { transform: scale(1.2); opacity: 1; }
            100% { transform: scale(1); }
        }
    </style>

    <!-- JavaScript -->
    @include('layouts.guest.js')
</body>
</html>
