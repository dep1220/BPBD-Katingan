<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="InformasiKontak",
 *     type="object",
 *     title="Informasi Kontak",
 *     description="Informasi kontak BPBD Katingan",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="alamat", type="string", example="Jl. Tjilik Riwut Km. 5, Kasongan, Kab. Katingan, Kalimantan Tengah"),
 *     @OA\Property(property="maps_url", type="string", example="https://maps.google.com/..."),
 *     @OA\Property(property="telepon", type="string", example="(0536) 21234"),
 *     @OA\Property(property="email", type="string", example="bpbd@katingankab.go.id"),
 *     @OA\Property(property="jam_operasional", type="string", example="Senin - Jumat: 08:00 - 16:00 WIB"),
 *     @OA\Property(property="facebook", type="string", example="https://facebook.com/bpbdkatingan"),
 *     @OA\Property(property="instagram", type="string", example="https://instagram.com/bpbdkatingan"),
 *     @OA\Property(property="twitter", type="string", example="https://twitter.com/bpbdkatingan"),
 *     @OA\Property(property="youtube", type="string", example="https://youtube.com/@bpbdkatingan"),
 *     @OA\Property(property="whatsapp", type="string", example="6285123456789"),
 *     @OA\Property(property="footer_text", type="string", example="Badan Penanggulangan Bencana Daerah Kabupaten Katingan"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-11-13T10:00:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-11-13T10:00:00.000000Z")
 * )
 * 
 * @OA\Schema(
 *     schema="InformasiKontakInput",
 *     type="object",
 *     title="Informasi Kontak Input",
 *     required={"alamat", "telepon", "email"},
 *     @OA\Property(property="alamat", type="string", example="Jl. Tjilik Riwut Km. 5, Kasongan, Kab. Katingan"),
 *     @OA\Property(property="maps_url", type="string", example="https://maps.google.com/..."),
 *     @OA\Property(property="telepon", type="string", example="(0536) 21234"),
 *     @OA\Property(property="email", type="string", format="email", example="bpbd@katingankab.go.id"),
 *     @OA\Property(property="jam_operasional", type="string", example="Senin - Jumat: 08:00 - 16:00 WIB"),
 *     @OA\Property(property="facebook", type="string", example="https://facebook.com/bpbdkatingan"),
 *     @OA\Property(property="instagram", type="string", example="https://instagram.com/bpbdkatingan"),
 *     @OA\Property(property="twitter", type="string", example="https://twitter.com/bpbdkatingan"),
 *     @OA\Property(property="youtube", type="string", example="https://youtube.com/@bpbdkatingan"),
 *     @OA\Property(property="whatsapp", type="string", example="6285123456789"),
 *     @OA\Property(property="footer_text", type="string", example="Badan Penanggulangan Bencana Daerah Kabupaten Katingan")
 * )
 */
class InformasiKontak extends Model
{
    use HasFactory;

    protected $fillable = [
        'alamat',
        'maps_url',
        'telepon',
        'email',
        'jam_operasional',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'whatsapp',
        'footer_text',
    ];

    /**
     * Get the active contact information (single record pattern)
     */
    public static function getActive()
    {
        return self::first();
    }
}


