@extends('layouts.public')

@section('title', $berita->judul . ' - BPBD Katingan')

@section('content')

    <section class="py-16 sm:py-24 bg-white">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-3 lg:gap-12">

                <div class="lg:col-span-2">

                    <div class="border-b border-gray-200 pb-6 mb-8">
                        <div class="flex flex-wrap items-center gap-2 sm:gap-4 text-xs sm:text-sm text-gray-500">
                            <span>Penulis: {{ $berita->penulis }}</span>
                            <span class="hidden sm:inline">|</span>
                            <span>Tanggal: {{ $berita->published_at ? $berita->published_at->format('d M Y') : $berita->created_at->format('d M Y') }}</span>
                            <span class="hidden sm:inline">|</span>
                            <span class="inline-flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ number_format($berita->views) }} views
                            </span>
                            <span class="hidden sm:inline">|</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $berita->kategori_color }}">
                                {{ $berita->kategori_icon }} {{ $berita->kategori_label }}
                            </span>
                        </div>

                        <h1 class="mt-4 text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                            {{ $berita->judul }}
                        </h1>

                        <div class="mt-6 flex items-center space-x-3">
                            <span class="text-sm font-medium text-gray-600">Bagikan:</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 hover:bg-blue-700 text-white transition-all duration-200 shadow-md hover:shadow-lg">
                                <span class="sr-only">Facebook</span>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($berita->judul . ' - ' . request()->url()) }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-500 hover:bg-green-600 text-white transition-all duration-200 shadow-md hover:shadow-lg">
                                <span class="sr-only">WhatsApp</span>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    @if($berita->gambar)
                        <img class="w-full rounded-lg shadow-md mb-8" src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}">
                    @endif

                    <div class="prose prose-lg prose-orange max-w-none select-none" oncontextmenu="return false;" oncopy="return false;" oncut="return false;">
                        {!! $berita->konten !!}
                    </div>

                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <a href="{{ route('berita.index') }}" class="inline-flex items-center text-orange-600 hover:text-orange-800 font-semibold transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali ke Semua Berita
                        </a>
                    </div>
                </div>


                <div class="lg:col-span-1 mt-16 lg:mt-0">
                    <div class="sticky top-28">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            {{-- Tambahkan SVG di sini --}}
                            <svg class="w-6 h-6 mr-3 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                            </svg>
                            Berita Lainnya
                        </h3>
                        <div class="space-y-6">
                            @forelse($relatedBeritas as $related)
                                <a href="{{ route('berita.show', $related->slug) }}" class="group flex items-center space-x-4">
                                    <div class="w-24 h-24 flex-shrink-0">
                                        @if($related->gambar)
                                            <img src="{{ asset('storage/' . $related->gambar) }}" alt="{{ $related->judul }}" class="w-full h-full rounded-lg object-cover">
                                        @else
                                            <img src="{{ asset('images/air.webp') }}" alt="{{ $related->judul }}" class="w-full h-full rounded-lg object-cover">
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">{{ $related->published_at ? $related->published_at->format('d M Y') : $related->created_at->format('d M Y') }}</p>
                                        <p class="font-semibold text-gray-800 group-hover:text-orange-600 transition">{{ Str::limit($related->judul, 60) }}</p>
                                    </div>
                                </a>
                            @empty
                                <p class="text-gray-500 text-sm">Belum ada berita lainnya.</p>
                            @endforelse
                        </div>
                        <div class="mt-8">
                            <a href="{{ route('berita.index') }}" class="inline-flex items-center font-semibold text-orange-600 hover:text-orange-800 transition">
                                Lihat Semua Berita
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <script>
        // Disable text selection on content
        document.addEventListener('DOMContentLoaded', function() {
            const contentArea = document.querySelector('.prose');
            
            if (contentArea) {
                // Disable right click
                contentArea.addEventListener('contextmenu', function(e) {
                    e.preventDefault();
                    return false;
                });
                
                // Disable copy
                contentArea.addEventListener('copy', function(e) {
                    e.preventDefault();
                    return false;
                });
                
                // Disable cut
                contentArea.addEventListener('cut', function(e) {
                    e.preventDefault();
                    return false;
                });
                
                // Disable drag and drop
                contentArea.addEventListener('dragstart', function(e) {
                    e.preventDefault();
                    return false;
                });
                
                // Disable keyboard shortcuts (Ctrl+C, Ctrl+A, etc)
                contentArea.addEventListener('keydown', function(e) {
                    if (e.ctrlKey && (e.key === 'c' || e.key === 'C' || 
                                      e.key === 'x' || e.key === 'X' || 
                                      e.key === 'a' || e.key === 'A' ||
                                      e.key === 'u' || e.key === 'U')) {
                        e.preventDefault();
                        return false;
                    }
                    
                    // Disable F12, Ctrl+Shift+I, Ctrl+Shift+J (Developer Tools)
                    if (e.key === 'F12' || 
                        (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J' || e.key === 'C'))) {
                        e.preventDefault();
                        return false;
                    }
                });
            }
        });
    </script>
@endsection
