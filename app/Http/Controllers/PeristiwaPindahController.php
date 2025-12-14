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
                // Cari berdasarkan nama warga atau NIK
                $q->whereHas('warga', function($subQ) use ($search) {
                    $subQ->where('nama', 'like', '%' . $search . '%')
                           ->orWhere('no_ktp', 'like', '%' . $search . '%');
                })
                // Cari berdasarkan alamat tujuan
                ->orWhere('alamat_tujuan', 'like', '%' . $search . '%')
                // Cari berdasarkan alasan (yang sekarang memuat jenis pindah & asal)
                ->orWhere('alasan', 'like', '%' . $search . '%'); 
                // CATATAN: 'alamat_asal' dihapus dari pencarian karena kolomnya tidak ada
            });
        }

        // 2. Filter Tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tgl_pindah', $request->tahun);
        }

        // 3. Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'tgl_terlama': $query->orderBy('tgl_pindah', 'asc'); break;
                case 'nama_az': 
                    $query->join('warga', 'peristiwa_pindah.warga_id', '=', 'warga.warga_id') // Sesuaikan PK warga jika 'id' atau 'warga_id'
                          ->orderBy('warga.nama', 'asc')
                          ->select('peristiwa_pindah.*'); // Penting agar ID tidak tertimpa
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
        // Ambil warga, asumsikan PK warga adalah 'id' atau 'warga_id' sesuaikan dengan model Warga kamu
        $warga = Warga::orderBy('nama', 'asc')->get();
        return view('pages.pindah.create', compact('warga'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input Form
        $request->validate([
            'warga_id'      => 'required', // Sesuaikan validasi exists jika perlu
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
            // 2. GABUNGKAN DATA (Mapping Manual)
            // Karena kolom 'jenis_pindah' & 'alamat_asal' TIDAK ADA di DB,
            // kita simpan infonya ke dalam kolom 'alasan' agar tidak hilang.
            $infoLengkap = "Jenis: " . $request->jenis_pindah . " | Asal: " . $request->alamat_asal . " | Ket: " . ($request->alasan ?? '-');

            // 3. Simpan Data ke Database
            $pindah = PeristiwaPindah::create([
                'warga_id'      => $request->warga_id,
                'tgl_pindah'    => $request->tgl_pindah,
                'alamat_tujuan' => $request->alamat_tujuan,
                'alasan'        => $infoLengkap, // Masuk ke sini
                'no_surat'      => $request->no_surat,
            ]);

            // 4. Update Status Warga (Opsional, uncomment jika butuh)
            // Warga::where('id', $request->warga_id)->update(['status' => 'Pindah']); 
            // Pastikan pakai PK yang benar ('id' atau 'warga_id')

            // 5. Upload File
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('public/uploads', $filename);

                    Media::create([
                        'ref_table' => 'peristiwa_pindah',
                        'ref_id'    => $pindah->pindah_id, // Menggunakan PK pindah_id
                        'file_path' => 'uploads/' . $filename,
                        'file_name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getClientMimeType(),
                        'caption'   => 'Dokumen Pindah'
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('pindah.index')->with('success', 'Data perpindahan berhasil dicatat!');

        } catch (\Exception $e) {
            DB::rollback();
            // Tampilkan pesan error spesifik untuk debugging
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
            'alasan'        => $infoLengkap, // Update kolom alasan
            'no_surat'      => $request->no_surat,
            // jenis_pindah dan alamat_asal tidak dimasukkan sebagai key array
        ]);

        return redirect()->route('pindah.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pindah = PeristiwaPindah::findOrFail($id);
        
        $docs = Media::where('ref_table', 'peristiwa_pindah')->where('ref_id', $id)->get();
        foreach($docs as $doc) {
            if(Storage::exists('public/'.$doc->file_path)) {
                Storage::delete('public/'.$doc->file_path);
            }
            $doc->delete();
        }
        
        $pindah->delete();
        return redirect()->route('pindah.index')->with('success', 'Data berhasil dihapus.');
    }
}