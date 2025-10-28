<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display login form
     */
    public function showLoginForm()
    {
        return view('pages.auth.login-form');
    }

    /**
     * Display registration form
     */
    public function showRegistrationForm()
    {
        return view('pages.auth.register');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $guestEmail = 'guest@example.com';
        $guestPassword = 'Guest123';

        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => ['required', 'min:3', 'regex:/[A-Z]/']
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 3 karakter.',
            'password.regex' => 'Password harus mengandung minimal satu huruf kapital.'
        ]);

        // Pengecekan login guest
        if ($request->email === $guestEmail && $request->password === $guestPassword) {
            session(['email' => $request->email]);
            return redirect('/auth/success');
        }

        // Pengecekan login user terdaftar
        $credentials = $this->getCredentials($request);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->with('error', 'Email atau password salah! Pastikan huruf kapital sudah benar.');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required|accepted',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.min' => 'Nama lengkap minimal 3 karakter.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar. Silakan gunakan email lain.',
            'email.max' => 'Alamat email maksimal 255 karakter.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'terms.required' => 'Anda harus menyetujui syarat dan ketentuan.',
            'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan dalam pengisian form.');
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Auto login setelah registrasi (optional)
            // Auth::login($user);

            return redirect()->route('login')
                ->with('success', 'Pendaftaran berhasil! Silakan login dengan akun Anda.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /**
     * Display success page after login
     */
    public function success()
{
    $email = session('email');

    // Jika ingin menampilkan username, bisa extract dari email
    $username = explode('@', $email)[0];

    return view('guest-success', compact('email', 'username'));
}

    /**
     * Get credentials for authentication
     */
    private function getCredentials(Request $request)
    {
        return [
            'email' => $request->email,
            'password' => $request->password
        ];
    }

    /**
     * Check email availability (for AJAX)
     */
    public function checkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json(['valid' => false, 'message' => 'Format email tidak valid']);
        }

        $exists = User::where('email', $request->email)->exists();

        return response()->json([
            'valid' => !$exists,
            'message' => $exists ? 'Email sudah terdaftar' : 'Email tersedia'
        ]);
    }

    // RESTful methods untuk kompatibilitas
    public function index()
    {
        return $this->showLoginForm();
    }

    public function create()
    {
        return $this->showRegistrationForm();
    }

    public function store(Request $request)
    {
        return $this->register($request);
    }

    public function show(string $id)
    {
        abort(404);
    }

    public function edit(string $id)
    {
        abort(404);
    }

    public function update(Request $request, string $id)
    {
        abort(404);
    }

    public function destroy(string $id)
    {
        abort(404);
    }
}
