<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StrukturOrganisasi;
use App\Enums\TipeJabatan;
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
        $tipeJabatanOptions = TipeJabatan::options();
        return view('admin.struktur-organisasi.create', compact('tipeJabatanOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tipeJabatanValues = collect(TipeJabatan::cases())->pluck('value')->implode(',');

        // Validasi berbeda untuk tipe jabatan custom vs enum
        $rules = [
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:20',
            'jabatan' => 'required|string|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'sambutan_kepala' => 'nullable|string',
            'sambutan_judul' => 'nullable|string|max:255',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ];

        // Jika bukan custom, validasi sebagai enum
        if ($request->tipe_jabatan !== 'custom') {
            $rules['tipe_jabatan'] = "required|in:{$tipeJabatanValues}";
        } else {
            // Jika custom, tipe_jabatan_custom wajib diisi
            $rules['tipe_jabatan_custom'] = 'required|string|max:100';
        }

        $request->validate($rules, [
            'nip.max' => 'NIP tidak boleh lebih dari 20 karakter, Kosong atau Huruf',
            'nip.required' => 'NIP wajib diisi.',
        ]);

        $data = $request->except(['foto']);

        // Jika user memilih "custom", gunakan tipe_jabatan_custom
        if ($request->tipe_jabatan === 'custom' && !empty($request->tipe_jabatan_custom)) {
            $data['tipe_jabatan'] = null; // Set enum ke null
            // Auto-assign urutan default untuk custom
            if (is_null($data['urutan']) || $data['urutan'] === '') {
                $data['urutan'] = 999; // Urutan paling bawah untuk custom
            }
        } else {
            // Jika menggunakan enum, hapus tipe_jabatan_custom
            $data['tipe_jabatan_custom'] = null;
            
            // Auto-assign urutan based on tipe_jabatan if not provided
            if (is_null($data['urutan']) || $data['urutan'] === '') {
                $tipeJabatan = TipeJabatan::from($data['tipe_jabatan']);
                $data['urutan'] = $tipeJabatan->urutan() * 10;
            }
        }

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
        $tipeJabatanOptions = TipeJabatan::options();
        return view('admin.struktur-organisasi.edit', compact('strukturOrganisasi', 'tipeJabatanOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StrukturOrganisasi $strukturOrganisasi)
    {
        $tipeJabatanValues = collect(TipeJabatan::cases())->pluck('value')->implode(',');

        // Validasi berbeda untuk tipe jabatan custom vs enum
        $rules = [
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:20',
            'jabatan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sambutan_kepala' => 'nullable|string',
            'sambutan_judul' => 'nullable|string|max:255',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ];

        // Jika bukan custom, validasi sebagai enum
        if ($request->tipe_jabatan !== 'custom') {
            $rules['tipe_jabatan'] = "required|in:{$tipeJabatanValues}";
        } else {
            // Jika custom, tipe_jabatan_custom wajib diisi
            $rules['tipe_jabatan_custom'] = 'required|string|max:100';
        }

        $request->validate($rules, [
            'nip.max' => 'NIP tidak boleh lebih dari 20 karakter, Kosong, atau Huruf',
            'nip.required' => 'NIP wajib diisi.',
        ]);

        $data = $request->except(['foto']);

        // Jika user memilih "custom", gunakan tipe_jabatan_custom
        if ($request->tipe_jabatan === 'custom' && !empty($request->tipe_jabatan_custom)) {
            $data['tipe_jabatan'] = null; // Set enum ke null
        } else {
            // Jika menggunakan enum, hapus tipe_jabatan_custom
            $data['tipe_jabatan_custom'] = null;
        }

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
