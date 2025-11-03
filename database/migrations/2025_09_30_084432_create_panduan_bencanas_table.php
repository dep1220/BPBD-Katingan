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
        Schema::create('panduan_bencanas', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g., "Sebelum Bencana"
            $table->string('description'); // e.g., "Persiapan adalah kunci..."
            $table->json('items'); // Akan menyimpan daftar poin-poin
            $table->integer('sequence')->default(0); // Untuk urutan kartu
            $table->boolean('is_active')->default(true); // Status aktif/tidak aktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panduan_bencanas');
    }
};
