<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AgendaApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/agenda",
     *     operationId="getAgenda",
     *     tags={"Agenda"},
     *     summary="Mendapatkan daftar agenda",
     *     description="Mengembalikan daftar semua agenda yang aktif, diurutkan berdasarkan tanggal mulai. Gunakan parameter status untuk filter berdasarkan status agenda.",
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filter berdasarkan status (akan_datang, sedang_berlangsung, selesai)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"akan_datang", "sedang_berlangsung", "selesai"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data agenda",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil mendapatkan data agenda"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="title", type="string", example="Rapat Koordinasi Kesiapsiagaan Bencana"),
     *                     @OA\Property(property="description", type="string", example="Rapat koordinasi dengan stakeholder terkait kesiapsiagaan menghadapi bencana"),
     *                     @OA\Property(property="location", type="string", example="Kantor BPBD Katingan"),
     *                     @OA\Property(property="start_date", type="string", example="2025-01-20"),
     *                     @OA\Property(property="end_date", type="string", example="2025-01-20", nullable=true),
     *                     @OA\Property(property="start_time", type="string", example="09:00:00"),
     *                     @OA\Property(property="end_time", type="string", example="12:00:00", nullable=true),
     *                     @OA\Property(property="formatted_date", type="string", example="20"),
     *                     @OA\Property(property="formatted_month", type="string", example="Jan"),
     *                     @OA\Property(property="formatted_time_range", type="string", example="09:00 WIB - 12:00 WIB"),
     *                     @OA\Property(property="status", type="string", example="akan_datang"),
     *                     @OA\Property(property="status_label", type="string", example="Akan Datang"),
     *                     @OA\Property(property="sequence", type="integer", example=1),
     *                     @OA\Property(property="is_active", type="boolean", example=true)
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        // Ambil semua agenda yang aktif (tidak perlu filter upcoming/ongoing)
        $query = Agenda::where('is_active', true);

        $agenda = $query->orderBy('start_date')
            ->orderBy('start_time')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'description' => $item->description,
                    'location' => $item->location,
                    'start_date' => $item->start_date->format('Y-m-d'),
                    'end_date' => $item->end_date ? $item->end_date->format('Y-m-d') : null,
                    'start_time' => $item->start_time,
                    'end_time' => $item->end_time,
                    'formatted_date' => $item->formatted_date,
                    'formatted_month' => $item->formatted_month,
                    'formatted_time_range' => $item->formatted_time_range,
                    'status' => $item->status,
                    'status_label' => $item->status_label,
                    'sequence' => $item->sequence,
                    'is_active' => $item->is_active,
                ];
            });

        // Filter berdasarkan status jika ada
        if ($request->filled('status')) {
            $status = $request->input('status');
            $agenda = $agenda->filter(function ($item) use ($status) {
                return $item['status'] === $status;
            })->values();
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data agenda',
            'data' => $agenda
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/agenda/{id}",
     *     operationId="getAgendaById",
     *     tags={"Agenda"},
     *     summary="Mendapatkan detail agenda",
     *     description="Menampilkan detail agenda berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID agenda",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan detail agenda",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil mendapatkan detail agenda"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Rapat Koordinasi Kesiapsiagaan Bencana"),
     *                 @OA\Property(property="description", type="string", example="Rapat koordinasi dengan stakeholder terkait kesiapsiagaan menghadapi bencana"),
     *                 @OA\Property(property="location", type="string", example="Kantor BPBD Katingan"),
     *                 @OA\Property(property="start_date", type="string", example="2025-01-20"),
     *                 @OA\Property(property="end_date", type="string", example="2025-01-20", nullable=true),
     *                 @OA\Property(property="start_time", type="string", example="09:00:00"),
     *                 @OA\Property(property="end_time", type="string", example="12:00:00", nullable=true),
     *                 @OA\Property(property="formatted_date", type="string", example="20"),
     *                 @OA\Property(property="formatted_month", type="string", example="Jan"),
     *                 @OA\Property(property="formatted_time_range", type="string", example="09:00 WIB - 12:00 WIB"),
     *                 @OA\Property(property="status", type="string", example="akan_datang"),
     *                 @OA\Property(property="status_label", type="string", example="Akan Datang"),
     *                 @OA\Property(property="sequence", type="integer", example=1),
     *                 @OA\Property(property="is_active", type="boolean", example=true),
     *                 @OA\Property(property="created_at", type="string", example="2025-01-15 10:30:00"),
     *                 @OA\Property(property="updated_at", type="string", example="2025-01-15 10:30:00")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Agenda tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Agenda tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function show($id): JsonResponse
    {
        $agenda = Agenda::find($id);

        if (!$agenda) {
            return response()->json([
                'success' => false,
                'message' => 'Agenda tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan detail agenda',
            'data' => [
                'id' => $agenda->id,
                'title' => $agenda->title,
                'description' => $agenda->description,
                'location' => $agenda->location,
                'start_date' => $agenda->start_date->format('Y-m-d'),
                'end_date' => $agenda->end_date ? $agenda->end_date->format('Y-m-d') : null,
                'start_time' => $agenda->start_time,
                'end_time' => $agenda->end_time,
                'formatted_date' => $agenda->formatted_date,
                'formatted_month' => $agenda->formatted_month,
                'formatted_time_range' => $agenda->formatted_time_range,
                'status' => $agenda->status,
                'status_label' => $agenda->status_label,
                'sequence' => $agenda->sequence,
                'is_active' => $agenda->is_active,
                'created_at' => $agenda->created_at->toDateTimeString(),
                'updated_at' => $agenda->updated_at->toDateTimeString(),
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/agenda",
     *     operationId="createAgenda",
     *     tags={"Agenda"},
     *     summary="Membuat agenda baru",
     *     description="Endpoint untuk membuat agenda baru. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "description", "location", "start_date", "start_time"},
     *             @OA\Property(property="title", type="string", example="Rapat Koordinasi Kesiapsiagaan Bencana"),
     *             @OA\Property(property="description", type="string", example="Rapat koordinasi dengan stakeholder terkait kesiapsiagaan menghadapi bencana"),
     *             @OA\Property(property="location", type="string", example="Kantor BPBD Katingan"),
     *             @OA\Property(property="start_date", type="string", format="date", example="2025-01-20"),
     *             @OA\Property(property="end_date", type="string", format="date", example="2025-01-20", nullable=true),
     *             @OA\Property(property="start_time", type="string", example="09:00"),
     *             @OA\Property(property="end_time", type="string", example="12:00", nullable=true),
     *             @OA\Property(property="sequence", type="integer", example=1, nullable=true),
     *             @OA\Property(property="is_active", type="boolean", example=true, nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Agenda berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Agenda berhasil dibuat"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Rapat Koordinasi Kesiapsiagaan Bencana"),
     *                 @OA\Property(property="description", type="string", example="Rapat koordinasi dengan stakeholder terkait kesiapsiagaan menghadapi bencana"),
     *                 @OA\Property(property="location", type="string", example="Kantor BPBD Katingan"),
     *                 @OA\Property(property="start_date", type="string", example="2025-01-20"),
     *                 @OA\Property(property="end_date", type="string", example="2025-01-20"),
     *                 @OA\Property(property="start_time", type="string", example="09:00:00"),
     *                 @OA\Property(property="end_time", type="string", example="12:00:00"),
     *                 @OA\Property(property="formatted_date", type="string", example="20"),
     *                 @OA\Property(property="formatted_month", type="string", example="Jan"),
     *                 @OA\Property(property="formatted_time_range", type="string", example="09:00 WIB - 12:00 WIB"),
     *                 @OA\Property(property="status", type="string", example="akan_datang"),
     *                 @OA\Property(property="status_label", type="string", example="Akan Datang"),
     *                 @OA\Property(property="sequence", type="integer", example=1),
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
     *                 @OA\Property(property="title", type="array", @OA\Items(type="string", example="Judul wajib diisi")),
     *                 @OA\Property(property="start_date", type="array", @OA\Items(type="string", example="Tanggal mulai wajib diisi"))
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
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
            'location' => $request->input('location'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'sequence' => $request->input('sequence', 0),
            'is_active' => $request->input('is_active', true),
        ];

        $agenda = Agenda::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Agenda berhasil dibuat',
            'data' => [
                'id' => $agenda->id,
                'title' => $agenda->title,
                'description' => $agenda->description,
                'location' => $agenda->location,
                'start_date' => $agenda->start_date->format('Y-m-d'),
                'end_date' => $agenda->end_date ? $agenda->end_date->format('Y-m-d') : null,
                'start_time' => $agenda->start_time,
                'end_time' => $agenda->end_time,
                'formatted_date' => $agenda->formatted_date,
                'formatted_month' => $agenda->formatted_month,
                'formatted_time_range' => $agenda->formatted_time_range,
                'status' => $agenda->status,
                'status_label' => $agenda->status_label,
                'sequence' => $agenda->sequence,
                'is_active' => $agenda->is_active,
                'created_at' => $agenda->created_at->toDateTimeString(),
                'updated_at' => $agenda->updated_at->toDateTimeString(),
            ]
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/agenda/{id}",
     *     operationId="updateAgenda",
     *     tags={"Agenda"},
     *     summary="Update agenda",
     *     description="Endpoint untuk update agenda berdasarkan ID. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID agenda",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Rapat Update"),
     *             @OA\Property(property="description", type="string", example="Deskripsi update"),
     *             @OA\Property(property="location", type="string", example="Lokasi baru"),
     *             @OA\Property(property="start_date", type="string", format="date", example="2025-01-25"),
     *             @OA\Property(property="end_date", type="string", format="date", example="2025-01-25"),
     *             @OA\Property(property="start_time", type="string", format="time", example="10:00"),
     *             @OA\Property(property="end_time", type="string", format="time", example="13:00"),
     *             @OA\Property(property="sequence", type="integer", example=2),
     *             @OA\Property(property="is_active", type="boolean", example=false)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Agenda berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Agenda berhasil diupdate"),
     *             @OA\Property(property="data", ref="#/components/schemas/Agenda")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Agenda tidak ditemukan"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        $agenda = Agenda::find($id);

        if (!$agenda) {
            return response()->json([
                'success' => false,
                'message' => 'Agenda tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'location' => 'sometimes|required|string|max:255',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'sometimes|required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
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
        if ($request->has('location')) {
            $data['location'] = $request->input('location');
        }
        if ($request->has('start_date')) {
            $data['start_date'] = $request->input('start_date');
        }
        if ($request->has('end_date')) {
            $data['end_date'] = $request->input('end_date');
        }
        if ($request->has('start_time')) {
            $data['start_time'] = $request->input('start_time');
        }
        if ($request->has('end_time')) {
            $data['end_time'] = $request->input('end_time');
        }
        if ($request->has('sequence')) {
            $data['sequence'] = $request->input('sequence');
        }
        if ($request->has('is_active')) {
            $data['is_active'] = $request->input('is_active');
        }

        $agenda->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Agenda berhasil diupdate',
            'data' => [
                'id' => $agenda->id,
                'title' => $agenda->title,
                'description' => $agenda->description,
                'location' => $agenda->location,
                'start_date' => $agenda->start_date->format('Y-m-d'),
                'end_date' => $agenda->end_date ? $agenda->end_date->format('Y-m-d') : null,
                'start_time' => $agenda->start_time,
                'end_time' => $agenda->end_time,
                'formatted_date' => $agenda->formatted_date,
                'formatted_month' => $agenda->formatted_month,
                'formatted_time_range' => $agenda->formatted_time_range,
                'status' => $agenda->status,
                'status_label' => $agenda->status_label,
                'sequence' => $agenda->sequence,
                'is_active' => $agenda->is_active,
                'created_at' => $agenda->created_at->toDateTimeString(),
                'updated_at' => $agenda->updated_at->toDateTimeString(),
            ]
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/agenda/{id}",
     *     operationId="deleteAgenda",
     *     tags={"Agenda"},
     *     summary="Hapus agenda",
     *     description="Endpoint untuk menghapus agenda berdasarkan ID. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID agenda yang akan dihapus",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Agenda berhasil dihapus",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Agenda berhasil dihapus")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Agenda tidak ditemukan")
     * )
     */
    public function destroy($id): JsonResponse
    {
        $agenda = Agenda::find($id);

        if (!$agenda) {
            return response()->json([
                'success' => false,
                'message' => 'Agenda tidak ditemukan'
            ], 404);
        }

        $agenda->delete();

        return response()->json([
            'success' => true,
            'message' => 'Agenda berhasil dihapus'
        ]);
    }
}
