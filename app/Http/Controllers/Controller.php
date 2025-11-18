<?php

namespace App\Http\Controllers;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="BPBD Katingan API Documentation",
 *         description="API Documentation untuk Sistem Informasi BPBD Kabupaten Katingan - Badan Penanggulangan Bencana Daerah",
 *         @OA\License(
 *             name="Proprietary",
 *             url="https://bpbd.katingankab.go.id"
 *         )
 *     ),
 *     @OA\Server(
 *         url=L5_SWAGGER_CONST_HOST,
 *         description="API Server"
 *     ),
 *     tags={
 *         @OA\Tag(
 *             name="Authentication",
 *             description="Endpoint untuk autentikasi admin"
 *         ),
 *         @OA\Tag(
 *             name="Berita",
 *             description="Endpoint untuk manajemen berita dan informasi"
 *         ),
 *         @OA\Tag(
 *             name="Slider",
 *             description="Endpoint untuk manajemen slider beranda"
 *         ),
 *         @OA\Tag(
 *             name="Agenda",
 *             description="Endpoint untuk manajemen agenda kegiatan"
 *         ),
 *         @OA\Tag(
 *             name="Galeri",
 *             description="Endpoint untuk manajemen galeri foto"
 *         ),
 *         @OA\Tag(
 *             name="Unduhan",
 *             description="Endpoint untuk manajemen dokumen unduhan"
 *         ),
 *         @OA\Tag(
 *             name="Struktur Organisasi",
 *             description="Endpoint untuk manajemen struktur organisasi"
 *         ),
 *         @OA\Tag(
 *             name="Panduan Bencana",
 *             description="Endpoint untuk manajemen panduan kesiapsiagaan bencana"
 *         ),
 *         @OA\Tag(
 *             name="Visi Misi",
 *             description="Endpoint untuk manajemen visi dan misi"
 *         ),
 *         @OA\Tag(
 *             name="Informasi Kontak",
 *             description="Endpoint untuk manajemen informasi kontak BPBD (alamat, telepon, social media)"
 *         ),
 *         @OA\Tag(
 *             name="Pesan Kontak",
 *             description="Endpoint untuk manajemen pesan dari pengunjung melalui form kontak"
 *         )
 *     }
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Masukkan token JWT untuk autentikasi"
 * )
 */
abstract class Controller
{
    //
}
