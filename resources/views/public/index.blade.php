@extends('layouts.public')

@section('title', 'Beranda - BPBD Katingan')

@section('content')
    {{-- Slider --}}
    @if (isset($sliders) && $sliders->isNotEmpty())
        <section
            x-data='{"slides": @json($sliders), "activeIndex": 0, "autoplay": function() { if (this.slides.length > 1) { setInterval(() => { this.next(); }, 5000); } }, "next": function() { if (this.slides.length > 0) { this.activeIndex = (this.activeIndex + 1) % this.slides.length; } }, "prev": function() { if (this.slides.length > 0) { this.activeIndex = (this.activeIndex - 1 + this.slides.length) % this.slides.length; } }, "handleClick": function(event) { if (this.slides.length > 1) { const rect = event.currentTarget.getBoundingClientRect(); const clickX = event.clientX - rect.left; const halfWidth = rect.width / 2; if (clickX < halfWidth) { this.prev(); } else { this.next(); } } }}'
            x-init="autoplay" class="relative w-full h-[60vh] md:h-[85vh] text-white overflow-hidden bg-gray-800">

            <div class="w-full h-full cursor-pointer" @click="handleClick">
                <template x-for="(slide, index) in slides" :key="index">
                    <div x-show="activeIndex === index" x-transition:enter="transition ease-in-out duration-1000"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in-out duration-1000" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" class="absolute inset-0 w-full h-full" style="display: none;">

                        <!-- Gambar sebagai elemen terpisah -->
                        <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover">

                        <!-- Konten text di bawah tengah -->
                        <div
                            class="absolute bottom-0 left-1/2 -translate-x-1/2 w-full max-w-4xl px-4 sm:px-6 lg:px-8 py-12 md:py-20 text-center pointer-events-none">
                            <template x-if="slide.link">
                                <a :href="slide.link" class="block pointer-events-auto">
                                    <h1 x-text="slide.title"
                                        class="text-3xl md:text-4xl font-extrabold tracking-tight text-white drop-shadow-2xl">
                                    </h1>
                                    <p x-text="slide.subtitle"
                                        class="mt-4 max-w-2xl mx-auto text-lg md:text-xl text-gray-100 drop-shadow-xl"></p>
                                </a>
                            </template>
                            <template x-if="!slide.link">
                                <div class="text-center">
                                    <h1 x-text="slide.title"
                                        class="text-3xl md:text-4xl font-extrabold tracking-tight text-white drop-shadow-2xl">
                                    </h1>
                                    <p x-text="slide.subtitle"
                                        class="mt-4 max-w-2xl mx-auto text-lg md:text-xl text-gray-100 drop-shadow-xl"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <template x-if="slides.length > 1">
                <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex space-x-3 pointer-events-none">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click.stop="activeIndex = index"
                            :class="{ 'bg-white': activeIndex === index, 'bg-white/50': activeIndex !== index }"
                            class="w-3 h-3 rounded-full hover:bg-white transition-all duration-300 shadow-lg pointer-events-auto"></button>
                    </template>
                </div>
            </template>
        </section>
    @endif

    <!-- Panduan Kesiapsiagaan Bencana -->
    <section class="bg-white py-16 sm:py-24">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Panduan Kesiapsiagaan Bencana</h2>
                <p class="mt-4 text-lg text-gray-600">Langkah-langkah penting untuk melindungi diri Anda dan keluarga.</p>
            </div>
            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
                @if ($panduanBencana->isNotEmpty())
                    @foreach ($panduanBencana as $index => $panduan)
                        @php
                            $colors = [
                                ['bg' => 'bg-blue-100', 'text' => 'text-blue-600'],
                                ['bg' => 'bg-orange-100', 'text' => 'text-orange-600'],
                                ['bg' => 'bg-green-100', 'text' => 'text-green-600'],
                                ['bg' => 'bg-purple-100', 'text' => 'text-purple-600'],
                                ['bg' => 'bg-red-100', 'text' => 'text-red-600'],
                                ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-600'],
                            ];
                            $color = $colors[$index % count($colors)];

                            $icons = [
                                'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4',
                                'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
                                'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.286z',
                                'M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5',
                                'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z',
                                'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z',
                            ];
                            $icon = $icons[$index % count($icons)];
                        @endphp

                        <div class="bg-gray-50 p-8 rounded-lg border border-gray-200">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="flex items-center justify-center h-12 w-12 {{ $color['bg'] }} {{ $color['text'] }} rounded-lg">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="{{ $icon }}"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">{{ $panduan->title }}</h3>
                            </div>
                            <p class="mt-5 text-gray-600">{{ $panduan->description }}</p>
                            @if ($panduan->items && count($panduan->items) > 0)
                                <ul class="mt-4 space-y-2">
                                    @foreach ($panduan->items as $item)
                                        <li class="flex items-start">
                                            <span class="text-orange-500 mr-2">&#10003;</span>
                                            {{ $item }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endforeach
                @else
                    {{-- Pesan jika sedang update --}}
                    <div
                        class="col-span-1 md:col-span-3 flex flex-col items-center justify-center bg-blue-50 border border-blue-200 rounded-lg p-12">
                        <div class="flex items-center justify-center h-16 w-16 bg-blue-100 text-blue-600 rounded-full mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3 text-center">Panduan Sedang Diperbarui</h3>
                        <p class="text-gray-600 text-center max-w-md">
                            Kami sedang memperbarui panduan kesiapsiagaan bencana untuk memberikan informasi yang lebih
                            lengkap dan terkini. Silakan kembali lagi nanti.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Agenda Kegiatan -->
    <section class="bg-blue-50 py-16 sm:py-24">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-5 lg:gap-12">
                <div class="lg:col-span-2">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Agenda Kegiatan</h2>
                    <p class="mt-4 text-lg text-gray-600">Jadwal kegiatan dan program kerja BPBD Kabupaten Katingan yang
                        akan datang.</p>
                    <div class="mt-6">
                        <a href="{{ route('public.agenda.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 transition-colors duration-200">
                            Lihat Semua Agenda
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="mt-10 lg:mt-0 lg:col-span-3">
                    @if (isset($agendas) && $agendas->isNotEmpty())
                        <div class="space-y-8">
                            @foreach ($agendas as $agenda)
                                <div class="flex space-x-4">
                                    <div
                                        class="flex-shrink-0 text-center bg-white border border-gray-200 rounded-lg p-2 w-20">
                                        <p class="text-3xl font-bold text-orange-600">{{ $agenda->formatted_date }}</p>
                                        <p class="text-sm font-medium text-gray-500">{{ $agenda->formatted_month }}</p>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-start justify-between">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $agenda->title }}</h3>
                                            <span
                                                class="ml-2 px-2 py-1 text-xs font-medium rounded-full {{ $agenda->status_color }}">
                                                {{ $agenda->status_label }}
                                            </span>
                                        </div>
                                        <p class="mt-1 text-gray-600">{{ Str::limit($agenda->description, 100) }}</p>
                                        <div
                                            class="mt-3 flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-2 sm:space-y-0 text-sm text-gray-500">
                                            <p class="flex items-center">
                                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                                </svg>
                                                Lokasi: {{ $agenda->location }}
                                            </p>
                                            <p class="flex items-center">
                                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Waktu: {{ $agenda->formatted_time_range }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Pesan jika tidak ada agenda --}}
                        <div
                            class="flex flex-col items-center justify-center bg-white border border-gray-200 rounded-lg p-12">
                            <div
                                class="flex items-center justify-center h-16 w-16 bg-orange-100 text-orange-600 rounded-full mb-6">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Belum Ada Agenda Terjadwal</h3>
                            <p class="text-gray-600 text-center max-w-md">
                                Saat ini belum ada agenda kegiatan yang terjadwal. Pantau terus website ini untuk informasi
                                agenda terbaru.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Berita & Informasi -->
    <section class="bg-gray-50 py-16 sm:py-24">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Berita & Informasi</h2>
                <p class="mt-4 text-lg text-gray-600">Ikuti perkembangan dan kegiatan terbaru dari kami.</p>
            </div>
            <div class="mt-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @if (isset($beritas) && $beritas->isNotEmpty())
                    @foreach ($beritas as $berita)
                        <div
                            class="group flex flex-col overflow-hidden rounded-lg shadow-lg transition-shadow duration-300 hover:shadow-xl">
                            <div class="flex-shrink-0 overflow-hidden">
                                @if ($berita->gambar)
                                    <img class="h-48 w-full object-cover transition-transform duration-300 group-hover:scale-105"
                                        src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}">
                                @else
                                    <img class="h-48 w-full object-cover transition-transform duration-300 group-hover:scale-105"
                                        src="{{ asset('images/air.webp') }}" alt="{{ $berita->judul }}">
                                @endif
                            </div>
                            <div class="flex flex-1 flex-col justify-between bg-white p-6">
                                <div class="flex-1">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $berita->kategori_color }}">
                                        {{ $berita->kategori_icon }} {{ $berita->kategori_label }}
                                    </span>
                                    <a href="{{ route('berita.show', $berita->slug) }}" class="mt-2 block">
                                        <p
                                            class="text-xl font-semibold text-orange-600 transition-colors duration-300 group-hover:text-orange-800">
                                            {{ Str::limit($berita->judul, 60) }}
                                        </p>
                                        <p class="mt-3 text-base text-gray-500">{{ $berita->excerpt }}</p>
                                    </a>
                                </div>
                                <div class="mt-6 flex items-center justify-between">
                                    <p class="text-sm text-gray-500">{{ $berita->formatted_published_date }}</p>
                                    <a href="{{ route('berita.show', $berita->slug) }}"
                                        class="text-orange-600 hover:text-orange-800 text-sm font-medium transition-colors duration-200">
                                        Baca selengkapnya →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    {{-- Fallback jika tidak ada berita --}}
                    <div
                        class="col-span-1 md:col-span-2 lg:col-span-3 flex flex-col items-center justify-center bg-white border border-gray-200 rounded-lg p-12">
                        <div
                            class="flex items-center justify-center h-16 w-16 bg-orange-100 text-orange-600 rounded-full mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Berita Sedang Dipersiapkan</h3>
                        <p class="text-gray-600 text-center max-w-md">
                            Kami sedang mempersiapkan berita dan informasi terbaru untuk Anda. Silakan kembali lagi nanti.
                        </p>
                    </div>
                @endif
            </div>

            @if (isset($beritas) && $beritas->isNotEmpty())
                <div class="mt-12 text-center">
                    <a href="{{ route('berita.index') }}"
                        class="inline-flex items-center px-6 py-3 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 transition-colors duration-200">
                        Lihat Semua Berita
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Sambutan Kepala Dinas -->
    <section class="bg-white py-16 sm:py-24">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if ($kepalaDinas)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 items-center">
                    <div class="md:col-span-1">
                        @if ($kepalaDinas->foto_url)
                            <img src="{{ $kepalaDinas->foto_url }}" alt="Foto {{ $kepalaDinas->nama }}"
                                class="w-full h-auto rounded-lg shadow-lg object-cover">
                        @else
                            <img src="{{ asset('images/prabowo.jpg') }}" alt="Foto Kepala Dinas BPBD Katingan"
                                class="w-full h-auto rounded-lg shadow-lg object-cover">
                        @endif
                    </div>
                    <div class="md:col-span-2">
                        <h2 class="text-base font-semibold leading-7 text-orange-600">Sambutan Kepala Dinas</h2>
                        @if ($kepalaDinas->sambutan_judul)
                            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                                {{ $kepalaDinas->sambutan_judul }}
                            </p>
                        @else
                            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                                Bersama Membangun Ketangguhan
                            </p>
                        @endif
                        @if ($kepalaDinas->sambutan_kepala)
                            <blockquote class="mt-6 border-l-4 border-orange-500 pl-6 text-gray-600 italic">
                                {!! $kepalaDinas->sambutan_kepala !!}
                            </blockquote>
                        @else
                            <blockquote class="mt-6 border-l-4 border-orange-500 pl-6 text-gray-600 italic">
                                "Selamat datang di website resmi BPBD Kabupaten Katingan. Melalui platform digital ini, kami
                                berkomitmen untuk menyediakan informasi yang akurat, cepat, dan mudah diakses mengenai
                                penanggulangan bencana. Mari bersama-sama kita tingkatkan kesadaran dan kesiapsiagaan untuk
                                mewujudkan Katingan yang tangguh bencana."
                            </blockquote>
                        @endif
                        <div class="mt-8">
                            <p class="font-bold text-gray-900">{{ $kepalaDinas->nama }}</p>
                            <p class="text-gray-500">{{ $kepalaDinas->jabatan }}</p>
                        </div>
                    </div>
                </div>
            @else
                <!-- Tidak ada data kepala dinas -->
            @endif
        </div>
    </section>

    <!-- Galeri & Unduhan -->
    <section class="bg-white py-16 sm:py-24">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Galeri & Unduhan</h2>
                <p class="mt-4 text-lg text-gray-600">Dokumentasi kegiatan dan dokumen publik yang dapat diakses.</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">

                <!-- Galeri Foto -->
                <div class="flex flex-col">
                    <h3 class="text-2xl font-semibold text-gray-900">Galeri Foto Terbaru</h3>
                    <div class="mt-6 grid grid-cols-2 gap-4 flex-grow">
                        @if (isset($galeris) && $galeris->count() > 0)
                            @foreach ($galeris as $galeri)
                                <div class="group block overflow-hidden rounded-lg">
                                    <img src="{{ Storage::url($galeri->gambar) }}" alt="{{ $galeri->judul }}"
                                        class="w-full h-full aspect-square object-cover transition duration-300 group-hover:scale-110 group-hover:opacity-80">
                                </div>
                            @endforeach
                        @else
                            <div class="col-span-2 text-center py-8">
                                <div class="mx-auto w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-500">Belum ada foto galeri</p>
                            </div>
                        @endif
                    </div>
                    <div class="mt-6 text-center">
                        <a href="{{ route('galeri.index') }}"
                            class="font-semibold text-orange-600 hover:text-orange-500">Lihat Semua Foto &rarr;</a>
                    </div>
                </div>

                <!-- Dokumen Publik -->
                <div>
                    <h3 class="text-2xl font-semibold text-gray-900">Dokumen Publik</h3>
                    <div class="mt-6 space-y-4">
                        @if (isset($unduhans) && $unduhans->count() > 0)
                            @foreach ($unduhans as $unduhan)
                                <div
                                    class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 rounded-lg border border-gray-200 p-4">
                                    <a href="{{ Storage::url($unduhan->file_path) }}" target="_blank"
                                        class="flex-grow flex items-center space-x-4 w-full">
                                        <div class="flex-shrink-0">
                                            <svg class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                            </svg>
                                        </div>
                                        <div class="flex-grow">
                                            <p class="font-semibold text-gray-800">{{ $unduhan->title }}</p>
                                            <p class="text-sm text-gray-500">Tipe: {{ $unduhan->type }} | Ukuran:
                                                {{ $unduhan->file_size }}</p>
                                        </div>
                                        <div class="flex-shrink-0 hidden sm:block">
                                            <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                            </svg>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-8">
                                <div class="mx-auto w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-500">Belum ada dokumen tersedia</p>
                            </div>
                        @endif
                    </div>
                    <div class="mt-6 text-center">
                        <a href="{{ route('unduhan.index') }}"
                            class="font-semibold text-orange-600 hover:text-orange-500">Lihat Semua Unduhan &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
