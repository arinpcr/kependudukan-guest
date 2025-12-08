<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan Halaman Login
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('pages.auth.login-form');
    }

    // Menampilkan Halaman Register (BARU)
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('pages.auth.register');
    }

    // Proses Register (BARU)
    public function register(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8|confirmed', // Pastikan field konfirmasi bernama password_confirmation
            'terms'     => 'required',
        ], [
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'terms.required' => 'Anda harus menyetujui syarat dan ketentuan.'
        ]);

        // 2. Buat User Baru
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'User', // <--- PENTING: Paksa role jadi 'User'
            'avatar'   => null,
        ]);

        // 3. Redirect ke Login dengan Pesan Sukses
        return redirect()->route('auth.login')->with('success', 'Registrasi berhasil! Silahkan login.');
    }

    // Proses Login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            session(['last_login' => now()]);

            return redirect()->route('dashboard')->with('success', 'Login Berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login')->with('success', 'Berhasil Logout.');
    }
}