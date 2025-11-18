<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformasiKontak;
use Illuminate\Http\Request;

class InformasiKontakController extends Controller
{
    public function index()
    {
        $kontak = InformasiKontak::first();
        return view('admin.informasi-kontak.index', compact('kontak'));
    }

    public function create()
    {
        return view('admin.informasi-kontak.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'alamat' => 'required|string|max:255',
            'maps_url' => 'nullable|string|max:2000',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'jam_operasional' => 'nullable|array',
            'jam_operasional.*' => 'nullable|string|max:255',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'footer_text' => 'nullable|string|max:500',
        ]);

        // Filter empty values and convert to JSON
        if (isset($validated['jam_operasional'])) {
            $validated['jam_operasional'] = json_encode(array_filter($validated['jam_operasional']));
        }

        InformasiKontak::create($validated);

        return redirect()->route('admin.informasi-kontak.index')
            ->with('success', 'Informasi kontak berhasil ditambahkan.');
    }

    public function edit(InformasiKontak $informasiKontak)
    {
        return view('admin.informasi-kontak.edit', compact('informasiKontak'));
    }

    public function update(Request $request, InformasiKontak $informasiKontak)
    {
        $validated = $request->validate([
            'alamat' => 'required|string|max:255',
            'maps_url' => 'nullable|string|max:2000',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'jam_operasional' => 'nullable|array',
            'jam_operasional.*' => 'nullable|string|max:255',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'footer_text' => 'nullable|string|max:500',
        ]);

        // Filter empty values and convert to JSON
        if (isset($validated['jam_operasional'])) {
            $validated['jam_operasional'] = json_encode(array_filter($validated['jam_operasional']));
        }

        $informasiKontak->update($validated);

        return redirect()->route('admin.informasi-kontak.index')
            ->with('success', 'Informasi kontak berhasil diperbarui.');
    }

    public function destroy(InformasiKontak $informasiKontak)
    {
        $informasiKontak->delete();

        return redirect()->route('admin.informasi-kontak.index')
            ->with('success', 'Informasi kontak berhasil dihapus.');
    }
}

