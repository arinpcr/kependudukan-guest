<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\KeluargaKkController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes - Tidak memerlukan authentication
Route::get('/', function () {
    return view('guest.dashboard');
});

// Authentication Routes untuk guest (belum login)
Route::middleware('guest')->group(function () {
    // Login Routes - versi baru
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    
    // Login Routes - versi lama (untuk kompatibilitas)
    Route::get('/auth', [AuthController::class, 'index']);           // Form login alternatif
    Route::post('/auth/login', [AuthController::class, 'login']);    // Proses login alternatif
    
    // Register Routes
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    
    // Email check (AJAX) - Optional
    Route::post('/check-email', [AuthController::class, 'checkEmail'])->name('check.email');
});

// Guest Success Route - bisa diakses setelah login guest
Route::get('/auth/success', [AuthController::class, 'success'])->name('auth.success');

// Protected Routes - Memerlukan authentication
Route::middleware('auth')->group(function () {
    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::get('/dashboard-guest', action: [DashboardController::class, 'index'])->name('guest.dashboard');
    
    // CRUD Routes
    Route::resource('warga', WargaController::class);
    Route::resource('keluarga', KeluargaKkController::class);
    Route::resource('user', UserController::class);
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Fallback Route
Route::fallback(function () {
    return redirect('/');
});

