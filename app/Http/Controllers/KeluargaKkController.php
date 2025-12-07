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
    public function index(Request $request)
    {
        // Query dasar dengan eager loading
        $query = KeluargaKk::with('kepalaKeluarga');

        // Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kk_nomor', 'like', '%' . $search . '%')
                  ->orWhere('alamat', 'like', '%' . $search . '%')
                  ->orWhere('rt', 'like', '%' . $search . '%')
                  ->orWhere('rw', 'like', '%' . $search . '%')
                  ->orWhereHas('kepalaKeluarga', function($q2) use ($search) {
                      $q2->where('nama', 'like', '%' . $search . '%');
                  });
            });
        }

        // Filter RT
        if ($request->has('rt') && $request->rt != '') {
            $query->where('rt', $request->rt);
        }

        // Filter RW
        if ($request->has('rw') && $request->rw != '') {
            $query->where('rw', $request->rw);
        }

        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'kk_nomor_desc':
                    $query->orderBy('kk_nomor', 'desc');
                    break;
                case 'alamat':
                    $query->orderBy('alamat', 'asc');
                    break;
                case 'alamat_desc':
                    $query->orderBy('alamat', 'desc');
                    break;
                case 'terbaru':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'terlama':
                    $query->orderBy('created_at', 'asc');
                    break;
                default:
                    $query->orderBy('kk_nomor', 'asc');
                    break;
            }
        } else {
            $query->orderBy('kk_nomor', 'asc');
        }

        // Pagination
        $perPage = $request->has('per_page') ? $request->per_page : 12;
        $keluarga = $query->paginate($perPage);

        return view('pages.keluarga.index', compact('keluarga'))->with('request', $request);
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