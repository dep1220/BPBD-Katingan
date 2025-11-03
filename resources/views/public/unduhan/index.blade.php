@extends('layouts.public')

@section('title', 'Pusat Unduhan - BPBD Katingan')

@section('content')

    <section class="bg-orange-500">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 md:py-24">
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl">Pusat Unduhan</h1>
            <p class="mt-3 text-xl text-orange-100">
                Akses dan unduh dokumen publik, laporan, dan formulir resmi dari BPBD Kabupaten Katingan.
            </p>
        </div>
    </section>

    <section class="py-16 sm:py-24 bg-gray-50"
             x-data="{
                isPreviewOpen: false,
                activeDocument: null,
                openPreview(doc) {
                    console.log('Opening preview:', doc);
                    this.activeDocument = doc;
                    this.isPreviewOpen = true;
                    if (typeof window !== 'undefined' && document.body) {
                        document.body.style.overflow = 'hidden';
                    }
                },
                closePreview() {
                    this.isPreviewOpen = false;
                    this.activeDocument = null;
                    if (typeof window !== 'undefined' && document.body) {
                        document.body.style.overflow = 'auto';
                    }
                }
             }"
             @keydown.escape.window="closePreview()">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-6 sm:p-8 rounded-xl shadow-lg">

                {{-- Search Bar & Filter --}}
                <form method="GET" action="{{ route('unduhan.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div class="md:col-span-3 relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari dokumen..." class="block w-full rounded-md border-gray-300 pl-10 focus:border-orange-500 focus:ring-orange-500">
                        </div>
                        <div class="md:col-span-1">
                            <select name="kategori" class="block w-full rounded-md border-gray-300 focus:border-orange-500 focus:ring-orange-500">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoriList as $kategori)
                                    <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                                        {{ $kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-1">
                            <button type="submit" class="w-full justify-center rounded-md bg-orange-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-orange-600 transition">Cari</button>
                        </div>
                    </div>
                </form>

                <div class="mt-8 border-t border-gray-200 pt-8">
                    @if($unduhans->count() > 0)
                        <div class="space-y-4">
                            @foreach($unduhans as $unduhan)
                                <div class="flex flex-col lg:flex-row rounded-lg border border-gray-200 p-4 lg:items-center">
                                    <div class="flex items-start space-x-3 w-full mb-3 lg:mb-0 flex-grow">
                                        <div class="flex-shrink-0">
                                            {{-- Icon berdasarkan tipe file --}}
                                            @php
                                                $typeString = is_object($unduhan->type) ? $unduhan->type->value : $unduhan->type;
                                            @endphp
                                            @if(str_contains(strtolower($typeString), 'pdf'))
                                                <svg class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                </svg>
                                            @elseif(str_contains(strtolower($typeString), 'doc'))
                                                <svg class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c-.621 0-1.125-.504-1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                </svg>
                                            @elseif(str_contains(strtolower($typeString), 'excel'))
                                                <svg class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c-.621 0-1.125-.504-1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                </svg>
                                            @else
                                                <svg class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c-.621 0-1.125-.504-1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="flex-grow min-w-0">
                                            <p class="font-semibold text-gray-800 text-sm sm:text-base mb-1">{{ $unduhan->title }}</p>
                                            <div class="flex flex-wrap gap-1 sm:gap-2 text-xs sm:text-sm text-gray-500">
                                                <span>{{ $unduhan->kategori }}</span>
                                                <span class="hidden sm:inline">|</span>
                                                <span>{{ $unduhan->file_size }}</span>
                                                <span class="hidden sm:inline">|</span>
                                                <span>{{ $unduhan->created_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex gap-2 w-full lg:w-auto lg:flex-shrink-0 lg:ml-4">
                                        {{-- Button Lihat/Preview - Buka modal --}}
                                        <button @click="openPreview({
                                                    title: {{ json_encode($unduhan->title) }},
                                                    kategori: {{ json_encode($unduhan->kategori) }},
                                                    file_path: {{ json_encode(asset('storage/' . $unduhan->file_path)) }},
                                                    file_size: {{ json_encode($unduhan->file_size) }},
                                                    created_at: {{ json_encode($unduhan->created_at->format('d M Y')) }}
                                                })"
                                                class="flex-1 lg:flex-none inline-flex items-center justify-center px-3 py-2 text-xs sm:text-sm font-medium text-orange-600 bg-orange-50 rounded-md hover:bg-orange-100 transition">
                                            <svg class="h-4 w-4 lg:mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span class="hidden lg:inline">Lihat</span>
                                        </button>
                                        {{-- Button Download --}}
                                        <a href="{{ asset('storage/' . $unduhan->file_path) }}" target="_blank" download
                                           class="flex-1 lg:flex-none inline-flex items-center justify-center px-3 py-2 text-xs sm:text-sm font-medium text-white bg-orange-600 rounded-md hover:bg-orange-700 transition">
                                            <svg class="h-4 w-4 lg:mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                            </svg>
                                            <span class="hidden lg:inline">Download</span>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        @if($unduhans->hasPages())
                            <div class="mt-8">
                                {{ $unduhans->appends(request()->query())->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-16">
                            <div class="mx-auto w-24 h-24 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-12 h-12 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada dokumen ditemukan</h3>
                            <p class="text-gray-500">
                                @if(request('search') || request('kategori'))
                                    Coba ubah kriteria pencarian Anda.
                                @else
                                    Belum ada dokumen yang tersedia untuk diunduh.
                                @endif
                            </p>
                            @if(request('search') || request('kategori'))
                                <div class="mt-6">
                                    <a href="{{ route('unduhan.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-orange-600 hover:bg-orange-700">
                                        Lihat Semua Dokumen
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Modal untuk preview dokumen seperti galeri --}}
        <div x-show="isPreviewOpen"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-80">

            <button @click="closePreview()" class="absolute top-2 right-2 sm:top-4 sm:right-4 text-white hover:text-gray-300 z-50 p-2 rounded-full bg-black bg-opacity-50">
                <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <div class="relative w-full h-full p-4 sm:p-8 md:p-16 flex items-center justify-center" x-show="activeDocument">
                <div class="w-full h-full flex flex-col items-center justify-center text-center max-w-6xl">
                    
                    {{-- Header dengan info dokumen --}}
                    <div class="mb-3 sm:mb-4 px-2">
                        <h3 x-text="activeDocument ? activeDocument.title : ''" class="text-base sm:text-xl font-semibold text-white mb-1 sm:mb-2 line-clamp-2"></h3>
                        <div class="flex flex-wrap justify-center gap-1 sm:gap-2 text-xs sm:text-sm text-gray-200">
                            <span x-text="activeDocument ? activeDocument.kategori : ''"></span>
                            <span class="hidden sm:inline">|</span>
                            <span x-text="activeDocument ? activeDocument.file_size : ''"></span>
                            <span class="hidden sm:inline">|</span>
                            <span x-text="activeDocument ? activeDocument.created_at : ''"></span>
                        </div>
                    </div>

                    {{-- Preview Content --}}
                    <div class="w-full max-w-5xl">
                        <iframe x-show="activeDocument" :src="activeDocument ? activeDocument.file_path : ''" class="w-full h-[60vh] sm:h-[70vh] md:h-[75vh] rounded-lg bg-white shadow-2xl" frameborder="0"></iframe>
                    </div>

                    {{-- Download button di footer --}}
                    <div class="mt-3 sm:mt-4">
                        <a :href="activeDocument ? activeDocument.file_path : '#'" target="_blank" download
                           class="inline-flex items-center px-3 py-2 sm:px-4 sm:py-2 text-sm sm:text-base bg-orange-600 text-white rounded-md hover:bg-orange-700 transition">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5 mr-1 sm:mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            <span class="hidden sm:inline">Download Dokumen</span>
                            <span class="sm:hidden">Download</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
