<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\BeritaController as PublicBeritaController;
use App\Http\Controllers\Public\StrukturOrganisasiController as PublicStrukturOrganisasiController;
use App\Http\Controllers\Public\VisiMisiController as PublicVisiMisiController;
use App\Http\Controllers\Public\GaleriController as PublicGaleriController;
use App\Http\Controllers\Admin\PanduanBencanaController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\StrukturOrganisasiController;
use App\Http\Controllers\Admin\VisiMisiController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Public\UnduhanController as PublicUnduhanController;
use App\Http\Controllers\Admin\UnduhanController;
use App\Http\Controllers\Public\PesanController as PublicPesanController;
use App\Http\Controllers\Admin\PesanController as AdminPesanController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InformasiKontakController;


// PUBLIC Routes

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/public/profile/visi-misi', [PublicVisiMisiController::class, 'index'])->name('visi-misi');

Route::get('/public/profile/struktur-organisasi', [PublicStrukturOrganisasiController::class, 'index'])->name('struktur-organisasi');

Route::get('/berita', [PublicBeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{berita}', [PublicBeritaController::class, 'show'])->name('berita.show');

Route::get('/galeri', [PublicGaleriController::class, 'index'])->name('galeri.index');

Route::get('/unduhan', [PublicUnduhanController::class, 'index'])->name('unduhan.index');

Route::get('/agenda', [App\Http\Controllers\Public\AgendaController::class, 'index'])->name('public.agenda.index');

Route::get('/kontak', function () {
    return view('public.kontak.index');
})->name('kontak.index');
Route::post('/kontak', [PublicPesanController::class, 'store'])->name('kontak.store');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('sliders', SliderController::class);
        Route::patch('sliders/{slider}/toggle', [SliderController::class, 'toggleStatus'])->name('sliders.toggle');

        // Route resource untuk panduan-bencana dengan custom route tambahan
        Route::resource('panduan-bencana', PanduanBencanaController::class);
        Route::patch('panduan-bencana/{panduanBencana}/toggle', [PanduanBencanaController::class, 'toggleStatus'])->name('panduan-bencana.toggle');

        // Routes untuk Agenda
        Route::resource('agendas', AgendaController::class);

        // Routes untuk Berita
        Route::resource('berita', BeritaController::class)-> parameters([
            'berita' => 'berita'
        ]);
        Route::patch('berita/{berita}/toggle', [BeritaController::class, 'toggleStatus'])->name('berita.toggle');
        Route::post('berita/upload-file', [BeritaController::class, 'uploadFile'])->name('berita.upload-file');

        // Routes untuk Struktur Organisasi
        Route::resource('struktur-organisasi', StrukturOrganisasiController::class);
        Route::patch('struktur-organisasi/{strukturOrganisasi}/toggle', [StrukturOrganisasiController::class, 'toggleStatus'])->name('struktur-organisasi.toggle');

        // Routes untuk Visi Misi
        Route::resource('visi-misi', VisiMisiController::class);
        Route::patch('visi-misi/{visiMisi}/toggle', [VisiMisiController::class, 'toggleStatus'])->name('visi-misi.toggle');

        // Routes untuk Galeri
        Route::resource('galeri', GaleriController::class);
        Route::patch('galeri/{galeri}/toggle', [GaleriController::class, 'toggleStatus'])->name('galeri.toggle');

        // Routes untuk Unduhan
        Route::resource('unduhan', UnduhanController::class);
        Route::patch('unduhan/{unduhan}/toggle', [UnduhanController::class, 'toggleStatus'])->name('unduhan.toggle');

        // Routes untuk Pesan
        Route::resource('pesan', AdminPesanController::class)->only(['index', 'show', 'destroy']);

        // Routes untuk Informasi Kontak
        Route::resource('informasi-kontak', InformasiKontakController::class);

        // Routes untuk User Management (hanya Super Admin)
        Route::middleware('super_admin')->group(function () {
            Route::resource('users', \App\Http\Controllers\Admin\UserManagementController::class);
        });

        // Routes untuk Activity Log Management
        Route::prefix('activity-logs')->name('activity-logs.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('index');
            Route::post('/clean-old', [\App\Http\Controllers\Admin\ActivityLogController::class, 'cleanOld'])->name('clean-old');
            Route::delete('/delete-all', [\App\Http\Controllers\Admin\ActivityLogController::class, 'deleteAll'])->name('delete-all');
            Route::delete('/{activityLog}', [\App\Http\Controllers\Admin\ActivityLogController::class, 'destroy'])->name('destroy');
        });
    });
});

require __DIR__.'/auth.php';
