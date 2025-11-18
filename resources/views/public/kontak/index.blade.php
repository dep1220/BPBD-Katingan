@extends('layouts.public')

@section('title', 'Kontak Kami - BPBD Katingan')

@section('content')

    <section class="bg-orange-500">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 sm:py-16 md:py-20 lg:py-24">
            <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl md:text-4xl lg:text-5xl">Hubungi Kami</h1>
            <p class="mt-3 text-sm sm:text-base md:text-lg lg:text-xl text-orange-100 leading-relaxed">
                Kami siap menerima laporan, pertanyaan, dan masukan dari Anda.
            </p>
        </div>
    </section>

    {{-- Ganti bg-white menjadi bg-gray-50 untuk latar belakang utama section --}}
    <section class="py-8 sm:py-12 md:py-16 lg:py-24 bg-gray-50">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Notifikasi Sukses --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform translate-y-2"
                     class="mb-4 sm:mb-6 bg-green-50 border-l-4 border-green-500 rounded-lg p-3 sm:p-4 shadow-lg">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 sm:h-6 sm:w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-2 sm:ml-3 flex-1">
                            <p class="text-xs sm:text-sm font-medium text-green-800">
                                {{ session('success') }}
                            </p>
                        </div>
                        <div class="ml-auto pl-2 sm:pl-3">
                            <button @click="show = false" class="inline-flex text-green-500 hover:text-green-700 focus:outline-none">
                                <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 md:gap-10 lg:gap-16">

                <div
                    {{-- Ganti bg-gray-50 menjadi bg-orange-50 --}}
                    class="p-4 sm:p-6 md:p-8 bg-orange-50 rounded-lg border border-orange-200"
                    x-data="{
                        num1: 0, num2: 0, userAnswer: '',
                        get correctAnswer() { return this.num1 + this.num2; },
                        generateCaptcha() {
                            this.num1 = Math.floor(Math.random() * 10) + 1;
                            this.num2 = Math.floor(Math.random() * 10) + 1;
                            this.userAnswer = '';
                        }
                    }"
                    x-init="generateCaptcha()">

                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Kirim Pesan</h2>
                    <p class="mt-2 text-sm sm:text-base text-gray-600 leading-relaxed">Isi formulir di bawah ini untuk mengirimkan pesan langsung ke tim kami.</p>

                    <form action="{{route('kontak.store')}}" method="POST" class="mt-6 sm:mt-8 space-y-4 sm:space-y-5 md:space-y-6">
                        @csrf
                        {{-- ... (Isi form tetap sama) ... --}}
                        <div>
                            <label for="name" class="block text-xs sm:text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <div class="mt-1"><input type="text" name="name" id="name" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm sm:text-base py-2 sm:py-2.5"></div>
                        </div>
                        <div>
                            <label for="email" class="block text-xs sm:text-sm font-medium text-gray-700">Email</label>
                            <div class="mt-1"><input id="email" name="email" type="email" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm sm:text-base py-2 sm:py-2.5"></div>
                        </div>
                        <div>
                            <label for="phone" class="block text-xs sm:text-sm font-medium text-gray-700">Nomor Telepon <span class="text-gray-400">(Opsional)</span></label>
                            <div class="mt-1">
                                <input type="tel" name="phone" id="phone"
                                       pattern="[0-9]*"
                                       inputmode="numeric"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                       placeholder="Contoh: 081234567890"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm sm:text-base py-2 sm:py-2.5">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Hanya angka yang diperbolehkan</p>
                        </div>
                        <div>
                            <label for="category" class="block text-xs sm:text-sm font-medium text-gray-700">Kategori Pesan</label>
                            <div class="mt-1"><select id="category" name="category" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm sm:text-base py-2 sm:py-2.5"><option>Pilih Kategori</option><option value="pengaduan">Pengaduan</option><option value="kritik">Kritik</option><option value="saran">Saran</option></select></div>
                        </div>
                        <div>
                            <label for="subject" class="block text-xs sm:text-sm font-medium text-gray-700">Subjek</label>
                            <div class="mt-1"><input type="text" name="subject" id="subject" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm sm:text-base py-2 sm:py-2.5"></div>
                        </div>
                        <div>
                            <label for="message" class="block text-xs sm:text-sm font-medium text-gray-700">Pesan</label>
                            <div class="mt-1"><textarea id="message" name="message" rows="4" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm sm:text-base py-2 sm:py-2.5"></textarea></div>
                        </div>
                        <div>
                            <label for="captcha" class="block text-xs sm:text-sm font-medium text-gray-700">Verifikasi: Berapa hasil dari <span x-text="num1"></span> + <span x-text="num2"></span>?</label>
                            <div class="mt-1"><input type="number" name="captcha" id="captcha" x-model="userAnswer" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 text-sm sm:text-base py-2 sm:py-2.5" placeholder="Jawab di sini..."></div>
                            <p x-show="userAnswer && parseInt(userAnswer) !== correctAnswer" class="mt-1 text-xs sm:text-sm text-red-600">Jawaban verifikasi salah.</p>
                        </div>
                        <div>
                            <button type="submit" :disabled="parseInt(userAnswer) !== correctAnswer" class="w-full inline-flex items-center justify-center rounded-md bg-orange-500 px-4 py-2.5 sm:py-3 text-sm sm:text-base font-semibold text-white shadow-sm hover:bg-orange-600 transition disabled:opacity-50 disabled:cursor-not-allowed">Kirim Pesan</button>
                        </div>
                    </form>
                </div>

                {{-- Tambahkan div pembungkus dengan background biru --}}
                <div class="p-4 sm:p-6 md:p-8 bg-blue-50 rounded-lg border border-blue-200">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Informasi Kontak</h2>
                    @if($informasiKontak)
                        <div class="mt-4 sm:mt-6 space-y-4 sm:space-y-5 md:space-y-6 text-gray-600">
                            <div class="flex items-start space-x-3 sm:space-x-4">
                                <div class="flex-shrink-0"><svg class="h-5 w-5 sm:h-6 sm:w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg></div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-900 text-sm sm:text-base">Alamat Kantor</h3>
                                    <p class="text-sm sm:text-base leading-relaxed break-words">{{ $informasiKontak->alamat }}</p>
                                    @if($informasiKontak->maps_url)
                                        @php
                                            $mapsUrl = $informasiKontak->maps_url;
                                            $shareLink = null;
                                            
                                            // If it's an iframe, extract src URL first
                                            if (strpos($mapsUrl, '<iframe') !== false) {
                                                // Use more flexible regex to extract src
                                                if (preg_match('/src=["\'](https:\/\/[^"\']+)["\']/', $mapsUrl, $matches)) {
                                                    $embedUrl = $matches[1];
                                                    
                                                    // Extract coordinates from pb parameter (!3d = latitude, !4d = longitude)
                                                    if (preg_match('/!3d(-?\d+\.\d+)!4d(-?\d+\.\d+)/', $embedUrl, $coords)) {
                                                        $lat = $coords[1];
                                                        $lng = $coords[2];
                                                        $shareLink = "https://www.google.com/maps/search/?api=1&query={$lat},{$lng}";
                                                    } else {
                                                        // If can't extract coords, try alternative pattern
                                                        if (preg_match('/!2d(-?\d+\.\d+)!3d(-?\d+\.\d+)/', $embedUrl, $coords2)) {
                                                            $lng = $coords2[1];
                                                            $lat = $coords2[2];
                                                            $shareLink = "https://www.google.com/maps/search/?api=1&query={$lat},{$lng}";
                                                        }
                                                    }
                                                }
                                            }
                                            // If it's already a regular link (not iframe), use it directly
                                            elseif (strpos($mapsUrl, 'google.com/maps') !== false && strpos($mapsUrl, '/embed') === false) {
                                                $shareLink = $mapsUrl;
                                            }
                                            // If embed URL without iframe tags
                                            elseif (strpos($mapsUrl, 'google.com/maps/embed') !== false) {
                                                if (preg_match('/!3d(-?\d+\.\d+)!4d(-?\d+\.\d+)/', $mapsUrl, $coords)) {
                                                    $lat = $coords[1];
                                                    $lng = $coords[2];
                                                    $shareLink = "https://www.google.com/maps/search/?api=1&query={$lat},{$lng}";
                                                }
                                            }
                                            
                                            // Fallback: if no link generated, create a basic search link
                                            if (!$shareLink) {
                                                $shareLink = '#';
                                            }
                                        @endphp
                                        <a href="{{ $shareLink }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center mt-2 text-xs sm:text-sm text-orange-600 hover:text-orange-700 font-medium transition-colors">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                            </svg>
                                            Lihat di Google Maps
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-start space-x-3 sm:space-x-4">
                                <div class="flex-shrink-0"><svg class="h-5 w-5 sm:h-6 sm:w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg></div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-900 text-sm sm:text-base">Telepon & Email</h3>
                                    <p class="text-sm sm:text-base break-words">Telepon: {{ $informasiKontak->telepon }}</p>
                                    <p class="text-sm sm:text-base break-words">Email: {{ $informasiKontak->email }}</p>
                                </div>
                            </div>
                            @if($informasiKontak->jam_operasional)
                                @php
                                    $jamOperasional = is_string($informasiKontak->jam_operasional)
                                        ? json_decode($informasiKontak->jam_operasional, true)
                                        : $informasiKontak->jam_operasional;
                                    $jamOperasional = is_array($jamOperasional) ? array_filter($jamOperasional) : [$informasiKontak->jam_operasional];
                                @endphp
                                @if(!empty($jamOperasional))
                                    <div class="flex items-start space-x-3 sm:space-x-4">
                                        <div class="flex-shrink-0"><svg class="h-5 w-5 sm:h-6 sm:w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-semibold text-gray-900 text-sm sm:text-base">Jam Operasional</h3>
                                            @foreach($jamOperasional as $jam)
                                                <p class="text-sm sm:text-base break-words">{{ $jam }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    @else
                        <div class="mt-4 sm:mt-6 text-center py-6 sm:py-8">
                            <svg class="mx-auto h-10 w-10 sm:h-12 sm:w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-2 text-sm sm:text-base text-gray-600">Informasi kontak belum tersedia.</p>
                        </div>
                    @endif

                    @if($informasiKontak && $informasiKontak->maps_url)
                        <div class="mt-6 sm:mt-8 md:mt-10">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">Lokasi Kami</h3>
                            @php
                                // Extract URL from iframe or use direct link
                                $mapsInput = $informasiKontak->maps_url;
                                $embedUrl = null;
                                
                                // Check if input is an iframe
                                if (strpos($mapsInput, '<iframe') !== false && strpos($mapsInput, 'src=') !== false) {
                                    // Extract src from iframe - this already has the pin
                                    preg_match('/src=["\']([^"\']+)["\']/', $mapsInput, $matches);
                                    if (!empty($matches[1])) {
                                        $embedUrl = $matches[1];
                                    }
                                } else {
                                    // It's a direct link, convert to embed with pin/marker
                                    
                                    // Handle goo.gl short links - convert to embed format with place marker
                                    if (strpos($mapsInput, 'goo.gl') !== false || strpos($mapsInput, 'maps.app.goo.gl') !== false) {
                                        // Extract the place ID or use the link to create embed with marker
                                        // Google will handle the short link and show the marker
                                        $embedUrl = str_replace('https://maps.app.goo.gl/', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.0!2d113.42!3d-1.87!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x', $mapsInput);
                                        
                                        // Better approach: use place query
                                        $embedUrl = "https://www.google.com/maps/embed/v1/place?key=&q=" . urlencode($mapsInput);
                                        
                                        // Or just use the link directly and let Google redirect with marker
                                        $placeId = str_replace(['https://maps.app.goo.gl/', 'https://goo.gl/maps/'], '', $mapsInput);
                                        $embedUrl = "https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15889.0!2d113.425!3d-1.873!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMcKwNTInMjIuMyJTIDExM8KwMjUnMTIuNCJF!5e0!3m2!1sen!2sid!4v1234567890";
                                    }
                                    // Handle standard Google Maps links
                                    elseif (strpos($mapsInput, 'google.com/maps') !== false) {
                                        // If already embed link, use as is
                                        if (strpos($mapsInput, '/embed') !== false || strpos($mapsInput, 'pb=') !== false) {
                                            $embedUrl = $mapsInput;
                                        } else {
                                            // Extract coordinates and create embed URL with marker
                                            if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $mapsInput, $matches)) {
                                                $lat = $matches[1];
                                                $lng = $matches[2];
                                                // Use place mode to show marker at coordinates
                                                $embedUrl = "https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3989!2d{$lng}!3d{$lat}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zM8KwNTInMjIuMyJTIDExM8KwMjUnMTIuNCJF!5e0!3m2!1sen!2sid";
                                            }
                                            elseif (preg_match('/q=(-?\d+\.\d+),(-?\d+\.\d+)/', $mapsInput, $matches)) {
                                                $lat = $matches[1];
                                                $lng = $matches[2];
                                                $embedUrl = "https://www.google.com/maps?q={$lat},{$lng}&output=embed";
                                            }
                                            // Try to extract place_id
                                            elseif (preg_match('/place\/([^\/]+)/', $mapsInput, $matches)) {
                                                $place = urlencode($matches[1]);
                                                $embedUrl = "https://www.google.com/maps/embed/v1/place?key=&q={$place}";
                                            }
                                            // Fallback: use the full link as query parameter
                                            else {
                                                $embedUrl = "https://www.google.com/maps?output=embed&q=" . urlencode($mapsInput);
                                            }
                                        }
                                    }
                                    // Plain coordinate string like "-1.873,113.425"
                                    elseif (preg_match('/^-?\d+\.\d+,-?\d+\.\d+$/', trim($mapsInput))) {
                                        list($lat, $lng) = explode(',', trim($mapsInput));
                                        $embedUrl = "https://www.google.com/maps?q={$lat},{$lng}&output=embed";
                                    }
                                    // If nothing matches, try as search query
                                    else {
                                        $embedUrl = "https://www.google.com/maps?output=embed&q=" . urlencode($mapsInput);
                                    }
                                }
                            @endphp
                            @if($embedUrl)
                                <iframe
                                    src="{{ $embedUrl }}"
                                    width="100%" height="250" style="border:0; pointer-events: none;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade" class="rounded-lg shadow-md sm:h-[300px] md:h-[350px]">
                                </iframe>
                            @else
                                <div class="bg-gray-100 rounded-lg shadow-md h-[250px] sm:h-[300px] md:h-[350px] flex items-center justify-center">
                                    <div class="text-center text-gray-500 px-4">
                                        <svg class="w-12 h-12 sm:w-16 sm:h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                        </svg>
                                        <p class="text-sm sm:text-base">Format peta tidak valid</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="mt-6 sm:mt-8 md:mt-10">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">Lokasi Kami</h3>
                            <div class="bg-gray-100 rounded-lg shadow-md h-[250px] sm:h-[300px] md:h-[350px] flex items-center justify-center">
                                <div class="text-center text-gray-500 px-4">
                                    <svg class="w-12 h-12 sm:w-16 sm:h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                    </svg>
                                    <p class="text-sm sm:text-base">Peta lokasi belum tersedia</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

@endsection
