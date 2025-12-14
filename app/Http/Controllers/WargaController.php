<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query dasar
        $query = Warga::query();

        // Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('no_ktp', 'like', '%' . $search . '%')
                  ->orWhere('agama', 'like', '%' . $search . '%')
                  ->orWhere('pekerjaan', 'like', '%' . $search . '%')
                  ->orWhere('telp', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Filter jenis kelamin
        if ($request->has('jenis_kelamin') && $request->jenis_kelamin != '') {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'nama_desc':
                    $query->orderBy('nama', 'desc');
                    break;
                case 'terbaru':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'terlama':
                    $query->orderBy('created_at', 'asc');
                    break;
                default:
                    $query->orderBy('nama', 'asc');
                    break;
            }
        } else {
            $query->orderBy('nama', 'asc');
        }

        // Pagination
        $perPage = $request->has('per_page') ? $request->per_page : 12;
        $warga = $query->paginate($perPage);

        return view('pages.warga.index', compact('warga'))->with('request', $request);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.warga.create', [
            'warga' => new Warga()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_ktp' => 'required|string|max:20|unique:warga,no_ktp',
            'nama' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'nullable|string|max:30',
            'pekerjaan' => 'nullable|string|max:50',
            'telp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
        ]);

        Warga::create($request->all());

        return redirect()->route('warga.index')
                         ->with('success', 'Data warga berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Warga $warga)
    {
        return view('pages.warga.show', compact('warga'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warga $warga)
    {
        return view('pages.warga.edit', compact('warga'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warga $warga)
    {
        $request->validate([
            'no_ktp' => 'required|string|max:20|unique:warga,no_ktp,' . $warga->warga_id . ',warga_id',
            'nama' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'nullable|string|max:30',
            'pekerjaan' => 'nullable|string|max:50',
            'telp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
        ]);

        $warga->update($request->all());

        return redirect()->route('warga.index')
                         ->with('success', 'Data warga berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warga $warga)
    {
        $warga->delete();

        return redirect()->route('warga.index')
                         ->with('success', 'Data warga berhasil dihapus.');
    }
}