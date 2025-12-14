<?php

namespace App\Http\Controllers;

use App\Models\KeluargaKk;
use App\Models\Warga;
use App\Models\AnggotaKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeluargaKkController extends Controller
{
    public function index(Request $request)
    {
        $query = KeluargaKk::with('kepalaKeluarga');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kk_nomor', 'like', '%' . $search . '%')
                  ->orWhere('alamat', 'like', '%' . $search . '%')
                  ->orWhereHas('kepalaKeluarga', function($q2) use ($search) {
                      $q2->where('nama', 'like', '%' . $search . '%');
                  });
            });
        }

        if ($request->filled('rt')) $query->where('rt', $request->rt);
        if ($request->filled('rw')) $query->where('rw', $request->rw);

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'kk_nomor_desc': $query->orderBy('kk_nomor', 'desc'); break;
                case 'alamat': $query->orderBy('alamat', 'asc'); break;
                case 'alamat_desc': $query->orderBy('alamat', 'desc'); break;
                case 'terbaru': $query->orderBy('created_at', 'desc'); break;
                case 'terlama': $query->orderBy('created_at', 'asc'); break;
                default: $query->orderBy('kk_nomor', 'asc'); break;
            }
        } else {
            $query->orderBy('kk_nomor', 'asc');
        }

        $keluarga = $query->paginate($request->input('per_page', 12));

        return view('pages.keluarga.index', compact('keluarga'))->with('request', $request);
    }

    public function create()
    {
        $warga = Warga::orderBy('nama', 'asc')->get();
        // Pastikan return view ke folder yang benar
        return view('pages.keluarga.create', compact('warga'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kk_nomor' => 'required|unique:keluarga_kk,kk_nomor|numeric|digits:16',
            'kepala_keluarga_warga_id' => 'required|exists:warga,warga_id',
            'alamat' => 'required|string',
            'rt' => 'required|numeric',
            'rw' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            // 1. Simpan Data KK
            $kk = KeluargaKK::create([
                'kk_nomor' => $request->kk_nomor,
                'kepala_keluarga_warga_id' => $request->kepala_keluarga_warga_id,
                'alamat' => $request->alamat,
                'rt' => $request->rt,
                'rw' => $request->rw,
            ]);

            // 2. Simpan Anggota Keluarga (Kepala Keluarga)
            // PERHATIKAN NAMA KOLOM DI BAWAH INI SANGAT PENTING
            AnggotaKeluarga::create([
                'kk_id' => $kk->kk_id, // Gunakan 'kk_id' bukan 'keluarga_id'
                'warga_id' => $request->kepala_keluarga_warga_id,
                'hubungan' => 'kepala_keluarga', // Gunakan 'hubungan' (kecil snake_case) sesuai ENUM migration
            ]);

            DB::commit();

            return redirect()->route('keluarga.index')
                             ->with('success', 'KK berhasil dibuat & Kepala Keluarga otomatis ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            // Tampilkan error spesifik agar ketahuan jika ada salah
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(KeluargaKk $keluarga)
    {
        $warga = Warga::orderBy('nama', 'asc')->get();
        return view('pages.keluarga.edit', compact('keluarga', 'warga'));
    }

    public function update(Request $request, KeluargaKk $keluarga)
    {
        $request->validate([
            'kk_nomor' => 'required|numeric|digits:16|unique:keluarga_kk,kk_nomor,' . $keluarga->kk_id . ',kk_id',
            'kepala_keluarga_warga_id' => 'required|exists:warga,warga_id',
            'alamat' => 'required|string|max:255',
            'rt' => 'required',
            'rw' => 'required',
        ]);

        $keluarga->update([
            'kk_nomor' => $request->kk_nomor,
            'kepala_keluarga_warga_id' => $request->kepala_keluarga_warga_id,
            'alamat' => $request->alamat,
            'rt' => $request->rt,
            'rw' => $request->rw,
        ]);

        return redirect()->route('keluarga.index')
                         ->with('success', 'Data Keluarga KK berhasil diperbarui.');
    }

    public function destroy(KeluargaKk $keluarga)
    {
        $keluarga->delete();
        return redirect()->route('keluarga.index')
                         ->with('success', 'Data Keluarga KK berhasil dihapus.');
    }
}