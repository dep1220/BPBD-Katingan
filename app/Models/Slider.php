<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Slider",
 *     type="object",
 *     title="Slider",
 *     description="Model data Slider beranda",
 *     @OA\Property(property="id", type="integer", example=1, description="ID slider"),
 *     @OA\Property(property="title", type="string", example="Selamat Datang di BPBD Katingan", description="Judul slider"),
 *     @OA\Property(property="subtitle", type="string", example="Badan Penanggulangan Bencana Daerah", nullable=true, description="Subjudul slider"),
 *     @OA\Property(property="image", type="string", example="http://localhost/storage/sliders/image.jpg", description="URL gambar lengkap"),
 *     @OA\Property(property="image_path", type="string", example="sliders/image.jpg", description="Path gambar di storage"),
 *     @OA\Property(property="link", type="string", example="https://bpbd.katingankab.go.id", nullable=true, description="Link tujuan slider"),
 *     @OA\Property(property="urutan", type="integer", example=1, description="Urutan tampil slider"),
 *     @OA\Property(property="is_active", type="boolean", example=true, description="Status aktif slider"),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2025-01-15 10:30:00", description="Waktu dibuat"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2025-01-15 10:30:00", description="Waktu diupdate")
 * )
 * 
 * @OA\Schema(
 *     schema="SliderInput",
 *     type="object",
 *     title="Slider Input",
 *     description="Data input untuk create/update slider",
 *     required={"title"},
 *     @OA\Property(property="title", type="string", example="Slider Baru", maxLength=255, description="Judul slider (wajib)"),
 *     @OA\Property(property="subtitle", type="string", example="Subtitle slider", maxLength=255, nullable=true, description="Subjudul slider (opsional)"),
 *     @OA\Property(property="image", type="string", format="binary", description="File gambar slider (wajib saat create, opsional saat update)"),
 *     @OA\Property(property="link", type="string", format="url", example="https://example.com", maxLength=255, nullable=true, description="URL link slider (opsional)"),
 *     @OA\Property(property="urutan", type="integer", example=1, minimum=0, nullable=true, description="Urutan tampil slider (opsional, default: 0)"),
 *     @OA\Property(property="is_active", type="boolean", example=true, nullable=true, description="Status aktif slider (opsional, default: true)")
 * )
 */
class Slider extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'subtitle',
        'link',
        'image',
        'is_active',
        'sequence',
    ];
}
