<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash; // PENTING: Untuk fitur ganti password
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard Utama
     */
    public function index()
    {
        return view('guest.dashboard');
    }

    /**
     * Menampilkan Halaman Profile (Read Only)
     */
    public function profile()
    {
        $user = Auth::user();
        return view('pages.profile', compact('user'));
    }

    /**
     * Menampilkan Form Edit Profile
     */
    public function editProfile()
    {
        $user = Auth::user();
        return view('pages.profile-edit', compact('user'));
    }

    /**
     * Memproses Update Profile (Data Diri & Avatar)
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // 1. Validasi
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Maks 2MB
        ]);

        // 2. Set Data Text (Nama & Email)
        $user->name  = $request->name;
        $user->email = $request->email;

        // 3. Cek apakah user mengupload avatar baru?
        if ($request->hasFile('avatar')) {
            
            // Hapus avatar lama jika ada (dan bukan default)
            // Kita cek apakah file lama ada di disk 'public'
            if ($user->avatar && Storage::disk('public')->exists('avatars/' . $user->avatar)) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }

            // Simpan file baru ke folder: storage/app/public/avatars
            $path = $request->file('avatar')->store('avatars', 'public');
            
            // Ambil nama filenya saja untuk disimpan di database
            $user->avatar = basename($path);
        }

        // 4. Simpan perubahan ke Database
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile berhasil diperbarui!');
    }

    /**
     * Menampilkan Form Ganti Password (FITUR BARU)
     */
    public function editPassword()
    {
        return view('pages.profile-password');
    }

    /**
     * Memproses Ganti Password (FITUR BARU)
     */
    public function updatePassword(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // 2. Cek apakah password lama yang diinput user COCOK dengan yang di database?
        if (!Hash::check($request->current_password, $user->password)) {
            // Jika salah, kembalikan dengan error
            return back()->withErrors(['current_password' => 'Password saat ini tidak cocok.']);
        }

        // 3. Jika benar, update password baru (di-hash)
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('profile')->with('success', 'Password berhasil diubah!');
    }
}