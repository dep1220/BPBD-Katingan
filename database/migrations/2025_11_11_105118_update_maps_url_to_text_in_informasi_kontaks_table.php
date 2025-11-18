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
            // Change maps_url to text type to support long iframe code
            $table->text('maps_url')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi_kontaks', function (Blueprint $table) {
            // Revert to string if needed
            $table->string('maps_url')->nullable()->change();
        });
    }
};
