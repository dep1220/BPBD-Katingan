<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use App\Enums\KategoriBerita;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BeritaApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/berita/kategori",
     *     tags={"Berita"},
     *     summary="Mendapatkan daftar kategori berita",
     *     description="Menampilkan kategori berita yang ada di berita yang sudah dipublikasikan",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan daftar kategori",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil mendapatkan daftar kategori"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="value", type="string", example="peringatan_dini"),
     *                     @OA\Property(property="label", type="string", example="Peringatan Dini"),
     *                     @OA\Property(property="icon", type="string", example="⚠️"),
     *                     @OA\Property(property="count", type="integer", example=5)
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function kategori()
    {
        // Ambil kategori yang ada di berita published (distinct)
        $usedKategoris = Berita::published()
            ->whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori')
            ->filter()
            ->map(fn($k) => $k->value)
            ->toArray();

        $kategoris = [];
        
        foreach (KategoriBerita::cases() as $kategori) {
            // Hanya tampilkan kategori yang ada di berita published
            if (in_array($kategori->value, $usedKategoris)) {
                // Hitung jumlah berita per kategori
                $count = Berita::published()
                    ->where('kategori', $kategori)
                    ->count();

                $kategoris[] = [
                    'value' => $kategori->value,
                    'label' => $kategori->label(),
                    'icon' => $kategori->icon(),
                    'count' => $count,
                ];
            }
        }

        // Tambahkan kategori untuk berita tanpa kategori jika ada
        $uncategorizedCount = Berita::published()
            ->whereNull('kategori')
            ->count();

        if ($uncategorizedCount > 0) {
            $kategoris[] = [
                'value' => null,
                'label' => 'Tanpa Kategori',
                'icon' => '📰',
                'count' => $uncategorizedCount,
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan daftar kategori',
            'data' => $kategoris
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/berita",
     *     tags={"Berita"},
     *     summary="Mendapatkan daftar berita",
     *     description="Menampilkan daftar berita yang telah dipublikasikan dengan pagination",
     *     @OA\Parameter(
     *         name="kategori",
     *         in="query",
     *         description="Filter berdasarkan kategori berita",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Pencarian berdasarkan judul atau konten",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data berita",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil mendapatkan data berita"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="items",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="judul", type="string", example="Pelatihan Kesiapsiagaan Bencana"),
     *                         @OA\Property(property="slug", type="string", example="pelatihan-kesiapsiagaan-bencana"),
     *                         @OA\Property(property="konten", type="string", example="Konten berita lengkap..."),
     *                         @OA\Property(property="excerpt", type="string", example="Ringkasan berita..."),
     *                         @OA\Property(property="gambar", type="string", example="http://localhost/storage/berita/image.jpg"),
     *                         @OA\Property(property="gambar_path", type="string", example="berita/image.jpg"),
     *                         @OA\Property(property="kategori", type="string", example="kegiatan"),
     *                         @OA\Property(property="kategori_label", type="string", example="Kegiatan"),
     *                         @OA\Property(property="kategori_custom", type="string", example=null, nullable=true),
     *                         @OA\Property(property="penulis", type="string", example="Admin BPBD"),
     *                         @OA\Property(property="views", type="integer", example=150),
     *                         @OA\Property(property="status", type="string", example="published"),
     *                         @OA\Property(property="published_at", type="string", format="date-time", example="2025-01-01 10:00:00"),
     *                         @OA\Property(property="formatted_date", type="string", example="01 Jan 2025, 10:00"),
     *                         @OA\Property(property="created_at", type="string", format="date-time"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time")
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="pagination",
     *                     type="object",
     *                     @OA\Property(property="current_page", type="integer", example=1),
     *                     @OA\Property(property="last_page", type="integer", example=5),
     *                     @OA\Property(property="per_page", type="integer", example=10),
     *                     @OA\Property(property="total", type="integer", example=50),
     *                     @OA\Property(property="from", type="integer", example=1),
     *                     @OA\Property(property="to", type="integer", example=10)
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Berita::published();

        // Filter berdasarkan kategori (opsional)
        if ($request->has('kategori')) {
            $kategori = $request->input('kategori');
            if ($kategori === null || $kategori === 'null' || $kategori === '') {
                // Filter berita tanpa kategori
                $query->whereNull('kategori');
            } else {
                // Filter berita dengan kategori tertentu
                $query->where('kategori', $kategori);
            }
        }

        // Filter berdasarkan pencarian (opsional)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'LIKE', "%{$search}%")
                  ->orWhere('konten', 'LIKE', "%{$search}%");
            });
        }

        $beritas = $query->orderBy('published_at', 'desc')
            ->paginate(10);

        // Transform data untuk API
        $beritas->getCollection()->transform(function ($berita) use ($request) {
            return [
                'id' => $berita->id,
                'judul' => $berita->judul,
                'slug' => $berita->slug,
                'konten' => $berita->konten,
                'excerpt' => $berita->excerpt,
                'gambar' => $berita->gambar ? asset('storage/' . $berita->gambar) : null,
                'gambar_path' => $berita->gambar,
                'kategori' => $berita->kategori?->value,
                'kategori_label' => $berita->kategori_label ?? '-',
                'kategori_custom' => $berita->kategori_custom,
                'penulis' => $berita->penulis,
                'views' => $berita->views ?? 0,
                'status' => $berita->status,
                'published_at' => $berita->published_at?->toDateTimeString(),
                'formatted_date' => $berita->formatted_published_date,
                'created_at' => $berita->created_at->toDateTimeString(),
                'updated_at' => $berita->updated_at->toDateTimeString(),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data berita',
            'data' => [
                'items' => $beritas->items(),
                'pagination' => [
                    'current_page' => $beritas->currentPage(),
                    'last_page' => $beritas->lastPage(),
                    'per_page' => $beritas->perPage(),
                    'total' => $beritas->total(),
                    'from' => $beritas->firstItem(),
                    'to' => $beritas->lastItem(),
                ]
            ]
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/berita/{slug}",
     *     tags={"Berita"},
     *     summary="Mendapatkan detail berita",
     *     description="Menampilkan detail berita berdasarkan slug dan berita terkait lainnya. View count akan otomatis bertambah.",
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="Slug berita",
     *         required=true,
     *         @OA\Schema(type="string", example="pelatihan-kesiapsiagaan-bencana")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan detail berita",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil mendapatkan detail berita"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="judul", type="string", example="Pelatihan Kesiapsiagaan Bencana"),
     *                 @OA\Property(property="slug", type="string", example="pelatihan-kesiapsiagaan-bencana"),
     *                 @OA\Property(property="konten", type="string", example="Konten berita lengkap..."),
     *                 @OA\Property(property="excerpt", type="string", example="Ringkasan berita..."),
     *                 @OA\Property(property="gambar", type="string", example="http://localhost/storage/berita/image.jpg"),
     *                 @OA\Property(property="gambar_path", type="string", example="berita/image.jpg"),
     *                 @OA\Property(property="kategori", type="string", example="kegiatan"),
     *                 @OA\Property(property="kategori_label", type="string", example="Kegiatan"),
     *                 @OA\Property(property="kategori_custom", type="string", example=null, nullable=true),
     *                 @OA\Property(property="penulis", type="string", example="Admin BPBD"),
     *                 @OA\Property(property="views", type="integer", example=151),
     *                 @OA\Property(property="status", type="string", example="published"),
     *                 @OA\Property(property="published_at", type="string", format="date-time", example="2025-01-01 10:00:00"),
     *                 @OA\Property(property="formatted_date", type="string", example="01 Jan 2025, 10:00"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 @OA\Property(
     *                     property="related_news",
     *                     type="array",
     *                     description="3 berita terkait terbaru",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer", example=2),
     *                         @OA\Property(property="judul", type="string", example="Berita Terkait"),
     *                         @OA\Property(property="slug", type="string", example="berita-terkait"),
     *                         @OA\Property(property="excerpt", type="string", example="Ringkasan..."),
     *                         @OA\Property(property="gambar", type="string", example="http://localhost/storage/berita/image2.jpg"),
     *                         @OA\Property(property="kategori_label", type="string", example="Informasi"),
     *                         @OA\Property(property="published_at", type="string", format="date-time"),
     *                         @OA\Property(property="formatted_date", type="string", example="02 Jan 2025, 14:30")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Berita tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Berita tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function show($slug)
    {
        $berita = Berita::where('slug', $slug)
            ->published()
            ->first();

        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        // Increment view count
        $berita->increment('views');

        // Get related news (exclude current)
        $relatedBeritas = Berita::published()
            ->where('id', '!=', $berita->id)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get()
            ->map(function ($item) use ($slug, $request) {
                return [
                    'id' => $item->id,
                    'judul' => $item->judul,
                    'slug' => $item->slug,
                    'excerpt' => $item->excerpt,
                    'gambar' => $item->gambar ? asset('storage/' . $item->gambar) : null,
                    'kategori_label' => $item->kategori_label ?? '-',
                    'published_at' => $item->published_at?->toDateTimeString(),
                    'formatted_date' => $item->formatted_published_date,
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan detail berita',
            'data' => [
                'id' => $berita->id,
                'judul' => $berita->judul,
                'slug' => $berita->slug,
                'konten' => $berita->konten,
                'excerpt' => $berita->excerpt,
                'gambar' => $berita->gambar ? asset('storage/' . $berita->gambar) : null,
                'gambar_path' => $berita->gambar,
                'kategori' => $berita->kategori?->value,
                'kategori_label' => $berita->kategori_label ?? '-',
                'kategori_custom' => $berita->kategori_custom,
                'penulis' => $berita->penulis,
                'views' => $berita->views ?? 0,
                'status' => $berita->status,
                'published_at' => $berita->published_at?->toDateTimeString(),
                'formatted_date' => $berita->formatted_published_date,
                'created_at' => $berita->created_at->toDateTimeString(),
                'updated_at' => $berita->updated_at->toDateTimeString(),
                'related_news' => $relatedBeritas,
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/berita",
     *     tags={"Berita"},
     *     summary="Membuat berita baru",
     *     description="Endpoint untuk membuat berita baru. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"judul", "konten"},
     *                 @OA\Property(property="judul", type="string", example="Judul Berita Baru"),
     *                 @OA\Property(property="konten", type="string", example="<p>Konten berita lengkap...</p>"),
     *                 @OA\Property(property="kategori", type="string", enum={"peringatan_dini", "kegiatan", "pengumuman", "berita_umum", "laporan", "edukasi"}, example="kegiatan"),
     *                 @OA\Property(property="kategori_custom", type="string", example="Kategori Khusus", nullable=true),
     *                 @OA\Property(property="status", type="string", enum={"draft", "published"}, example="draft"),
     *                 @OA\Property(property="gambar", type="string", format="binary", description="Upload gambar berita")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Berita berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berita berhasil dibuat"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'nullable|string',
            'kategori_custom' => 'nullable|string|max:100',
            'status' => 'required|in:draft,published',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only(['judul', 'konten', 'kategori', 'kategori_custom', 'status']);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('berita', $filename, 'public');
            $data['gambar'] = $path;
        }

        $berita = Berita::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil dibuat',
            'data' => [
                'id' => $berita->id,
                'judul' => $berita->judul,
                'slug' => $berita->slug,
                'konten' => $berita->konten,
                'excerpt' => $berita->excerpt,
                'gambar' => $berita->gambar ? asset('storage/' . $berita->gambar) : null,
                'gambar_path' => $berita->gambar,
                'kategori' => $berita->kategori?->value,
                'kategori_label' => $berita->kategori_label ?? '-',
                'kategori_custom' => $berita->kategori_custom,
                'penulis' => $berita->penulis,
                'views' => $berita->views ?? 0,
                'status' => $berita->status,
                'published_at' => $berita->published_at?->toDateTimeString(),
                'formatted_date' => $berita->formatted_published_date,
                'created_at' => $berita->created_at->toDateTimeString(),
                'updated_at' => $berita->updated_at->toDateTimeString(),
            ]
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/berita/{slug}",
     *     tags={"Berita"},
     *     summary="Update berita",
     *     description="Endpoint untuk update berita berdasarkan slug. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="Slug berita",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="judul", type="string", example="Judul Berita Update"),
     *             @OA\Property(property="konten", type="string", example="<p>Konten update...</p>"),
     *             @OA\Property(property="kategori", type="string", example="kegiatan"),
     *             @OA\Property(property="kategori_custom", type="string", example="Kategori Khusus"),
     *             @OA\Property(property="status", type="string", enum={"draft", "published"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berita berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berita berhasil diupdate"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Berita tidak ditemukan"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, $slug)
    {
        $berita = Berita::where('slug', $slug)->first();

        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'judul' => 'sometimes|required|string|max:255',
            'konten' => 'sometimes|required|string',
            'kategori' => 'nullable|string',
            'kategori_custom' => 'nullable|string|max:100',
            'status' => 'sometimes|required|in:draft,published',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only(['judul', 'konten', 'kategori', 'kategori_custom', 'status']);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                Storage::disk('public')->delete($berita->gambar);
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('berita', $filename, 'public');
            $data['gambar'] = $path;
        }

        $berita->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil diupdate',
            'data' => [
                'id' => $berita->id,
                'judul' => $berita->judul,
                'slug' => $berita->slug,
                'konten' => $berita->konten,
                'excerpt' => $berita->excerpt,
                'gambar' => $berita->gambar ? asset('storage/' . $berita->gambar) : null,
                'gambar_path' => $berita->gambar,
                'kategori' => $berita->kategori?->value,
                'kategori_label' => $berita->kategori_label ?? '-',
                'kategori_custom' => $berita->kategori_custom,
                'penulis' => $berita->penulis,
                'views' => $berita->views ?? 0,
                'status' => $berita->status,
                'published_at' => $berita->published_at?->toDateTimeString(),
                'formatted_date' => $berita->formatted_published_date,
                'created_at' => $berita->created_at->toDateTimeString(),
                'updated_at' => $berita->updated_at->toDateTimeString(),
            ]
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/berita/{slug}",
     *     tags={"Berita"},
     *     summary="Hapus berita",
     *     description="Endpoint untuk menghapus berita berdasarkan slug. Requires authentication.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="Slug berita yang akan dihapus",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berita berhasil dihapus",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berita berhasil dihapus")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Berita tidak ditemukan")
     * )
     */
    public function destroy($slug)
    {
        $berita = Berita::where('slug', $slug)->first();

        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        // Delete image if exists
        if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil dihapus'
        ]);
    }
}





