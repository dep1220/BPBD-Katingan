<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            // Ubah kolom kategori dari enum menjadi string
            $table->string('kategori')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            // Kembalikan ke enum dengan nilai yang sudah ada
            $table->enum('kategori', ['peringatan_dini', 'kegiatan', 'pengumuman', 'berita_umum', 'laporan', 'edukasi'])->nullable()->change();
        });
    }
};
