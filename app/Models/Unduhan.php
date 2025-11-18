<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Unduhan",
 *     type="object",
 *     title="Unduhan",
 *     description="Model data Unduhan dokumen",
 *     @OA\Property(property="id", type="integer", example=1, description="ID unduhan"),
 *     @OA\Property(property="title", type="string", example="Laporan Tahunan BPBD 2024", description="Judul dokumen"),
 *     @OA\Property(property="kategori", type="string", example="Laporan", nullable=true, description="Kategori dokumen (Laporan, SOP, Peta, dll)"),
 *     @OA\Property(property="file_path", type="string", example="unduhan/laporan-2024.pdf", description="Path file di storage"),
 *     @OA\Property(property="file_url", type="string", example="http://localhost:8000/storage/unduhan/laporan-2024.pdf", description="URL download lengkap"),
 *     @OA\Property(property="file_size", type="string", example="2.5 MB", description="Ukuran file"),
 *     @OA\Property(property="file_extension", type="string", example="pdf", description="Ekstensi file"),
 *     @OA\Property(property="is_active", type="boolean", example=true, description="Status aktif"),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2025-01-15 10:30:00", description="Waktu dibuat"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2025-01-15 10:30:00", description="Waktu diupdate")
 * )
 * 
 * @OA\Schema(
 *     schema="UnduhanInput",
 *     type="object",
 *     title="Unduhan Input",
 *     description="Data input untuk create/update unduhan",
 *     required={"title", "file"},
 *     @OA\Property(property="title", type="string", example="Laporan Tahunan BPBD 2024", maxLength=255, description="Judul dokumen (wajib)"),
 *     @OA\Property(property="kategori", type="string", example="Laporan", maxLength=255, nullable=true, description="Kategori dokumen (opsional)"),
 *     @OA\Property(property="file", type="string", format="binary", description="File dokumen (wajib, max: 10MB, format: pdf,doc,docx,xls,xlsx,ppt,pptx)"),
 *     @OA\Property(property="is_active", type="boolean", example=true, nullable=true, description="Status aktif (opsional, default: true)")
 * )
 */
class Unduhan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang dihubungkan dengan model ini.
     *
     * @var string
     */
    protected $table = 'unduhan';

    protected $fillable = [
        'title',
        'kategori',
        'file_path',
        'file_size',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Accessor untuk URL download
    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }

    // Accessor untuk ekstensi file
    public function getFileExtensionAttribute()
    {
        if ($this->file_path) {
            return pathinfo($this->file_path, PATHINFO_EXTENSION);
        }
        return null;
    }

    // Scope untuk data aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
