<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\{Auth, Hash, Storage};
use App\Models\{Warga, KeluargaKk, PeristiwaKematian, PeristiwaKelahiran, PeristiwaPindah, User};

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard / Laporan Statistik
     */
    public function index()
    {
        // 1. Data Statistik Utama (Card)
        $totalWarga     = Warga::count();
        $totalKK        = KeluargaKk::count(); // Sesuaikan nama Model (KeluargaKk)
        $totalKematian  = PeristiwaKematian::count();
        $totalKelahiran = PeristiwaKelahiran::count();
        $totalPindah    = PeristiwaPindah::count(); 

        // 2. Statistik Gender (Variabel disamakan dengan Blade: $laki, $perempuan)
        $laki      = Warga::where('jenis_kelamin', 'L')->count();
        $perempuan = Warga::where('jenis_kelamin', 'P')->count();

        // 3. Data Grafik Peristiwa (12 Bulan Terakhir)
        $dataKelahiranBulanan = [];
        $dataKematianBulanan  = [];
        $dataPindahanBulanan  = [];

        for ($m = 1; $m <= 12; $m++) {
            $dataKelahiranBulanan[] = PeristiwaKelahiran::whereMonth('tgl_lahir', $m)
                                        ->whereYear('tgl_lahir', date('Y'))->count();
            
            $dataKematianBulanan[]  = PeristiwaKematian::whereMonth('tgl_meninggal', $m)
                                        ->whereYear('tgl_meninggal', date('Y'))->count();
                                        
            $dataPindahanBulanan[]  = PeristiwaPindah::whereMonth('tgl_pindah', $m)
                                        ->whereYear('tgl_pindah', date('Y'))->count();
        }

        // 4. Return View (Gunakan folder guest jika itu dashboard tamu)
        return view('guest.dashboard', compact(
            'totalWarga', 'totalKK', 'totalKematian', 'totalKelahiran', 'totalPindah', 
            'laki', 'perempuan',
            'dataKelahiranBulanan', 'dataKematianBulanan', 'dataPindahanBulanan'
        ));
    }

    /**
     * Menampilkan Halaman Profile
     */
    public function profile()
    {
        return view('pages.profile', ['user' => Auth::user()]);
    }

    /**
     * Menampilkan Form Edit Profile
     */
    public function editProfile()
    {
        return view('pages.profile-edit', ['user' => Auth::user()]);
    }

    /**
     * Memproses Update Profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada (Kecuali default)
            if ($user->avatar && Storage::disk('public')->exists('avatars/' . $user->avatar)) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }
            
            // Simpan file dengan nama asli atau random
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = basename($path);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profile berhasil diperbarui!');
    }

    /**
     * Menampilkan Form Ganti Password
     */
    public function editPassword()
    {
        return view('pages.profile-password');
    }

    /**
     * Memproses Ganti Password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak cocok.']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('profile')->with('success', 'Password berhasil diubah!');
    }
}