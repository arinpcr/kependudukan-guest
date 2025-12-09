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
            ->join('warga', 'peristiwa_kematian.warga_id', '=', 'warga.warga_id')
            ->select('peristiwa_kematian.*');

        // 1. Fitur Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('warga.nama', 'like', '%' . $search . '%')
                  ->orWhere('warga.no_ktp', 'like', '%' . $search . '%') // Cari berdasarkan no_ktp warga
                  ->orWhere('peristiwa_kematian.nik', 'like', '%' . $search . '%') // Cari berdasarkan nik tersimpan
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
            $query->orderBy('tgl_meninggal', 'desc');
        }

        // 3. Pagination
        $perPage = $request->input('per_page', 12);
        $data = $query->paginate($perPage);

        return view('pages.kematian.index', compact('data'));
    }

    public function create()
    {
        // Ambil warga yang statusnya masih HIDUP (asumsi logis)
        // Tapi untuk sekarang ambil semua dulu tidak apa-apa
        $warga = Warga::all();
        return view('pages.kematian.create', compact('warga'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warga_id' => 'required|exists:warga,warga_id',
            'tgl_meninggal' => 'required|date',
            'sebab_kematian' => 'required|string',
        ]);

        // 1. Ambil Data Warga
        $warga = Warga::findOrFail($request->warga_id);

        // 2. Siapkan Data
        $data = $request->all();

        // --- PERBAIKAN UTAMA DISINI ---
        // Kita ambil dari 'no_ktp' milik Warga, lalu simpan ke kolom 'nik' milik Kematian
        $data['nik'] = $warga->no_ktp;
        // ------------------------------

        // 3. Simpan
        $kematian = PeristiwaKematian::create($data);

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

    public function edit($id)
    {
        $kematian = PeristiwaKematian::findOrFail($id);
        $warga = Warga::all();

        return view('pages.kematian.edit', compact('kematian', 'warga'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'warga_id' => 'required|exists:warga,warga_id',
            'tgl_meninggal' => 'required|date',
            'sebab_kematian' => 'required|string',
        ]);

        $kematian = PeristiwaKematian::findOrFail($id);

        // 1. Ambil Data Warga (Siapa tau user ganti orangnya)
        $warga = Warga::findOrFail($request->warga_id);

        // 2. Update data
        $data = $request->all();

        // --- PERBAIKAN UTAMA DISINI JUGA ---
        $data['nik'] = $warga->no_ktp;
        // -----------------------------------

        $kematian->update($data);

        return redirect()->route('kematian.index')
                         ->with('success', 'Data kematian berhasil diperbarui!');
    }

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
