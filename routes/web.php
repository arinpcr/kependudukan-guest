<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/auth', [AuthController::class, 'index']);           // Form login
Route::post('/auth/login', [AuthController::class, 'login']);    // Proses login
Route::get('/auth/success', [AuthController::class, 'success']); // Halaman success
Route::get('/dashboard-guest', [GuestController::class, 'index']); // Dashboard Guest
