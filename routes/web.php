<?php

use Illuminate\Support\Facades\Route;

// --- Import Controllers ---
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\KeluargaKkController;
use App\Http\Controllers\AnggotaKeluargaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeristiwaKematianController;
use App\Http\Controllers\PeristiwaKelahiranController;
use App\Http\Controllers\PeristiwaPindahController; // [BARU] Import Controller Pindah

// --- Import Models (PENTING untuk Halaman Laporan) ---
use App\Models\Warga;
use App\Models\KeluargaKK;
use App\Models\PeristiwaKematian;
use App\Models\PeristiwaKelahiran;
use App\Models\PeristiwaPindah; // [BARU] Import Model Pindah

/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/

// Halaman Depan / Landing Page
Route::get('/', function () {
    return view('guest.dashboard');
})->name('landing');

// Halaman About (Tentang Kami)
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

// Halaman Kontak
Route::get('/kontak', function () {
    return view('pages.kontak');
})->name('kontak');

// Halaman Laporan (Statistik)
Route::get('/laporan', function () {
    // 1. Hitung Total Data
    $totalWarga     = Warga::count();
    $totalKK        = KeluargaKK::count();
    $totalKematian  = PeristiwaKematian::count();
    $totalKelahiran = PeristiwaKelahiran::count();
    $totalPindah    = PeristiwaPindah::count(); // [BARU] Hitung Pindah

    // 2. Data Grafik Gender
    $laki      = Warga::where('jenis_kelamin', 'L')->count();
    $perempuan = Warga::where('jenis_kelamin', 'P')->count();

    return view('pages.laporan', compact(
        'totalWarga', 'totalKK', 'totalKematian', 'totalKelahiran', 'totalPindah',
        'laki', 'perempuan'
    ));
})->name('laporan.index');

// --- Authentication (Login & Register) ---
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

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- Profile Management ---
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
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

        // --- Manajemen Warga ---
        Route::resource('warga', WargaController::class);
        Route::delete('/warga/document/{document}', [WargaController::class, 'deleteDocument'])
            ->name('warga.document.delete');

        // --- Manajemen Keluarga (KK) ---
        Route::resource('keluarga', KeluargaKkController::class, [
            'parameters' => ['keluarga' => 'keluarga'],
        ]);

        // --- Manajemen Anggota Keluarga (Nested) ---
        Route::prefix('keluarga/{keluarga}')->group(function () {
            Route::get('/anggota', [AnggotaKeluargaController::class, 'index'])->name('anggota-keluarga.index');
            Route::get('/anggota/create', [AnggotaKeluargaController::class, 'create'])->name('anggota-keluarga.create');
            Route::post('/anggota', [AnggotaKeluargaController::class, 'store'])->name('anggota-keluarga.store');
            Route::get('/anggota/{anggota}', [AnggotaKeluargaController::class, 'show'])->name('anggota-keluarga.show');
            Route::get('/anggota/{anggota}/edit', [AnggotaKeluargaController::class, 'edit'])->name('anggota-keluarga.edit');
            Route::put('/anggota/{anggota}', [AnggotaKeluargaController::class, 'update'])->name('anggota-keluarga.update');
            Route::delete('/anggota/{anggota}', [AnggotaKeluargaController::class, 'destroy'])->name('anggota-keluarga.destroy');
        });

        // List Semua Anggota (Tanpa Grup KK)
        Route::get('/anggota-keluarga', [AnggotaKeluargaController::class, 'allAnggota'])->name('anggota-keluarga.all');

        // --- Manajemen Kematian ---
        Route::resource('kematian', PeristiwaKematianController::class);
        Route::post('kematian/upload', [PeristiwaKematianController::class, 'storeMedia'])->name('kematian.upload');
        
        // --- Manajemen Kelahiran ---
        Route::resource('kelahiran', PeristiwaKelahiranController::class);
        Route::post('kelahiran/upload', [PeristiwaKelahiranController::class, 'storeMedia'])->name('kelahiran.upload');

        // --- [BARU] Manajemen Pindah (Mutasi) ---
        Route::resource('pindah', PeristiwaPindahController::class);
        Route::post('pindah/upload', [PeristiwaPindahController::class, 'storeMedia'])->name('pindah.upload');

        // Delete Media (Global - Bisa dipakai Kematian, Kelahiran, Pindah)
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

// Fallback Route (Jika akses URL ngawur -> ke Home)
Route::fallback(function () {
    return redirect('/');
});