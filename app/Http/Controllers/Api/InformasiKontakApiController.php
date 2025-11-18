<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InformasiKontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InformasiKontakApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/informasi-kontak",
     *     summary="Get informasi kontak BPBD",
     *     description="Mendapatkan informasi kontak BPBD (alamat, telepon, email, social media)",
     *     tags={"Informasi Kontak"},
     *     @OA\Response(
     *         response=200,
     *         description="Data informasi kontak berhasil diambil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data informasi kontak berhasil diambil"),
     *             @OA\Property(property="data", ref="#/components/schemas/InformasiKontak")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Informasi kontak belum diatur",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Informasi kontak belum diatur"),
     *             @OA\Property(property="data", type="null")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $kontak = InformasiKontak::first();

        if (!$kontak) {
            return response()->json([
                'success' => false,
                'message' => 'Informasi kontak belum diatur',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data informasi kontak berhasil diambil',
            'data' => $kontak
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/informasi-kontak/{id}",
     *     summary="Get detail informasi kontak by ID",
     *     description="Mendapatkan detail informasi kontak berdasarkan ID",
     *     tags={"Informasi Kontak"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID informasi kontak",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail informasi kontak berhasil diambil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Detail informasi kontak berhasil diambil"),
     *             @OA\Property(property="data", ref="#/components/schemas/InformasiKontak")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Informasi kontak tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Informasi kontak tidak ditemukan"),
     *             @OA\Property(property="data", type="null")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $kontak = InformasiKontak::find($id);

        if (!$kontak) {
            return response()->json([
                'success' => false,
                'message' => 'Informasi kontak tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail informasi kontak berhasil diambil',
            'data' => $kontak
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/informasi-kontak",
     *     summary="Create informasi kontak",
     *     description="Membuat informasi kontak baru (hanya satu record yang diperbolehkan)",
     *     tags={"Informasi Kontak"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/InformasiKontakInput")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Informasi kontak berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Informasi kontak berhasil dibuat"),
     *             @OA\Property(property="data", ref="#/components/schemas/InformasiKontak")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Informasi kontak sudah ada",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Informasi kontak sudah ada, gunakan endpoint update"),
     *             @OA\Property(property="data", type="null")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validasi gagal"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        // Check if contact info already exists
        if (InformasiKontak::exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Informasi kontak sudah ada, gunakan endpoint update',
                'data' => null
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'alamat' => 'required|string',
            'maps_url' => 'nullable|url',
            'telepon' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'jam_operasional' => 'nullable|string|max:255',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'footer_text' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $kontak = InformasiKontak::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Informasi kontak berhasil dibuat',
            'data' => $kontak
        ], 201);
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/informasi-kontak/{id}",
     *     summary="Update informasi kontak",
     *     description="Mengupdate informasi kontak BPBD (partial update - hanya field yang dikirim yang akan diubah)",
     *     tags={"Informasi Kontak"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID informasi kontak",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Kirim hanya field yang ingin diubah",
     *         @OA\JsonContent(
     *             @OA\Property(property="alamat", type="string", example="Jl. Tjilik Riwut Km. 5, Kasongan"),
     *             @OA\Property(property="maps_url", type="string", example="https://maps.google.com/..."),
     *             @OA\Property(property="telepon", type="string", example="(0536) 21234"),
     *             @OA\Property(property="email", type="string", format="email", example="bpbd@katingankab.go.id"),
     *             @OA\Property(property="jam_operasional", type="string", example="Senin - Jumat: 08:00 - 16:00 WIB"),
     *             @OA\Property(property="facebook", type="string", example="https://facebook.com/bpbdkatingan"),
     *             @OA\Property(property="instagram", type="string", example="https://instagram.com/bpbdkatingan"),
     *             @OA\Property(property="twitter", type="string", example="https://twitter.com/bpbdkatingan"),
     *             @OA\Property(property="youtube", type="string", example="https://youtube.com/@bpbdkatingan"),
     *             @OA\Property(property="whatsapp", type="string", example="6285123456789"),
     *             @OA\Property(property="footer_text", type="string", example="BPBD Kabupaten Katingan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informasi kontak berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Informasi kontak berhasil diupdate"),
     *             @OA\Property(property="data", ref="#/components/schemas/InformasiKontak")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Informasi kontak tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Informasi kontak tidak ditemukan"),
     *             @OA\Property(property="data", type="null")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validasi gagal"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $kontak = InformasiKontak::find($id);

        if (!$kontak) {
            return response()->json([
                'success' => false,
                'message' => 'Informasi kontak tidak ditemukan',
                'data' => null
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'alamat' => 'sometimes|required|string',
            'maps_url' => 'nullable|url',
            'telepon' => 'sometimes|required|string|max:50',
            'email' => 'sometimes|required|email|max:255',
            'jam_operasional' => 'nullable|string|max:255',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'footer_text' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $kontak->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Informasi kontak berhasil diupdate',
            'data' => $kontak
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/informasi-kontak/{id}",
     *     summary="Delete informasi kontak",
     *     description="Menghapus informasi kontak (biasanya tidak digunakan, lebih baik update)",
     *     tags={"Informasi Kontak"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID informasi kontak",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informasi kontak berhasil dihapus",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Informasi kontak berhasil dihapus"),
     *             @OA\Property(property="data", type="null")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Informasi kontak tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Informasi kontak tidak ditemukan"),
     *             @OA\Property(property="data", type="null")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $kontak = InformasiKontak::find($id);

        if (!$kontak) {
            return response()->json([
                'success' => false,
                'message' => 'Informasi kontak tidak ditemukan',
                'data' => null
            ], 404);
        }

        $kontak->delete();

        return response()->json([
            'success' => true,
            'message' => 'Informasi kontak berhasil dihapus',
            'data' => null
        ]);
    }
}
