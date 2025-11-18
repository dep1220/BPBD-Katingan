<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-sm sm:text-base md:text-2xl text-orange-600 tracking-tight flex items-center truncate">
                <svg class="mr-2 sm:mr-3 h-5 w-5 sm:h-6 sm:w-6 text-orange-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 8.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 018.25 20.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25A2.25 2.25 0 0113.5 8.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                <span class="truncate">Dashboard BPBD Katingan</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-10 bg-gradient-to-br from-blue-50 via-white to-orange-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Selamat Datang -->
            <div class="bg-gradient-to-r from-blue-600 to-orange-500 text-white rounded-2xl shadow-lg p-6 sm:p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }} 👋</h3>
                            @if(Auth::user()->isSuperAdmin())
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-500 text-white">
                                    👑 Super Admin
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-400 text-white">
                                    👤 Admin
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-blue-100">Semoga harimu produktif dan penuh kesiapsiagaan!</p>
                    </div>
{{--                <img src="https://cdn-icons-png.flaticon.com/512/809/809957.png" class="w-16 h-16 hidden sm:block" alt="BPBD Icon">--}}
                </div>
            </div>

            <!-- Statistik -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                @php
                    $cards = [
                        ['route' => 'admin.sliders.index', 'color' => 'from-orange-400 to-orange-600', 'icon' => '🌅', 'count' => $sliderCount, 'label' => 'Total Slider'],
                        ['route' => 'admin.berita.index', 'color' => 'from-blue-400 to-blue-600', 'icon' => '📰', 'count' => $beritaCount, 'label' => 'Total Berita'],
                        ['route' => 'admin.galeri.index', 'color' => 'from-green-400 to-green-600', 'icon' => '📷', 'count' => $galeriCount, 'label' => 'Total Galeri'],
                        ['route' => 'admin.unduhan.index', 'color' => 'from-purple-400 to-purple-600', 'icon' => '📁', 'count' => $unduhanCount, 'label' => 'Total Unduhan'],
                        ['route' => 'admin.pesan.index', 'color' => 'from-red-400 to-red-600', 'icon' => '📩', 'count' => $pesanBaruCount, 'label' => 'Pesan Baru'],
                    ];
                @endphp

                @foreach ($cards as $card)
                    <a href="{{ route($card['route']) }}"
                       class="relative block bg-gradient-to-br {{ $card['color'] }} text-white rounded-2xl shadow-lg hover:scale-105 transform transition duration-300 overflow-hidden">
                        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/asfalt-dark.png')]"></div>
                        <div class="p-6 relative z-10">
                            <div class="flex items-center justify-between">
                                <div class="text-5xl">{{ $card['icon'] }}</div>
                                <div class="text-right">
                                    <p class="text-3xl font-extrabold">{{ $card['count'] }}</p>
                                    <p class="text-sm font-medium opacity-90">{{ $card['label'] }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Berita Terbaru & Log Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Berita Terbaru -->
                <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                    <h3 class="font-bold text-lg text-gray-800 flex items-center mb-4">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" />
                        </svg>
                        Berita Terbaru
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <tbody class="divide-y divide-gray-200">
                            @forelse ($latestBerita as $berita)
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-gray-800 line-clamp-1" title="{{ $berita->judul }}">
                                            {{ Str::limit($berita->judul, 80) }}
                                        </p>
                                        <p class="text-xs text-gray-500">{{ $berita->created_at->format('d M Y') }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.berita.edit', $berita) }}"
                                           class="text-sm text-blue-600 hover:text-blue-800 font-semibold transition">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-6 text-center text-gray-500 italic">
                                        Belum ada berita terbaru.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Log Activity User -->
                <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-lg text-gray-800 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Log Activity User
                        </h3>
                        <a href="{{ route('admin.activity-logs.index') }}" 
                           class="text-sm text-orange-600 hover:text-orange-800 font-semibold flex items-center">
                            Lihat Semua
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    <div class="overflow-y-auto max-h-96 pr-2 scrollbar-thin scrollbar-thumb-orange-300 scrollbar-track-gray-100">
                        <div class="space-y-3">
                            @forelse ($activityLogs as $log)
                                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg hover:bg-orange-50 transition">
                                    <div class="flex-shrink-0 mt-1">
                                        @if($log->action == 'create')
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </span>
                                        @elseif($log->action == 'update')
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </span>
                                        @elseif($log->action == 'delete')
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </span>
                                        @elseif($log->action == 'login')
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-purple-100 text-purple-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                                </svg>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-800">
                                            {{ $log->user ? $log->user->name : 'System' }}
                                        </p>
                                        <p class="text-sm text-gray-600 line-clamp-1" title="{{ $log->description }}">
                                            {{ $log->description }}
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            {{ $log->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12 text-gray-400">
                                    <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="italic">Belum ada aktivitas</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div> 
</x-app-layout>
