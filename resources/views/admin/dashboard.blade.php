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

        </div>
    </div>
</x-app-layout>
