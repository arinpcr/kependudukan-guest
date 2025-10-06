<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan halaman login
     */
    public function index()
    {
        return view('login-form');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Menerima dan memproses data login
     */
    public function login(Request $request)
{
    $guestUsername = 'Arin';
    $guestPassword = 'Arin';

    // Validasi sederhana
  $request->validate([
    'username' => 'required',
    'password' => ['required', 'min:3', 'regex:/[A-Z]/']
]);


    // Pengecekan login
    if ($request->username === $guestUsername && $request->password === $guestPassword) {
        // Simpan username ke session biar nanti bisa dipakai di dashboard
        session(['username' => $request->username]);

        // Arahkan ke halaman success
        return redirect('/auth/success');
    } else {
        return back()->with('error', 'Username atau password salah! Pastikan huruf kapital sudah benar.');
    }
}

// Menampilkan halaman success
public function success()
{
    $username = session('username');
    return view('guest-success', compact('username'));
}
}
