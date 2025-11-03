<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Galeri;

class GaleriController extends Controller
{
    /**
     * Display the public gallery page.
     */
    public function index()
    {
        $galeris = Galeri::active()->latest()->paginate(12);
        return view('public.galeri.index', compact('galeris'));
    }
}
