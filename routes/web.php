<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\KeluargaKkController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/auth', [AuthController::class, 'index']);           // Form login
Route::post('/auth/login', [AuthController::class, 'login']);    // Proses login
Route::get('/auth/success', [AuthController::class, 'success']); // Halaman success
Route::get('/dashboard-guest', [GuestController::class, 'index']); // Dashboard Guest

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

// 2. Tambahkan baris ini untuk semua rute CRUD Warga
Route::resource('warga', WargaController::class);

Route::resource('keluarga', KeluargaKkController::class);