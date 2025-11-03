<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider; // 1. Import Model Slider
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // 2. Import Storage Facade untuk mengelola file

class SliderController extends Controller
{
    /**
     * Menampilkan daftar semua slide.
     */
    public function index()
    {
        // Ambil semua data slider, urutkan berdasarkan kolom 'sequence'
        $sliders = Slider::orderBy('sequence')->get();

        // Kirim data ke view
        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Menampilkan formulir untuk membuat slide baru.
     */
    public function create()
    {
        return view('admin.sliders.create');
    }

    /**
     * Menyimpan slide baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // Wajib gambar, maks 2MB
            'sequence' => 'required|integer',
        ]);

        // Proses upload gambar
        $imagePath = $request->file('image')->store('sliders', 'public');

        // Simpan data ke database
        Slider::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'link' => $request->link,
            'image' => $imagePath,
            'sequence' => $request->sequence,
            'is_active' => $request->has('is_active'), // Jika checkbox dicentang, nilainya true
        ]);

        // Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.sliders.index')->with('success', 'Slide baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir untuk mengedit slide.
     * Kita menggunakan model binding di sini, Laravel akan otomatis mencari Slider berdasarkan ID.
     */
    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * Memperbarui slide yang ada di database.
     */
    public function update(Request $request, Slider $slider)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Gambar tidak wajib diisi saat update
            'sequence' => 'required|integer',
        ]);

        $imagePath = $slider->image; // Gunakan gambar lama sebagai default

        // Jika ada gambar baru yang di-upload
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari storage
            Storage::disk('public')->delete($slider->image);
            // Upload gambar baru
            $imagePath = $request->file('image')->store('sliders', 'public');
        }

        // Update data di database
        $slider->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'link' => $request->link,
            'image' => $imagePath,
            'sequence' => $request->sequence,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'Slide berhasil diperbarui.');
    }

    /**
     * Menghapus slide dari database.
     */
    public function destroy(Slider $slider)
    {
        // Hapus file gambar dari storage
        Storage::disk('public')->delete($slider->image);

        // Hapus data dari database
        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'Slide berhasil dihapus.');
    }

    /**
     * Toggle status aktif/tidak aktif slider
     */
    public function toggleStatus(Slider $slider)
    {
        $slider->is_active = !$slider->is_active;
        $slider->save();
        
        $status = $slider->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.sliders.index')->with('success', "Slide berhasil {$status}.");
    }
}
