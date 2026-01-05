<?php

namespace App\Http\Controllers;

use App\Models\PeristiwaKematian;
use App\Models\Warga;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PeristiwaKematianController extends Controller
{
    public function index(Request $request)
    {
        $query = PeristiwaKematian::with('warga')
            ->join('warga', 'peristiwa_kematian.warga_id', '=', 'warga.warga_id')
            ->select('peristiwa_kematian.*');

        // 1. Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('warga.nama', 'like', '%' . $search . '%')
                  ->orWhere('warga.no_ktp', 'like', '%' . $search . '%')
                  ->orWhere('sebab', 'like', '%' . $search . '%')
                  ->orWhere('lokasi', 'like', '%' . $search . '%')
                  ->orWhere('no_surat', 'like', '%' . $search . '%');
            });
        }

        // 2. Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'tgl_terbaru': $query->orderBy('tgl_meninggal', 'desc'); break;
                case 'tgl_terlama': $query->orderBy('tgl_meninggal', 'asc'); break;
                case 'nama_az': $query->orderBy('warga.nama', 'asc'); break;
                case 'nama_za': $query->orderBy('warga.nama', 'desc'); break;
                default: $query->orderBy('tgl_meninggal', 'desc'); break;
            }
        } else {
            $query->orderBy('tgl_meninggal', 'desc');
        }

        $perPage = $request->input('per_page', 12);
        $data = $query->paginate($perPage);

        return view('pages.kematian.index', compact('data'));
    }

    public function create()
    {
        $warga = Warga::orderBy('nama', 'asc')->get();
        return view('pages.kematian.create', compact('warga'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warga_id'      => 'required|exists:warga,warga_id',
            'tgl_meninggal' => 'required|date|before_or_equal:today',
            'sebab'         => 'required|string|max:255',
            'lokasi'        => 'required|string|max:255',
            'no_surat'      => 'nullable|string|max:50',
            'files.*'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // Simpan Data
            $kematian = PeristiwaKematian::create([
                'warga_id'      => $request->warga_id,
                'tgl_meninggal' => $request->tgl_meninggal,
                'sebab'         => $request->sebab,
                'lokasi'        => $request->lokasi,
                'no_surat'      => $request->no_surat,
            ]);

            // Upload File
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/uploads', $filename);

                    Media::create([
                        'ref_table' => 'peristiwa_kematian',
                        'ref_id'    => $kematian->kematian_id,
                        'file_name' => $filename,
                        'file_path' => 'uploads/' . $filename,
                        'mime_type' => $file->getMimeType(),
                        'caption'   => $request->caption ?? $file->getClientOriginalName(),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('kematian.index')->with('success', 'Data berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $kematian = PeristiwaKematian::with('warga')->findOrFail($id);
        $documents = Media::where('ref_table', 'peristiwa_kematian')->where('ref_id', $id)->get();
        return view('pages.kematian.show', compact('kematian', 'documents'));
    }

    public function edit($id)
    {
        $kematian = PeristiwaKematian::findOrFail($id);
        $warga = Warga::orderBy('nama', 'asc')->get();
        return view('pages.kematian.edit', compact('kematian', 'warga'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'warga_id'      => 'required|exists:warga,warga_id',
            'tgl_meninggal' => 'required|date|before_or_equal:today',
            'sebab'         => 'required|string',
            'lokasi'        => 'required|string',
        ]);

        $kematian = PeristiwaKematian::findOrFail($id);
        
        $kematian->update([
            'warga_id'      => $request->warga_id,
            'tgl_meninggal' => $request->tgl_meninggal,
            'sebab'         => $request->sebab,
            'lokasi'        => $request->lokasi,
            'no_surat'      => $request->no_surat,
        ]);

        return redirect()->route('kematian.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kematian = PeristiwaKematian::findOrFail($id);
        
        // Hapus Media
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

    // --- FUNGSI TAMBAHAN (FULL CODE) ---

    // 1. Simpan Media Tambahan (dari halaman Show)
    public function storeMedia(Request $request)
    {
        $request->validate([
            'ref_id'      => 'required',
            'files'       => 'required',
            'files.*'     => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/uploads', $filename);

                Media::create([
                    'ref_table' => 'peristiwa_kematian',
                    'ref_id'    => $request->ref_id,
                    'file_name' => $filename,
                    'file_path' => 'uploads/' . $filename,
                    'caption'   => $request->caption ?? $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                ]);
            }
        }
        return back()->with('success', 'File tambahan berhasil diunggah!');
    }

    // 2. Hapus Media (dari halaman Show)
    public function deleteMedia($media_id)
    {
        $media = Media::findOrFail($media_id);
        
        // Hapus file fisik di storage
        if (Storage::exists('public/uploads/' . $media->file_name)) {
            Storage::delete('public/uploads/' . $media->file_name);
        }
        
        // Hapus data di database
        $media->delete();
        
        return back()->with('success', 'File berhasil dihapus!');
    }
}