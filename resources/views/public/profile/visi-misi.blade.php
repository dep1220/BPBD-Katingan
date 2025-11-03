@extends('layouts.public')

@section('title', 'Visi & Misi - BPBD Katingan')

@section('content')
    <section class="bg-orange-500">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 md:py-24">
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl">Visi & Misi</h1>
            <p class="mt-3 text-xl text-orange-100">
                @if($visiMisi && $visiMisi->deskripsi_visi)
                    {{ $visiMisi->deskripsi_visi }}
                @else
                    Landasan dan arah gerak Badan Penanggulangan Bencana Daerah Kabupaten Katingan dalam menjalankan tugas dan fungsinya.
                @endif
            </p>
        </div>
    </section>
    
    <section class="py-16 sm:py-24 bg-white">
        <div class="container mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            @if($visiMisi)
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Visi</h2>
                    <blockquote class="mt-6 border-l-4 border-orange-500 pl-6 text-xl italic text-gray-700">
                        "{{ $visiMisi->visi }}"
                    </blockquote>
                </div>

                <div class="mt-16">
                    <h2 class="text-3xl font-bold text-gray-900">Misi</h2>
                    <ul class="mt-8 space-y-10">
                        @foreach($visiMisi->misi as $index => $misi)
                            @php
                                // Split misi jika ada format "Judul - Deskripsi"
                                $parts = explode(' - ', $misi, 2);
                                $judul = $parts[0];
                                $deskripsi = isset($parts[1]) ? $parts[1] : '';
                            @endphp
                            <li class="flex">
                                <div class="flex-shrink-0">
                                    <span class="flex items-center justify-center h-12 w-12 rounded-full bg-blue-800 text-white font-bold text-xl">{{ $index + 1 }}</span>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $judul }}</h3>
                                    @if($deskripsi)
                                        <p class="mt-1 text-gray-600">{{ $deskripsi }}</p>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                {{-- Fallback jika tidak ada data visi misi --}}
                <div class="text-center py-12">
                    <div class="flex items-center justify-center h-16 w-16 bg-orange-100 text-orange-600 rounded-full mx-auto mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Visi & Misi Sedang Dipersiapkan</h3>
                    <p class="text-gray-600 max-w-md mx-auto">
                        Kami sedang mempersiapkan visi dan misi terbaru untuk memberikan informasi yang lebih komprehensif. Silakan kembali lagi nanti.
                    </p>
                </div>

                {{-- Default content sebagai fallback --}}
                <div style="display: none;">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900">Visi</h2>
                        <blockquote class="mt-6 border-l-4 border-orange-500 pl-6 text-xl italic text-gray-700">
                            "Terwujudnya Penyelenggaraan Penanggulangan Bencana yang Handal dan Profesional dalam Melindungi Masyarakat di Kabupaten Katingan."
                        </blockquote>
                    </div>

                    <div class="mt-16">
                        <h2 class="text-3xl font-bold text-gray-900">Misi</h2>
                        <ul class="mt-8 space-y-10">
                            <li class="flex">
                                <div class="flex-shrink-0">
                                    <span class="flex items-center justify-center h-12 w-12 rounded-full bg-blue-800 text-white font-bold text-xl">1</span>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Membangun Sistem Penanggulangan Bencana yang Handal</h3>
                                    <p class="mt-1 text-gray-600">Mengembangkan sistem informasi, komunikasi, dan peringatan dini yang terintegrasi untuk mendukung pengambilan keputusan yang cepat dan tepat.</p>
                                </div>
                            </li>
                            <li class="flex">
                                <div class="flex-shrink-0">
                                    <span class="flex items-center justify-center h-12 w-12 rounded-full bg-blue-800 text-white font-bold text-xl">2</span>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Meningkatkan Kapasitas Sumber Daya</h3>
                                    <p class="mt-1 text-gray-600">Menyelenggarakan pelatihan dan pendidikan secara berkala bagi aparat dan relawan untuk meningkatkan kompetensi dalam setiap fase penanggulangan bencana.</p>
                                </div>
                            </li>
                            <li class="flex">
                                <div class="flex-shrink-0">
                                    <span class="flex items-center justify-center h-12 w-12 rounded-full bg-blue-800 text-white font-bold text-xl">3</span>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Meningkatkan Kesiapsiagaan Masyarakat</h3>
                                    <p class="mt-1 text-gray-600">Melaksanakan program sosialisasi dan edukasi secara masif untuk membangun budaya sadar bencana di seluruh lapisan masyarakat.</p>
                                </div>
                            </li>
                            <li class="flex">
                                <div class="flex-shrink-0">
                                    <span class="flex items-center justify-center h-12 w-12 rounded-full bg-blue-800 text-white font-bold text-xl">4</span>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Mengoptimalkan Upaya Mitigasi Bencana</h3>
                                    <p class="mt-1 text-gray-600">Bekerja sama dengan instansi terkait untuk melakukan kajian risiko dan mendorong implementasi kebijakan pengurangan risiko bencana dalam rencana pembangunan daerah.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
