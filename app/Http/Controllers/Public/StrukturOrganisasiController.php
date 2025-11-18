<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\StrukturOrganisasi;
use Illuminate\Support\Facades\Log;

class StrukturOrganisasiController extends Controller
{
    public function index()
    {
        try {
            // Ambil data kepala dinas/kepala pelaksana untuk sambutan
            $kepalaDinas = StrukturOrganisasi::ketua()
                ->active()
                ->first();

            // Ambil semua struktur organisasi yang aktif dan urutkan
            $strukturOrganisasi = StrukturOrganisasi::active()
                ->ordered()
                ->get()
                ->groupBy('urutan');

        } catch (\Exception $e) {
            // Jika ada error, set data kosong
            $kepalaDinas = null;
            $strukturOrganisasi = collect();
            Log::error('Error loading struktur organisasi: ' . $e->getMessage());
        }

        return view('public.profile.struktur-organisasi', compact('kepalaDinas', 'strukturOrganisasi'));
    }
}