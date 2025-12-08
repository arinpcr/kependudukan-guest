<?php

// File: routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\KeluargaKkController;
use App\Http\Controllers\AnggotaKeluargaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeristiwaKematianController;

/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/

// Halaman Depan / Landing Page
Route::get('/', function () {
    return view('guest.dashboard');
})->name('landing');

// Halaman About
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

// Route Authentication (Login & Register)
Route::get('/login', [AuthController::class, 'index'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login.post');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register.post');

/*
|--------------------------------------------------------------------------
| 2. PROTECTED ROUTES (Harus Login Dulu)
| Middleware: checkislogin
|--------------------------------------------------------------------------
*/
Route::middleware(['checkislogin'])->group(function () {

    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Dashboard (Bisa diakses semua user yang login)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // === PROFILE ROUTES ===
    // Lihat Profile
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    
    // Edit & Update Profile (Data Diri & Avatar)
    Route::get('/profile/edit', [DashboardController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [DashboardController::class, 'updateProfile'])->name('profile.update');

    // Ganti Password
    Route::get('/profile/password', [DashboardController::class, 'editPassword'])->name('profile.password');
    Route::put('/profile/password', [DashboardController::class, 'updatePassword'])->name('profile.password.update');

    /*
    |--------------------------------------------------------------------------
    | 3. ADMIN & SUPER ADMIN ROUTES
    | Middleware: checkrole:Admin,Super Admin
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkrole:Admin,Super Admin'])->group(function () {

        // === MANAJEMEN WARGA ===
        Route::resource('warga', WargaController::class);
        Route::delete('/warga/document/{document}', [WargaController::class, 'deleteDocument'])
            ->name('warga.document.delete');

        // === MANAJEMEN KELUARGA (KK) ===
        Route::resource('keluarga', KeluargaKkController::class, [
            'parameters' => ['keluarga' => 'keluarga'],
        ]);

        // === MANAJEMEN ANGGOTA KELUARGA (Nested Routes) ===
        Route::prefix('keluarga/{keluarga}')->group(function () {
            Route::get('/anggota', [AnggotaKeluargaController::class, 'index'])->name('anggota-keluarga.index');
            Route::get('/anggota/create', [AnggotaKeluargaController::class, 'create'])->name('anggota-keluarga.create');
            Route::post('/anggota', [AnggotaKeluargaController::class, 'store'])->name('anggota-keluarga.store');
            Route::get('/anggota/{anggota}', [AnggotaKeluargaController::class, 'show'])->name('anggota-keluarga.show');
            Route::get('/anggota/{anggota}/edit', [AnggotaKeluargaController::class, 'edit'])->name('anggota-keluarga.edit');
            Route::put('/anggota/{anggota}', [AnggotaKeluargaController::class, 'update'])->name('anggota-keluarga.update');
            Route::delete('/anggota/{anggota}', [AnggotaKeluargaController::class, 'destroy'])->name('anggota-keluarga.destroy');
        });

        // Route List Semua Anggota
        Route::get('/anggota-keluarga', [AnggotaKeluargaController::class, 'allAnggota'])->name('anggota-keluarga.all');

        // === MANAJEMEN PERISTIWA KEMATIAN ===
        // Resource ini sudah otomatis membuat route untuk index, create, store, show, EDIT, UPDATE, destroy
        Route::resource('kematian', PeristiwaKematianController::class);
        
        // Custom Route untuk Media Upload & Delete
        Route::post('kematian/upload', [PeristiwaKematianController::class, 'storeMedia'])->name('kematian.upload');
        Route::delete('media/{media_id}', [PeristiwaKematianController::class, 'deleteMedia'])->name('media.delete');
    });

    /*
    |--------------------------------------------------------------------------
    | 4. SUPER ADMIN ONLY ROUTES
    | Middleware: checkrole:Super Admin
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkrole:Super Admin'])->group(function () {
        // Hanya Super Admin yang boleh kelola data User
        Route::resource('user', UserController::class);
    });

});

// Fallback Route (Jika akses halaman ngawur, kembalikan ke home)
Route::fallback(function () {
    return redirect('/');
});