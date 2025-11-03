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
        Schema::table('informasi_kontaks', function (Blueprint $table) {
            $table->text('jam_operasional')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi_kontaks', function (Blueprint $table) {
            $table->string('jam_operasional')->nullable()->change();
        });
    }
};
