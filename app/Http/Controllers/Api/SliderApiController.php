<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Slider",
 *     description="Endpoint untuk manajemen slider beranda"
 * )
 */
class SliderApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/sliders",
     *     operationId="getSliders",
     *     tags={"Slider"},
     *     summary="Mendapatkan daftar slider aktif",
     *     description="Mengembalikan daftar slider yang aktif dan terurut berdasarkan urutan",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data slider",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil mendapatkan data slider"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="title", type="string", example="Siaga Bencana 24 Jam"),
     *                     @OA\Property(property="subtitle", type="string", example="BPBD Katingan siap melayani masyarakat"),
     *                     @OA\Property(property="image", type="string", example="http://localhost:8000/storage/sliders/slider1.jpg"),
     *                     @OA\Property(property="image_path", type="string", example="sliders/slider1.jpg"),
     *                     @OA\Property(property="link", type="string", example="https://example.com", nullable=true),
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
        $sliders = Slider::where('is_active', true)
            ->orderBy('sequence')
            ->get()
            ->map(function ($slider) {
                return [
                    'id' => $slider->id,
                    'title' => $slider->title,
                    'subtitle' => $slider->subtitle,
                    'image' => asset('storage/' . $slider->image),
                    'image_path' => $slider->image,
                    'link' => $slider->link,
                    'urutan' => $slider->sequence,
                    'is_active' => $slider->is_active,
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data slider',
            'data' => $sliders
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/sliders/{id}",
     *     operationId="getSliderById",
     *     tags={"Slider"},
     *     summary="Mendapatkan detail slider",
     *     description="Menampilkan detail slider berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID slider",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan detail slider",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil mendapatkan detail slider"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Siaga Bencana 24 Jam"),
     *                 @OA\Property(property="subtitle", type="string", example="BPBD Katingan siap melayani masyarakat"),
     *                 @OA\Property(property="image", type="string", example="http://localhost:8000/storage/sliders/slider1.jpg"),
     *                 @OA\Property(property="image_path", type="string", example="sliders/slider1.jpg"),
     *                 @OA\Property(property="link", type="string", example="https://example.com", nullable=true),
     *                 @OA\Property(property="urutan", type="integer", example=1),
     *                 @OA\Property(property="is_active", type="boolean", example=true),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Slider tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Slider tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function show($id): JsonResponse
    {
        $slider = Slider::find($id);

        if (!$slider) {
            return response()->json([
                'success' => false,
                'message' => 'Slider tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan detail slider',
            'data' => [
                'id' => $slider->id,
                'title' => $slider->title,
                'subtitle' => $slider->subtitle,
                'image' => asset('storage/' . $slider->image),
                'image_path' => $slider->image,
                'link' => $slider->link,
                'urutan' => $slider->sequence,
                'is_active' => $slider->is_active,
                'created_at' => $slider->created_at->toDateTimeString(),
                'updated_at' => $slider->updated_at->toDateTimeString(),
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/sliders",
     *     operationId="createSlider",
     *     tags={"Slider"},
     *     summary="Membuat slider baru",
     *     description="Endpoint untuk membuat slider baru. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"title", "image"},
     *                 @OA\Property(property="title", type="string", example="Slider Title"),
     *                 @OA\Property(property="subtitle", type="string", example="Slider subtitle", nullable=true),
     *                 @OA\Property(property="link", type="string", example="https://example.com", nullable=true),
     *                 @OA\Property(property="urutan", type="integer", example=1),
     *                 @OA\Property(property="is_active", type="boolean", example=true),
     *                 @OA\Property(property="image", type="string", format="binary", description="Upload gambar slider")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Slider berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Slider berhasil dibuat"),
     *             @OA\Property(property="data", type="object")
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
            'subtitle' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
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
            'subtitle' => $request->input('subtitle'),
            'link' => $request->input('link'),
            'sequence' => $request->input('urutan', 0),
            'is_active' => $request->input('is_active', true),
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('sliders', $filename, 'public');
            $data['image'] = $path;
        }

        $slider = Slider::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Slider berhasil dibuat',
            'data' => [
                'id' => $slider->id,
                'title' => $slider->title,
                'subtitle' => $slider->subtitle,
                'image' => asset('storage/' . $slider->image),
                'image_path' => $slider->image,
                'link' => $slider->link,
                'urutan' => $slider->sequence,
                'is_active' => $slider->is_active,
                'created_at' => $slider->created_at->toDateTimeString(),
                'updated_at' => $slider->updated_at->toDateTimeString(),
            ]
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/sliders/{id}",
     *     operationId="updateSlider",
     *     tags={"Slider"},
     *     summary="Update slider",
     *     description="Endpoint untuk update slider berdasarkan ID. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID slider",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Updated Title"),
     *             @OA\Property(property="subtitle", type="string", example="Updated subtitle"),
     *             @OA\Property(property="link", type="string", example="https://example.com"),
     *             @OA\Property(property="urutan", type="integer", example=2),
     *             @OA\Property(property="is_active", type="boolean", example=false)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Slider berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Slider berhasil diupdate"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Slider tidak ditemukan"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        $slider = Slider::find($id);

        if (!$slider) {
            return response()->json([
                'success' => false,
                'message' => 'Slider tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
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
        if ($request->has('subtitle')) {
            $data['subtitle'] = $request->input('subtitle');
        }
        if ($request->has('link')) {
            $data['link'] = $request->input('link');
        }
        if ($request->has('urutan')) {
            $data['sequence'] = $request->input('urutan');
        }
        if ($request->has('is_active')) {
            $data['is_active'] = $request->input('is_active');
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($slider->image && Storage::disk('public')->exists($slider->image)) {
                Storage::disk('public')->delete($slider->image);
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('sliders', $filename, 'public');
            $data['image'] = $path;
        }

        $slider->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Slider berhasil diupdate',
            'data' => [
                'id' => $slider->id,
                'title' => $slider->title,
                'subtitle' => $slider->subtitle,
                'image' => asset('storage/' . $slider->image),
                'image_path' => $slider->image,
                'link' => $slider->link,
                'urutan' => $slider->sequence,
                'is_active' => $slider->is_active,
                'created_at' => $slider->created_at->toDateTimeString(),
                'updated_at' => $slider->updated_at->toDateTimeString(),
            ]
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/sliders/{id}",
     *     operationId="deleteSlider",
     *     tags={"Slider"},
     *     summary="Hapus slider",
     *     description="Endpoint untuk menghapus slider berdasarkan ID. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID slider yang akan dihapus",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Slider berhasil dihapus",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Slider berhasil dihapus")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Slider tidak ditemukan")
     * )
     */
    public function destroy($id): JsonResponse
    {
        $slider = Slider::find($id);

        if (!$slider) {
            return response()->json([
                'success' => false,
                'message' => 'Slider tidak ditemukan'
            ], 404);
        }

        // Delete image if exists
        if ($slider->image && Storage::disk('public')->exists($slider->image)) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return response()->json([
            'success' => true,
            'message' => 'Slider berhasil dihapus'
        ]);
    }
}




