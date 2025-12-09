<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKeluarga;
use App\Models\KeluargaKk;
use App\Models\Warga;
use Illuminate\Http\Request;

class AnggotaKeluargaController extends Controller
{
    // ✅ PROPERTY UNTUK HUBUNGAN OPTIONS
    protected $hubunganOptions = [
        'kepala_keluarga' => 'Kepala Keluarga',
        'istri' => 'Istri',
        'anak' => 'Anak',
        'menantu' => 'Menantu',
        'cucu' => 'Cucu',
        'orang_tua' => 'Orang Tua',
        'mertua' => 'Mertua',
        'famili_lain' => 'Famili Lain',
        'lainnya' => 'Lainnya'
    ];

    /**
     * Menampilkan semua anggota keluarga untuk KK tertentu
     */
    public function index(Request $request, KeluargaKk $keluarga)
    {
        // Query dasar
        $query = $keluarga->anggotaKeluarga()->with('warga');

        // Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('warga', function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('no_ktp', 'like', '%' . $search . '%');
            });
        }

        // Filter hubungan
        if ($request->has('hubungan') && $request->hubungan != '') {
            $query->where('hubungan', $request->hubungan);
        }

        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'nama_desc':
                    $query->whereHas('warga', function($q) {
                        $q->orderBy('nama', 'desc');
                    });
                    break;
                case 'terbaru':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'terlama':
                    $query->orderBy('created_at', 'asc');
                    break;
                default:
                    $query->whereHas('warga', function($q) {
                        $q->orderBy('nama', 'asc');
                    });
                    break;
            }
        } else {
            $query->whereHas('warga', function($q) {
                $q->orderBy('nama', 'asc');
            });
        }

        // Pagination
        $perPage = $request->has('per_page') ? $request->per_page : 12;
        $anggota = $query->paginate($perPage);

        return view('pages.anggota-keluarga.index', compact('keluarga', 'anggota'));
    }

    /**
     * Menampilkan semua anggota dari semua keluarga
     */
    /**
     * Menampilkan semua anggota dari semua keluarga (KHUSUS KEPALA KELUARGA)
     */
    public function allAnggota(Request $request)
    {
        // ✅ PERUBAHAN UTAMA: Tambahkan where('hubungan', 'kepala_keluarga') di sini
        // Ini memaksa query hanya mengambil data Kepala Keluarga sejak awal.
        $query = AnggotaKeluarga::with(['keluarga.kepalaKeluarga', 'warga'])
                    ->where('hubungan', 'kepala_keluarga');

        // Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('warga', function($q2) use ($search) {
                    $q2->where('nama', 'like', '%' . $search . '%')
                       ->orWhere('no_ktp', 'like', '%' . $search . '%');
                })->orWhereHas('keluarga', function($q2) use ($search) {
                    $q2->where('kk_nomor', 'like', '%' . $search . '%');
                });
            });
        }

        // ❌ HAPUS BAGIAN FILTER HUBUNGAN MANUAL
        // Bagian "if ($request->has('hubungan')..." dihapus karena sudah di-filter permanen di atas.

        // Filter KK (Tetap dipertahankan jika ingin filter spesifik KK)
        if ($request->has('kk_id') && $request->kk_id != '') {
            $query->where('kk_id', $request->kk_id);
        }

        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'nama_desc':
                    $query->whereHas('warga', function($q) {
                        $q->orderBy('nama', 'desc');
                    });
                    break;
                case 'kk':
                    $query->orderBy('kk_id', 'asc');
                    break;
                case 'terbaru':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'terlama':
                    $query->orderBy('created_at', 'asc');
                    break;
                default:
                    $query->whereHas('warga', function($q) {
                        $q->orderBy('nama', 'asc');
                    });
                    break;
            }
        } else {
            $query->whereHas('warga', function($q) {
                $q->orderBy('nama', 'asc');
            });
        }

        // Pagination
        $perPage = $request->has('per_page') ? $request->per_page : 12;
        $anggota = $query->paginate($perPage);

        // Ambil data KK untuk dropdown filter (opsional)
        $keluargas = KeluargaKk::with('kepalaKeluarga')->get();

        return view('pages.anggota-keluarga.all', compact('anggota', 'keluargas'));
    }

    /**
     * Menampilkan form tambah anggota
     */
    public function create(KeluargaKk $keluarga)
    {
        $warga = Warga::whereNotIn('warga_id', function($query) use ($keluarga) {
            $query->select('warga_id')
                  ->from('anggota_keluarga')
                  ->where('kk_id', $keluarga->kk_id);
        })->orderBy('nama', 'asc')->get();

        $hubunganOptions = $this->hubunganOptions;

        return view('pages.anggota-keluarga.create', compact('keluarga', 'warga', 'hubunganOptions'));
    }

    /**
     * Menyimpan anggota baru
     */
    public function store(Request $request, KeluargaKk $keluarga)
    {
        $request->validate([
            'warga_id' => 'required|integer|exists:warga,warga_id',
            'hubungan' => 'required|string|max:50|in:' . implode(',', array_keys($this->hubunganOptions)),
        ]);

        // Cek apakah warga sudah menjadi anggota keluarga lain
        $existingAnggota = AnggotaKeluarga::where('warga_id', $request->warga_id)->first();
        if ($existingAnggota) {
            return redirect()->back()
                ->with('error', 'Warga ini sudah menjadi anggota keluarga lain.')
                ->withInput();
        }

        AnggotaKeluarga::create([
            'kk_id' => $keluarga->kk_id,
            'warga_id' => $request->warga_id,
            'hubungan' => $request->hubungan,
        ]);

        return redirect()->route('anggota-keluarga.index', $keluarga->kk_id)
            ->with('success', 'Anggota keluarga berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail anggota
     */
    public function show(KeluargaKk $keluarga, AnggotaKeluarga $anggota)
    {
        // Pastikan anggota termasuk dalam keluarga yang dimaksud
        if ($anggota->kk_id != $keluarga->kk_id) {
            abort(404);
        }

        $anggota->load('warga');
        return view('pages.anggota-keluarga.show', compact('keluarga', 'anggota'));
    }

    /**
     * Form edit anggota
     */
    public function edit(KeluargaKk $keluarga, AnggotaKeluarga $anggota)
    {
        if ($anggota->kk_id != $keluarga->kk_id) {
            abort(404);
        }

        $hubunganOptions = $this->hubunganOptions;

        return view('pages.anggota-keluarga.edit', compact('keluarga', 'anggota', 'hubunganOptions'));
    }

    /**
     * Update anggota
     */
    public function update(Request $request, KeluargaKk $keluarga, AnggotaKeluarga $anggota)
    {
        if ($anggota->kk_id != $keluarga->kk_id) {
            abort(404);
        }

        $request->validate([
            'hubungan' => 'required|string|max:50|in:' . implode(',', array_keys($this->hubunganOptions)),
        ]);

        // ✅ CEK APAKAH INI KEPALA KELUARGA
        if ($anggota->hubungan == 'kepala_keluarga' && $request->hubungan != 'kepala_keluarga') {
            return redirect()->back()
                ->with('error', 'Tidak dapat mengubah hubungan kepala keluarga.')
                ->withInput();
        }

        $anggota->update($request->only('hubungan'));

        return redirect()->route('anggota-keluarga.index', $keluarga->kk_id)
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Hapus anggota
     */
    public function destroy(KeluargaKk $keluarga, AnggotaKeluarga $anggota)
    {
        if ($anggota->kk_id != $keluarga->kk_id) {
            abort(404);
        }

        // Jangan izinkan menghapus kepala keluarga
        if ($anggota->hubungan == 'kepala_keluarga') {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus kepala keluarga.');
        }

        $anggota->delete();

        return redirect()->route('anggota-keluarga.index', $keluarga->kk_id)
            ->with('success', 'Anggota keluarga berhasil dihapus.');
    }
}
