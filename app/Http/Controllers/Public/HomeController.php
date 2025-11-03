<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\PanduanBencana;
use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Unduhan;
use App\Models\StrukturOrganisasi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // Ambil semua slider yang aktif, urutkan berdasarkan 'sequence'
            $sliders = Slider::where('is_active', true)
                ->orderBy('sequence')
                ->get()
                ->map(function ($slider) {
                    // Pastikan image tidak null sebelum menggunakan Storage::url
                    if ($slider->image) {
                        $slider->image = Storage::url($slider->image);
                    } else {
                        // Berikan gambar default jika image kosong
                        $slider->image = asset('images/default-slider.jpg');
                    }
                    return $slider;
                });

            // Jika tidak ada slider aktif, buat collection kosong
            if ($sliders->isEmpty()) {
                $sliders = collect();
            }

        } catch (\Exception $e) {
            // Jika ada error, buat collection kosong
            $sliders = collect();
            Log::error('Error loading sliders: ' . $e->getMessage());
        }

        try {
            // Ambil data panduan bencana yang aktif, urutkan berdasarkan sequence
            $panduanBencana = PanduanBencana::where('is_active', true)->orderBy('sequence')->get();
        } catch (\Exception $e) {
            // Jika ada error, buat collection kosong
            $panduanBencana = collect();
            Log::error('Error loading panduan bencana: ' . $e->getMessage());
        }

        try {
            // Ambil agenda untuk preview di beranda (akan datang dan sedang berlangsung)
            // Prioritas: sedang berlangsung dulu, kemudian akan datang
            // Maksimal 4 agenda untuk preview
            // Note: Agenda selesai bisa dilihat di halaman /agenda
            $agendas = Agenda::forPublic()
                ->get()
                ->sortBy(function ($agenda) {
                    // Prioritas sorting: sedang berlangsung (1), akan datang (2)
                    switch ($agenda->status) {
                        case 'sedang_berlangsung':
                            return 1;
                        case 'akan_datang':
                            return 2;
                        default:
                            return 3;
                    }
                })
                ->values()
                ->take(4);
        } catch (\Exception $e) {
            // Jika ada error, buat collection kosong
            $agendas = collect();
            Log::error('Error loading agendas: ' . $e->getMessage());
        }

        try {
            // Ambil 3 berita terbaru yang published untuk preview di beranda
            $beritas = Berita::published()
                ->orderBy('published_at', 'desc')
                ->limit(3)
                ->get();
        } catch (\Exception $e) {
            // Jika ada error, buat collection kosong
            $beritas = collect();
            Log::error('Error loading beritas: ' . $e->getMessage());
        }

        try {
            // Ambil data kepala dinas/kepala pelaksana untuk sambutan
            $kepalaDinas = StrukturOrganisasi::kepala()
                ->active()
                ->first();
        } catch (\Exception $e) {
            // Jika ada error, set null
            $kepalaDinas = null;
            Log::error('Error loading kepala dinas: ' . $e->getMessage());
        }

        try {
            // Ambil 4 foto galeri terbaru yang aktif
            $galeris = Galeri::where('is_active', true)
                ->latest() // Mengurutkan berdasarkan created_at (terbaru dulu)
                ->take(4)    // Membatasi hanya 4 item
                ->get();
        } catch (\Exception $e) {
            $galeris = collect();
            Log::error('Error loading galeris: ' . $e->getMessage());
        }

        try {
            // Ambil 4 dokumen unduhan terbaru yang aktif
            $unduhans = Unduhan::where('is_active', true)
                ->latest()
                ->take(4)
                ->get();
        } catch (\Exception $e) {
            $unduhans = collect();
            Log::error('Error loading unduhans: ' . $e->getMessage());
        }

        // Kirim data sliders, panduan bencana, agendas, beritas, dan kepala dinas ke view
        return view('public.index', compact(
            'sliders',
            'panduanBencana',
            'agendas',
            'beritas',
            'kepalaDinas',
            'galeris',
            'unduhans'
        ));
    }
}
