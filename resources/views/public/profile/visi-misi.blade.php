@extends('layouts.public')

@section('title', 'Visi & Misi - BPBD Katingan')

@section('content')
    <section class="bg-orange-500">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 sm:py-16 md:py-20 lg:py-24">
            <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl md:text-4xl lg:text-5xl">Visi & Misi</h1>
            <p class="mt-3 text-sm sm:text-base md:text-lg lg:text-xl text-orange-100 leading-relaxed">
                @if($visiMisi && $visiMisi->deskripsi_visi)
                    {{ $visiMisi->deskripsi_visi }}
                @else
                    Landasan dan arah gerak Badan Penanggulangan Bencana Daerah Kabupaten Katingan dalam menjalankan tugas dan fungsinya.
                @endif
            </p>
        </div>
    </section>
    
    <section class="py-12 sm:py-16 md:py-20 lg:py-24 bg-white">
        <div class="container mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            @if($visiMisi)
                <div>
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900">Visi</h2>
                    <blockquote class="mt-4 sm:mt-6 border-l-4 border-orange-500 pl-4 sm:pl-6 text-base sm:text-lg md:text-xl italic text-gray-700 leading-relaxed">
                        "{{ $visiMisi->visi }}"
                    </blockquote>
                </div>

                <div class="mt-12 sm:mt-16">
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900">Misi</h2>
                    <ul class="mt-6 sm:mt-8 space-y-6 sm:space-y-8 md:space-y-10">
                        @foreach($visiMisi->misi as $index => $misi)
                            @php
                                // Split misi jika ada format "Judul - Deskripsi"
                                $parts = explode(' - ', $misi, 2);
                                $judul = $parts[0];
                                $deskripsi = isset($parts[1]) ? $parts[1] : '';
                            @endphp
                            <li class="flex">
                                <div class="flex-shrink-0">
                                    <span class="flex items-center justify-center h-10 w-10 sm:h-12 sm:w-12 rounded-full bg-blue-800 text-white font-bold text-lg sm:text-xl">{{ $index + 1 }}</span>
                                </div>
                                <div class="ml-3 sm:ml-4">
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 leading-tight">{{ $judul }}</h3>
                                    @if($deskripsi)
                                        <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-600 leading-relaxed">{{ $deskripsi }}</p>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                {{-- Fallback jika tidak ada data visi misi --}}
                <div class="text-center py-8 sm:py-12">
                    <div class="flex items-center justify-center h-14 w-14 sm:h-16 sm:w-16 bg-orange-100 text-orange-600 rounded-full mx-auto mb-4 sm:mb-6">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3 px-4">Visi & Misi Sedang Dipersiapkan</h3>
                    <p class="text-sm sm:text-base text-gray-600 max-w-md mx-auto px-4 leading-relaxed">
                        Kami sedang mempersiapkan visi dan misi terbaru untuk memberikan informasi yang lebih komprehensif. Silakan kembali lagi nanti.
                    </p>
                </div>

                {{-- Default content sebagai fallback --}}
                <div style="display: none;">
                    <div>
                        <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900">Visi</h2>
                        <blockquote class="mt-4 sm:mt-6 border-l-4 border-orange-500 pl-4 sm:pl-6 text-base sm:text-lg md:text-xl italic text-gray-700 leading-relaxed">
                            "Terwujudnya Penyelenggaraan Penanggulangan Bencana yang Handal dan Profesional dalam Melindungi Masyarakat di Kabupaten Katingan."
                        </blockquote>
                    </div>

                    <div class="mt-12 sm:mt-16">
                        <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900">Misi</h2>
                        <ul class="mt-6 sm:mt-8 space-y-6 sm:space-y-8 md:space-y-10">
                            <li class="flex">
                                <div class="flex-shrink-0">
                                    <span class="flex items-center justify-center h-10 w-10 sm:h-12 sm:w-12 rounded-full bg-blue-800 text-white font-bold text-lg sm:text-xl">1</span>
                                </div>
                                <div class="ml-3 sm:ml-4">
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 leading-tight">Membangun Sistem Penanggulangan Bencana yang Handal</h3>
                                    <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-600 leading-relaxed">Mengembangkan sistem informasi, komunikasi, dan peringatan dini yang terintegrasi untuk mendukung pengambilan keputusan yang cepat dan tepat.</p>
                                </div>
                            </li>
                            <li class="flex">
                                <div class="flex-shrink-0">
                                    <span class="flex items-center justify-center h-10 w-10 sm:h-12 sm:w-12 rounded-full bg-blue-800 text-white font-bold text-lg sm:text-xl">2</span>
                                </div>
                                <div class="ml-3 sm:ml-4">
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 leading-tight">Meningkatkan Kapasitas Sumber Daya</h3>
                                    <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-600 leading-relaxed">Menyelenggarakan pelatihan dan pendidikan secara berkala bagi aparat dan relawan untuk meningkatkan kompetensi dalam setiap fase penanggulangan bencana.</p>
                                </div>
                            </li>
                            <li class="flex">
                                <div class="flex-shrink-0">
                                    <span class="flex items-center justify-center h-10 w-10 sm:h-12 sm:w-12 rounded-full bg-blue-800 text-white font-bold text-lg sm:text-xl">3</span>
                                </div>
                                <div class="ml-3 sm:ml-4">
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 leading-tight">Meningkatkan Kesiapsiagaan Masyarakat</h3>
                                    <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-600 leading-relaxed">Melaksanakan program sosialisasi dan edukasi secara masif untuk membangun budaya sadar bencana di seluruh lapisan masyarakat.</p>
                                </div>
                            </li>
                            <li class="flex">
                                <div class="flex-shrink-0">
                                    <span class="flex items-center justify-center h-10 w-10 sm:h-12 sm:w-12 rounded-full bg-blue-800 text-white font-bold text-lg sm:text-xl">4</span>
                                </div>
                                <div class="ml-3 sm:ml-4">
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 leading-tight">Mengoptimalkan Upaya Mitigasi Bencana</h3>
                                    <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-600 leading-relaxed">Bekerja sama dengan instansi terkait untuk melakukan kajian risiko dan mendorong implementasi kebijakan pengurangan risiko bencana dalam rencana pembangunan daerah.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
