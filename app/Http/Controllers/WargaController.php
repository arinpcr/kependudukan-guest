<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data warga, urutkan berdasarkan nama, dan buat pagination
        $warga = Warga::orderBy('nama', 'asc')->paginate(10);

        // Kirim data ke view 'warga.index'
        return view('pages.warga.index', compact('warga'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('pages.warga.create', [
        'warga' => new Warga() // Kirim model Warga yang baru (kosong)
    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi input form
        $request->validate([
            'no_ktp' => 'required|string|max:20|unique:warga,no_ktp',
            'nama' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'nullable|string|max:30',
            'pekerjaan' => 'nullable|string|max:50',
            'telp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
        ]);

        // 2. Jika validasi berhasil, simpan data ke database
        Warga::create($request->all());

        // 3. Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('warga.index')
                         ->with('success', 'Data warga berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // TAMBAHKAN BARIS INI:
    $warga = Warga::find($id);

    return view('warga.show', compact('warga'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
       $warga = Warga::find($id); // Ambil data
    return view('pages.warga.edit', ['warga' => $warga]); // Kirim data
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    // TAMBAHKAN BARIS INI:
    $warga = Warga::find($id);

    // 1. Validasi input form
    $request->validate([
        'no_ktp' => 'required|string|max:20|unique:warga,no_ktp,' . $warga->warga_id . ',warga_id',
        'nama' => 'required|string|max:100',
        'jenis_kelamin' => 'required|in:L,P',
        // ... (sisanya sudah benar)
    ]);

    // 2. Update data warga yang ada
    $warga->update($request->all());

    // 3. Redirect kembali ke halaman index dengan pesan sukses
    return redirect()->route('warga.index')
                        ->with('success', 'Data warga berhasil diperbarui.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    // TAMBAHKAN BARIS INI:
    $warga = Warga::find($id);

    // Jika data tidak ditemukan
    if (!$warga) {
        return redirect()->route('warga.index')
                        ->with('error', 'Data warga tidak ditemukan.');
    }

    // Hapus data warga
    $warga->delete();

    // Redirect kembali ke halaman index dengan pesan sukses
    return redirect()->route('warga.index')
                        ->with('success', 'Data warga berhasil dihapus.');
}
}
