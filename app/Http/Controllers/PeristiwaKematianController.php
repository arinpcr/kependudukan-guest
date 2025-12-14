<?php

namespace App\Http\Controllers;

use App\Models\PeristiwaKematian;
use App\Models\Warga;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; // WAJIB ADA untuk Transaction

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
                  ->orWhere('warga.no_ktp', 'like', '%' . $search . '%')
                  ->orWhere('peristiwa_kematian.nik', 'like', '%' . $search . '%')
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
        $warga = Warga::orderBy('nama', 'asc')->get();
        return view('pages.kematian.create', compact('warga'));
    }

    public function store(Request $request)
    {
        // 1. VALIDASI
        $request->validate([
            'warga_id'        => 'required|exists:warga,warga_id',
            // [FIX] before_or_equal:today mencegah input tahun 20002 atau masa depan
            'tgl_meninggal'   => 'required|date|before_or_equal:today', 
            'sebab_kematian'  => 'required|string|max:255',
            'tempat_kematian' => 'nullable|string|max:255',
            // Validasi File Upload
            'files.*'         => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'tgl_meninggal.before_or_equal' => 'Tanggal meninggal tidak boleh melebihi hari ini.',
        ]);

        // [FIX] Gunakan Transaction agar data & file konsisten
        DB::beginTransaction();

        try {
            // A. Ambil Data Warga
            $warga = Warga::findOrFail($request->warga_id);

            // B. Simpan Data Kematian
            $kematian = PeristiwaKematian::create([
                'warga_id'        => $request->warga_id,
                'nik'             => $warga->no_ktp, // Copy NIK dari Warga
                'tgl_meninggal'   => $request->tgl_meninggal,
                'sebab_kematian'  => $request->sebab_kematian,
                'tempat_kematian' => $request->tempat_kematian,
            ]);

            // C. Proses Upload File (Jika Ada)
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    
                    // Simpan ke storage (pastikan folder public/uploads ada)
                    $file->storeAs('public/uploads', $filename);

                    // Simpan ke tabel media
                    Media::create([
                        'ref_table' => 'peristiwa_kematian',
                        'ref_id'    => $kematian->kematian_id,
                        'file_name' => $filename,
                        'file_path' => 'uploads/' . $filename,
                        'file_type' => 'document',
                        'mime_type' => $file->getMimeType(),
                        'caption'   => 'Bukti Kematian (Upload Awal)',
                    ]);
                }
            }

            // D. Commit (Simpan Permanen)
            DB::commit();

            return redirect()->route('kematian.index')
                             ->with('success', 'Data berhasil disimpan & file berhasil diupload.');

        } catch (\Exception $e) {
            // E. Rollback (Batalkan semua jika error)
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
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
        $warga = Warga::orderBy('nama', 'asc')->get();

        return view('pages.kematian.edit', compact('kematian', 'warga'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'warga_id'       => 'required|exists:warga,warga_id',
            'tgl_meninggal'  => 'required|date|before_or_equal:today',
            'sebab_kematian' => 'required|string',
        ]);

        $kematian = PeristiwaKematian::findOrFail($id);
        $warga = Warga::findOrFail($request->warga_id);

        $kematian->update([
            'warga_id'        => $request->warga_id,
            'nik'             => $warga->no_ktp, // Update NIK jika warga berubah
            'tgl_meninggal'   => $request->tgl_meninggal,
            'sebab_kematian'  => $request->sebab_kematian,
            'tempat_kematian' => $request->tempat_kematian,
        ]);

        return redirect()->route('kematian.index')
                         ->with('success', 'Data kematian berhasil diperbarui!');
    }

    // Fungsi upload tambahan dari halaman Show (Detail)
    public function storeMedia(Request $request)
    {
        $request->validate([
            'ref_id'  => 'required',
            'files'   => 'required',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
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

        // Hapus file fisik dulu
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