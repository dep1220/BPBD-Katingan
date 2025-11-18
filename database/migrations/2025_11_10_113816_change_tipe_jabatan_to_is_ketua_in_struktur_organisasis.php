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
        Schema::table('struktur_organisasis', function (Blueprint $table) {
            // Add new boolean column
            $table->boolean('is_ketua')->default(false)->after('jabatan');
            
            // Drop old columns
            $table->dropColumn(['tipe_jabatan', 'tipe_jabatan_custom']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('struktur_organisasis', function (Blueprint $table) {
            // Restore old columns
            $table->enum('tipe_jabatan', ['kepala', 'sekretaris', 'kabid', 'staff'])->default('staff');
            $table->string('tipe_jabatan_custom')->nullable();
            
            // Drop new column
            $table->dropColumn('is_ketua');
        });
    }
};
