<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-sm sm:text-base md:text-2xl text-orange-600 tracking-tight flex items-center truncate">
            <span class="truncate">{{ __('Informasi Kontak & Media Sosial') }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($kontak)
                        <div class="mb-6 flex justify-end">
                            <x-action-buttons
                                edit-url="{{ route('admin.informasi-kontak.edit', $kontak) }}"
                                :show-delete="false"
                                size="lg"
                            />
                        </div>

                        <!-- Informasi Kontak -->
                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Informasi Kontak
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="text-sm font-medium text-gray-600">Alamat</label>
                                    <p class="text-gray-900 mt-1">{{ $kontak->alamat }}</p>
                                    @if($kontak->maps_url)
                                        @php
                                            // Extract URL from iframe or use direct link
                                            $mapsInput = $kontak->maps_url;
                                            $displayUrl = $mapsInput;
                                            $embedUrl = null;
                                            
                                            // Check if input is an iframe
                                            if (strpos($mapsInput, '<iframe') !== false && strpos($mapsInput, 'src=') !== false) {
                                                // Extract src from iframe - this already has the pin
                                                preg_match('/src=["\']([^"\']+)["\']/', $mapsInput, $matches);
                                                if (!empty($matches[1])) {
                                                    $embedUrl = $matches[1];
                                                    $displayUrl = $embedUrl;
                                                }
                                            } else {
                                                // It's a direct link, convert to embed with pin/marker
                                                $displayUrl = $mapsInput;
                                                
                                                // Handle goo.gl short links - convert to embed format with place marker
                                                if (strpos($mapsInput, 'goo.gl') !== false || strpos($mapsInput, 'maps.app.goo.gl') !== false) {
                                                    // Use the link to create embed with marker (Google will handle short links)
                                                    $embedUrl = "https://www.google.com/maps?output=embed&q=" . urlencode($mapsInput);
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
                                                            // Use query parameter format to show marker at coordinates
                                                            $embedUrl = "https://www.google.com/maps?q={$lat},{$lng}&output=embed";
                                                        }
                                                        elseif (preg_match('/q=(-?\d+\.\d+),(-?\d+\.\d+)/', $mapsInput, $matches)) {
                                                            $lat = $matches[1];
                                                            $lng = $matches[2];
                                                            $embedUrl = "https://www.google.com/maps?q={$lat},{$lng}&output=embed";
                                                        }
                                                        // Try to extract place_id or place name
                                                        elseif (preg_match('/place\/([^\/]+)/', $mapsInput, $matches)) {
                                                            $place = urlencode($matches[1]);
                                                            $embedUrl = "https://www.google.com/maps?output=embed&q={$place}";
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
                                        <a href="{{ strpos($displayUrl, '<iframe') !== false ? '#' : $displayUrl }}" target="_blank" class="inline-flex items-center mt-2 text-sm text-orange-600 hover:text-orange-700 font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Lihat di Peta
                                        </a>
                                        
                                        {{-- Preview Peta --}}
                                        @if($embedUrl)
                                            <div class="mt-4">
                                                <iframe 
                                                    src="{{ $embedUrl }}" 
                                                    width="100%" 
                                                    height="300" 
                                                    style="border:0;" 
                                                    allowfullscreen="" 
                                                    loading="lazy" 
                                                    referrerpolicy="no-referrer-when-downgrade"
                                                    class="rounded-lg shadow-md">
                                                </iframe>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Telepon</label>
                                    <p class="text-gray-900 mt-1">{{ $kontak->telepon }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Email</label>
                                    <p class="text-gray-900 mt-1">{{ $kontak->email }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Jam Operasional</label>
                                    @php
                                        $jamOperasional = is_string($kontak->jam_operasional)
                                            ? json_decode($kontak->jam_operasional, true)
                                            : $kontak->jam_operasional;
                                        $jamOperasional = is_array($jamOperasional) ? $jamOperasional : [$kontak->jam_operasional];
                                    @endphp
                                    @if(!empty(array_filter($jamOperasional)))
                                        @foreach(array_filter($jamOperasional) as $jam)
                                            <p class="text-gray-900 mt-1">{{ $jam }}</p>
                                        @endforeach
                                    @else
                                        <p class="text-gray-900 mt-1">-</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Teks Footer -->
                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                Teks Footer
                            </h3>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Deskripsi Footer</label>
                                <p class="text-gray-900 mt-1">{{ $kontak->footer_text ?? 'Belum diisi' }}</p>
                            </div>
                        </div>

                        <!-- Media Sosial -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                Link Media Sosial
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                    <div class="flex-1 min-w-0">
                                        <label class="text-sm font-medium text-gray-600">Facebook</label>
                                        <p class="text-gray-900 text-sm truncate">{{ $kontak->facebook ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-pink-600 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                    <div class="flex-1 min-w-0">
                                        <label class="text-sm font-medium text-gray-600">Instagram</label>
                                        <p class="text-gray-900 text-sm truncate">{{ $kontak->instagram ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-400 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                    <div class="flex-1 min-w-0">
                                        <label class="text-sm font-medium text-gray-600">Twitter</label>
                                        <p class="text-gray-900 text-sm truncate">{{ $kontak->twitter ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-red-600 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                    </svg>
                                    <div class="flex-1 min-w-0">
                                        <label class="text-sm font-medium text-gray-600">YouTube</label>
                                        <p class="text-gray-900 text-sm truncate">{{ $kontak->youtube ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center md:col-span-2">
                                    <svg class="w-5 h-5 mr-2 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                    </svg>
                                    <div class="flex-1 min-w-0">
                                        <label class="text-sm font-medium text-gray-600">WhatsApp</label>
                                        <p class="text-gray-900 text-sm truncate">{{ $kontak->whatsapp ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada informasi kontak</h3>
                            <p class="mt-1 text-sm text-gray-500">Silakan tambahkan informasi kontak dan media sosial.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.informasi-kontak.create') }}" class="inline-flex items-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Tambah Informasi Kontak
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

