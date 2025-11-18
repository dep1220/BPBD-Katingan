<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="Pesan",
 *     type="object",
 *     title="Pesan Kontak",
 *     description="Model data Pesan/Kontak dari pengunjung",
 *     @OA\Property(property="id", type="integer", example=1, description="ID pesan"),
 *     @OA\Property(property="name", type="string", example="John Doe", description="Nama pengirim"),
 *     @OA\Property(property="email", type="string", example="john@example.com", description="Email pengirim"),
 *     @OA\Property(property="phone", type="string", example="08123456789", nullable=true, description="Nomor telepon (opsional)"),
 *     @OA\Property(property="category", type="string", example="Pertanyaan", description="Kategori pesan"),
 *     @OA\Property(property="subject", type="string", example="Informasi Kesiapsiagaan Bencana", description="Subjek pesan"),
 *     @OA\Property(property="message", type="string", example="Saya ingin menanyakan tentang...", description="Isi pesan"),
 *     @OA\Property(property="is_read", type="boolean", example=false, description="Status sudah dibaca"),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2025-01-15 10:30:00", description="Waktu dibuat"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2025-01-15 10:30:00", description="Waktu diupdate")
 * )
 * 
 * @OA\Schema(
 *     schema="PesanInput",
 *     type="object",
 *     title="Pesan Input",
 *     description="Data input untuk mengirim pesan/kontak",
 *     required={"name", "email", "category", "subject", "message"},
 *     @OA\Property(property="name", type="string", example="John Doe", maxLength=255, description="Nama pengirim (wajib)"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com", maxLength=255, description="Email pengirim (wajib)"),
 *     @OA\Property(property="phone", type="string", example="08123456789", maxLength=255, nullable=true, description="Nomor telepon (opsional)"),
 *     @OA\Property(property="category", type="string", example="Pertanyaan", maxLength=255, description="Kategori pesan (wajib)"),
 *     @OA\Property(property="subject", type="string", example="Informasi Kesiapsiagaan Bencana", maxLength=255, description="Subjek pesan (wajib)"),
 *     @OA\Property(property="message", type="string", example="Saya ingin menanyakan tentang...", description="Isi pesan (wajib)")
 * )
 */
class Pesan extends Model
{
    use HasFactory;
    protected $fillable = [

        'name',
        'email',
        'phone',
        'category',
        'subject',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    // Scope untuk pesan yang belum dibaca
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // Scope untuk pesan yang sudah dibaca
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }
}
