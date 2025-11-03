@extends('layouts.public')

@section('title', 'Berita & Informasi - BPBD Katingan')

@section('content')

    <section class="bg-orange-500">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 md:py-24">
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl">Berita & Informasi</h1>
            <p class="mt-3 text-xl text-orange-100">
                Ikuti perkembangan terkini, kegiatan, dan peringatan dini dari BPBD Kabupaten Katingan.
            </p>
        </div>
    </section>
    <section class="py-16 sm:py-24 bg-gray-50">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">Semua Berita</h2>
                
                <!-- Form Pencarian -->
                <div class="mt-4 md:mt-0">
                    <form action="{{ route('berita.index') }}" method="GET" class="flex gap-2">
                        <div class="relative">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="Cari berita..." 
                                class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                            >
                            @if(request('search'))
                                <a href="{{ route('berita.index') }}" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                        <button 
                            type="submit" 
                            class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-semibold transition duration-300 flex items-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Cari
                        </button>
                    </form>
                </div>
            </div>

            <!-- Hasil Pencarian Info -->
            @if(request('search'))
                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-blue-800">
                        Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
                        @if($beritas->total() > 0)
                            - Ditemukan {{ $beritas->total() }} berita
                        @endif
                    </p>
                </div>
            @endif

            <div class="mt-12 grid grid-cols-1 gap-12">

                @forelse($beritas as $berita)
                    <article class="flex flex-col md:flex-row items-center bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="w-full md:w-4/12 flex-shrink-0 h-64 md:h-80">
                            @if($berita->gambar)
                                <img class="w-full h-full object-cover" src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}">
                            @else
                                <img class="w-full h-full object-cover" src="{{ asset('images/air.webp') }}" alt="{{ $berita->judul }}">
                            @endif
                        </div>
                        <div class="p-6 flex flex-col justify-between leading-normal w-full">
                            <div class="mb-8">
                                <div class="flex items-center mb-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $berita->kategori_color }}">
                                        {{ $berita->kategori_icon }} {{ $berita->kategori_label }}
                                    </span>
                                </div>
                                <a href="{{ route('berita.show', $berita->slug) }}" class="text-orange-600 hover:text-orange-800 text-xl sm:text-2xl font-bold mb-2 transition duration-300 block" title="{{ $berita->judul }}">
                                    {{ Str::limit($berita->judul, 80) }}
                                </a>
                                <p class="text-sm text-gray-600 mb-4">
                                    Penulis: {{ $berita->penulis }} |
                                    Tanggal: {{ $berita->published_at ? $berita->published_at->format('d-m-Y') : $berita->created_at->format('d-m-Y') }}
                                </p>
                                <p class="text-gray-700 text-base">{{ $berita->excerpt }}</p>
                            </div>
                            <a href="{{ route('berita.show', $berita->slug) }}" class="self-start bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-5 rounded-md transition duration-300">
                                Selengkapnya
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="flex flex-col items-center justify-center bg-white border border-gray-200 rounded-lg p-12">
                        <div class="flex items-center justify-center h-16 w-16 bg-orange-100 text-orange-600 rounded-full mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Belum Ada Berita</h3>
                        <p class="text-gray-600 text-center max-w-md">
                            Saat ini belum ada berita yang dipublikasikan. Silakan kembali lagi nanti untuk informasi terbaru.
                        </p>
                    </div>
                @endforelse

            </div>

            <!-- Pagination -->
            @if($beritas->hasPages())
                <div class="mt-16">
                    {{ $beritas->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
