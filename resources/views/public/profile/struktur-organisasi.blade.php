@extends('layouts.public')

@section('title', 'Struktur Organisasi - BPBD Katingan')

@section('content')

    <section class="bg-orange-500">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 sm:py-16 md:py-20 lg:py-24">
            <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl md:text-4xl lg:text-5xl">Struktur Organisasi</h1>
            <p class="mt-3 text-sm sm:text-base md:text-lg lg:text-xl text-orange-100 leading-relaxed">
                Mengenal tim di balik layar yang berdedikasi dalam penanggulangan bencana di Kabupaten Katingan.
            </p>
        </div>
    </section>

    @if($kepalaDinas && $kepalaDinas->sambutan_kepala)
    <section class="bg-gray-50 py-12 sm:py-16 md:py-20 lg:py-24">
        <div class="container mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-sm sm:text-base font-semibold leading-7 text-orange-600">Sambutan Kepala Pelaksana</h2>
            @if($kepalaDinas->sambutan_judul)
                <p class="mt-2 text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold tracking-tight text-gray-900">
                    {{ $kepalaDinas->sambutan_judul }}
                </p>
            @else
                <p class="mt-2 text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold tracking-tight text-gray-900">
                    Bersama Membangun Ketangguhan
                </p>
            @endif
            <blockquote class="mt-6 sm:mt-8 border-l-4 border-orange-500 pl-4 sm:pl-6 text-sm sm:text-base text-gray-600 italic text-left leading-relaxed">
                {!! clean($kepalaDinas->sambutan_kepala) !!}
            </blockquote>
            <div class="mt-6 sm:mt-8">
                <p class="text-base sm:text-lg font-bold text-gray-900">{{ $kepalaDinas->nama }}</p>
                <p class="text-sm sm:text-base text-gray-500 mt-1">{{ $kepalaDinas->jabatan }}</p>
            </div>
        </div>
    </section>
    @endif

    <section class="py-12 sm:py-16 md:py-20 lg:py-24 bg-white">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if($strukturOrganisasi && $strukturOrganisasi->flatten()->count() > 0)
                @php
                    // Gabungkan semua data dan urutkan berdasarkan urutan
                    $allStruktur = $strukturOrganisasi->flatten()->sortBy('urutan');
                    $groupedByUrutan = $allStruktur->groupBy('urutan');
                @endphp

                {{-- Wadah utama untuk semua level/baris, dengan jarak vertikal antar baris --}}
                <div class="flex flex-col items-center gap-6 sm:gap-8">

                    @foreach($groupedByUrutan as $urutan => $people)
                        {{-- Wadah ini bertanggung jawab untuk menata kartu dalam satu baris --}}
                        {{-- Responsif: 1 kolom di mobile, 2 di tablet, 3-4 di desktop --}}
                        <div class="w-full flex flex-row flex-wrap justify-center items-stretch gap-3 sm:gap-4">

                            @foreach($people->sortBy('id') as $person)
                                {{-- KARTU PROFIL --}}
                                {{-- Mobile: full width dengan max-w, Tablet: 2 kolom, Desktop: 3-4 kolom --}}
                                <div class="bg-white rounded-lg shadow-lg p-4 sm:p-5 md:p-6 text-center w-full sm:w-[calc(50%-0.5rem)] md:w-72 flex flex-col">

                                    {{-- Foto Profil --}}
                                    <div class="w-32 h-40 sm:w-36 sm:h-44 md:w-40 md:h-48 mx-auto mb-3 sm:mb-4 overflow-hidden rounded-lg shadow-md flex-shrink-0">
                                        @if($person->foto_url)
                                            <img src="{{ $person->foto_url }}" alt="{{ $person->nama }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-orange-100 flex items-center justify-center">
                                                <svg class="w-16 h-16 sm:w-18 sm:h-18 md:w-20 md:h-20 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Informasi Teks (Nama, Jabatan, NIP) --}}
                                    <div class="flex-grow flex flex-col justify-center">
                                        <h3 class="font-bold text-sm sm:text-base text-gray-900 mb-1 leading-tight uppercase">{{ $person->nama }}</h3>
                                        <p class="text-orange-600 font-semibold mb-1 text-xs sm:text-sm uppercase leading-tight">{{ $person->jabatan }}</p>
                                        @if(!empty($person->nip))
                                            <p class="text-xs text-gray-600 font-medium mt-1">NIP: ********{{ substr($person->nip, -10) }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    @endforeach
                </div>
            @else
                {{-- Pesan jika tidak ada data --}}
                <div class="text-center py-12 sm:py-16 px-4">
                    <div class="mx-auto w-20 h-20 sm:w-24 sm:h-24 bg-orange-100 rounded-full flex items-center justify-center mb-4 sm:mb-6">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-2">Struktur Organisasi Sedang Diperbaharui</h3>
                    <p class="text-sm sm:text-base text-gray-500 leading-relaxed">Informasi struktur organisasi akan segera ditampilkan.</p>
                </div>
            @endif
        </div>
    </section>

@endsection
