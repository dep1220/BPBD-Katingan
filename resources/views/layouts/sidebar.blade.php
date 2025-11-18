<div class="flex flex-col flex-grow bg-white border-r border-gray-200 pt-5 pb-4 overflow-y-auto">
    <div class="flex items-center justify-center mb-5 space-x-4">
        <a href="{{ route('dashboard') }}">
            <img class="h-10 w-auto" src="{{ asset('images/logo-bpbd.png') }}" alt="Logo BPBD Katingan">
        </a>
        <div class="flex flex-col">
            <span class="text-xl font-bold text-gray-800">BPBD</span>
            <span class="text-xs text-gray-500">Admin Panel</span>
        </div>
    </div>
    <div class="flex-1 flex flex-col mt-6">
        <nav class="flex-1 px-2 space-y-2">
            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}" @class(['flex items-center px-4 py-3 text-m font-semibold rounded-lg transition-all duration-200', 'bg-blue-100 text-blue-700 border-l-4 border-blue-500' => request()->routeIs('dashboard'), 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' => !request()->routeIs('dashboard')])>
                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>

            {{-- Slider --}}
            <a href="{{ route('admin.sliders.index') }}" @class(['flex items-center px-4 py-3 text-m font-semibold rounded-lg transition-all duration-200', 'bg-indigo-100 text-indigo-700 border-l-4 border-indigo-500' => request()->routeIs('admin.sliders.*'), 'text-gray-600 hover:bg-indigo-50 hover:text-indigo-700' => !request()->routeIs('admin.sliders.*')])>
                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                </svg>
                Manajemen Banner
            </a>

            {{-- Panduan Bencana --}}
            <a href="{{ route('admin.panduan-bencana.index') }}" @class(['flex items-center px-4 py-3 text-m font-semibold rounded-lg transition-all duration-200', 'bg-green-100 text-green-700 border-l-4 border-green-500' => request()->routeIs('admin.panduan-bencana.*'), 'text-gray-600 hover:bg-green-50 hover:text-green-700' => !request()->routeIs('admin.panduan-bencana.*')])>
                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                </svg>
                Panduan Bencana
            </a>

            {{-- Agenda Kegiatan --}}
            <a href="{{ route('admin.agendas.index') }}" @class(['flex items-center px-4 py-3 text-m font-semibold rounded-lg transition-all duration-200', 'bg-yellow-100 text-yellow-700 border-l-4 border-yellow-500' => request()->routeIs('admin.agendas.*'), 'text-gray-600 hover:bg-yellow-50 hover:text-yellow-700' => !request()->routeIs('admin.agendas.*')])>
                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Manajemen Agenda
            </a>

            {{-- Berita & Informasi --}}
            <a href="{{ route('admin.berita.index') }}" @class(['flex items-center px-4 py-3 text-m font-semibold rounded-lg transition-all duration-200', 'bg-orange-100 text-orange-700 border-l-4 border-orange-500' => request()->routeIs('admin.berita.*'), 'text-gray-600 hover:bg-orange-50 hover:text-orange-700' => !request()->routeIs('admin.berita.*')])>
                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                Manajemen Berita
            </a>

            {{-- Struktur Organisasi --}}
            <a href="{{ route('admin.struktur-organisasi.index') }}" @class(['flex items-center px-4 py-3 text-m font-semibold rounded-lg transition-all duration-200', 'bg-cyan-100 text-cyan-700 border-l-4 border-cyan-500' => request()->routeIs('admin.struktur-organisasi.*'), 'text-gray-600 hover:bg-cyan-50 hover:text-cyan-700' => !request()->routeIs('admin.struktur-organisasi.*')])>
                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                Struktur Organisasi
            </a>

            {{-- Visi & Misi --}}
            <a href="{{ route('admin.visi-misi.index') }}" @class(['flex items-center px-4 py-3 text-m font-semibold rounded-lg transition-all duration-200', 'bg-pink-100 text-pink-700 border-l-4 border-pink-500' => request()->routeIs('admin.visi-misi.*'), 'text-gray-600 hover:bg-pink-50 hover:text-pink-700' => !request()->routeIs('admin.visi-misi.*')])>
                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
                Visi & Misi
            </a>

            {{-- Galeri Kegiatan --}}
            <a href="{{ route('admin.galeri.index') }}" @class(['flex items-center px-4 py-3 text-m font-semibold rounded-lg transition-all duration-200', 'bg-green-100 text-green-700 border-l-4 border-green-500' => request()->routeIs('admin.galeri.*'), 'text-gray-600 hover:bg-green-50 hover:text-green-700' => !request()->routeIs('admin.galeri.*')])>
                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Manajemen Galeri
            </a>

            {{-- Manajemen Unduhan --}}
            <a href="{{ route('admin.unduhan.index') }}" @class(['flex items-center px-4 py-3 text-m font-semibold rounded-lg transition-all duration-200 whitespace-nowrap', 'bg-rose-100 text-rose-700 border-l-4 border-rose-500' => request()->routeIs('admin.unduhan.*'), 'text-gray-600 hover:bg-rose-50 hover:text-rose-700' => !request()->routeIs('admin.unduhan.*')])>
                <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Manajemen Unduhan
            </a>

            {{-- Pesan Masuk --}}
            <a href="{{ route('admin.pesan.index') }}" @class(['flex items-center px-4 py-3 text-m font-semibold rounded-lg transition-all duration-200', 'bg-purple-100 text-purple-700 border-l-4 border-purple-500' => request()->routeIs('admin.pesan.*'), 'text-gray-600 hover:bg-purple-50 hover:text-purple-700' => !request()->routeIs('admin.pesan.*')])>
                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Pesan Masuk
            </a>

            {{-- Informasi Kontak --}}
            <a href="{{ route('admin.informasi-kontak.index') }}" @class(['flex items-center px-4 py-3 text-m font-semibold rounded-lg transition-all duration-200', 'bg-teal-100 text-teal-700 border-l-4 border-teal-500' => request()->routeIs('admin.informasi-kontak.*'), 'text-gray-600 hover:bg-teal-50 hover:text-teal-700' => !request()->routeIs('admin.informasi-kontak.*')])>
                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                </svg>
                Informasi Kontak
            </a>

            @if(auth()->user()->isSuperAdmin())
                {{-- User Management (Only Super Admin) --}}
                <a href="{{ route('admin.users.index') }}" @class(['flex items-center px-4 py-3 text-m font-semibold rounded-lg transition-all duration-200', 'bg-red-100 text-red-700 border-l-4 border-red-500' => request()->routeIs('admin.users.*'), 'text-gray-600 hover:bg-red-50 hover:text-red-700' => !request()->routeIs('admin.users.*')])>
                    <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    Manajemen User
                </a>
            @endif
        </nav>

        {{-- Quick Links --}}
        <div class="mt-auto px-2 pt-6">
            <div class="space-y-2">
                <div class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    Quick Links
                </div>
                <a href="{{ url('/') }}" target="_blank" class="flex items-center px-4 py-3 text-m font-semibold rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-700 transition-all duration-200">
                    <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Lihat Website
                </a>
            </div>
        </div>
    </div>
</div>
