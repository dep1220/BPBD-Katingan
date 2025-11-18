<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Judul halaman dinamis dari setiap halaman anak --}}
    <title>@yield('title', 'BPBD Katingan')</title>
    <meta name="description" content="@yield('description', 'Badan Penanggulangan Bencana Daerah Kabupaten Katingan - Informasi, Berita, dan Layanan Penanggulangan Bencana')">
    <meta name="keywords" content="@yield('keywords', 'BPBD, Katingan, Bencana, Penanggulangan Bencana, Kalimantan Tengah')">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', 'BPBD Katingan')">
    <meta property="og:description" content="@yield('og_description', 'Badan Penanggulangan Bencana Daerah Kabupaten Katingan - Informasi, Berita, dan Layanan Penanggulangan Bencana')">
    <meta property="og:image" content="@yield('og_image', asset('images/logo-bpbd.png'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="BPBD Kabupaten Katingan">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('og_title', 'BPBD Katingan')">
    <meta property="twitter:description" content="@yield('og_description', 'Badan Penanggulangan Bencana Daerah Kabupaten Katingan - Informasi, Berita, dan Layanan Penanggulangan Bencana')">
    <meta property="twitter:image" content="@yield('og_image', asset('images/logo-bpbd.png'))">

    <!-- Additional SEO -->
    <meta name="author" content="BPBD Kabupaten Katingan">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo-bpbd.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo-bpbd.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-bpbd.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
{{--NAVBAR--}}
<nav x-data="{ open: false }" class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto max-w-7xl px-3 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 sm:h-20">
            <div class="flex-shrink-0">
                <a href="{{route('home')}}" class="flex items-center space-x-2 sm:space-x-3">
                    <img class="h-10 sm:h-12 w-auto" src="{{ asset('images/logo-bpbd.png') }}" alt="Logo BPBD Katingan">
                    <div>
                        <span class="block font-bold text-sm sm:text-lg text-gray-800">BPBD</span>
                        <span class="block text-xs sm:text-sm text-gray-600">Kab. Katingan</span>
                    </div>
                </a>
            </div>

            <div class="hidden md:block">
                <div class="ml-10 flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'bg-orange-500 text-white' : 'text-gray-700 hover:text-orange-500' }} px-3 py-2 rounded-md text-sm font-medium">Beranda</a>
                    <div x-data="{ open: false }" @click.away="open = false" class="relative">
                        <button @click="open = !open" class="{{ request()->routeIs('visi-misi', 'struktur-organisasi') ? 'bg-orange-500 text-white' : 'text-gray-700 hover:text-orange-500' }} px-3 py-2 rounded-md text-sm font-medium flex items-center focus:outline-none">
                            <span>Profil</span>
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute z-10 -ml-4 mt-3 w-56 transform px-4 sm:px-0 lg:ml-0 lg:left-1/2 lg:-translate-x-1/2"
                             style="display: none;"
                             @click="open = false">
                            <div class="overflow-hidden rounded-lg shadow-lg ring-1 ring-black ring-opacity-5">
                                <div class="relative grid gap-2 bg-white p-4">
                                    <a href="{{route('visi-misi')}}" class="group block rounded-md p-3 transition ease-in-out duration-150 hover:bg-orange-50">
                                        <p class="text-base font-medium text-gray-900 group-hover:text-orange-600">
                                            Visi & Misi
                                        </p>
                                    </a>
                                    <a href="{{route('struktur-organisasi')}}" class="group block rounded-md p-3 transition ease-in-out duration-150 hover:bg-orange-50">
                                        <p class="text-base font-medium text-gray-900 group-hover:text-orange-600">
                                            Struktur Organisasi
                                        </p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{route('berita.index')}}" class="{{ request()->routeIs('berita.*') ? 'bg-orange-500 text-white' : 'text-gray-700 hover:text-orange-500' }} px-3 py-2 rounded-md text-sm font-medium">Berita</a>
                    <a href="{{route('public.agenda.index')}}" class="{{ request()->routeIs('public.agenda.*') ? 'bg-orange-500 text-white' : 'text-gray-700 hover:text-orange-500' }} px-3 py-2 rounded-md text-sm font-medium">Agenda</a>
                    <a href="{{route('galeri.index')}}" class="{{ request()->routeIs('galeri.*') ? 'bg-orange-500 text-white' : 'text-gray-700 hover:text-orange-500' }} px-3 py-2 rounded-md text-sm font-medium">Galeri</a>
                    <a href="{{route('unduhan.index')}}" class="{{ request()->routeIs('unduhan.*') ? 'bg-orange-500 text-white' : 'text-gray-700 hover:text-orange-500' }} px-3 py-2 rounded-md text-sm font-medium">Unduhan</a>
                    <a href="{{route('kontak.index')}}" class="{{ request()->routeIs('kontak.*') ? 'bg-orange-500 text-white' : 'text-gray-700 hover:text-orange-500' }} px-3 py-2 rounded-md text-sm font-medium">Kontak</a>

                </div>
            </div>

            <div class="-mr-1 flex md:hidden">
                <button @click="open = !open" type="button" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-orange-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-orange-500 transition-all duration-200">
                    <span class="sr-only">Buka menu</span>
                    <svg :class="{ 'hidden': open, 'block': !open }" class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg :class="{ 'hidden': !open, 'block': open }" class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-1"
         class="md:hidden border-t border-gray-200" 
         style="display: none;">
        <div class="px-3 pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" 
               class="{{ request()->routeIs('home') ? 'bg-orange-500 text-white' : 'text-gray-700 hover:bg-orange-50 hover:text-orange-600' }} block px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Beranda</span>
                </div>
            </a>

            {{-- Profil Dropdown --}}
            <div x-data="{ openProfil: {{ request()->routeIs('visi-misi', 'struktur-organisasi') ? 'true' : 'false' }} }">
                <button @click="openProfil = !openProfil" 
                        class="{{ request()->routeIs('visi-misi', 'struktur-organisasi') ? 'bg-orange-500 text-white' : 'text-gray-700 hover:bg-orange-50 hover:text-orange-600' }} w-full flex items-center justify-between px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span>Profil</span>
                    </div>
                    <svg :class="{ 'rotate-180': openProfil }" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openProfil" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="mt-1 ml-4 space-y-1"
                     style="display: none;">
                    <a href="{{ route('visi-misi') }}" 
                       class="{{ request()->routeIs('visi-misi') ? 'bg-orange-100 text-orange-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} block px-4 py-2 rounded-lg text-sm transition-all duration-200">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <span>Visi & Misi</span>
                        </div>
                    </a>
                    <a href="{{ route('struktur-organisasi') }}" 
                       class="{{ request()->routeIs('struktur-organisasi') ? 'bg-orange-100 text-orange-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} block px-4 py-2 rounded-lg text-sm transition-all duration-200">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <span>Struktur Organisasi</span>
                        </div>
                    </a>
                </div>
            </div>

            <a href="{{ route('berita.index') }}" 
               class="{{ request()->routeIs('berita.*') ? 'bg-orange-500 text-white' : 'text-gray-700 hover:bg-orange-50 hover:text-orange-600' }} block px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    <span>Berita</span>
                </div>
            </a>

            <a href="{{route('public.agenda.index')}}" 
               class="{{ request()->routeIs('public.agenda.*') ? 'bg-orange-500 text-white' : 'text-gray-700 hover:bg-orange-50 hover:text-orange-600' }} block px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Agenda</span>
                </div>
            </a>

            <a href="{{ route('galeri.index') }}" 
               class="{{ request()->routeIs('galeri.*') ? 'bg-orange-500 text-white' : 'text-gray-700 hover:bg-orange-50 hover:text-orange-600' }} block px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Galeri</span>
                </div>
            </a>

            <a href="{{ route('unduhan.index') }}" 
               class="{{ request()->routeIs('unduhan.*') ? 'bg-orange-500 text-white' : 'text-gray-700 hover:bg-orange-50 hover:text-orange-600' }} block px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Unduhan</span>
                </div>
            </a>

            <a href="{{ route('kontak.index') }}" 
               class="{{ request()->routeIs('kontak.*') ? 'bg-orange-500 text-white' : 'text-gray-700 hover:bg-orange-50 hover:text-orange-600' }} block px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>Kontak</span>
                </div>
            </a>
        </div>
    </div>
</nav>
{{--content--}}
<main>
    @yield('content')
</main>

{{-- Scroll to Top Button --}}
<button
    x-data="{ 
        show: false,
        scrollTimeout: null,
        handleScroll() {
            if (window.pageYOffset > 300) {
                this.show = true;
                clearTimeout(this.scrollTimeout);
                this.scrollTimeout = setTimeout(() => {
                    this.show = false;
                }, 2000);
            } else {
                this.show = false;
            }
        }
    }"
    x-init="window.addEventListener('scroll', () => handleScroll())"
    x-show="show"
    @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4"
    class="fixed bottom-8 right-8 z-50 bg-orange-600 hover:bg-orange-700 text-white p-3 rounded-full shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2"
    style="display: none;"
    aria-label="Scroll to top">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
    </svg>
</button>

{{--footer--}}
<footer class="bg-blue-900 text-white">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-lg font-semibold">BPBD KATINGAN</h3>
                <p class="mt-4 text-blue-200">
                    @if($informasiKontak && $informasiKontak->footer_text)
                        {{ $informasiKontak->footer_text }}
                    @else
                        Badan Penanggulangan Bencana Daerah Kabupaten Katingan. Siap melayani dan melindungi masyarakat dari ancaman bencana.
                    @endif
                </p>
            </div>
            <div>
                <h3 class="text-lg font-semibold">Tautan Cepat</h3>
                <ul class="mt-4 space-y-2">
                    <li><a href="{{ route('visi-misi') }}" class="text-blue-200 hover:text-white transition">Visi & Misi</a></li>
                    <li><a href="{{ route('struktur-organisasi') }}" class="text-blue-200 hover:text-white transition">Struktur Organisasi</a></li>
                    <li><a href="{{ route('berita.index') }}" class="text-blue-200 hover:text-white transition">Berita Terkini</a></li>
                    <li><a href="{{ route('galeri.index') }}" class="text-blue-200 hover:text-white transition">Galeri Kegiatan</a></li>
                    <li><a href="{{ route('kontak.index') }}" class="text-blue-200 hover:text-white transition">Kontak Kami</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold">Hubungi Kami</h3>
                @if($informasiKontak)
                    <div class="mt-4 space-y-3">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 mr-3 text-blue-200 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <p class="text-blue-200">{{ $informasiKontak->alamat }}</p>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-blue-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <p class="text-blue-200">{{ $informasiKontak->telepon }}</p>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-blue-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <p class="text-blue-200">{{ $informasiKontak->email }}</p>
                        </div>
                        @if($informasiKontak->jam_operasional)
                            @php
                                $jamOperasional = is_string($informasiKontak->jam_operasional)
                                    ? json_decode($informasiKontak->jam_operasional, true)
                                    : $informasiKontak->jam_operasional;
                                $jamOperasional = is_array($jamOperasional) ? array_filter($jamOperasional) : [$informasiKontak->jam_operasional];
                            @endphp
                            @if(!empty($jamOperasional))
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 mr-3 text-blue-200 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div class="text-blue-200 text-sm space-y-1">
                                        @foreach($jamOperasional as $jam)
                                            <p>{{ $jam }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>

                    @if($informasiKontak->facebook || $informasiKontak->instagram || $informasiKontak->twitter || $informasiKontak->youtube || $informasiKontak->whatsapp)
                        <div class="mt-4 flex space-x-4">
                            @if($informasiKontak->facebook)
                                <a href="{{ $informasiKontak->facebook }}" target="_blank" class="text-blue-200 hover:text-white transition">
                                    <span class="sr-only">Facebook</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                                </a>
                            @endif
                            @if($informasiKontak->instagram)
                                <a href="{{ $informasiKontak->instagram }}" target="_blank" class="text-blue-200 hover:text-white transition">
                                    <span class="sr-only">Instagram</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.024.06 1.378.06 3.808s-.012 2.784-.06 3.808c-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.024.048-1.378.06-3.808.06s-2.784-.012-3.808-.06c-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.048-1.024-.06-1.378-.06-3.808s.012-2.784.06-3.808c.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 016.345 2.525c.636-.247 1.363-.416 2.427-.465C9.793 2.013 10.147 2 12.315 2zm0 1.623c-2.387 0-2.71.01-3.66.052-.95.043-1.273.052-3.66.052s-2.71-.01-3.66-.052c-1.002-.046-1.503-.208-1.837-.333a3.27 3.27 0 00-1.18-.77 3.27 3.27 0 00-.77-1.18c-.125-.334-.287-.835-.333-1.837C3.633 5.025 3.623 4.702 3.623 2.315s.01-2.71.052-3.66c.046-1.002.208-1.503.333-1.837a3.27 3.27 0 00.77-1.18 3.27 3.27 0 001.18-.77c.334-.125.835-.287 1.837-.333.95-.043 1.273-.052 3.66-.052s2.71.01 3.66.052c1.002.046 1.503.208 1.837.333a3.27 3.27 0 001.18.77 3.27 3.27 0 00.77 1.18c.125.334.287.835.333 1.837.043.95.052 1.273.052 3.66s-.01 2.71-.052 3.66c-.046 1.002-.208 1.503-.333 1.837a3.27 3.27 0 00-.77 1.18 3.27 3.27 0 00-1.18.77c-.334.125-.835.287-1.837.333-.95.043-1.273.052-3.66.052zM12 8.118a3.882 3.882 0 100 7.764 3.882 3.882 0 000-7.764zm0 6.138a2.256 2.256 0 110-4.512 2.256 2.256 0 010 4.512zM16.55 6.304a.96.96 0 100 1.92.96.96 0 000-1.92z" clip-rule="evenodd" /></svg>
                                </a>
                            @endif
                            @if($informasiKontak->twitter)
                                <a href="{{ $informasiKontak->twitter }}" target="_blank" class="text-blue-200 hover:text-white transition">
                                    <span class="sr-only">Twitter</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
                                </a>
                            @endif
                            @if($informasiKontak->youtube)
                                <a href="{{ $informasiKontak->youtube }}" target="_blank" class="text-blue-200 hover:text-white transition">
                                    <span class="sr-only">YouTube</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd" /></svg>
                                </a>
                            @endif
                            @if($informasiKontak->whatsapp)
                                <a href="https://wa.me/{{ $informasiKontak->whatsapp }}" target="_blank" class="text-blue-200 hover:text-white transition">
                                    <span class="sr-only">WhatsApp</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                </a>
                            @endif
                        </div>
                    @endif
                @endif
            </div>
        </div>
        <div class="mt-8 border-t border-blue-800 pt-8 text-center text-blue-200 text-sm">
            &copy; {{ date('Y') }} BPBD Kabupaten Katingan.
        </div>
    </div>
</footer>
</body>
</html>
