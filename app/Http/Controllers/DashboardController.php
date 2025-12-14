<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
// 1. Grouping Facades (Bawaan Laravel)
use Illuminate\Support\Facades\{Auth, Hash, Storage};

// 2. Grouping Models (Agar hemat baris)
use App\Models\{
    Warga,
    KeluargaKK,
    PeristiwaKematian,
    PeristiwaKelahiran,
    PeristiwaPindah,
    User
};

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard Utama dengan Statistik
     */
    public function index()
    {
        // Data Statistik
        $totalWarga     = Warga::count();
        $totalKK        = KeluargaKK::count();
        $totalKematian  = PeristiwaKematian::count();
        $totalKelahiran = PeristiwaKelahiran::count();
        $totalPindah    = PeristiwaPindah::count(); 

        // Statistik Gender
        $totalLaki      = Warga::where('jenis_kelamin', 'L')->count();
        $totalPerempuan = Warga::where('jenis_kelamin', 'P')->count();

        return view('pages.dashboard', compact(
            'totalWarga', 
            'totalKK', 
            'totalKematian', 
            'totalKelahiran', 
            'totalPindah', 
            'totalLaki', 
            'totalPerempuan'
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
            // Hapus avatar lama
            if ($user->avatar && Storage::disk('public')->exists('avatars/' . $user->avatar)) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }
            // Simpan avatar baru
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