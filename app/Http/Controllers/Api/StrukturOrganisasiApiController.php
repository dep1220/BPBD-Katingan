<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StrukturOrganisasiApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/struktur-organisasi",
     *     operationId="getStrukturOrganisasi",
     *     tags={"Struktur Organisasi"},
     *     summary="Mendapatkan daftar struktur organisasi",
     *     description="Mengembalikan daftar struktur organisasi yang aktif, diurutkan berdasarkan ketua dan urutan",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data struktur organisasi",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil mendapatkan data struktur organisasi"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="nama", type="string", example="Dr. Ahmad Budiman, M.Si"),
     *                     @OA\Property(property="nip", type="string", example="196501011990031001"),
     *                     @OA\Property(property="jabatan", type="string", example="Kepala Pelaksana BPBD"),
     *                     @OA\Property(property="is_ketua", type="boolean", example=true),
     *                     @OA\Property(property="foto", type="string", example="struktur/foto-kepala.jpg"),
     *                     @OA\Property(property="foto_url", type="string", example="http://localhost:8000/storage/struktur/foto-kepala.jpg"),
     *                     @OA\Property(property="sambutan_kepala", type="string", example="Selamat datang di website BPBD Katingan..."),
     *                     @OA\Property(property="sambutan_judul", type="string", example="Sambutan Kepala BPBD"),
     *                     @OA\Property(property="urutan", type="integer", example=1),
     *                     @OA\Property(property="is_active", type="boolean", example=true)
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $strukturOrganisasi = StrukturOrganisasi::where('is_active', true)
            ->ordered()
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama' => $item->nama,
                    'nip' => $item->nip,
                    'jabatan' => $item->jabatan,
                    'is_ketua' => $item->is_ketua,
                    'foto' => $item->foto,
                    'foto_url' => $item->foto_url,
                    'sambutan_kepala' => $item->sambutan_kepala,
                    'sambutan_judul' => $item->sambutan_judul,
                    'urutan' => $item->urutan,
                    'is_active' => $item->is_active,
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data struktur organisasi',
            'data' => $strukturOrganisasi
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/struktur-organisasi/{id}",
     *     operationId="getStrukturOrganisasiById",
     *     tags={"Struktur Organisasi"},
     *     summary="Mendapatkan detail struktur organisasi",
     *     description="Menampilkan detail struktur organisasi berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID struktur organisasi",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan detail struktur organisasi",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil mendapatkan detail struktur organisasi"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nama", type="string", example="Dr. Ahmad Budiman, M.Si"),
     *                 @OA\Property(property="nip", type="string", example="196501011990031001"),
     *                 @OA\Property(property="jabatan", type="string", example="Kepala Pelaksana BPBD"),
     *                 @OA\Property(property="is_ketua", type="boolean", example=true),
     *                 @OA\Property(property="foto", type="string", example="struktur/foto-kepala.jpg"),
     *                 @OA\Property(property="foto_url", type="string", example="http://localhost:8000/storage/struktur/foto-kepala.jpg"),
     *                 @OA\Property(property="sambutan_kepala", type="string", example="Selamat datang di website BPBD Katingan..."),
     *                 @OA\Property(property="sambutan_judul", type="string", example="Sambutan Kepala BPBD"),
     *                 @OA\Property(property="urutan", type="integer", example=1),
     *                 @OA\Property(property="is_active", type="boolean", example=true),
     *                 @OA\Property(property="created_at", type="string", example="2025-01-15 10:30:00"),
     *                 @OA\Property(property="updated_at", type="string", example="2025-01-15 10:30:00")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Struktur organisasi tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Struktur organisasi tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function show($id): JsonResponse
    {
        $strukturOrganisasi = StrukturOrganisasi::find($id);

        if (!$strukturOrganisasi) {
            return response()->json([
                'success' => false,
                'message' => 'Struktur organisasi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan detail struktur organisasi',
            'data' => [
                'id' => $strukturOrganisasi->id,
                'nama' => $strukturOrganisasi->nama,
                'nip' => $strukturOrganisasi->nip,
                'jabatan' => $strukturOrganisasi->jabatan,
                'is_ketua' => $strukturOrganisasi->is_ketua,
                'foto' => $strukturOrganisasi->foto,
                'foto_url' => $strukturOrganisasi->foto_url,
                'sambutan_kepala' => $strukturOrganisasi->sambutan_kepala,
                'sambutan_judul' => $strukturOrganisasi->sambutan_judul,
                'urutan' => $strukturOrganisasi->urutan,
                'is_active' => $strukturOrganisasi->is_active,
                'created_at' => $strukturOrganisasi->created_at->toDateTimeString(),
                'updated_at' => $strukturOrganisasi->updated_at->toDateTimeString(),
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/struktur-organisasi",
     *     operationId="createStrukturOrganisasi",
     *     tags={"Struktur Organisasi"},
     *     summary="Membuat struktur organisasi baru",
     *     description="Endpoint untuk membuat struktur organisasi baru. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"nama", "jabatan"},
     *                 @OA\Property(property="nama", type="string", example="Dr. Ahmad Budiman, M.Si"),
     *                 @OA\Property(property="nip", type="string", example="196501011990031001", nullable=true),
     *                 @OA\Property(property="jabatan", type="string", example="Kepala Pelaksana BPBD"),
     *                 @OA\Property(property="is_ketua", type="boolean", example=true, nullable=true),
     *                 @OA\Property(property="foto", type="string", format="binary", nullable=true, description="File foto (max: 2MB, format: jpg,jpeg,png)"),
     *                 @OA\Property(property="sambutan_kepala", type="string", example="Selamat datang di website BPBD Katingan...", nullable=true),
     *                 @OA\Property(property="sambutan_judul", type="string", example="Sambutan Kepala BPBD", nullable=true),
     *                 @OA\Property(property="urutan", type="integer", example=1, nullable=true),
     *                 @OA\Property(property="is_active", type="boolean", example=true, nullable=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Struktur organisasi berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Struktur organisasi berhasil dibuat"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nama", type="string", example="Dr. Ahmad Budiman, M.Si"),
     *                 @OA\Property(property="nip", type="string", example="196501011990031001"),
     *                 @OA\Property(property="jabatan", type="string", example="Kepala Pelaksana BPBD"),
     *                 @OA\Property(property="is_ketua", type="boolean", example=true),
     *                 @OA\Property(property="foto", type="string", example="struktur/foto-kepala.jpg"),
     *                 @OA\Property(property="foto_url", type="string", example="http://localhost:8000/storage/struktur/foto-kepala.jpg"),
     *                 @OA\Property(property="sambutan_kepala", type="string", example="Selamat datang di website BPBD Katingan..."),
     *                 @OA\Property(property="sambutan_judul", type="string", example="Sambutan Kepala BPBD"),
     *                 @OA\Property(property="urutan", type="integer", example=1),
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
     *                 @OA\Property(property="nama", type="array", @OA\Items(type="string", example="Nama wajib diisi")),
     *                 @OA\Property(property="jabatan", type="array", @OA\Items(type="string", example="Jabatan wajib diisi"))
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255',
            'jabatan' => 'required|string|max:255',
            'is_ketua' => 'nullable|boolean',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'sambutan_kepala' => 'nullable|string',
            'sambutan_judul' => 'nullable|string|max:255',
            'urutan' => 'nullable|integer|min:0',
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
            'nama' => $request->input('nama'),
            'nip' => $request->input('nip'),
            'jabatan' => $request->input('jabatan'),
            'is_ketua' => $request->input('is_ketua', false),
            'sambutan_kepala' => $request->input('sambutan_kepala'),
            'sambutan_judul' => $request->input('sambutan_judul'),
            'urutan' => $request->input('urutan', 0),
            'is_active' => $request->input('is_active', true),
        ];

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoPath = $foto->store('struktur', 'public');
            $data['foto'] = $fotoPath;
        }

        $strukturOrganisasi = StrukturOrganisasi::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Struktur organisasi berhasil dibuat',
            'data' => [
                'id' => $strukturOrganisasi->id,
                'nama' => $strukturOrganisasi->nama,
                'nip' => $strukturOrganisasi->nip,
                'jabatan' => $strukturOrganisasi->jabatan,
                'is_ketua' => $strukturOrganisasi->is_ketua,
                'foto' => $strukturOrganisasi->foto,
                'foto_url' => $strukturOrganisasi->foto_url,
                'sambutan_kepala' => $strukturOrganisasi->sambutan_kepala,
                'sambutan_judul' => $strukturOrganisasi->sambutan_judul,
                'urutan' => $strukturOrganisasi->urutan,
                'is_active' => $strukturOrganisasi->is_active,
                'created_at' => $strukturOrganisasi->created_at->toDateTimeString(),
                'updated_at' => $strukturOrganisasi->updated_at->toDateTimeString(),
            ]
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/struktur-organisasi/{id}",
     *     operationId="updateStrukturOrganisasi",
     *     tags={"Struktur Organisasi"},
     *     summary="Update struktur organisasi",
     *     description="Endpoint untuk update struktur organisasi berdasarkan ID. Requires authentication. Gunakan POST dengan _method=PUT untuk multipart/form-data",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID struktur organisasi",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="_method", type="string", example="PUT", description="Method spoofing untuk form-data"),
     *                 @OA\Property(property="nama", type="string", example="Dr. Ahmad Budiman Update, M.Si"),
     *                 @OA\Property(property="nip", type="string", example="196501011990031001"),
     *                 @OA\Property(property="jabatan", type="string", example="Kepala Pelaksana BPBD Update"),
     *                 @OA\Property(property="is_ketua", type="boolean", example=true),
     *                 @OA\Property(property="foto", type="string", format="binary", nullable=true, description="File foto baru (opsional, max: 2MB)"),
     *                 @OA\Property(property="sambutan_kepala", type="string", example="Sambutan update..."),
     *                 @OA\Property(property="sambutan_judul", type="string", example="Sambutan Update"),
     *                 @OA\Property(property="urutan", type="integer", example=2),
     *                 @OA\Property(property="is_active", type="boolean", example=false)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Struktur organisasi berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Struktur organisasi berhasil diupdate"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nama", type="string", example="Dr. Ahmad Budiman Update, M.Si"),
     *                 @OA\Property(property="jabatan", type="string", example="Kepala Pelaksana BPBD Update"),
     *                 @OA\Property(property="foto_url", type="string", example="http://localhost:8000/storage/struktur/foto-new.jpg")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Struktur organisasi tidak ditemukan"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        $strukturOrganisasi = StrukturOrganisasi::find($id);

        if (!$strukturOrganisasi) {
            return response()->json([
                'success' => false,
                'message' => 'Struktur organisasi tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'sometimes|required|string|max:255',
            'nip' => 'nullable|string|max:255',
            'jabatan' => 'sometimes|required|string|max:255',
            'is_ketua' => 'nullable|boolean',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'sambutan_kepala' => 'nullable|string',
            'sambutan_judul' => 'nullable|string|max:255',
            'urutan' => 'nullable|integer|min:0',
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

        if ($request->has('nama')) {
            $data['nama'] = $request->input('nama');
        }
        if ($request->has('nip')) {
            $data['nip'] = $request->input('nip');
        }
        if ($request->has('jabatan')) {
            $data['jabatan'] = $request->input('jabatan');
        }
        if ($request->has('is_ketua')) {
            $data['is_ketua'] = $request->input('is_ketua');
        }
        if ($request->has('sambutan_kepala')) {
            $data['sambutan_kepala'] = $request->input('sambutan_kepala');
        }
        if ($request->has('sambutan_judul')) {
            $data['sambutan_judul'] = $request->input('sambutan_judul');
        }
        if ($request->has('urutan')) {
            $data['urutan'] = $request->input('urutan');
        }
        if ($request->has('is_active')) {
            $data['is_active'] = $request->input('is_active');
        }

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($strukturOrganisasi->foto && Storage::disk('public')->exists($strukturOrganisasi->foto)) {
                Storage::disk('public')->delete($strukturOrganisasi->foto);
            }

            $foto = $request->file('foto');
            $fotoPath = $foto->store('struktur', 'public');
            $data['foto'] = $fotoPath;
        }

        $strukturOrganisasi->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Struktur organisasi berhasil diupdate',
            'data' => [
                'id' => $strukturOrganisasi->id,
                'nama' => $strukturOrganisasi->nama,
                'nip' => $strukturOrganisasi->nip,
                'jabatan' => $strukturOrganisasi->jabatan,
                'is_ketua' => $strukturOrganisasi->is_ketua,
                'foto' => $strukturOrganisasi->foto,
                'foto_url' => $strukturOrganisasi->foto_url,
                'sambutan_kepala' => $strukturOrganisasi->sambutan_kepala,
                'sambutan_judul' => $strukturOrganisasi->sambutan_judul,
                'urutan' => $strukturOrganisasi->urutan,
                'is_active' => $strukturOrganisasi->is_active,
                'created_at' => $strukturOrganisasi->created_at->toDateTimeString(),
                'updated_at' => $strukturOrganisasi->updated_at->toDateTimeString(),
            ]
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/struktur-organisasi/{id}",
     *     operationId="deleteStrukturOrganisasi",
     *     tags={"Struktur Organisasi"},
     *     summary="Hapus struktur organisasi",
     *     description="Endpoint untuk menghapus struktur organisasi berdasarkan ID. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID struktur organisasi yang akan dihapus",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Struktur organisasi berhasil dihapus",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Struktur organisasi berhasil dihapus")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Struktur organisasi tidak ditemukan")
     * )
     */
    public function destroy($id): JsonResponse
    {
        $strukturOrganisasi = StrukturOrganisasi::find($id);

        if (!$strukturOrganisasi) {
            return response()->json([
                'success' => false,
                'message' => 'Struktur organisasi tidak ditemukan'
            ], 404);
        }

        // Hapus foto jika ada
        if ($strukturOrganisasi->foto && Storage::disk('public')->exists($strukturOrganisasi->foto)) {
            Storage::disk('public')->delete($strukturOrganisasi->foto);
        }

        $strukturOrganisasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Struktur organisasi berhasil dihapus'
        ]);
    }
}
