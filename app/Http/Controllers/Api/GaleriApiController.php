<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GaleriApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/galeri",
     *     operationId="getGaleri",
     *     tags={"Galeri"},
     *     summary="Mendapatkan daftar galeri",
     *     description="Mengembalikan daftar galeri foto dan video yang aktif",
     *     @OA\Parameter(
     *         name="tipe",
     *         in="query",
     *         description="Filter berdasarkan tipe (gambar atau video)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"gambar", "video"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data galeri",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil mendapatkan data galeri"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="judul", type="string", example="Kegiatan Pelatihan Tanggap Bencana"),
     *                     @OA\Property(property="deskripsi", type="string", example="Dokumentasi kegiatan pelatihan..."),
     *                     @OA\Property(property="tipe", type="string", example="gambar"),
     *                     @OA\Property(property="gambar", type="string", example="galeri/foto-kegiatan.jpg"),
     *                     @OA\Property(property="gambar_url", type="string", example="http://localhost:8000/storage/galeri/foto-kegiatan.jpg"),
     *                     @OA\Property(property="video_url", type="string", example=null),
     *                     @OA\Property(property="youtube_embed_url", type="string", example=null),
     *                     @OA\Property(property="youtube_video_id", type="string", example=null),
     *                     @OA\Property(property="is_active", type="boolean", example=true)
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $query = Galeri::where('is_active', true);

        // Filter by tipe if provided
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->input('tipe'));
        }

        $galeri = $query->latest()->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'judul' => $item->judul,
                'deskripsi' => $item->deskripsi,
                'tipe' => $item->tipe,
                'gambar' => $item->gambar,
                'gambar_url' => $item->gambar_url,
                'video_url' => $item->video_url,
                'youtube_embed_url' => $item->youtube_embed_url,
                'youtube_video_id' => $item->youtube_video_id,
                'is_active' => $item->is_active,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data galeri',
            'data' => $galeri
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/galeri/{id}",
     *     operationId="getGaleriById",
     *     tags={"Galeri"},
     *     summary="Mendapatkan detail galeri",
     *     description="Menampilkan detail galeri berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID galeri",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan detail galeri",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil mendapatkan detail galeri"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="judul", type="string", example="Kegiatan Pelatihan Tanggap Bencana"),
     *                 @OA\Property(property="deskripsi", type="string", example="Dokumentasi kegiatan pelatihan..."),
     *                 @OA\Property(property="tipe", type="string", example="gambar"),
     *                 @OA\Property(property="gambar", type="string", example="galeri/foto-kegiatan.jpg"),
     *                 @OA\Property(property="gambar_url", type="string", example="http://localhost:8000/storage/galeri/foto-kegiatan.jpg"),
     *                 @OA\Property(property="video_url", type="string", example=null),
     *                 @OA\Property(property="youtube_embed_url", type="string", example=null),
     *                 @OA\Property(property="youtube_video_id", type="string", example=null),
     *                 @OA\Property(property="is_active", type="boolean", example=true),
     *                 @OA\Property(property="created_at", type="string", example="2025-01-15 10:30:00"),
     *                 @OA\Property(property="updated_at", type="string", example="2025-01-15 10:30:00")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Galeri tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Galeri tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function show($id): JsonResponse
    {
        $galeri = Galeri::find($id);

        if (!$galeri) {
            return response()->json([
                'success' => false,
                'message' => 'Galeri tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan detail galeri',
            'data' => [
                'id' => $galeri->id,
                'judul' => $galeri->judul,
                'deskripsi' => $galeri->deskripsi,
                'tipe' => $galeri->tipe,
                'gambar' => $galeri->gambar,
                'gambar_url' => $galeri->gambar_url,
                'video_url' => $galeri->video_url,
                'youtube_embed_url' => $galeri->youtube_embed_url,
                'youtube_video_id' => $galeri->youtube_video_id,
                'is_active' => $galeri->is_active,
                'created_at' => $galeri->created_at->toDateTimeString(),
                'updated_at' => $galeri->updated_at->toDateTimeString(),
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/galeri",
     *     operationId="createGaleri",
     *     tags={"Galeri"},
     *     summary="Membuat galeri baru",
     *     description="Endpoint untuk membuat galeri baru. Requires authentication. Untuk tipe=gambar wajib upload file, untuk tipe=video wajib isi video_url",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"tipe"},
     *                 @OA\Property(property="judul", type="string", example="Kegiatan Pelatihan Tanggap Bencana", nullable=true),
     *                 @OA\Property(property="deskripsi", type="string", example="Dokumentasi kegiatan pelatihan...", nullable=true),
     *                 @OA\Property(property="tipe", type="string", enum={"gambar", "video"}, example="gambar"),
     *                 @OA\Property(property="gambar", type="string", format="binary", nullable=true, description="File gambar (wajib jika tipe=gambar)"),
     *                 @OA\Property(property="video_url", type="string", example="https://www.youtube.com/watch?v=xxxxx", nullable=true, description="URL YouTube (wajib jika tipe=video)"),
     *                 @OA\Property(property="is_active", type="boolean", example=true, nullable=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Galeri berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Galeri berhasil dibuat"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="judul", type="string", example="Kegiatan Pelatihan Tanggap Bencana"),
     *                 @OA\Property(property="tipe", type="string", example="gambar"),
     *                 @OA\Property(property="gambar_url", type="string", example="http://localhost:8000/storage/galeri/foto.jpg")
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
     *                 @OA\Property(property="tipe", type="array", @OA\Items(type="string", example="Tipe wajib diisi")),
     *                 @OA\Property(property="gambar", type="array", @OA\Items(type="string", example="Gambar wajib diisi untuk tipe gambar"))
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:gambar,video',
            'gambar' => 'required_if:tipe,gambar|nullable|image|mimes:jpeg,jpg,png|max:2048',
            'video_url' => 'required_if:tipe,video|nullable|url',
            'is_active' => 'nullable|boolean',
        ], [
            'gambar.required_if' => 'Gambar wajib diisi untuk tipe gambar',
            'video_url.required_if' => 'Video URL wajib diisi untuk tipe video',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [
            'judul' => $request->input('judul'),
            'deskripsi' => $request->input('deskripsi'),
            'tipe' => $request->input('tipe'),
            'is_active' => $request->input('is_active', true),
        ];

        // Handle gambar upload for tipe=gambar
        if ($request->input('tipe') === 'gambar' && $request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarPath = $gambar->store('galeri', 'public');
            $data['gambar'] = $gambarPath;
        }

        // Handle video_url for tipe=video
        if ($request->input('tipe') === 'video') {
            $data['video_url'] = $request->input('video_url');
        }

        $galeri = Galeri::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Galeri berhasil dibuat',
            'data' => [
                'id' => $galeri->id,
                'judul' => $galeri->judul,
                'deskripsi' => $galeri->deskripsi,
                'tipe' => $galeri->tipe,
                'gambar' => $galeri->gambar,
                'gambar_url' => $galeri->gambar_url,
                'video_url' => $galeri->video_url,
                'youtube_embed_url' => $galeri->youtube_embed_url,
                'youtube_video_id' => $galeri->youtube_video_id,
                'is_active' => $galeri->is_active,
                'created_at' => $galeri->created_at->toDateTimeString(),
                'updated_at' => $galeri->updated_at->toDateTimeString(),
            ]
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/galeri/{id}",
     *     operationId="updateGaleri",
     *     tags={"Galeri"},
     *     summary="Update galeri",
     *     description="Endpoint untuk update galeri berdasarkan ID. Requires authentication. Gunakan POST dengan _method=PUT untuk multipart/form-data",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID galeri",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="_method", type="string", example="PUT", description="Method spoofing untuk form-data"),
     *                 @OA\Property(property="judul", type="string", example="Kegiatan Update", nullable=true),
     *                 @OA\Property(property="deskripsi", type="string", example="Deskripsi update...", nullable=true),
     *                 @OA\Property(property="tipe", type="string", enum={"gambar", "video"}, example="gambar"),
     *                 @OA\Property(property="gambar", type="string", format="binary", nullable=true, description="File gambar baru (opsional)"),
     *                 @OA\Property(property="video_url", type="string", example="https://www.youtube.com/watch?v=xxxxx", nullable=true),
     *                 @OA\Property(property="is_active", type="boolean", example=false, nullable=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Galeri berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Galeri berhasil diupdate"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="judul", type="string", example="Kegiatan Update")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Galeri tidak ditemukan"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        $galeri = Galeri::find($id);

        if (!$galeri) {
            return response()->json([
                'success' => false,
                'message' => 'Galeri tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe' => 'sometimes|required|in:gambar,video',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'video_url' => 'nullable|url',
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

        if ($request->has('judul')) {
            $data['judul'] = $request->input('judul');
        }
        if ($request->has('deskripsi')) {
            $data['deskripsi'] = $request->input('deskripsi');
        }
        if ($request->has('tipe')) {
            $data['tipe'] = $request->input('tipe');
        }
        if ($request->has('is_active')) {
            $data['is_active'] = $request->input('is_active');
        }

        // Handle gambar upload
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($galeri->gambar && Storage::disk('public')->exists($galeri->gambar)) {
                Storage::disk('public')->delete($galeri->gambar);
            }

            $gambar = $request->file('gambar');
            $gambarPath = $gambar->store('galeri', 'public');
            $data['gambar'] = $gambarPath;
        }

        // Handle video_url
        if ($request->has('video_url')) {
            $data['video_url'] = $request->input('video_url');
        }

        $galeri->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Galeri berhasil diupdate',
            'data' => [
                'id' => $galeri->id,
                'judul' => $galeri->judul,
                'deskripsi' => $galeri->deskripsi,
                'tipe' => $galeri->tipe,
                'gambar' => $galeri->gambar,
                'gambar_url' => $galeri->gambar_url,
                'video_url' => $galeri->video_url,
                'youtube_embed_url' => $galeri->youtube_embed_url,
                'youtube_video_id' => $galeri->youtube_video_id,
                'is_active' => $galeri->is_active,
                'created_at' => $galeri->created_at->toDateTimeString(),
                'updated_at' => $galeri->updated_at->toDateTimeString(),
            ]
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/galeri/{id}",
     *     operationId="deleteGaleri",
     *     tags={"Galeri"},
     *     summary="Hapus galeri",
     *     description="Endpoint untuk menghapus galeri berdasarkan ID. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID galeri yang akan dihapus",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Galeri berhasil dihapus",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Galeri berhasil dihapus")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Galeri tidak ditemukan")
     * )
     */
    public function destroy($id): JsonResponse
    {
        $galeri = Galeri::find($id);

        if (!$galeri) {
            return response()->json([
                'success' => false,
                'message' => 'Galeri tidak ditemukan'
            ], 404);
        }

        // Hapus gambar jika ada
        if ($galeri->gambar && Storage::disk('public')->exists($galeri->gambar)) {
            Storage::disk('public')->delete($galeri->gambar);
        }

        $galeri->delete();

        return response()->json([
            'success' => true,
            'message' => 'Galeri berhasil dihapus'
        ]);
    }
}
