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
        Schema::table('galeris', function (Blueprint $table) {
            $table->enum('tipe', ['gambar', 'video'])->default('gambar')->after('deskripsi');
            $table->string('video_url')->nullable()->after('tipe');
            $table->string('gambar')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galeris', function (Blueprint $table) {
            $table->dropColumn(['tipe', 'video_url']);
        });
    }
};
