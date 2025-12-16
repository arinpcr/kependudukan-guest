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
                // Cari berdasarkan alasan
                ->orWhere('alasan', 'like', '%' . $search . '%'); 
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
        // Sesuaikan 'warga_id' atau 'id' tergantung PK tabel warga kamu
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
            // 2. Mapping Data ke Kolom Alasan
            $infoLengkap = "Jenis: " . $request->jenis_pindah . " | Asal: " . $request->alamat_asal . " | Ket: " . ($request->alasan ?? '-');

            // 3. Simpan Data Pindah
            $pindah = PeristiwaPindah::create([
                'warga_id'      => $request->warga_id,
                'tgl_pindah'    => $request->tgl_pindah,
                'alamat_tujuan' => $request->alamat_tujuan,
                'alasan'        => $infoLengkap,
                'no_surat'      => $request->no_surat,
            ]);

            // 4. Upload File (Jika ada saat create)
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    // Simpan ke storage/app/public/uploads
                    $path = $file->storeAs('public/uploads', $filename);

                    Media::create([
                        'ref_table' => 'peristiwa_pindah',
                        'ref_id'    => $pindah->pindah_id, // Pastikan model PeristiwaPindah primary key-nya benar
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

    /**
     * [BARU] Method untuk menangani Upload Dokumen Tambahan (Dari Modal/Detail)
     */
    public function storeMedia(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'ref_id'  => 'required', 
            // Validasi untuk SINGLE file (tanpa bintang *)
            'files'   => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', 
            'caption' => 'nullable|string|max:255',
        ]);

        try {
            // 2. Ambil Data Pindah
            // Pastikan pakai findOrFail agar kalau ID salah langsung 404, bukan error aneh
            $pindah = PeristiwaPindah::findOrFail($request->ref_id);

            // 3. Proses Upload
            if ($request->hasFile('files')) {
                $file = $request->file('files'); // Ambil file tunggal
                
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/uploads', $filename);

                // 4. Simpan ke Database Media
                Media::create([
                    'ref_table' => 'peristiwa_pindah',
                    'ref_id'    => $pindah->pindah_id, // Menggunakan ID dari data yang ditemukan
                    'file_path' => 'uploads/' . $filename,
                    'file_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getClientMimeType(),
                    'caption'   => $request->caption ?? $file->getClientOriginalName(),
                ]);

                return redirect()->back()->with('success', 'Dokumen pendukung berhasil diunggah!');
            }

            return redirect()->back()->with('error', 'Tidak ada file yang dipilih.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal upload: ' . $e->getMessage());
        }
    }
}