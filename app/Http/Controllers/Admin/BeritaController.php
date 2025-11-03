<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Enums\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;
use PhpOffice\PhpWord\IOFactory;
use Smalot\PdfParser\Parser;
//use function Laravel\Prompts\search;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil opsi kategori untuk dropdown filter - hanya ambil label saja
        $kategoriOptions = collect(KategoriBerita::cases())->map(fn($case) => $case->label())->toArray();

        // --- LOGIKA UNTUK KARTU STATISTIK (Dihitung dari semua data) ---
        $totalBeritaCount = Berita::count();
        $publishedCount = Berita::where('status', 'published')->count();
        $draftCount = Berita::where('status', 'draft')->count();

        // --- LOGIKA PENCARIAN & FILTER ---
        $query = Berita::query();

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            // Cari enum berdasarkan label yang dipilih
            $selectedEnum = collect(KategoriBerita::cases())
                ->first(fn($case) => $case->label() === $request->kategori);

            if ($selectedEnum) {
                $query->where('kategori', $selectedEnum->value);
            }
        }

        $beritas = $query->with('user')->latest()->paginate(10);

        return view('admin.berita.index', compact(
            'beritas',
            'kategoriOptions',
            'totalBeritaCount',
            'publishedCount',
            'draftCount'
        ));
    }

    public function create()
    {
        $kategoris = KategoriBerita::options();
        return view('admin.berita.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        // Validasi berbeda untuk kategori custom vs enum
        $rules = [
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,published',
        ];

        // Jika bukan custom, validasi sebagai enum
        if ($request->kategori !== 'custom') {
            $rules['kategori'] = ['nullable', new Enum(KategoriBerita::class)];
        } else {
            // Jika custom, kategori_custom wajib diisi
            $rules['kategori_custom'] = 'required|string|max:100';
        }

        $request->validate($rules);

        $data = $request->all();

        // Jika user memilih "custom", gunakan kategori_custom
        if ($request->kategori === 'custom' && !empty($request->kategori_custom)) {
            $data['kategori'] = null; // Set enum ke null
        } else {
            // Jika menggunakan enum, hapus kategori_custom
            $data['kategori_custom'] = null;
        }

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('berita', $imageName, 'public');
            $data['gambar'] = $imagePath;
        }

        Berita::create($data);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function show(Berita $berita)
    {
        return view('admin.berita.show', compact('berita'));
    }

    public function edit(Berita $berita)
    {
        $kategoris = KategoriBerita::options();
        return view('admin.berita.edit', compact('berita', 'kategoris'));
    }

    public function update(Request $request, Berita $berita)
    {
        // Validasi berbeda untuk kategori custom vs enum
        $rules = [
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,published',
        ];

        // Jika bukan custom, validasi sebagai enum
        if ($request->kategori !== 'custom') {
            $rules['kategori'] = ['nullable', new Enum(KategoriBerita::class)];
        } else {
            // Jika custom, kategori_custom wajib diisi
            $rules['kategori_custom'] = 'required|string|max:100';
        }

        $request->validate($rules);

        $data = $request->all();

        // Jika user memilih "custom", gunakan kategori_custom
        if ($request->kategori === 'custom' && !empty($request->kategori_custom)) {
            $data['kategori'] = null;
        } else {
            // Jika menggunakan enum, hapus kategori_custom
            $data['kategori_custom'] = null;
        }

        // Handle image upload
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                Storage::disk('public')->delete($berita->gambar);
            }

            $image = $request->file('gambar');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('berita', $imageName, 'public');
            $data['gambar'] = $imagePath;
        }

        $berita->update($data);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        // Delete image if exists
        if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }

    public function toggleStatus(Berita $berita)
    {
        $berita->status = $berita->status === 'published' ? 'draft' : 'published';

        // Jika status diubah ke published dan belum ada published_at, set published_at
        if ($berita->status === 'published' && !$berita->published_at) {
            $berita->published_at = now();
        }

        $berita->save();

        $statusText = $berita->status === 'published' ? 'dipublikasi' : 'dijadikan draft';

        return redirect()->back()->with('success', "Status berita berhasil {$statusText}.");
    }

    public function uploadFile(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:doc,docx,pdf,txt|max:10240', // Max 10MB
            ]);

            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $extension = strtolower($file->getClientOriginalExtension());

            $content = '';

            if ($extension === 'txt') {
                // Handle plain text files - langsung baca isi
                $textContent = file_get_contents($file->getPathname());
                $content = nl2br(htmlspecialchars($textContent));

            } elseif ($extension === 'pdf') {
                // Handle PDF files using proper library
                $content = $this->processPdfFile($file);

            } elseif (in_array($extension, ['doc', 'docx'])) {
                // Handle Word files using proper library
                $content = $this->processWordFile($file);
            }

            // Jika content kosong, beri pesan
            if (empty(trim(strip_tags($content)))) {
                $content = '<p>File berhasil diupload namun konten tidak dapat diekstrak. Silakan copy-paste manual dari file: ' . htmlspecialchars($fileName) . '</p>';
            }

            return response()->json([
                'success' => true,
                'message' => 'Konten berhasil diekstrak dari: ' . $fileName,
                'content' => $content
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses file: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process Word file and extract content with formatting.
     */
    private function processWordFile($file)
    {
        try {
            // Check if PhpWord library is available
            if (!class_exists('PhpOffice\PhpWord\IOFactory')) {
                throw new \Exception('Library PhpWord belum terinstall. Jalankan: composer require phpoffice/phpword');
            }

            // Try to load the file
            $phpWord = IOFactory::load($file->getPathname());
            $content = '';

            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    $content .= $this->convertElementToHtml($element);
                }
            }

            return $this->cleanHtmlContent($content);
        } catch (\Exception $e) {
            // Fallback to basic extraction
            return $this->fallbackWordExtraction($file);
        }
    }

    /**
     * Process PDF file and extract text.
     */
    private function processPdfFile($file)
    {
        try {
            // Check if PdfParser library is available
            if (!class_exists('Smalot\PdfParser\Parser')) {
                throw new \Exception('Library PdfParser belum terinstall. Jalankan: composer require smalot/pdfparser');
            }

            $parser = new Parser();
            $pdf = $parser->parseFile($file->getPathname());
            $text = $pdf->getText();

            // Convert line breaks to HTML paragraphs
            $paragraphs = explode("\n\n", trim($text));
            $content = '';

            foreach ($paragraphs as $paragraph) {
                $paragraph = trim($paragraph);
                if (!empty($paragraph)) {
                    // Replace single line breaks with spaces, keep paragraph breaks
                    $paragraph = str_replace("\n", ' ', $paragraph);
                    $paragraph = preg_replace('/\s+/', ' ', $paragraph); // Remove extra spaces
                    $content .= '<p>' . htmlspecialchars($paragraph) . '</p>';
                }
            }

            return $content;
        } catch (\Exception $e) {
            // Fallback to basic extraction
            return $this->fallbackPdfExtraction($file);
        }
    }

    /**
     * Fallback Word extraction when library not available
     */
    private function fallbackWordExtraction($file)
    {
        $fileName = $file->getClientOriginalName();
        $extension = strtolower($file->getClientOriginalExtension());

        if ($extension === 'docx') {
            try {
                // DOCX adalah ZIP file, coba ekstrak XML
                $zip = new \ZipArchive();
                if ($zip->open($file->getPathname()) === TRUE) {
                    $xml = $zip->getFromName('word/document.xml');
                    $zip->close();

                    if ($xml) {
                        // Parse XML dan ambil text
                        $dom = new \DOMDocument();
                        $dom->loadXML($xml);
                        $textNodes = $dom->getElementsByTagName('t');
                        $text = '';
                        foreach ($textNodes as $node) {
                            $text .= $node->nodeValue . ' ';
                        }

                        if (!empty(trim($text))) {
                            // Bersihkan dan format text
                            $text = preg_replace('/\s+/', ' ', trim($text));
                            return '<p>' . nl2br(htmlspecialchars($text)) . '</p>';
                        }
                    }
                }
            } catch (\Exception $e) {
                // Ignore and return message
            }
        }

        return '<p>Library PhpWord diperlukan untuk ekstraksi Word. File: ' . htmlspecialchars($fileName) . ' - Silakan copy-paste manual.</p>';
    }

    /**
     * Fallback PDF extraction when library not available
     */
    private function fallbackPdfExtraction($file)
    {
        $fileName = $file->getClientOriginalName();

        try {
            // Method 1: Coba gunakan pdftotext jika ada
            $output = shell_exec("pdftotext '" . $file->getPathname() . "' -");
            if (!empty($output)) {
                return '<p>' . nl2br(htmlspecialchars(trim($output))) . '</p>';
            }
        } catch (\Exception $e) {
            // Ignore and try next method
        }

        return '<p>Library PdfParser diperlukan untuk ekstraksi PDF. File: ' . htmlspecialchars($fileName) . ' - Silakan copy-paste manual.</p>';
    }

    /**
     * Convert PhpWord element to HTML.
     */
    private function convertElementToHtml($element)
    {
        $html = '';

        if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
            $html .= '<p>';
            foreach ($element->getElements() as $textElement) {
                if ($textElement instanceof \PhpOffice\PhpWord\Element\Text) {
                    $text = htmlspecialchars($textElement->getText());
                    $fontStyle = $textElement->getFontStyle();

                    if ($fontStyle) {
                        if ($fontStyle->isBold()) {
                            $text = '<strong>' . $text . '</strong>';
                        }
                        if ($fontStyle->isItalic()) {
                            $text = '<em>' . $text . '</em>';
                        }
                    }

                    $html .= $text;
                }
            }
            $html .= '</p>';
        } elseif ($element instanceof \PhpOffice\PhpWord\Element\Text) {
            $text = htmlspecialchars($element->getText());
            $fontStyle = $element->getFontStyle();

            if ($fontStyle) {
                if ($fontStyle->isBold()) {
                    $text = '<strong>' . $text . '</strong>';
                }
                if ($fontStyle->isItalic()) {
                    $text = '<em>' . $text . '</em>';
                }
            }

            $html .= '<p>' . $text . '</p>';
        }

        return $html;
    }

    /**
     * Clean and optimize HTML content.
     */
    private function cleanHtmlContent($content)
    {
        // Remove empty paragraphs
        $content = preg_replace('/<p[\s]*><\/p>/', '', $content);
        $content = preg_replace('/<p[\s]*>\s*<\/p>/', '', $content);

        // Clean up extra whitespace
        $content = preg_replace('/\s+/', ' ', $content);
        $content = str_replace('> <', '><', $content);

        // Ensure proper paragraph structure
        $content = trim($content);

        return $content;
    }
}

