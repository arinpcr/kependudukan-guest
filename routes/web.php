<?php
// File: routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\KeluargaKkController;
use App\Http\Controllers\AnggotaKeluargaController;
use App\Http\Controllers\UserController;

// Public Routes - Tidak memerlukan authentication
Route::get('/', function () {
    return view('guest.dashboard');
});

// Authentication Routes untuk guest (belum login)
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    // Register Routes
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

    // Email check
    Route::post('/check-email', [AuthController::class, 'checkEmail'])->name('check.email');
});

// Guest Success Route
Route::get('/auth/success', [AuthController::class, 'success'])->name('auth.success');

// Protected Routes - Memerlukan authentication
Route::middleware('auth')->group(function () {
    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Routes dengan parameter yang benar
    Route::resource('warga', WargaController::class);
    
    // ✅ PERBAIKI ROUTE KELUARGA DENGAN PARAMETER YANG BENAR
    Route::resource('keluarga', KeluargaKkController::class, [
        'parameters' => ['keluarga' => 'keluarga']
    ]);
    
    // ✅ ROUTES ANGGOTA KELUARGA - Nested Routes dengan parameter konsisten
    Route::prefix('keluarga/{keluarga}')->group(function () {
        Route::get('/anggota', [AnggotaKeluargaController::class, 'index'])->name('anggota-keluarga.index');
        Route::get('/anggota/create', [AnggotaKeluargaController::class, 'create'])->name('anggota-keluarga.create');
        Route::post('/anggota', [AnggotaKeluargaController::class, 'store'])->name('anggota-keluarga.store');
        Route::get('/anggota/{anggota}', [AnggotaKeluargaController::class, 'show'])->name('anggota-keluarga.show');
        Route::get('/anggota/{anggota}/edit', [AnggotaKeluargaController::class, 'edit'])->name('anggota-keluarga.edit');
        Route::put('/anggota/{anggota}', [AnggotaKeluargaController::class, 'update'])->name('anggota-keluarga.update');
        Route::delete('/anggota/{anggota}', [AnggotaKeluargaController::class, 'destroy'])->name('anggota-keluarga.destroy');
    });

    // ✅ ROUTE BARU UNTUK SEMUA ANGGOTA
    Route::get('/anggota-keluarga', [AnggotaKeluargaController::class, 'allAnggota'])->name('anggota-keluarga.all');

    Route::resource('user', UserController::class);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Public Routes - Tambahan
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

// Fallback Route
Route::fallback(function () {
    return redirect('/');
});