<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unduhan;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UnduhanController extends Controller
{
    use LogsActivity;
    public function index()
    {
        $unduhans = Unduhan::latest()->paginate(10);
        return view('admin.unduhan.index', compact('unduhans'));
    }

    // File: app/Http/Controllers/Admin/UnduhanController.php

    public function create()
    {
        // Kategori default dari Enum
        $defaultKategoris = [
            ['value' => 'Laporan', 'label' => 'Laporan', 'icon' => '📊'],
            ['value' => 'SOP', 'label' => 'SOP', 'icon' => '📋'],
            ['value' => 'Peta', 'label' => 'Peta', 'icon' => '🗺️'],
            ['value' => 'Formulir', 'label' => 'Formulir', 'icon' => '📝'],
            ['value' => 'Panduan', 'label' => 'Panduan', 'icon' => '📖'],
        ];

        // Ambil kategori custom dari database
        $customKategoris = Unduhan::whereNotNull('kategori')
            ->whereNotIn('kategori', ['', 'Laporan', 'SOP', 'Peta', 'Formulir', 'Panduan'])
            ->distinct()
            ->pluck('kategori')
            ->map(function($kat) {
                return [
                    'value' => $kat,
                    'label' => $kat,
                    'icon' => '📌'
                ];
            })
            ->values()
            ->toArray();

        // Gabungkan
        $kategoris = array_merge($defaultKategoris, $customKategoris);

        return view('admin.unduhan.create', compact('kategoris'));
    }

    /**
     * Menyimpan data baru (STORE).
     * Logika ini hanya untuk membuat data baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:5120',
            'is_active' => 'nullable|boolean',
            'kategori' => 'nullable|string',
            'kategori_custom' => 'nullable|required_if:kategori,custom|string|max:100',
        ], [
            'kategori_custom.required_if' => 'Nama kategori custom wajib diisi.',
        ]);

        // Upload file
        $file = $request->file('file');
        $path = $file->store('unduhan', 'public');

        // Tentukan kategori
        $kategoriValue = null;
        if ($request->kategori === 'custom') {
            $kategoriValue = $request->kategori_custom;
        } elseif ($request->filled('kategori')) {
            $kategoriValue = $request->kategori;
        }

        // Simpan data
        $unduhan = Unduhan::create([
            'title' => $validated['title'],
            'kategori' => $kategoriValue,
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'is_active' => $request->has('is_active'),
        ]);
        
        // Log activity
        $this->logCreate('Unduhan', $unduhan->title);

        return redirect()->route('admin.unduhan.index')
            ->with('success', 'Dokumen berhasil ditambahkan.');
    }


    public function edit(Unduhan $unduhan)
    {
        // Kategori default dari Enum
        $defaultKategoris = [
            ['value' => 'Laporan', 'label' => 'Laporan', 'icon' => '📊'],
            ['value' => 'SOP', 'label' => 'SOP', 'icon' => '📋'],
            ['value' => 'Peta', 'label' => 'Peta', 'icon' => '🗺️'],
            ['value' => 'Formulir', 'label' => 'Formulir', 'icon' => '📝'],
            ['value' => 'Panduan', 'label' => 'Panduan', 'icon' => '📖'],
        ];

        // Ambil kategori custom
        $customKategoris = Unduhan::whereNotNull('kategori')
            ->whereNotIn('kategori', ['', 'Laporan', 'SOP', 'Peta', 'Formulir', 'Panduan'])
            ->distinct()
            ->pluck('kategori')
            ->map(function($kat) {
                return [
                    'value' => $kat,
                    'label' => $kat,
                    'icon' => '📌'
                ];
            })
            ->values()
            ->toArray();

        $kategoris = array_merge($defaultKategoris, $customKategoris);

        return view('admin.unduhan.edit', compact('unduhan', 'kategoris'));
    }

    /**
     * Memperbarui data yang ada (UPDATE).
     * Logika ini hanya untuk mengubah data yang sudah ada.
     */
    public function update(Request $request, Unduhan $unduhan)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:5120',
            'is_active' => 'nullable|boolean',
            'kategori' => 'nullable|string',
            'kategori_custom' => 'nullable|required_if:kategori,custom|string|max:100',
        ], [
            'kategori_custom.required_if' => 'Nama kategori custom wajib diisi.',
        ]);

        // Upload file baru jika ada
        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($unduhan->file_path);
            $file = $request->file('file');
            $path = $file->store('unduhan', 'public');
            $fileSize = $file->getSize();
        } else {
            $path = $unduhan->file_path;
            $fileSize = $unduhan->file_size;
        }

        // Tentukan kategori
        $kategoriValue = null;
        if ($request->kategori === 'custom') {
            $kategoriValue = $request->kategori_custom;
        } elseif ($request->filled('kategori')) {
            $kategoriValue = $request->kategori;
        }

        // Update data
        $unduhan->update([
            'title' => $validated['title'],
            'kategori' => $kategoriValue,
            'file_path' => $path,
            'file_size' => $fileSize,
            'is_active' => $request->has('is_active'),
        ]);
        
        // Log activity
        $this->logUpdate('Unduhan', $unduhan->title);

        return redirect()->route('admin.unduhan.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Unduhan $unduhan)
    {
        $titleUnduhan = $unduhan->title;
        
        if ($unduhan->file_path) {
            Storage::disk('public')->delete($unduhan->file_path);
        }
        $unduhan->delete();
        
        // Log activity
        $this->logDelete('Unduhan', $titleUnduhan);

        return redirect()->route('admin.unduhan.index')->with('success', 'Dokumen berhasil dihapus.');
    }

    public function toggleStatus(Unduhan $unduhan)
    {
        $unduhan->is_active = !$unduhan->is_active;
        $unduhan->save();

        return redirect()->route('admin.unduhan.index')->with('success', 'Status dokumen berhasil diubah.');
    }
}
