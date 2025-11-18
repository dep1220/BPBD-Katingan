<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="PanduanBencana",
 *     type="object",
 *     title="Panduan Bencana",
 *     description="Model data Panduan Kesiapsiagaan Bencana",
 *     @OA\Property(property="id", type="integer", example=1, description="ID panduan"),
 *     @OA\Property(property="title", type="string", example="Sebelum Bencana", description="Judul panduan"),
 *     @OA\Property(property="description", type="string", example="Persiapan adalah kunci untuk menghadapi bencana", description="Deskripsi panduan"),
 *     @OA\Property(
 *         property="items",
 *         type="array",
 *         description="Daftar poin-poin panduan",
 *         @OA\Items(type="string", example="Siapkan tas siaga bencana")
 *     ),
 *     @OA\Property(property="sequence", type="integer", example=1, description="Urutan tampil panduan"),
 *     @OA\Property(property="is_active", type="boolean", example=true, description="Status aktif panduan"),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2025-01-15 10:30:00", description="Waktu dibuat"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2025-01-15 10:30:00", description="Waktu diupdate")
 * )
 * 
 * @OA\Schema(
 *     schema="PanduanBencanaInput",
 *     type="object",
 *     title="Panduan Bencana Input",
 *     description="Data input untuk create/update panduan bencana",
 *     required={"title", "description", "items"},
 *     @OA\Property(property="title", type="string", example="Sebelum Bencana", maxLength=255, description="Judul panduan (wajib)"),
 *     @OA\Property(property="description", type="string", example="Persiapan adalah kunci", maxLength=255, description="Deskripsi panduan (wajib)"),
 *     @OA\Property(
 *         property="items",
 *         type="array",
 *         description="Daftar poin-poin panduan (wajib, minimal 1 item)",
 *         @OA\Items(type="string", example="Siapkan tas siaga bencana"),
 *         minItems=1
 *     ),
 *     @OA\Property(property="sequence", type="integer", example=1, minimum=0, nullable=true, description="Urutan tampil (opsional, default: 0)"),
 *     @OA\Property(property="is_active", type="boolean", example=true, nullable=true, description="Status aktif (opsional, default: true)")
 * )
 */
class PanduanBencana extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'items',
        'sequence',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'items' => 'array', // Otomatis mengubah JSON -> array dan sebaliknya
        'is_active' => 'boolean',
    ];
}
