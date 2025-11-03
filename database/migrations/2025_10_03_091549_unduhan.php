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
        Schema::create('unduhan', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type'); // e.g., Laporan, SOP, Peta
            $table->string('file_path'); // Path ke file di storage
            $table->string('file_size');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::dropIfExists('unduhan');
    }
};
