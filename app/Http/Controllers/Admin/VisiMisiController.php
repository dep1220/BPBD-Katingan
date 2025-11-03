<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisiMisi;
use Illuminate\Http\Request;

class VisiMisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $visiMisi = VisiMisi::latest()->paginate(10);
            return view('admin.visi-misi.index', compact('visiMisi'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error loading data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.visi-misi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'visi' => 'required|string',
            'misi' => 'required|array|min:1',
            'misi.*' => 'required|string',
            'deskripsi_visi' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        // Jika status aktif, nonaktifkan yang lain
        if ($request->boolean('is_active')) {
            VisiMisi::where('is_active', true)->update(['is_active' => false]);
        }

        VisiMisi::create([
            'visi' => $request->visi,
            'misi' => array_filter($request->misi), // Remove empty values
            'deskripsi_visi' => $request->deskripsi_visi,
            'is_active' => $request->boolean('is_active')
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Visi & Misi berhasil ditambahkan.'
            ]);
        }

        return redirect()->route('admin.visi-misi.index')
            ->with('success', 'Visi & Misi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(VisiMisi $visiMisi)
    {
        return view('admin.visi-misi.show', compact('visiMisi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VisiMisi $visiMisi)
    {
        return view('admin.visi-misi.edit', compact('visiMisi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VisiMisi $visiMisi)
    {
        $request->validate([
            'visi' => 'required|string',
            'misi' => 'required|array|min:1',
            'misi.*' => 'required|string',
            'deskripsi_visi' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        // Jika status aktif, nonaktifkan yang lain kecuali yang sedang diedit
        if ($request->boolean('is_active')) {
            VisiMisi::where('is_active', true)
                ->where('id', '!=', $visiMisi->id)
                ->update(['is_active' => false]);
        }

        $visiMisi->update([
            'visi' => $request->visi,
            'misi' => array_filter($request->misi), // Remove empty values
            'deskripsi_visi' => $request->deskripsi_visi,
            'is_active' => $request->boolean('is_active')
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Visi & Misi berhasil diperbarui.'
            ]);
        }

        return redirect()->route('admin.visi-misi.index')
            ->with('success', 'Visi & Misi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VisiMisi $visiMisi)
    {
        $visiMisi->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Visi & Misi berhasil dihapus.'
            ]);
        }

        return redirect()->route('admin.visi-misi.index')
            ->with('success', 'Visi & Misi berhasil dihapus.');
    }

    /**
     * Toggle status aktif/non-aktif visi misi
     */
    public function toggleStatus(VisiMisi $visiMisi)
    {
        // Jika akan diaktifkan, nonaktifkan yang lain terlebih dahulu
        if (!$visiMisi->is_active) {
            VisiMisi::where('is_active', true)->update(['is_active' => false]);
        }

        $visiMisi->update([
            'is_active' => !$visiMisi->is_active
        ]);

        $status = $visiMisi->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return back()->with('success', "Visi & Misi berhasil {$status}.");
    }
}
