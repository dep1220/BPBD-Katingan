<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="VisiMisi",
 *     type="object",
 *     title="Visi Misi",
 *     description="Model data Visi dan Misi BPBD",
 *     @OA\Property(property="id", type="integer", example=1, description="ID visi misi"),
 *     @OA\Property(property="visi", type="string", example="Mewujudkan Kabupaten Katingan yang tangguh dalam menghadapi bencana", description="Visi organisasi"),
 *     @OA\Property(
 *         property="misi",
 *         type="array",
 *         description="Daftar misi organisasi",
 *         @OA\Items(
 *             type="string",
 *             example="Meningkatkan kapasitas kelembagaan dalam penanggulangan bencana"
 *         )
 *     ),
 *     @OA\Property(property="deskripsi_visi", type="string", example="Penjelasan detail tentang visi...", nullable=true, description="Deskripsi visi (opsional)"),
 *     @OA\Property(property="is_active", type="boolean", example=true, description="Status aktif"),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2025-01-15 10:30:00", description="Waktu dibuat"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2025-01-15 10:30:00", description="Waktu diupdate")
 * )
 * 
 * @OA\Schema(
 *     schema="VisiMisiInput",
 *     type="object",
 *     title="Visi Misi Input",
 *     description="Data input untuk create/update visi misi",
 *     required={"visi", "misi"},
 *     @OA\Property(property="visi", type="string", example="Mewujudkan Kabupaten Katingan yang tangguh dalam menghadapi bencana", description="Visi organisasi (wajib)"),
 *     @OA\Property(
 *         property="misi",
 *         type="array",
 *         description="Daftar misi organisasi (wajib, minimal 1 item)",
 *         @OA\Items(
 *             type="string",
 *             example="Meningkatkan kapasitas kelembagaan dalam penanggulangan bencana"
 *         ),
 *         minItems=1
 *     ),
 *     @OA\Property(property="deskripsi_visi", type="string", example="Penjelasan detail tentang visi...", nullable=true, description="Deskripsi visi (opsional)"),
 *     @OA\Property(property="is_active", type="boolean", example=true, nullable=true, description="Status aktif (opsional, default: true)")
 * )
 */
class VisiMisi extends Model
{
    protected $table = 'visi_misi';

    protected $fillable = [
        'visi',
        'misi',
        'deskripsi_visi',
        'is_active'
    ];

    protected $casts = [
        'misi' => 'array',
        'is_active' => 'boolean'
    ];

    // Scope untuk data aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Method untuk mendapatkan visi misi aktif
    public static function getActive()
    {
        return self::active()->first();
    }

    // Route key name untuk binding
    public function getRouteKeyName()
    {
        return 'id';
    }
}
