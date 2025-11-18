<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    use LogsActivity;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galeris = Galeri::latest()->paginate(10);
        return view('admin.galeri.index', compact('galeris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.galeri.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:gambar,video',
            'gambar' => 'required_if:tipe,gambar|nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'video_url' => 'required_if:tipe,video|nullable|url',
            'is_active' => 'boolean'
        ], [
            'gambar.required_if' => 'Gambar wajib diisi untuk tipe gambar.',
            'video_url.required_if' => 'URL Video YouTube wajib diisi untuk tipe video.',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tipe' => $request->tipe,
            'is_active' => $request->has('is_active')
        ];

        if ($request->tipe === 'gambar' && $request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('galeri', 'public');
        } elseif ($request->tipe === 'video') {
            $data['video_url'] = $request->video_url;
        }

        $galeri = Galeri::create($data);
        
        // Log activity
        $this->logCreate('Galeri', $galeri->judul ?? 'Item Galeri');

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Galeri $galeri)
    {
        return view('admin.galeri.show', compact('galeri'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Galeri $galeri)
    {
        return view('admin.galeri.edit', compact('galeri'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:gambar,video',
            'gambar' => 'required_if:tipe,gambar|nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'video_url' => 'required_if:tipe,video|nullable|url',
            'is_active' => 'boolean'
        ], [
            'gambar.required_if' => 'Gambar wajib diisi untuk tipe gambar.',
            'video_url.required_if' => 'URL Video YouTube wajib diisi untuk tipe video.',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tipe' => $request->tipe,
            'is_active' => $request->has('is_active')
        ];

        // If type changed from video to image or vice versa, clear old data
        if ($request->tipe !== $galeri->tipe) {
            if ($galeri->tipe === 'gambar' && $galeri->gambar && Storage::disk('public')->exists($galeri->gambar)) {
                Storage::disk('public')->delete($galeri->gambar);
            }
            $data['gambar'] = null;
            $data['video_url'] = null;
        }

        if ($request->tipe === 'gambar') {
            if ($request->hasFile('gambar')) {
                // Delete old image
                if ($galeri->gambar && Storage::disk('public')->exists($galeri->gambar)) {
                    Storage::disk('public')->delete($galeri->gambar);
                }
                $data['gambar'] = $request->file('gambar')->store('galeri', 'public');
            }
            $data['video_url'] = null;
        } elseif ($request->tipe === 'video') {
            $data['video_url'] = $request->video_url;
            $data['gambar'] = null;
        }

        $galeri->update($data);
        
        // Log activity
        $this->logUpdate('Galeri', $galeri->judul ?? 'Item Galeri');

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galeri $galeri)
    {
        $judulGaleri = $galeri->judul ?? 'Item Galeri';
        
        // Delete image file if exists
        if ($galeri->tipe === 'gambar' && $galeri->gambar && Storage::disk('public')->exists($galeri->gambar)) {
            Storage::disk('public')->delete($galeri->gambar);
        }

        $galeri->delete();
        
        // Log activity
        $this->logDelete('Galeri', $judulGaleri);

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil dihapus!');
    }

    /**
     * Get active galleries for public display
     */
    public function getActiveGaleries()
    {
        return Galeri::active()->latest()->get();
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus(Galeri $galeri)
    {
        $galeri->update([
            'is_active' => !$galeri->is_active
        ]);

        $status = $galeri->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Galeri berhasil {$status}!");
    }
}
