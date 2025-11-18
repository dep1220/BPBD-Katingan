<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pesan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PesanApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/pesan",
     *     operationId="getPesan",
     *     tags={"Pesan Kontak"},
     *     summary="Mendapatkan daftar pesan kontak",
     *     description="Mengembalikan daftar semua pesan kontak. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="is_read",
     *         in="query",
     *         description="Filter berdasarkan status baca (0=belum dibaca, 1=sudah dibaca)",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="category",
     *         in="query",
     *         description="Filter berdasarkan kategori",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data pesan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil mendapatkan data pesan"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="John Doe"),
     *                     @OA\Property(property="email", type="string", example="john@example.com"),
     *                     @OA\Property(property="phone", type="string", example="08123456789"),
     *                     @OA\Property(property="category", type="string", example="Pertanyaan"),
     *                     @OA\Property(property="subject", type="string", example="Informasi Kesiapsiagaan Bencana"),
     *                     @OA\Property(property="message", type="string", example="Saya ingin menanyakan tentang..."),
     *                     @OA\Property(property="is_read", type="boolean", example=false),
     *                     @OA\Property(property="created_at", type="string", example="2025-01-15 10:30:00")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $query = Pesan::query();

        // Filter by is_read if provided
        if ($request->has('is_read')) {
            $isRead = filter_var($request->input('is_read'), FILTER_VALIDATE_BOOLEAN);
            $query->where('is_read', $isRead);
        }

        // Filter by category if provided
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $pesan = $query->latest()->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'email' => $item->email,
                'phone' => $item->phone,
                'category' => $item->category,
                'subject' => $item->subject,
                'message' => $item->message,
                'is_read' => $item->is_read,
                'created_at' => $item->created_at->toDateTimeString(),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data pesan',
            'data' => $pesan
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/pesan/{id}",
     *     operationId="getPesanById",
     *     tags={"Pesan Kontak"},
     *     summary="Mendapatkan detail pesan",
     *     description="Menampilkan detail pesan berdasarkan ID. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID pesan",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan detail pesan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil mendapatkan detail pesan"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="john@example.com"),
     *                 @OA\Property(property="phone", type="string", example="08123456789"),
     *                 @OA\Property(property="category", type="string", example="Pertanyaan"),
     *                 @OA\Property(property="subject", type="string", example="Informasi Kesiapsiagaan Bencana"),
     *                 @OA\Property(property="message", type="string", example="Saya ingin menanyakan tentang..."),
     *                 @OA\Property(property="is_read", type="boolean", example=false),
     *                 @OA\Property(property="created_at", type="string", example="2025-01-15 10:30:00"),
     *                 @OA\Property(property="updated_at", type="string", example="2025-01-15 10:30:00")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=404,
     *         description="Pesan tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Pesan tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function show($id): JsonResponse
    {
        $pesan = Pesan::find($id);

        if (!$pesan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan detail pesan',
            'data' => [
                'id' => $pesan->id,
                'name' => $pesan->name,
                'email' => $pesan->email,
                'phone' => $pesan->phone,
                'category' => $pesan->category,
                'subject' => $pesan->subject,
                'message' => $pesan->message,
                'is_read' => $pesan->is_read,
                'created_at' => $pesan->created_at->toDateTimeString(),
                'updated_at' => $pesan->updated_at->toDateTimeString(),
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/pesan",
     *     operationId="createPesan",
     *     tags={"Pesan Kontak"},
     *     summary="Mengirim pesan kontak",
     *     description="Endpoint untuk mengirim pesan/kontak dari pengunjung. No authentication required.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "category", "subject", "message"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="phone", type="string", example="08123456789", nullable=true),
     *             @OA\Property(property="category", type="string", example="Pertanyaan"),
     *             @OA\Property(property="subject", type="string", example="Informasi Kesiapsiagaan Bencana"),
     *             @OA\Property(property="message", type="string", example="Saya ingin menanyakan tentang...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pesan berhasil dikirim",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Pesan berhasil dikirim"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="john@example.com"),
     *                 @OA\Property(property="subject", type="string", example="Informasi Kesiapsiagaan Bencana"),
     *                 @OA\Property(property="created_at", type="string", example="2025-01-15 10:30:00")
     *             )
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
     *                 @OA\Property(property="name", type="array", @OA\Items(type="string", example="Nama wajib diisi")),
     *                 @OA\Property(property="email", type="array", @OA\Items(type="string", example="Email wajib diisi"))
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'category' => $request->input('category'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'is_read' => false,
        ];

        $pesan = Pesan::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dikirim',
            'data' => [
                'id' => $pesan->id,
                'name' => $pesan->name,
                'email' => $pesan->email,
                'phone' => $pesan->phone,
                'category' => $pesan->category,
                'subject' => $pesan->subject,
                'message' => $pesan->message,
                'is_read' => $pesan->is_read,
                'created_at' => $pesan->created_at->toDateTimeString(),
            ]
        ], 201);
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/pesan/{id}/mark-as-read",
     *     operationId="markPesanAsRead",
     *     tags={"Pesan Kontak"},
     *     summary="Tandai pesan sebagai sudah dibaca",
     *     description="Endpoint untuk menandai pesan sebagai sudah dibaca. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID pesan",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pesan berhasil ditandai sebagai sudah dibaca",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Pesan berhasil ditandai sebagai sudah dibaca"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="is_read", type="boolean", example=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Pesan tidak ditemukan")
     * )
     */
    public function markAsRead($id): JsonResponse
    {
        $pesan = Pesan::find($id);

        if (!$pesan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesan tidak ditemukan'
            ], 404);
        }

        $pesan->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil ditandai sebagai sudah dibaca',
            'data' => [
                'id' => $pesan->id,
                'is_read' => $pesan->is_read,
                'updated_at' => $pesan->updated_at->toDateTimeString(),
            ]
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/pesan/{id}",
     *     operationId="deletePesan",
     *     tags={"Pesan Kontak"},
     *     summary="Hapus pesan",
     *     description="Endpoint untuk menghapus pesan berdasarkan ID. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID pesan yang akan dihapus",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pesan berhasil dihapus",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Pesan berhasil dihapus")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Pesan tidak ditemukan")
     * )
     */
    public function destroy($id): JsonResponse
    {
        $pesan = Pesan::find($id);

        if (!$pesan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesan tidak ditemukan'
            ], 404);
        }

        $pesan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dihapus'
        ]);
    }
}
