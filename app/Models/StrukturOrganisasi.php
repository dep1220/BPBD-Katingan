<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Schema(
 *     schema="StrukturOrganisasi",
 *     type="object",
 *     title="Struktur Organisasi",
 *     description="Model data Struktur Organisasi BPBD",
 *     @OA\Property(property="id", type="integer", example=1, description="ID struktur organisasi"),
 *     @OA\Property(property="nama", type="string", example="Dr. Ahmad Budiman, M.Si", description="Nama lengkap"),
 *     @OA\Property(property="nip", type="string", example="196501011990031001", nullable=true, description="Nomor Induk Pegawai"),
 *     @OA\Property(property="jabatan", type="string", example="Kepala Pelaksana BPBD", description="Jabatan/posisi"),
 *     @OA\Property(property="is_ketua", type="boolean", example=true, description="Apakah jabatan ketua/kepala"),
 *     @OA\Property(property="foto", type="string", example="struktur/foto-kepala.jpg", nullable=true, description="Path foto profil"),
 *     @OA\Property(property="foto_url", type="string", example="http://localhost:8000/storage/struktur/foto-kepala.jpg", nullable=true, description="URL lengkap foto profil"),
 *     @OA\Property(property="sambutan_kepala", type="string", example="Selamat datang di website BPBD Katingan...", nullable=true, description="Sambutan kepala (khusus untuk ketua)"),
 *     @OA\Property(property="sambutan_judul", type="string", example="Sambutan Kepala BPBD", nullable=true, description="Judul sambutan"),
 *     @OA\Property(property="urutan", type="integer", example=1, description="Urutan tampilan"),
 *     @OA\Property(property="is_active", type="boolean", example=true, description="Status aktif"),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2025-01-15 10:30:00", description="Waktu dibuat"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2025-01-15 10:30:00", description="Waktu diupdate")
 * )
 * 
 * @OA\Schema(
 *     schema="StrukturOrganisasiInput",
 *     type="object",
 *     title="Struktur Organisasi Input",
 *     description="Data input untuk create/update struktur organisasi",
 *     required={"nama", "jabatan"},
 *     @OA\Property(property="nama", type="string", example="Dr. Ahmad Budiman, M.Si", maxLength=255, description="Nama lengkap (wajib)"),
 *     @OA\Property(property="nip", type="string", example="196501011990031001", maxLength=255, nullable=true, description="Nomor Induk Pegawai (opsional)"),
 *     @OA\Property(property="jabatan", type="string", example="Kepala Pelaksana BPBD", maxLength=255, description="Jabatan/posisi (wajib)"),
 *     @OA\Property(property="is_ketua", type="boolean", example=true, nullable=true, description="Apakah jabatan ketua/kepala (opsional, default: false)"),
 *     @OA\Property(property="foto", type="string", format="binary", nullable=true, description="File foto profil (opsional, max: 2MB, format: jpg,jpeg,png)"),
 *     @OA\Property(property="sambutan_kepala", type="string", example="Selamat datang di website BPBD Katingan...", nullable=true, description="Sambutan kepala (opsional, khusus untuk ketua)"),
 *     @OA\Property(property="sambutan_judul", type="string", example="Sambutan Kepala BPBD", maxLength=255, nullable=true, description="Judul sambutan (opsional)"),
 *     @OA\Property(property="urutan", type="integer", example=1, minimum=0, nullable=true, description="Urutan tampilan (opsional, default: 0)"),
 *     @OA\Property(property="is_active", type="boolean", example=true, nullable=true, description="Status aktif (opsional, default: true)")
 * )
 */
class StrukturOrganisasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nip',
        'jabatan',
        'is_ketua',
        'foto',
        'sambutan_kepala',
        'sambutan_judul',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_ketua' => 'boolean',
        'urutan' => 'integer',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeKetua($query)
    {
        return $query->where('is_ketua', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderByRaw('is_ketua DESC')
                     ->orderBy('urutan')
                     ->orderBy('created_at');
    }

    // Accessors
    public function getFotoUrlAttribute()
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            return asset('storage/' . $this->foto);
        }
        
        return null;
    }
}
