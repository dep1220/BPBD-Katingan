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
        Schema::table('panduan_bencanas', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('sequence');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('panduan_bencanas', function (Blueprint $table) {
            //
        });
    }
};
