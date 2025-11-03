@extends('layouts.public')

@section('title', 'Struktur Organisasi - BPBD Katingan')

@section('content')

    <section class="bg-orange-500">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 md:py-24">
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl">Struktur Organisasi</h1>
            <p class="mt-3 text-xl text-orange-100">
                Mengenal tim di balik layar yang berdedikasi dalam penanggulangan bencana di Kabupaten Katingan.
            </p>
        </div>
    </section>

    @if($kepalaDinas && $kepalaDinas->sambutan_kepala)
    <section class="bg-gray-50 py-16 sm:py-24">
        <div class="container mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-base font-semibold leading-7 text-orange-600">Sambutan Kepala Pelaksana</h2>
            @if($kepalaDinas->sambutan_judul)
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    {{ $kepalaDinas->sambutan_judul }}
                </p>
            @else
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Bersama Membangun Ketangguhan
                </p>
            @endif
            <blockquote class="mt-8 border-l-4 border-orange-500 pl-6 text-gray-600 italic text-left">
                {!! $kepalaDinas->sambutan_kepala !!}
            </blockquote>
            <div class="mt-8">
                <p class="font-bold text-gray-900">{{ $kepalaDinas->nama }}</p>
                <p class="text-gray-500">{{ $kepalaDinas->jabatan }}</p>
            </div>
        </div>
    </section>
    @endif

    <section class="py-16 sm:py-24 bg-white">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if($strukturOrganisasi && $strukturOrganisasi->flatten()->count() > 0)
                @php
                    // Gabungkan semua data dan urutkan berdasarkan urutan
                    $allStruktur = $strukturOrganisasi->flatten()->sortBy('urutan');
                    $groupedByUrutan = $allStruktur->groupBy('urutan');
                @endphp

                {{-- Wadah utama untuk semua level/baris, dengan jarak vertikal antar baris --}}
                <div class="flex flex-col items-center gap-8">

                    @foreach($groupedByUrutan as $urutan => $people)
                        {{-- Wadah ini bertanggung jawab untuk menata kartu dalam satu baris --}}
                        {{-- Mengurangi jarak antar kartu dari gap-6 menjadi gap-4 --}}
                        <div class="w-full flex flex-row flex-wrap justify-center items-stretch gap-4">

                            @foreach($people->sortBy('id') as $person)
                                {{-- KARTU PROFIL --}}
                                {{-- Menggunakan lebar tetap w-72 agar 4 kartu muat --}}
                                <div class="bg-white rounded-lg shadow-lg p-6 text-center w-72 flex flex-col">

                                    {{-- Foto Profil --}}
                                    <div class="w-40 h-48 mx-auto mb-4 overflow-hidden rounded-lg shadow-md flex-shrink-0">
                                        @if($person->foto_url)
                                            <img src="{{ $person->foto_url }}" alt="{{ $person->nama }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-orange-100 flex items-center justify-center">
                                                <svg class="w-20 h-20 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Informasi Teks (Nama, Jabatan, NIP) --}}
                                    <div class="flex-grow flex flex-col justify-center">
                                        <h3 class="font-bold text-base text-gray-900 mb-1 leading-tight uppercase">{{ $person->nama }}</h3>
                                        <p class="text-orange-600 font-semibold mb-1 text-sm uppercase">{{ $person->jabatan }}</p>
                                        @if(!empty($person->nip))
                                            <p class="text-xs text-gray-600 font-medium">NIP: ********{{ substr($person->nip, -10) }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    @endforeach
                </div>
            @else
                {{-- Pesan jika tidak ada data --}}
                <div class="text-center py-16">
                    <div class="mx-auto w-24 h-24 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Struktur Organisasi Sedang Diperbaharui</h3>
                    <p class="text-gray-500">Informasi struktur organisasi akan segera ditampilkan.</p>
                </div>
            @endif
        </div>
    </section>

@endsection
