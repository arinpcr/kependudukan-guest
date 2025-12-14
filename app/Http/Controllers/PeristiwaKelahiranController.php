<?php

namespace App\Http\Controllers;

use App\Models\PeristiwaKelahiran;
use App\Models\Warga;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PeristiwaKelahiranController extends Controller
{
    public function index(Request $request)
    {
        // 1. Eager Loading Relasi (PENTING: Load ayah & ibu)
        $query = PeristiwaKelahiran::with(['bayi', 'ayah', 'ibu']);

        // 2. Filter Pencarian Lengkap
        if ($request->filled('search')) {
            $search = $request->search;
            
            $query->where(function($q) use ($search) {
                // Cari di Nama Bayi
                $q->whereHas('bayi', function($subQ) use ($search) {
                    $subQ->where('nama', 'like', '%' . $search . '%');
                })
                // [BARU] Cari di Nama Ayah
                ->orWhereHas('ayah', function($subQ) use ($search) {
                    $subQ->where('nama', 'like', '%' . $search . '%');
                })
                // [BARU] Cari di Nama Ibu
                ->orWhereHas('ibu', function($subQ) use ($search) {
                    $subQ->where('nama', 'like', '%' . $search . '%');
                })
                // Cari di No Akta & Tempat Lahir
                ->orWhere('no_akta', 'like', '%' . $search . '%')
                ->orWhere('tempat_lahir', 'like', '%' . $search . '%');
            });
        }

        // 3. Filter Bulan Lahir
        if ($request->filled('bulan')) {
            $query->whereMonth('tgl_lahir', $request->bulan);
        }

        // 4. Filter Tahun Lahir
        if ($request->filled('tahun')) {
            $query->whereYear('tgl_lahir', $request->tahun);
        }

        // 5. Sorting / Urutan
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'tgl_terlama':
                    $query->orderBy('tgl_lahir', 'asc');
                    break;
                case 'input_terbaru':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'tgl_terbaru':
                default:
                    $query->orderBy('tgl_lahir', 'desc');
                    break;
            }
        } else {
            $query->orderBy('tgl_lahir', 'desc');
        }

        // 6. Pagination Dinamis
        $perPage = $request->input('per_page', 12);
        $data = $query->paginate($perPage)->withQueryString();

        return view('pages.kelahiran.index', compact('data'));
    }

    public function create()
    {
        // Dropdown Bayi: Ambil semua warga
        $warga_all = Warga::orderBy('nama', 'asc')->get();

        // Dropdown Ayah: Hanya Laki-laki
        $ayah_list = Warga::where('jenis_kelamin', 'L')->orderBy('nama', 'asc')->get();

        // Dropdown Ibu: Hanya Perempuan
        $ibu_list  = Warga::where('jenis_kelamin', 'P')->orderBy('nama', 'asc')->get();

        return view('pages.kelahiran.create', compact('warga_all', 'ayah_list', 'ibu_list'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warga_id'      => 'required|unique:peristiwa_kelahiran,warga_id',
            'tgl_lahir'     => 'required|date|before_or_equal:today',
            'tempat_lahir'  => 'required|string|max:255',
            'no_akta'       => 'nullable|unique:peristiwa_kelahiran,no_akta',
            'files.*'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // 1. Simpan Data
            $kelahiran = PeristiwaKelahiran::create([
                'warga_id'      => $request->warga_id,
                'tgl_lahir'     => $request->tgl_lahir,
                'tempat_lahir'  => $request->tempat_lahir,
                'no_akta'       => $request->no_akta,
                'ayah_warga_id' => $request->ayah_warga_id,
                'ibu_warga_id'  => $request->ibu_warga_id,
            ]);

            // 2. Upload File (Jika ada)
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/uploads', $filename);

                    Media::create([
                        'ref_table' => 'peristiwa_kelahiran',
                        'ref_id'    => $kelahiran->kelahiran_id,
                        'file_name' => $filename,
                        'caption'   => 'Bukti Kelahiran',
                        'mime_type' => $file->getMimeType(),
                        'file_path' => 'uploads/' . $filename,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('kelahiran.index')->with('success', 'Data kelahiran berhasil dicatat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $kelahiran = PeristiwaKelahiran::with(['bayi', 'ayah', 'ibu'])->findOrFail($id);
        // Ambil dokumen via relasi model
        $documents = $kelahiran->dokumen; 
        return view('pages.kelahiran.show', compact('kelahiran', 'documents'));
    }

    public function edit($id)
    {
        $kelahiran = PeristiwaKelahiran::findOrFail($id);
        $warga_all = Warga::orderBy('nama', 'asc')->get();
        $ayah_list = Warga::where('jenis_kelamin', 'L')->orderBy('nama', 'asc')->get();
        $ibu_list  = Warga::where('jenis_kelamin', 'P')->orderBy('nama', 'asc')->get();

        return view('pages.kelahiran.edit', compact('kelahiran', 'warga_all', 'ayah_list', 'ibu_list'));
    }

    public function update(Request $request, $id)
    {
        $kelahiran = PeristiwaKelahiran::findOrFail($id);

        $request->validate([
            // Ignore ID saat cek unique warga_id sendiri
            'warga_id'      => 'required|unique:peristiwa_kelahiran,warga_id,'.$id.',kelahiran_id',
            'tgl_lahir'     => 'required|date',
            'tempat_lahir'  => 'required',
            'no_akta'       => 'nullable|unique:peristiwa_kelahiran,no_akta,'.$id.',kelahiran_id',
        ]);

        $kelahiran->update($request->all());

        return redirect()->route('kelahiran.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kelahiran = PeristiwaKelahiran::findOrFail($id);

        // Hapus file fisik
        foreach($kelahiran->dokumen as $doc) {
            if (Storage::exists('public/uploads/' . $doc->file_name)) {
                Storage::delete('public/uploads/' . $doc->file_name);
            }
            $doc->delete(); // Hapus record media
        }

        $kelahiran->delete();
        return redirect()->route('kelahiran.index')->with('success', 'Data berhasil dihapus.');
    }

    // Upload Tambahan di halaman Show
    public function storeMedia(Request $request)
    {
        $request->validate([
            'ref_id' => 'required',
            'files.*' => 'file|mimes:jpg,png,pdf|max:2048'
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/uploads', $filename);
                Media::create([
                    'ref_table' => 'peristiwa_kelahiran',
                    'ref_id'    => $request->ref_id,
                    'file_name' => $filename,
                    'file_path' => 'uploads/' . $filename,
                    'caption'   => $request->caption ?? 'Dokumen Tambahan',
                    'mime_type' => $file->getMimeType(),
                ]);
            }
        }
        return back()->with('success', 'File tambahan berhasil diunggah.');
    }
    
    // Fungsi Delete Media (Dipanggil oleh route media.delete)
    public function deleteMedia($media_id)
    {
        $media = Media::findOrFail($media_id);
        if (Storage::exists('public/uploads/' . $media->file_name)) {
            Storage::delete('public/uploads/' . $media->file_name);
        }
        $media->delete();
        return back()->with('success', 'File berhasil dihapus!');
    }
}