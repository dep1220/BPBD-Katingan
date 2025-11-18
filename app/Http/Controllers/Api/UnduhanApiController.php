<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Unduhan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UnduhanApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/unduhan",
     *     operationId="getUnduhan",
     *     tags={"Unduhan"},
     *     summary="Mendapatkan daftar unduhan",
     *     description="Mengembalikan daftar dokumen unduhan yang aktif",
     *     @OA\Parameter(
     *         name="kategori",
     *         in="query",
     *         description="Filter berdasarkan kategori",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data unduhan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil mendapatkan data unduhan"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="title", type="string", example="Laporan Tahunan BPBD 2024"),
     *                     @OA\Property(property="kategori", type="string", example="Laporan"),
     *                     @OA\Property(property="file_path", type="string", example="unduhan/laporan-2024.pdf"),
     *                     @OA\Property(property="file_url", type="string", example="http://localhost:8000/storage/unduhan/laporan-2024.pdf"),
     *                     @OA\Property(property="file_size", type="string", example="2.5 MB"),
     *                     @OA\Property(property="file_extension", type="string", example="pdf"),
     *                     @OA\Property(property="is_active", type="boolean", example=true)
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $query = Unduhan::where('is_active', true);

        // Filter by kategori if provided
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->input('kategori'));
        }

        $unduhan = $query->latest()->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'kategori' => $item->kategori,
                'file_path' => $item->file_path,
                'file_url' => $item->file_url,
                'file_size' => $item->file_size,
                'file_extension' => $item->file_extension,
                'is_active' => $item->is_active,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data unduhan',
            'data' => $unduhan
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/unduhan/{id}",
     *     operationId="getUnduhanById",
     *     tags={"Unduhan"},
     *     summary="Mendapatkan detail unduhan",
     *     description="Menampilkan detail unduhan berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID unduhan",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan detail unduhan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil mendapatkan detail unduhan"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Laporan Tahunan BPBD 2024"),
     *                 @OA\Property(property="kategori", type="string", example="Laporan"),
     *                 @OA\Property(property="file_path", type="string", example="unduhan/laporan-2024.pdf"),
     *                 @OA\Property(property="file_url", type="string", example="http://localhost:8000/storage/unduhan/laporan-2024.pdf"),
     *                 @OA\Property(property="file_size", type="string", example="2.5 MB"),
     *                 @OA\Property(property="file_extension", type="string", example="pdf"),
     *                 @OA\Property(property="is_active", type="boolean", example=true),
     *                 @OA\Property(property="created_at", type="string", example="2025-01-15 10:30:00"),
     *                 @OA\Property(property="updated_at", type="string", example="2025-01-15 10:30:00")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Unduhan tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unduhan tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function show($id): JsonResponse
    {
        $unduhan = Unduhan::find($id);

        if (!$unduhan) {
            return response()->json([
                'success' => false,
                'message' => 'Unduhan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan detail unduhan',
            'data' => [
                'id' => $unduhan->id,
                'title' => $unduhan->title,
                'kategori' => $unduhan->kategori,
                'file_path' => $unduhan->file_path,
                'file_url' => $unduhan->file_url,
                'file_size' => $unduhan->file_size,
                'file_extension' => $unduhan->file_extension,
                'is_active' => $unduhan->is_active,
                'created_at' => $unduhan->created_at->toDateTimeString(),
                'updated_at' => $unduhan->updated_at->toDateTimeString(),
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/unduhan",
     *     operationId="createUnduhan",
     *     tags={"Unduhan"},
     *     summary="Membuat unduhan baru",
     *     description="Endpoint untuk upload dokumen unduhan baru. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"title", "file"},
     *                 @OA\Property(property="title", type="string", example="Laporan Tahunan BPBD 2024"),
     *                 @OA\Property(property="kategori", type="string", example="Laporan", nullable=true),
     *                 @OA\Property(property="file", type="string", format="binary", description="File dokumen (max: 10MB, format: pdf,doc,docx,xls,xlsx,ppt,pptx)"),
     *                 @OA\Property(property="is_active", type="boolean", example=true, nullable=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Unduhan berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Unduhan berhasil dibuat"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Laporan Tahunan BPBD 2024"),
     *                 @OA\Property(property="kategori", type="string", example="Laporan"),
     *                 @OA\Property(property="file_url", type="string", example="http://localhost:8000/storage/unduhan/laporan-2024.pdf"),
     *                 @OA\Property(property="file_size", type="string", example="2.5 MB")
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
     *                 @OA\Property(property="title", type="array", @OA\Items(type="string", example="Judul wajib diisi")),
     *                 @OA\Property(property="file", type="array", @OA\Items(type="string", example="File wajib diupload"))
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240', // 10MB
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Upload file
        $file = $request->file('file');
        $filePath = $file->store('unduhan', 'public');
        
        // Get file size in human readable format
        $fileSizeBytes = $file->getSize();
        $fileSize = $this->formatFileSize($fileSizeBytes);

        $data = [
            'title' => $request->input('title'),
            'kategori' => $request->input('kategori'),
            'file_path' => $filePath,
            'file_size' => $fileSize,
            'is_active' => $request->input('is_active', true),
        ];

        $unduhan = Unduhan::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Unduhan berhasil dibuat',
            'data' => [
                'id' => $unduhan->id,
                'title' => $unduhan->title,
                'kategori' => $unduhan->kategori,
                'file_path' => $unduhan->file_path,
                'file_url' => $unduhan->file_url,
                'file_size' => $unduhan->file_size,
                'file_extension' => $unduhan->file_extension,
                'is_active' => $unduhan->is_active,
                'created_at' => $unduhan->created_at->toDateTimeString(),
                'updated_at' => $unduhan->updated_at->toDateTimeString(),
            ]
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/unduhan/{id}",
     *     operationId="updateUnduhan",
     *     tags={"Unduhan"},
     *     summary="Update unduhan",
     *     description="Endpoint untuk update unduhan berdasarkan ID. Requires authentication. Gunakan POST dengan _method=PUT untuk multipart/form-data",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID unduhan",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="_method", type="string", example="PUT", description="Method spoofing untuk form-data"),
     *                 @OA\Property(property="title", type="string", example="Laporan Update 2024"),
     *                 @OA\Property(property="kategori", type="string", example="Laporan Update"),
     *                 @OA\Property(property="file", type="string", format="binary", nullable=true, description="File dokumen baru (opsional)"),
     *                 @OA\Property(property="is_active", type="boolean", example=false)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Unduhan berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Unduhan berhasil diupdate"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Laporan Update 2024")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Unduhan tidak ditemukan"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        $unduhan = Unduhan::find($id);

        if (!$unduhan) {
            return response()->json([
                'success' => false,
                'message' => 'Unduhan tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
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
        if ($request->has('kategori')) {
            $data['kategori'] = $request->input('kategori');
        }
        if ($request->has('is_active')) {
            $data['is_active'] = $request->input('is_active');
        }

        // Handle file upload
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($unduhan->file_path && Storage::disk('public')->exists($unduhan->file_path)) {
                Storage::disk('public')->delete($unduhan->file_path);
            }

            $file = $request->file('file');
            $filePath = $file->store('unduhan', 'public');
            
            // Get file size
            $fileSizeBytes = $file->getSize();
            $fileSize = $this->formatFileSize($fileSizeBytes);

            $data['file_path'] = $filePath;
            $data['file_size'] = $fileSize;
        }

        $unduhan->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Unduhan berhasil diupdate',
            'data' => [
                'id' => $unduhan->id,
                'title' => $unduhan->title,
                'kategori' => $unduhan->kategori,
                'file_path' => $unduhan->file_path,
                'file_url' => $unduhan->file_url,
                'file_size' => $unduhan->file_size,
                'file_extension' => $unduhan->file_extension,
                'is_active' => $unduhan->is_active,
                'created_at' => $unduhan->created_at->toDateTimeString(),
                'updated_at' => $unduhan->updated_at->toDateTimeString(),
            ]
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/unduhan/{id}",
     *     operationId="deleteUnduhan",
     *     tags={"Unduhan"},
     *     summary="Hapus unduhan",
     *     description="Endpoint untuk menghapus unduhan berdasarkan ID. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID unduhan yang akan dihapus",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Unduhan berhasil dihapus",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Unduhan berhasil dihapus")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Unduhan tidak ditemukan")
     * )
     */
    public function destroy($id): JsonResponse
    {
        $unduhan = Unduhan::find($id);

        if (!$unduhan) {
            return response()->json([
                'success' => false,
                'message' => 'Unduhan tidak ditemukan'
            ], 404);
        }

        // Hapus file jika ada
        if ($unduhan->file_path && Storage::disk('public')->exists($unduhan->file_path)) {
            Storage::disk('public')->delete($unduhan->file_path);
        }

        $unduhan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Unduhan berhasil dihapus'
        ]);
    }

    /**
     * Helper function untuk format file size
     */
    private function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
