<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Enums\KategoriBerita;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     schema="Berita",
 *     type="object",
 *     title="Berita",
 *     description="Model data Berita/Informasi",
 *     @OA\Property(property="id", type="integer", example=1, description="ID berita"),
 *     @OA\Property(property="judul", type="string", example="Sosialisasi Kesiapsiagaan Bencana", description="Judul berita"),
 *     @OA\Property(property="slug", type="string", example="sosialisasi-kesiapsiagaan-bencana", description="URL-friendly slug"),
 *     @OA\Property(property="konten", type="string", example="<p>Isi berita lengkap...</p>", description="Konten berita dalam HTML"),
 *     @OA\Property(property="excerpt", type="string", example="Ringkasan berita...", description="Ringkasan otomatis dari konten"),
 *     @OA\Property(property="gambar", type="string", example="http://localhost/storage/berita/image.jpg", description="URL gambar lengkap"),
 *     @OA\Property(property="gambar_path", type="string", example="berita/image.jpg", description="Path gambar di storage"),
 *     @OA\Property(
 *         property="kategori",
 *         type="string",
 *         example="kegiatan",
 *         enum={"peringatan_dini", "kegiatan", "pengumuman", "berita_umum", "laporan", "edukasi"},
 *         description="Kategori berita"
 *     ),
 *     @OA\Property(property="kategori_label", type="string", example="Kegiatan", description="Label kategori untuk ditampilkan"),
 *     @OA\Property(property="kategori_custom", type="string", example="Kategori Khusus", nullable=true, description="Kategori kustom jika tidak ada di enum"),
 *     @OA\Property(property="penulis", type="string", example="Admin BPBD", description="Nama penulis berita"),
 *     @OA\Property(property="views", type="integer", example=150, description="Jumlah views berita"),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         example="published",
 *         enum={"draft", "published"},
 *         description="Status publikasi"
 *     ),
 *     @OA\Property(property="published_at", type="string", format="datetime", example="2025-01-15 10:00:00", description="Waktu publikasi"),
 *     @OA\Property(property="formatted_date", type="string", example="15 Jan 2025, 10:00", description="Tanggal terformat"),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2025-01-15 09:30:00", description="Waktu dibuat"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2025-01-15 10:30:00", description="Waktu diupdate")
 * )
 * 
 * @OA\Schema(
 *     schema="BeritaInput",
 *     type="object",
 *     title="Berita Input",
 *     description="Data input untuk create/update berita",
 *     required={"judul", "konten", "status"},
 *     @OA\Property(property="judul", type="string", example="Judul Berita Baru", maxLength=255, description="Judul berita (wajib)"),
 *     @OA\Property(property="konten", type="string", example="<p>Konten berita lengkap...</p>", description="Konten berita dalam HTML (wajib)"),
 *     @OA\Property(
 *         property="kategori",
 *         type="string",
 *         example="kegiatan",
 *         enum={"peringatan_dini", "kegiatan", "pengumuman", "berita_umum", "laporan", "edukasi"},
 *         nullable=true,
 *         description="Kategori berita (opsional)"
 *     ),
 *     @OA\Property(property="kategori_custom", type="string", example="Kategori Khusus", maxLength=100, nullable=true, description="Kategori kustom (opsional)"),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         example="draft",
 *         enum={"draft", "published"},
 *         description="Status publikasi (wajib)"
 *     ),
 *     @OA\Property(property="gambar", type="string", format="binary", description="File gambar berita (opsional)")
 * )
 */
class Berita extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'gambar',
        'status',
        'kategori',
        'kategori_custom',
        'penulis',
        'published_at',
        'views',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'kategori' => KategoriBerita::class,
    ];

    // Automatically generate slug from judul
    public static function boot()
    {
        parent::boot();

        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = static::generateUniqueSlug($berita->judul);
            }

            if (empty($berita->penulis)) {
                $berita->penulis = Auth::check() ? Auth::user()->name : 'Admin';
            }

            if ($berita->status === 'published' && empty($berita->published_at)) {
                $berita->published_at = now();
            }
        });

        static::updating(function ($berita) {
            if ($berita->isDirty('judul')) {
                $berita->slug = static::generateUniqueSlug($berita->judul, $berita->id);
            }

            if ($berita->isDirty('status') && $berita->status === 'published' && empty($berita->published_at)) {
                $berita->published_at = now();
            }
        });
    }

    /**
     * Generate unique slug from title
     */
    public static function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        // Check if slug exists
        while (static::slugExists($slug, $ignoreId)) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    /**
     * Check if slug exists in database
     */
    public static function slugExists($slug, $ignoreId = null)
    {
        $query = static::where('slug', $slug);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->exists();
    }

    // Menggunakan Enum untuk kategori
    public static function getKategoris()
    {
        return KategoriBerita::options();
    }

    // Accessor untuk kategori label
    public function getKategoriLabelAttribute()
    {
        // Jika ada kategori custom, gunakan itu
        if (!empty($this->kategori_custom)) {
            return $this->kategori_custom;
        }
        
        // Jika tidak, gunakan enum
        if (!$this->kategori instanceof KategoriBerita) {
            return '-';
        }
        return $this->kategori->label();
    }

    // Accessor untuk kategori color
    public function getKategoriColorAttribute()
    {
        // Jika ada kategori custom, gunakan warna default
        if (!empty($this->kategori_custom)) {
            return 'bg-teal-100 text-teal-800';
        }
        
        if (!$this->kategori instanceof KategoriBerita) {
            return 'bg-gray-100 text-gray-800';
        }
        return $this->kategori->color();
    }

    // Accessor untuk kategori icon
    public function getKategoriIconAttribute()
    {
        // Jika ada kategori custom, gunakan icon default
        if (!empty($this->kategori_custom)) {
            return '🏷️';
        }
        
        if (!$this->kategori instanceof KategoriBerita) {
            return '📄';
        }
        return $this->kategori->icon();
    }

    // Accessor untuk status label
    public function getStatusLabelAttribute()
    {
        return $this->status === 'published' ? 'Terbit' : 'Draft';
    }

    // Accessor untuk status color
    public function getStatusColorAttribute()
    {
        return $this->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';
    }

    // Accessor untuk excerpt
    public function getExcerptAttribute()
    {
        return Str::limit(strip_tags($this->konten), 150);
    }

    // Accessor untuk formatted published date
    public function getFormattedPublishedDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('d M Y, H:i') : '-';
    }

    // Scope untuk berita published
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    // Scope untuk berita draft
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    // Scope untuk kategori tertentu
    public function scopeByKategori($query, KategoriBerita $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // Route key name untuk slug
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Override untuk mendukung pencarian berdasarkan ID atau slug
    public function resolveRouteBinding($value, $field = null)
    {
        // Jika value adalah angka, cari berdasarkan ID
        if (is_numeric($value)) {
            return $this->where('id', $value)->first();
        }

        // Jika bukan angka, cari berdasarkan slug
        return $this->where('slug', $value)->first();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
