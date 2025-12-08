<?php

namespace App\Http\Controllers;

use App\Models\PeristiwaKematian;
use App\Models\Warga;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PeristiwaKematianController extends Controller
{
    public function index(Request $request)
    {
        // Query Dasar dengan Relasi
        $query = PeristiwaKematian::with('warga')
            // Join agar bisa sorting/searching berdasarkan nama warga
            ->join('warga', 'peristiwa_kematian.warga_id', '=', 'warga.warga_id')
            ->select('peristiwa_kematian.*'); // Ambil kolom tabel kematian saja agar tidak bentrok id

        // 1. Fitur Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('warga.nama', 'like', '%' . $search . '%')
                  ->orWhere('warga.nik', 'like', '%' . $search . '%')
                  ->orWhere('sebab_kematian', 'like', '%' . $search . '%');
            });
        }

        // 2. Fitur Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'tgl_terbaru':
                    $query->orderBy('tgl_meninggal', 'desc');
                    break;
                case 'tgl_terlama':
                    $query->orderBy('tgl_meninggal', 'asc');
                    break;
                case 'nama_az':
                    $query->orderBy('warga.nama', 'asc');
                    break;
                case 'nama_za':
                    $query->orderBy('warga.nama', 'desc');
                    break;
                case 'input_terbaru':
                    $query->orderBy('peristiwa_kematian.created_at', 'desc');
                    break;
                default:
                    $query->orderBy('tgl_meninggal', 'desc');
                    break;
            }
        } else {
            // Default sort: Tanggal meninggal terbaru
            $query->orderBy('tgl_meninggal', 'desc');
        }

        // 3. Pagination Dinamis
        $perPage = $request->input('per_page', 12);
        $data = $query->paginate($perPage);

        return view('pages.kematian.index', compact('data'));
    }

    public function create()
    {
        $warga = Warga::all();
        return view('pages.kematian.create', compact('warga'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warga_id' => 'required|exists:warga,warga_id',
            'tgl_meninggal' => 'required|date',
            'sebab_kematian' => 'required|string',
            // Tambahkan validasi lain jika ada kolom tambahan (misal: tempat_kematian, keterangan)
        ]);

        $kematian = PeristiwaKematian::create($request->all());

        return redirect()->route('kematian.show', $kematian->kematian_id)
                         ->with('success', 'Data berhasil disimpan. Silakan upload bukti dokumen.');
    }

    public function show($id)
    {
        $kematian = PeristiwaKematian::with('warga')->findOrFail($id);
        $documents = Media::where('ref_table', 'peristiwa_kematian')
                          ->where('ref_id', $id)
                          ->get();

        return view('pages.kematian.show', compact('kematian', 'documents'));
    }

    // --- BAGIAN YANG DITAMBAHKAN (EDIT & UPDATE) ---

    /**
     * Menampilkan Form Edit
     */
    public function edit($id)
    {
        // Ambil data kematian berdasarkan ID
        $kematian = PeristiwaKematian::findOrFail($id);
        
        // Ambil data semua warga untuk dropdown (jika user ingin mengubah siapa yang meninggal)
        $warga = Warga::all();

        return view('pages.kematian.edit', compact('kematian', 'warga'));
    }

    /**
     * Memproses Update Data
     */
    public function update(Request $request, $id)
    {
        // 1. Validasi Input (Sama seperti store)
        $request->validate([
            'warga_id' => 'required|exists:warga,warga_id',
            'tgl_meninggal' => 'required|date',
            'sebab_kematian' => 'required|string',
            // Tambahkan validasi lain jika ada
        ]);

        // 2. Cari data yang mau diedit
        $kematian = PeristiwaKematian::findOrFail($id);

        // 3. Update data
        $kematian->update($request->all());

        // 4. Redirect kembali ke index atau show
        return redirect()->route('kematian.index')
                         ->with('success', 'Data kematian berhasil diperbarui!');
    }

    // ------------------------------------------------

    public function storeMedia(Request $request)
    {
        $request->validate([
            'ref_id' => 'required',
            'files' => 'required',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/uploads', $filename);

                Media::create([
                    'ref_table' => 'peristiwa_kematian',
                    'ref_id'    => $request->ref_id,
                    'file_name' => $filename,
                    'caption'   => $request->caption ?? $file->getClientOriginalName(),
                    'mime_type' => $file->getClientMimeType(),
                ]);
            }
        }
        return back()->with('success', 'File berhasil diunggah!');
    }

    public function deleteMedia($media_id)
    {
        $media = Media::findOrFail($media_id);
        if (Storage::exists('public/uploads/' . $media->file_name)) {
            Storage::delete('public/uploads/' . $media->file_name);
        }
        $media->delete();
        return back()->with('success', 'File berhasil dihapus!');
    }
    
    public function destroy($id)
    {
        $kematian = PeristiwaKematian::findOrFail($id);
        
        // Hapus media terkait
        $medias = Media::where('ref_table', 'peristiwa_kematian')->where('ref_id', $id)->get();
        foreach($medias as $m){
             if (Storage::exists('public/uploads/' . $m->file_name)) {
                Storage::delete('public/uploads/' . $m->file_name);
            }
            $m->delete();
        }
        
        $kematian->delete();
        return redirect()->route('kematian.index')->with('success', 'Data berhasil dihapus.');
    }
}