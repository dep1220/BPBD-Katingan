<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VisiMisi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VisiMisiApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/visi-misi",
     *     operationId="getVisiMisi",
     *     tags={"Visi Misi"},
     *     summary="Mendapatkan visi misi",
     *     description="Mengembalikan data visi dan misi yang aktif",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data visi misi",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil mendapatkan data visi misi"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="visi", type="string", example="Mewujudkan Kabupaten Katingan yang tangguh dalam menghadapi bencana"),
     *                 @OA\Property(
     *                     property="misi",
     *                     type="array",
     *                     @OA\Items(type="string", example="Meningkatkan kapasitas kelembagaan dalam penanggulangan bencana")
     *                 ),
     *                 @OA\Property(property="deskripsi_visi", type="string", example="Penjelasan detail tentang visi..."),
     *                 @OA\Property(property="is_active", type="boolean", example=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data visi misi tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Data visi misi tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $visiMisi = VisiMisi::getActive();

        if (!$visiMisi) {
            return response()->json([
                'success' => false,
                'message' => 'Data visi misi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data visi misi',
            'data' => [
                'id' => $visiMisi->id,
                'visi' => $visiMisi->visi,
                'misi' => $visiMisi->misi,
                'deskripsi_visi' => $visiMisi->deskripsi_visi,
                'is_active' => $visiMisi->is_active,
            ]
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/visi-misi/{id}",
     *     operationId="getVisiMisiById",
     *     tags={"Visi Misi"},
     *     summary="Mendapatkan detail visi misi",
     *     description="Menampilkan detail visi misi berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID visi misi",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan detail visi misi",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil mendapatkan detail visi misi"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="visi", type="string", example="Mewujudkan Kabupaten Katingan yang tangguh dalam menghadapi bencana"),
     *                 @OA\Property(
     *                     property="misi",
     *                     type="array",
     *                     @OA\Items(type="string", example="Meningkatkan kapasitas kelembagaan dalam penanggulangan bencana")
     *                 ),
     *                 @OA\Property(property="deskripsi_visi", type="string", example="Penjelasan detail tentang visi..."),
     *                 @OA\Property(property="is_active", type="boolean", example=true),
     *                 @OA\Property(property="created_at", type="string", example="2025-01-15 10:30:00"),
     *                 @OA\Property(property="updated_at", type="string", example="2025-01-15 10:30:00")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Visi misi tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Visi misi tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function show($id): JsonResponse
    {
        $visiMisi = VisiMisi::find($id);

        if (!$visiMisi) {
            return response()->json([
                'success' => false,
                'message' => 'Visi misi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan detail visi misi',
            'data' => [
                'id' => $visiMisi->id,
                'visi' => $visiMisi->visi,
                'misi' => $visiMisi->misi,
                'deskripsi_visi' => $visiMisi->deskripsi_visi,
                'is_active' => $visiMisi->is_active,
                'created_at' => $visiMisi->created_at->toDateTimeString(),
                'updated_at' => $visiMisi->updated_at->toDateTimeString(),
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/visi-misi",
     *     operationId="createVisiMisi",
     *     tags={"Visi Misi"},
     *     summary="Membuat visi misi baru",
     *     description="Endpoint untuk membuat visi misi baru. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"visi", "misi"},
     *             @OA\Property(property="visi", type="string", example="Mewujudkan Kabupaten Katingan yang tangguh dalam menghadapi bencana"),
     *             @OA\Property(
     *                 property="misi",
     *                 type="array",
     *                 @OA\Items(type="string", example="Meningkatkan kapasitas kelembagaan dalam penanggulangan bencana")
     *             ),
     *             @OA\Property(property="deskripsi_visi", type="string", example="Penjelasan detail tentang visi...", nullable=true),
     *             @OA\Property(property="is_active", type="boolean", example=true, nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Visi misi berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Visi misi berhasil dibuat"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="visi", type="string", example="Mewujudkan Kabupaten Katingan yang tangguh dalam menghadapi bencana"),
     *                 @OA\Property(
     *                     property="misi",
     *                     type="array",
     *                     @OA\Items(type="string", example="Meningkatkan kapasitas kelembagaan dalam penanggulangan bencana")
     *                 ),
     *                 @OA\Property(property="deskripsi_visi", type="string", example="Penjelasan detail tentang visi..."),
     *                 @OA\Property(property="is_active", type="boolean", example=true),
     *                 @OA\Property(property="created_at", type="string", example="2025-01-15 10:30:00"),
     *                 @OA\Property(property="updated_at", type="string", example="2025-01-15 10:30:00")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation error"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="visi", type="array", @OA\Items(type="string", example="Visi wajib diisi")),
     *                 @OA\Property(property="misi", type="array", @OA\Items(type="string", example="Misi wajib diisi"))
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'visi' => 'required|string',
            'misi' => 'required|array|min:1',
            'misi.*' => 'required|string',
            'deskripsi_visi' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Nonaktifkan visi misi yang lama jika yang baru diset aktif
        if ($request->input('is_active', true)) {
            VisiMisi::where('is_active', true)->update(['is_active' => false]);
        }

        $data = [
            'visi' => $request->input('visi'),
            'misi' => $request->input('misi'),
            'deskripsi_visi' => $request->input('deskripsi_visi'),
            'is_active' => $request->input('is_active', true),
        ];

        $visiMisi = VisiMisi::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Visi misi berhasil dibuat',
            'data' => [
                'id' => $visiMisi->id,
                'visi' => $visiMisi->visi,
                'misi' => $visiMisi->misi,
                'deskripsi_visi' => $visiMisi->deskripsi_visi,
                'is_active' => $visiMisi->is_active,
                'created_at' => $visiMisi->created_at->toDateTimeString(),
                'updated_at' => $visiMisi->updated_at->toDateTimeString(),
            ]
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/visi-misi/{id}",
     *     operationId="updateVisiMisi",
     *     tags={"Visi Misi"},
     *     summary="Update visi misi",
     *     description="Endpoint untuk update visi misi berdasarkan ID. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID visi misi",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="visi", type="string", example="Mewujudkan Kabupaten Katingan yang tangguh (Update)"),
     *             @OA\Property(
     *                 property="misi",
     *                 type="array",
     *                 @OA\Items(type="string", example="Misi update 1")
     *             ),
     *             @OA\Property(property="deskripsi_visi", type="string", example="Deskripsi update..."),
     *             @OA\Property(property="is_active", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Visi misi berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Visi misi berhasil diupdate"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="visi", type="string", example="Mewujudkan Kabupaten Katingan yang tangguh (Update)"),
     *                 @OA\Property(
     *                     property="misi",
     *                     type="array",
     *                     @OA\Items(type="string", example="Misi update 1")
     *                 ),
     *                 @OA\Property(property="deskripsi_visi", type="string", example="Deskripsi update..."),
     *                 @OA\Property(property="is_active", type="boolean", example=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Visi misi tidak ditemukan"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        $visiMisi = VisiMisi::find($id);

        if (!$visiMisi) {
            return response()->json([
                'success' => false,
                'message' => 'Visi misi tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'visi' => 'sometimes|required|string',
            'misi' => 'sometimes|required|array|min:1',
            'misi.*' => 'required|string',
            'deskripsi_visi' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Nonaktifkan visi misi yang lain jika yang ini diset aktif
        if ($request->has('is_active') && $request->input('is_active')) {
            VisiMisi::where('id', '!=', $id)->where('is_active', true)->update(['is_active' => false]);
        }

        $data = [];

        if ($request->has('visi')) {
            $data['visi'] = $request->input('visi');
        }
        if ($request->has('misi')) {
            $data['misi'] = $request->input('misi');
        }
        if ($request->has('deskripsi_visi')) {
            $data['deskripsi_visi'] = $request->input('deskripsi_visi');
        }
        if ($request->has('is_active')) {
            $data['is_active'] = $request->input('is_active');
        }

        $visiMisi->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Visi misi berhasil diupdate',
            'data' => [
                'id' => $visiMisi->id,
                'visi' => $visiMisi->visi,
                'misi' => $visiMisi->misi,
                'deskripsi_visi' => $visiMisi->deskripsi_visi,
                'is_active' => $visiMisi->is_active,
                'created_at' => $visiMisi->created_at->toDateTimeString(),
                'updated_at' => $visiMisi->updated_at->toDateTimeString(),
            ]
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/visi-misi/{id}",
     *     operationId="deleteVisiMisi",
     *     tags={"Visi Misi"},
     *     summary="Hapus visi misi",
     *     description="Endpoint untuk menghapus visi misi berdasarkan ID. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID visi misi yang akan dihapus",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Visi misi berhasil dihapus",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Visi misi berhasil dihapus")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Visi misi tidak ditemukan")
     * )
     */
    public function destroy($id): JsonResponse
    {
        $visiMisi = VisiMisi::find($id);

        if (!$visiMisi) {
            return response()->json([
                'success' => false,
                'message' => 'Visi misi tidak ditemukan'
            ], 404);
        }

        $visiMisi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Visi misi berhasil dihapus'
        ]);
    }
}
