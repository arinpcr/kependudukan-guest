<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\WargaDocument;
use Illuminate\Support\Facades\Storage;

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
            'documents.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB
        ]);

        $warga = Warga::create($request->all());

        // Handle document upload
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $document) {
                $documentName = time() . '_' . uniqid() . '.' . $document->getClientOriginalExtension();
                $documentPath = $document->storeAs('public/documents', $documentName);

                WargaDocument::create([
                    'warga_id' => $warga->warga_id,
                    'file_name' => $documentName,
                    'file_path' => $documentPath,
                    'file_type' => $document->getClientMimeType(),
                    'original_name' => $document->getClientOriginalName(),
                    'file_size' => $document->getSize(),
                    'document_type' => 'kk', // Default KK
                    'description' => 'Dokumen KK ' . $warga->nama,
                ]);
            }
        }

        return redirect()->route('warga.index')
                         ->with('success', 'Data warga berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Warga $warga)
    {
        $warga->load('documents');
        return view('pages.warga.show', compact('warga'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warga $warga)
    {
        $warga->load('documents');
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
            'documents.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $warga->update($request->all());

        // Handle document upload
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $document) {
                $documentName = time() . '_' . uniqid() . '.' . $document->getClientOriginalExtension();
                $documentPath = $document->storeAs('public/documents', $documentName);

                WargaDocument::create([
                    'warga_id' => $warga->warga_id,
                    'file_name' => $documentName,
                    'file_path' => $documentPath,
                    'file_type' => $document->getClientMimeType(),
                    'original_name' => $document->getClientOriginalName(),
                    'file_size' => $document->getSize(),
                    'document_type' => 'kk',
                    'description' => 'Dokumen KK ' . $warga->nama,
                ]);
            }
        }

        return redirect()->route('warga.index')
                        ->with('success', 'Data warga berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warga $warga)
    {
        // Hapus dokumen terkait
        foreach ($warga->documents as $document) {
            if (Storage::exists('public/documents/' . $document->file_name)) {
                Storage::delete('public/documents/' . $document->file_name);
            }
            $document->delete();
        }

        $warga->delete();

        return redirect()->route('warga.index')
                        ->with('success', 'Data warga berhasil dihapus.');
    }

    /**
     * Hapus dokumen warga
     */
    public function deleteDocument($documentId)
    {
        $document = WargaDocument::findOrFail($documentId);
        
        if (Storage::exists('public/documents/' . $document->file_name)) {
            Storage::delete('public/documents/' . $document->file_name);
        }
        
        $document->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}