<?php

namespace App\Http\Controllers;

use App\Models\KeluargaKk; // 1. Import model KeluargaKk
use App\Models\Warga;       // 2. Import model Warga (untuk Foreign Key)
use Illuminate\Http\Request;

class KeluargaKkController extends Controller
{
    /**
     * Menampilkan daftar semua data keluarga_kk.
     */
    public function index()
    {
        // Ambil data KK, muat relasi 'kepalaKeluarga' (untuk mengambil nama)
        // 'with('kepalaKeluarga')' -> Mencegah N+1 problem
        $keluarga = KeluargaKk::with('kepalaKeluarga')
                            ->orderBy('kk_nomor', 'asc')
                            ->paginate(10);

        return view('pages.keluarga.index', compact('keluarga'));
    }

    /**
     * Menampilkan formulir untuk membuat data KK baru.
     */
    public function create()
    {
        // Kita perlu mengambil daftar warga untuk dijadikan pilihan Kepala Keluarga
        $warga = Warga::orderBy('nama', 'asc')->get();

        return view('pages.keluarga.create', compact('warga'));
    }

    /**
     * Menyimpan data KK baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'kk_nomor' => 'required|string|max:50|unique:keluarga_kk,kk_nomor',
            'kepala_keluarga_warga_id' => 'required|integer|exists:warga,warga_id',
            'alamat' => 'required|string|max:255',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
        ]);

        // 2. Simpan data
        KeluargaKk::create($request->all());

        // 3. Redirect
        return redirect()->route('keluarga.index')
                         ->with('success', 'Data Keluarga KK berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu data KK.
     * Kita ganti 'string $id' menjadi 'KeluargaKk $keluarga' (Route Model Binding)
     */
    public function show(KeluargaKk $keluarga)
    {
        // Data $keluarga sudah otomatis diambil Laravel
        // Kita bisa muat relasinya jika perlu
        $keluarga->load('kepalaKeluarga');

        return view('pages.keluarga.show', compact('keluarga')); // Perbaiki path view
    }

    /**
     * Menampilkan formulir untuk mengedit data KK.
     */
    public function edit(KeluargaKk $keluarga)
    {
        // Data $keluarga sudah otomatis diambil

        // Kita juga perlu daftar warga untuk dropdown
        $warga = Warga::orderBy('nama', 'asc')->get();

        return view('pages.keluarga.edit', compact('keluarga', 'warga'));
    }

    /**
     * Memperbarui data KK di database.
     */
    public function update(Request $request, KeluargaKk $keluarga)
    {
        // 1. Validasi
        $request->validate([
            // Rule 'unique' harus mengabaikan data KK yang sedang diedit
            'kk_nomor' => 'required|string|max:50|unique:keluarga_kk,kk_nomor,' . $keluarga->kk_id . ',kk_id',
            'kepala_keluarga_warga_id' => 'required|integer|exists:warga,warga_id',
            'alamat' => 'required|string|max:255',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
        ]);

        // 2. Update data
        $keluarga->update($request->all());

        // 3. Redirect
        return redirect()->route('keluarga.index')
                         ->with('success', 'Data Keluarga KK berhasil diperbarui.');
    }

    /**
     * Menghapus data KK dari database.
     */
    public function destroy(KeluargaKk $keluarga)
    {
        // 1. Hapus data
        $keluarga->delete();

        // 2. Redirect
        return redirect()->route('keluarga.index')
                         ->with('success', 'Data Keluarga KK berhasil dihapus.');
    }
}
