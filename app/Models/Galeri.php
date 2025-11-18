<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Galeri",
 *     type="object",
 *     title="Galeri",
 *     description="Model data Galeri foto dan video",
 *     @OA\Property(property="id", type="integer", example=1, description="ID galeri"),
 *     @OA\Property(property="judul", type="string", example="Kegiatan Pelatihan Tanggap Bencana", nullable=true, description="Judul galeri (opsional)"),
 *     @OA\Property(property="deskripsi", type="string", example="Dokumentasi kegiatan pelatihan...", nullable=true, description="Deskripsi galeri (opsional)"),
 *     @OA\Property(
 *         property="tipe",
 *         type="string",
 *         example="gambar",
 *         enum={"gambar", "video"},
 *         description="Tipe media"
 *     ),
 *     @OA\Property(property="gambar", type="string", example="galeri/foto-kegiatan.jpg", nullable=true, description="Path file gambar (untuk tipe gambar)"),
 *     @OA\Property(property="gambar_url", type="string", example="http://localhost:8000/storage/galeri/foto-kegiatan.jpg", nullable=true, description="URL lengkap gambar"),
 *     @OA\Property(property="video_url", type="string", example="https://www.youtube.com/watch?v=xxxxx", nullable=true, description="URL video YouTube (untuk tipe video)"),
 *     @OA\Property(property="youtube_embed_url", type="string", example="https://www.youtube.com/embed/xxxxx?rel=0&modestbranding=1", nullable=true, description="URL embed YouTube"),
 *     @OA\Property(property="youtube_video_id", type="string", example="xxxxx", nullable=true, description="YouTube video ID"),
 *     @OA\Property(property="is_active", type="boolean", example=true, description="Status aktif"),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2025-01-15 10:30:00", description="Waktu dibuat"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2025-01-15 10:30:00", description="Waktu diupdate")
 * )
 * 
 * @OA\Schema(
 *     schema="GaleriInput",
 *     type="object",
 *     title="Galeri Input",
 *     description="Data input untuk create/update galeri",
 *     required={"tipe"},
 *     @OA\Property(property="judul", type="string", example="Kegiatan Pelatihan Tanggap Bencana", maxLength=255, nullable=true, description="Judul galeri (opsional)"),
 *     @OA\Property(property="deskripsi", type="string", example="Dokumentasi kegiatan pelatihan...", nullable=true, description="Deskripsi galeri (opsional)"),
 *     @OA\Property(
 *         property="tipe",
 *         type="string",
 *         example="gambar",
 *         enum={"gambar", "video"},
 *         description="Tipe media (wajib)"
 *     ),
 *     @OA\Property(property="gambar", type="string", format="binary", nullable=true, description="File gambar (wajib jika tipe=gambar, max: 2MB, format: jpg,jpeg,png)"),
 *     @OA\Property(property="video_url", type="string", example="https://www.youtube.com/watch?v=xxxxx", nullable=true, description="URL video YouTube (wajib jika tipe=video)"),
 *     @OA\Property(property="is_active", type="boolean", example=true, nullable=true, description="Status aktif (opsional, default: true)")
 * )
 */
class Galeri extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'tipe',
        'gambar',
        'video_url',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getGambarUrlAttribute()
    {
        if ($this->tipe === 'gambar' && $this->gambar) {
            return asset('storage/' . $this->gambar);
        }
        return null;
    }

    public function getYoutubeEmbedUrlAttribute()
    {
        if ($this->tipe === 'video' && $this->video_url) {
            // Extract video ID from various YouTube URL formats
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $this->video_url, $matches);
            
            if (isset($matches[1])) {
                // Add parameters to enable autoplay and allow fullscreen
                return 'https://www.youtube.com/embed/' . $matches[1] . '?rel=0&modestbranding=1';
            }
        }
        return null;
    }
    
    public function getYoutubeVideoIdAttribute()
    {
        if ($this->tipe === 'video' && $this->video_url) {
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $this->video_url, $matches);
            return $matches[1] ?? null;
        }
        return null;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
