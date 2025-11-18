<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StrukturOrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $strukturs = StrukturOrganisasi::ordered()
                                     ->paginate(10);

        return view('admin.struktur-organisasi.index', compact('strukturs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.struktur-organisasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|numeric|digits_between:1,20',
            'jabatan' => 'required|string|max:255',
            'is_ketua' => 'boolean',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'sambutan_kepala' => 'nullable|string',
            'sambutan_judul' => 'nullable|string|max:255',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ], [
            'nip.numeric' => 'NIP hanya boleh berisi angka.',
            'nip.digits_between' => 'NIP harus terdiri dari 1-20 digit.',
            'nip.required' => 'NIP wajib diisi.',
        ]);

        $data = $request->except(['foto']);
        $data['is_ketua'] = $request->has('is_ketua');
        $data['is_active'] = $request->has('is_active');

        // Handle file upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            $data['foto'] = $file->storeAs('struktur-organisasi', $filename, 'public');
        }

        StrukturOrganisasi::create($data);

        return redirect()->route('admin.struktur-organisasi.index')
                        ->with('success', 'Data struktur organisasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StrukturOrganisasi $strukturOrganisasi)
    {
        return view('admin.struktur-organisasi.show', compact('strukturOrganisasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StrukturOrganisasi $strukturOrganisasi)
    {
        return view('admin.struktur-organisasi.edit', compact('strukturOrganisasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StrukturOrganisasi $strukturOrganisasi)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|numeric|digits_between:1,20',
            'jabatan' => 'required|string|max:255',
            'is_ketua' => 'boolean',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'sambutan_kepala' => 'nullable|string',
            'sambutan_judul' => 'nullable|string|max:255',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ], [
            'nip.numeric' => 'NIP hanya boleh berisi angka.',
            'nip.digits_between' => 'NIP harus terdiri dari 1-20 digit.',
            'nip.required' => 'NIP wajib diisi.',
        ]);

        $data = $request->except(['foto']);
        $data['is_ketua'] = $request->has('is_ketua');
        $data['is_active'] = $request->has('is_active');

        // Handle file upload
        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($strukturOrganisasi->foto && Storage::disk('public')->exists($strukturOrganisasi->foto)) {
                Storage::disk('public')->delete($strukturOrganisasi->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            $data['foto'] = $file->storeAs('struktur-organisasi', $filename, 'public');
        }

        $strukturOrganisasi->update($data);

        return redirect()->route('admin.struktur-organisasi.index')
                        ->with('success', 'Data struktur organisasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StrukturOrganisasi $strukturOrganisasi)
    {
        // Delete photo if exists
        if ($strukturOrganisasi->foto && Storage::disk('public')->exists($strukturOrganisasi->foto)) {
            Storage::disk('public')->delete($strukturOrganisasi->foto);
        }

        $strukturOrganisasi->delete();

        return redirect()->route('admin.struktur-organisasi.index')
                        ->with('success', 'Data struktur organisasi berhasil dihapus.');
    }

    /**
     * Toggle the status of the resource.
     */
    public function toggleStatus(StrukturOrganisasi $strukturOrganisasi)
    {
        $strukturOrganisasi->update([
            'is_active' => !$strukturOrganisasi->is_active
        ]);

        $status = $strukturOrganisasi->is_active ? 'diaktifkan' : 'dinonaktifkan';

        // Handle both AJAX and form submission
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Data struktur organisasi berhasil {$status}.",
                'is_active' => $strukturOrganisasi->is_active
            ]);
        }

        return redirect()->route('admin.struktur-organisasi.index')
                        ->with('success', "Data struktur organisasi berhasil {$status}.");
    }
}
