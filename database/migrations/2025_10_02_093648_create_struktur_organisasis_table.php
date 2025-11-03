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
        Schema::create('struktur_organisasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip')->nullable();
            $table->string('jabatan');
            $table->enum('tipe_jabatan', ['kepala', 'sekretaris', 'kabid', 'staff'])->default('staff');
            $table->text('foto')->nullable();
            $table->text('sambutan_kepala')->nullable(); // Khusus untuk kepala
            $table->text('bio')->nullable();
            $table->integer('urutan')->default(0); // Untuk sorting
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('struktur_organisasis');
    }
};
