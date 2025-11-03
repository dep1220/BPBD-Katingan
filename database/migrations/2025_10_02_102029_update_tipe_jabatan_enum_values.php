<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update existing data to match new enum values
        DB::table('struktur_organisasis')->where('tipe_jabatan', 'kabid')->update(['tipe_jabatan' => 'kepala_bidang']);
        
        // Change the enum column to include all new values
        DB::statement("ALTER TABLE struktur_organisasis MODIFY COLUMN tipe_jabatan ENUM('kepala', 'wakil_kepala', 'sekretaris', 'kepala_bidang', 'kepala_seksi', 'kasubag', 'staff') DEFAULT 'staff'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert data changes
        DB::table('struktur_organisasis')->where('tipe_jabatan', 'kepala_bidang')->update(['tipe_jabatan' => 'kabid']);
        
        // Revert enum column
        DB::statement("ALTER TABLE struktur_organisasis MODIFY COLUMN tipe_jabatan ENUM('kepala', 'sekretaris', 'kabid', 'staff') DEFAULT 'staff'");
    }
};
