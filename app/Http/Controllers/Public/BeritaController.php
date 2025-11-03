<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::published()
            ->with([]);

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'LIKE', "%{$search}%")
                  ->orWhere('konten', 'LIKE', "%{$search}%")
                  ->orWhere('penulis', 'LIKE', "%{$search}%");
            });
        }

        $beritas = $query->orderBy('published_at', 'desc')
            ->paginate(6)
            ->appends($request->query());

        return view('public.berita.index', compact('beritas'));
    }

    public function show(Berita $berita)
    {
        // Pastikan berita sudah published
        if ($berita->status !== 'published') {
            abort(404);
        }

        // Increment view count
        $berita->increment('views');

        // Ambil berita lainnya untuk sidebar (3 berita terbaru, exclude berita saat ini)
        $relatedBeritas = Berita::published()
            ->where('id', '!=', $berita->id)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        return view('public.berita.show', compact('berita', 'relatedBeritas'));
    }
}
