<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Unduhan;
use Illuminate\Http\Request;

class UnduhanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kategori unik dari database (termasuk custom)
        $kategoriList = Unduhan::where('is_active', true)
            ->whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori')
            ->sort()
            ->values();

        $query = Unduhan::where('is_active', true);

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $unduhans = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('public.unduhan.index', compact('unduhans', 'kategoriList'));
    }
}