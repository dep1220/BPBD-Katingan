<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Pesan;
use App\Models\Unduhan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk Kartu Statistik
        $sliderCount = Slider::count();
        $beritaCount = Berita::count();
        $galeriCount = Galeri::count();
        $unduhanCount = Unduhan::count();
        $pesanBaruCount = Pesan::where('is_read', false)->count();

        // Data untuk Widget Berita Terbaru (ambil 5 terakhir)
        $latestBerita = Berita::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'sliderCount',
            'beritaCount',
            'galeriCount',
            'unduhanCount',
            'pesanBaruCount',
            'latestBerita'
        ));
    }
}
