<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PanduanBencana;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PanduanBencanaApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/panduan-bencana",
     *     operationId="getPanduanBencana",
     *     tags={"Panduan Bencana"},
     *     summary="Mendapatkan daftar panduan bencana",
     *     description="Mengembalikan daftar panduan kesiapsiagaan bencana yang aktif, diurutkan berdasarkan sequence",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data panduan bencana",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil mendapatkan data panduan bencana"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/PanduanBencana")
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $query = PanduanBencana::where('is_active', true);

        $panduan = $query->orderBy('sequence')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'description' => $item->description,
                'items' => $item->items,
                'sequence' => $item->sequence,
                'is_active' => $item->is_active,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data panduan bencana',
            'data' => $panduan
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/panduan-bencana/{id}",
     *     operationId="getPanduanBencanaById",
     *     tags={"Panduan Bencana"},
     *     summary="Mendapatkan detail panduan bencana",
     *     description="Menampilkan detail panduan bencana berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID panduan bencana",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan detail panduan bencana",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil mendapatkan detail panduan bencana"),
     *             @OA\Property(property="data", ref="#/components/schemas/PanduanBencana")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Panduan bencana tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Panduan bencana tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function show($id): JsonResponse
    {
        $panduan = PanduanBencana::find($id);

        if (!$panduan) {
            return response()->json([
                'success' => false,
                'message' => 'Panduan bencana tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan detail panduan bencana',
            'data' => [
                'id' => $panduan->id,
                'title' => $panduan->title,
                'description' => $panduan->description,
                'items' => $panduan->items,
                'sequence' => $panduan->sequence,
                'is_active' => $panduan->is_active,
                'created_at' => $panduan->created_at->toDateTimeString(),
                'updated_at' => $panduan->updated_at->toDateTimeString(),
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/panduan-bencana",
     *     operationId="createPanduanBencana",
     *     tags={"Panduan Bencana"},
     *     summary="Membuat panduan bencana baru",
     *     description="Endpoint untuk membuat panduan bencana baru. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PanduanBencanaInput")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Panduan bencana berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Panduan bencana berhasil dibuat"),
     *             @OA\Property(property="data", ref="#/components/schemas/PanduanBencana")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*' => 'required|string',
            'sequence' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'items' => $request->input('items'),
            'sequence' => $request->input('sequence', 0),
            'is_active' => $request->input('is_active', true),
        ];

        $panduan = PanduanBencana::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Panduan bencana berhasil dibuat',
            'data' => [
                'id' => $panduan->id,
                'title' => $panduan->title,
                'description' => $panduan->description,
                'items' => $panduan->items,
                'sequence' => $panduan->sequence,
                'is_active' => $panduan->is_active,
                'created_at' => $panduan->created_at->toDateTimeString(),
                'updated_at' => $panduan->updated_at->toDateTimeString(),
            ]
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/panduan-bencana/{id}",
     *     operationId="updatePanduanBencana",
     *     tags={"Panduan Bencana"},
     *     summary="Update panduan bencana",
     *     description="Endpoint untuk update panduan bencana berdasarkan ID. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID panduan bencana",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Panduan Update"),
     *             @OA\Property(property="description", type="string", example="Deskripsi update"),
     *             @OA\Property(property="items", type="array", @OA\Items(type="string", example="Poin panduan")),
     *             @OA\Property(property="sequence", type="integer", example=2),
     *             @OA\Property(property="is_active", type="boolean", example=false)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Panduan bencana berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Panduan bencana berhasil diupdate"),
     *             @OA\Property(property="data", ref="#/components/schemas/PanduanBencana")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Panduan bencana tidak ditemukan"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        $panduan = PanduanBencana::find($id);

        if (!$panduan) {
            return response()->json([
                'success' => false,
                'message' => 'Panduan bencana tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string|max:255',
            'items' => 'sometimes|required|array|min:1',
            'items.*' => 'required|string',
            'sequence' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [];

        if ($request->has('title')) {
            $data['title'] = $request->input('title');
        }
        if ($request->has('description')) {
            $data['description'] = $request->input('description');
        }
        if ($request->has('items')) {
            $data['items'] = $request->input('items');
        }
        if ($request->has('sequence')) {
            $data['sequence'] = $request->input('sequence');
        }
        if ($request->has('is_active')) {
            $data['is_active'] = $request->input('is_active');
        }

        $panduan->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Panduan bencana berhasil diupdate',
            'data' => [
                'id' => $panduan->id,
                'title' => $panduan->title,
                'description' => $panduan->description,
                'items' => $panduan->items,
                'sequence' => $panduan->sequence,
                'is_active' => $panduan->is_active,
                'created_at' => $panduan->created_at->toDateTimeString(),
                'updated_at' => $panduan->updated_at->toDateTimeString(),
            ]
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/panduan-bencana/{id}",
     *     operationId="deletePanduanBencana",
     *     tags={"Panduan Bencana"},
     *     summary="Hapus panduan bencana",
     *     description="Endpoint untuk menghapus panduan bencana berdasarkan ID. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID panduan bencana yang akan dihapus",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Panduan bencana berhasil dihapus",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Panduan bencana berhasil dihapus")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Panduan bencana tidak ditemukan")
     * )
     */
    public function destroy($id): JsonResponse
    {
        $panduan = PanduanBencana::find($id);

        if (!$panduan) {
            return response()->json([
                'success' => false,
                'message' => 'Panduan bencana tidak ditemukan'
            ], 404);
        }

        $panduan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Panduan bencana berhasil dihapus'
        ]);
    }
}
