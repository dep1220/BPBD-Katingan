<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PanduanBencana; // Import model yang relevan
use Illuminate\Http\Request;

class PanduanBencanaController extends Controller
{
   public function index()
    {
        $guides = PanduanBencana::orderBy('sequence')->get();
        // Pastikan view menunjuk ke folder 'panduan-bencana'
        return view('admin.panduan-bencana.index', compact('guides'));
    }

    /**
     * Menampilkan formulir untuk membuat panduan baru.
     */
    public function create()
    {
        return view('admin.panduan-bencana.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'sequence' => 'required|integer',
            'items' => 'required|array',
            'items.*' => 'nullable|string',
        ]);

        $items = array_filter($request->items);

            PanduanBencana::create([
            'title' => $request->title,
            'description' => $request->description,
            'sequence' => $request->sequence,
            'items' => $items,
        ]);

        return redirect()->route('admin.panduan-bencana.index')->with('success', 'Panduan baru berhasil ditambahkan.');
    }

    public function edit(PanduanBencana $panduan_bencana)
    {
        // Pastikan view menunjuk ke folder 'panduan-bencana'
        return view('admin.panduan-bencana.edit', compact('panduan_bencana'));
    }

    /**
     * Menampilkan detail panduan yang ada.
     */
    public function show(PanduanBencana $panduan_bencana)
    {
        return view('admin.panduan-bencana.show', compact('panduan_bencana'));
    }



    /**
     * Memperbarui panduan yang ada di database.
     */
    public function update(Request $request, PanduanBencana $panduan_bencana)
    {
        // Validasi data yang masuk dari form
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'items' => 'required|array', // Pastikan 'items' adalah sebuah array
            'items.*' => 'nullable|string', // Validasi setiap item di dalam array
        ]);

        // Filter untuk menghapus poin-poin 'items' yang kosong
        $items = array_filter($request->items);

        // Update data di database
        $panduan_bencana->update([
            'title' => $request->title,
            'description' => $request->description,
            'items' => $items,
        ]);

        // Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.panduan-bencana.index')->with('success', 'Panduan Kesiapsiagaan berhasil diperbarui.');
    }

    public function destroy(PanduanBencana $panduan_bencana)
    {
        $panduan_bencana->delete();
        return redirect()->route('admin.panduan-bencana.index')->with('success', 'Panduan berhasil dihapus.');
    }

    public function toggleStatus(PanduanBencana $panduanBencana)
    {
        $panduanBencana->is_active = !$panduanBencana->is_active;
        $panduanBencana->save();
        return redirect()->route('admin.panduan-bencana.index')->with('success', 'Status panduan berhasil diubah.');
    }
}