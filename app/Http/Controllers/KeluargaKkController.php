<?php

namespace App\Http\Controllers;

use App\Models\KeluargaKk;
use App\Models\Warga;
use Illuminate\Http\Request;

class KeluargaKkController extends Controller
{
    /**
     * Menampilkan daftar semua data keluarga_kk.
     */
    public function index()
    {
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
        $warga = Warga::orderBy('nama', 'asc')->get();
        return view('pages.keluarga.create', compact('warga'));
    }

    /**
     * Menyimpan data KK baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kk_nomor' => 'required|string|max:50|unique:keluarga_kk,kk_nomor',
            'kepala_keluarga_warga_id' => 'required|integer|exists:warga,warga_id',
            'alamat' => 'required|string|max:255',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
        ]);

        KeluargaKk::create($request->all());

        return redirect()->route('keluarga.index')
                         ->with('success', 'Data Keluarga KK berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu data KK.
     * ✅ DIPERBAIKI: Gunakan Route Model Binding dengan benar
     */
    public function show(KeluargaKk $keluarga)
    {
        // Load relasi yang diperlukan
        $keluarga->load(['kepalaKeluarga', 'anggotaKeluarga.warga']);
        
        return view('pages.keluarga.show', compact('keluarga'));
    }

    /**
     * Menampilkan formulir untuk mengedit data KK.
     */
    public function edit(KeluargaKk $keluarga)
    {
        $warga = Warga::orderBy('nama', 'asc')->get();
        return view('pages.keluarga.edit', compact('keluarga', 'warga'));
    }

    /**
     * Memperbarui data KK di database.
     */
    public function update(Request $request, KeluargaKk $keluarga)
    {
        $request->validate([
            'kk_nomor' => 'required|string|max:50|unique:keluarga_kk,kk_nomor,' . $keluarga->kk_id . ',kk_id',
            'kepala_keluarga_warga_id' => 'required|integer|exists:warga,warga_id',
            'alamat' => 'required|string|max:255',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
        ]);

        $keluarga->update($request->all());

        return redirect()->route('keluarga.index')
                         ->with('success', 'Data Keluarga KK berhasil diperbarui.');
    }

    /**
     * Menghapus data KK dari database.
     */
    public function destroy(KeluargaKk $keluarga)
    {
        $keluarga->delete();
        return redirect()->route('keluarga.index')
                         ->with('success', 'Data Keluarga KK berhasil dihapus.');
    }
}