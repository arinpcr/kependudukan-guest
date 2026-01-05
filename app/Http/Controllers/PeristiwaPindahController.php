<?php

namespace App\Http\Controllers;

use App\Models\PeristiwaPindah;
use App\Models\Warga;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PeristiwaPindahController extends Controller
{
    public function index(Request $request)
    {
        $query = PeristiwaPindah::with('warga');

        // 1. Filter Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('warga', function($subQ) use ($search) {
                    $subQ->where('nama', 'like', '%' . $search . '%')
                           ->orWhere('no_ktp', 'like', '%' . $search . '%');
                })
                ->orWhere('alamat_tujuan', 'like', '%' . $search . '%')
                ->orWhere('alasan', 'like', '%' . $search . '%'); 
            });
        }

        // 2. Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'tgl_terlama': $query->orderBy('tgl_pindah', 'asc'); break;
                case 'nama_az': 
                    $query->join('warga', 'peristiwa_pindah.warga_id', '=', 'warga.warga_id')
                          ->orderBy('warga.nama', 'asc')
                          ->select('peristiwa_pindah.*'); 
                    break;
                case 'nama_za': 
                    $query->join('warga', 'peristiwa_pindah.warga_id', '=', 'warga.warga_id')
                          ->orderBy('warga.nama', 'desc')
                          ->select('peristiwa_pindah.*');
                    break;
                case 'tgl_terbaru': default: $query->orderBy('tgl_pindah', 'desc'); break;
            }
        } else {
            $query->orderBy('tgl_pindah', 'desc');
        }

        $perPage = $request->input('per_page', 12);
        $data = $query->paginate($perPage)->withQueryString();

        return view('pages.pindah.index', compact('data'));
    }

    public function create()
    {
        $warga = Warga::orderBy('nama', 'asc')->get();
        return view('pages.pindah.create', compact('warga'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input Form
        $request->validate([
            'warga_id'      => 'required',
            'tgl_pindah'    => 'required|date',
            'jenis_pindah'  => 'required|string', 
            'alamat_asal'   => 'required|string',
            'alamat_tujuan' => 'required|string',
            'alasan'        => 'nullable|string',
            'no_surat'      => 'nullable|string',
            'files.*'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        DB::beginTransaction();

        try {
            // 2. Mapping Data ke Kolom Alasan (Gabung String)
            $infoLengkap = "Jenis: " . $request->jenis_pindah . " | Asal: " . $request->alamat_asal . " | Ket: " . ($request->alasan ?? '-');

            // 3. Simpan Data Pindah
            $pindah = PeristiwaPindah::create([
                'warga_id'      => $request->warga_id,
                'tgl_pindah'    => $request->tgl_pindah,
                'alamat_tujuan' => $request->alamat_tujuan,
                'alasan'        => $infoLengkap,
                'no_surat'      => $request->no_surat,
            ]);

            // 4. Upload File (Looping Array files[])
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    
                    // Simpan ke storage/app/public/uploads
                    $file->storeAs('public/uploads', $filename);

                    // Simpan ke Tabel Media
                    Media::create([
                        'ref_table' => 'peristiwa_pindah',
                        'ref_id'    => $pindah->pindah_id, // Ambil ID Pindah yang baru dibuat
                        'file_path' => 'uploads/' . $filename,
                        'file_name' => $filename, // Simpan nama file fisik
                        'mime_type' => $file->getMimeType(),
                        'caption'   => $request->caption ?? $file->getClientOriginalName(), // Default nama asli file jika caption kosong
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('pindah.index')->with('success', 'Data perpindahan berhasil dicatat!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->withErrors(['msg' => 'Gagal menyimpan: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $pindah = PeristiwaPindah::with('warga')->findOrFail($id);
        $documents = Media::where('ref_table', 'peristiwa_pindah')->where('ref_id', $id)->get();
        return view('pages.pindah.show', compact('pindah', 'documents'));
    }

    public function edit($id)
    {
        $pindah = PeristiwaPindah::findOrFail($id);
        $warga = Warga::orderBy('nama', 'asc')->get();
        return view('pages.pindah.edit', compact('pindah', 'warga'));
    }

    public function update(Request $request, $id)
    {
        $pindah = PeristiwaPindah::findOrFail($id);
        
        $request->validate([
            'tgl_pindah'    => 'required|date',
            'jenis_pindah'  => 'required|string',
            'alamat_asal'   => 'required|string',
            'alamat_tujuan' => 'required|string',
        ]);

        // Logic penggabungan yang sama saat Update
        $infoLengkap = "Jenis: " . $request->jenis_pindah . " | Asal: " . $request->alamat_asal . " | Ket: " . ($request->alasan ?? '-');

        $pindah->update([
            'tgl_pindah'    => $request->tgl_pindah,
            'alamat_tujuan' => $request->alamat_tujuan,
            'alasan'        => $infoLengkap,
            'no_surat'      => $request->no_surat,
        ]);

        return redirect()->route('pindah.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pindah = PeristiwaPindah::findOrFail($id);
        
        // Hapus File Fisik & Data Media
        $docs = Media::where('ref_table', 'peristiwa_pindah')->where('ref_id', $id)->get();
        foreach($docs as $doc) {
            if(Storage::exists('public/uploads/' . $doc->file_name)) {
                Storage::delete('public/uploads/' . $doc->file_name);
            }
            $doc->delete();
        }
        
        $pindah->delete();
        return redirect()->route('pindah.index')->with('success', 'Data berhasil dihapus.');
    }

    // --- FUNGSI UPLOAD DARI HALAMAN DETAIL (SHOW) ---
    public function storeMedia(Request $request)
    {
        $request->validate([
            'ref_id'  => 'required', 
            'files'   => 'required', // Array files[]
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf|max:5120', 
        ]);

        try {
            if ($request->hasFile('files')) {
                // Looping karena inputnya array multiple
                foreach ($request->file('files') as $file) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/uploads', $filename);

                    Media::create([
                        'ref_table' => 'peristiwa_pindah',
                        'ref_id'    => $request->ref_id,
                        'file_path' => 'uploads/' . $filename,
                        'file_name' => $filename,
                        'mime_type' => $file->getMimeType(),
                        'caption'   => $request->caption ?? $file->getClientOriginalName(),
                    ]);
                }
                return back()->with('success', 'File berhasil diunggah!');
            }
            return back()->with('error', 'Tidak ada file dipilih.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal upload: ' . $e->getMessage());
        }
    }

    // Fungsi Hapus Media
    public function deleteMedia($media_id)
    {
        $media = Media::findOrFail($media_id);
        
        if(Storage::exists('public/uploads/' . $media->file_name)) {
            Storage::delete('public/uploads/' . $media->file_name);
        }
        
        $media->delete();
        return back()->with('success', 'File berhasil dihapus.');
    }
}