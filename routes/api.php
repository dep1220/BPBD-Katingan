<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BeritaApiController;
use App\Http\Controllers\Api\SliderApiController;
use App\Http\Controllers\Api\PanduanBencanaApiController;
use App\Http\Controllers\Api\AgendaApiController;
use App\Http\Controllers\Api\StrukturOrganisasiApiController;
use App\Http\Controllers\Api\VisiMisiApiController;
use App\Http\Controllers\Api\GaleriApiController;
use App\Http\Controllers\Api\UnduhanApiController;
use App\Http\Controllers\Api\PesanApiController;
use App\Http\Controllers\Api\InformasiKontakApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // Authentication Routes
    Route::post('/auth/login', [AuthController::class, 'login']);
    
    // Protected Routes (Requires Authentication)
    Route::middleware('auth:sanctum')->group(function () {
        // Auth endpoints
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/user', [AuthController::class, 'user']);
        
        // Berita CRUD (Admin) - Requires Authentication
        Route::post('/berita', [BeritaApiController::class, 'store']);
        Route::put('/berita/{slug}', [BeritaApiController::class, 'update']);
        Route::patch('/berita/{slug}', [BeritaApiController::class, 'update']);
        Route::delete('/berita/{slug}', [BeritaApiController::class, 'destroy']);

        // Slider CRUD (Admin) - Requires Authentication
        Route::post('/sliders', [SliderApiController::class, 'store']);
        Route::put('/sliders/{id}', [SliderApiController::class, 'update']);
        Route::patch('/sliders/{id}', [SliderApiController::class, 'update']);
        Route::delete('/sliders/{id}', [SliderApiController::class, 'destroy']);

        // Panduan Bencana CRUD (Admin) - Requires Authentication
        Route::post('/panduan-bencana', [PanduanBencanaApiController::class, 'store']);
        Route::put('/panduan-bencana/{id}', [PanduanBencanaApiController::class, 'update']);
        Route::patch('/panduan-bencana/{id}', [PanduanBencanaApiController::class, 'update']);
        Route::delete('/panduan-bencana/{id}', [PanduanBencanaApiController::class, 'destroy']);

        // Agenda CRUD (Admin) - Requires Authentication
        Route::post('/agenda', [AgendaApiController::class, 'store']);
        Route::put('/agenda/{id}', [AgendaApiController::class, 'update']);
        Route::patch('/agenda/{id}', [AgendaApiController::class, 'update']);
        Route::delete('/agenda/{id}', [AgendaApiController::class, 'destroy']);

        // Struktur Organisasi CRUD (Admin) - Requires Authentication
        Route::post('/struktur-organisasi', [StrukturOrganisasiApiController::class, 'store']);
        Route::post('/struktur-organisasi/{id}', [StrukturOrganisasiApiController::class, 'update']); // POST for file upload
        Route::put('/struktur-organisasi/{id}', [StrukturOrganisasiApiController::class, 'update']);
        Route::patch('/struktur-organisasi/{id}', [StrukturOrganisasiApiController::class, 'update']);
        Route::delete('/struktur-organisasi/{id}', [StrukturOrganisasiApiController::class, 'destroy']);

        // Visi Misi CRUD (Admin) - Requires Authentication
        Route::post('/visi-misi', [VisiMisiApiController::class, 'store']);
        Route::put('/visi-misi/{id}', [VisiMisiApiController::class, 'update']);
        Route::patch('/visi-misi/{id}', [VisiMisiApiController::class, 'update']);
        Route::delete('/visi-misi/{id}', [VisiMisiApiController::class, 'destroy']);

        // Galeri CRUD (Admin) - Requires Authentication
        Route::post('/galeri', [GaleriApiController::class, 'store']);
        Route::post('/galeri/{id}', [GaleriApiController::class, 'update']); // POST for file upload
        Route::put('/galeri/{id}', [GaleriApiController::class, 'update']);
        Route::patch('/galeri/{id}', [GaleriApiController::class, 'update']);
        Route::delete('/galeri/{id}', [GaleriApiController::class, 'destroy']);

        // Unduhan CRUD (Admin) - Requires Authentication
        Route::post('/unduhan', [UnduhanApiController::class, 'store']);
        Route::post('/unduhan/{id}', [UnduhanApiController::class, 'update']); // POST for file upload
        Route::put('/unduhan/{id}', [UnduhanApiController::class, 'update']);
        Route::patch('/unduhan/{id}', [UnduhanApiController::class, 'update']);
        Route::delete('/unduhan/{id}', [UnduhanApiController::class, 'destroy']);

        // Pesan/Kontak CRUD (Admin) - Requires Authentication
        Route::get('/pesan', [PesanApiController::class, 'index']);
        Route::get('/pesan/{id}', [PesanApiController::class, 'show']);
        Route::patch('/pesan/{id}/mark-as-read', [PesanApiController::class, 'markAsRead']);
        Route::delete('/pesan/{id}', [PesanApiController::class, 'destroy']);

        // Informasi Kontak CRUD (Admin) - Requires Authentication
        Route::post('/informasi-kontak', [InformasiKontakApiController::class, 'store']);
        Route::put('/informasi-kontak/{id}', [InformasiKontakApiController::class, 'update']);
        Route::patch('/informasi-kontak/{id}', [InformasiKontakApiController::class, 'update']);
        Route::delete('/informasi-kontak/{id}', [InformasiKontakApiController::class, 'destroy']);
    });
    
    //Berita Public API Endpoints (No Authentication Required) 
    Route::get('/berita/kategori', [BeritaApiController::class, 'kategori']);
    Route::get('/berita', [BeritaApiController::class, 'index']);
    Route::get('/berita/{slug}', [BeritaApiController::class, 'show']);

    // Slider Public API Endpoints (No Authentication Required)
    Route::get('/sliders', [SliderApiController::class, 'index']);
    Route::get('/sliders/{id}', [SliderApiController::class, 'show']);

    // Panduan Bencana Public API Endpoints (No Authentication Required)
    Route::get('/panduan-bencana', [PanduanBencanaApiController::class, 'index']);
    Route::get('/panduan-bencana/{id}', [PanduanBencanaApiController::class, 'show']);

    // Agenda Public API Endpoints (No Authentication Required)
    Route::get('/agenda', [AgendaApiController::class, 'index']);
    Route::get('/agenda/{id}', [AgendaApiController::class, 'show']);

    // Struktur Organisasi Public API Endpoints (No Authentication Required)
    Route::get('/struktur-organisasi', [StrukturOrganisasiApiController::class, 'index']);
    Route::get('/struktur-organisasi/{id}', [StrukturOrganisasiApiController::class, 'show']);

    // Visi Misi Public API Endpoints (No Authentication Required)
    Route::get('/visi-misi', [VisiMisiApiController::class, 'index']);
    Route::get('/visi-misi/{id}', [VisiMisiApiController::class, 'show']);

    // Galeri Public API Endpoints (No Authentication Required)
    Route::get('/galeri', [GaleriApiController::class, 'index']);
    Route::get('/galeri/{id}', [GaleriApiController::class, 'show']);

    // Unduhan Public API Endpoints (No Authentication Required)
    Route::get('/unduhan', [UnduhanApiController::class, 'index']);
    Route::get('/unduhan/{id}', [UnduhanApiController::class, 'show']);

    // Informasi Kontak Public API Endpoints (No Authentication Required)
    Route::get('/informasi-kontak', [InformasiKontakApiController::class, 'index']);
    Route::get('/informasi-kontak/{id}', [InformasiKontakApiController::class, 'show']);

    // Pesan/Kontak Public API Endpoints (No Authentication Required)
    Route::post('/pesan', [PesanApiController::class, 'store']);
});
