<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-sm sm:text-base md:text-2xl text-orange-600 leading-tight">
            Berita
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <form method="GET" action="{{ route('admin.berita.index') }}">
                            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-center">
                                <div class="sm:col-span-2">
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan judul..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                </div>
                                <div>
                                    <select name="kategori" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                        <option value="">Semua Kategori</option>
                                        @foreach($kategoriOptions as $kategori)
                                            <option value="{{ $kategori }}" @selected(request('kategori') == $kategori)>{{ $kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button type="submit" class="w-full justify-center rounded-md bg-orange-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-orange-700">Cari</button>
                                    <a href="{{ route('admin.berita.index') }}" class="w-full justify-center text-center rounded-md bg-gray-200 px-3 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-300">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center mb-6 space-y-4 lg:space-y-0">
                        <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                            <div class="bg-blue-50 px-3 py-2 rounded-lg text-center sm:text-left">
                                <span class="text-xs sm:text-sm text-gray-600">Total:</span>
                                <span class="font-semibold text-blue-600 ml-1 sm:ml-2">{{ $totalBeritaCount }}</span>
                            </div>
                            <div class="bg-green-50 px-3 py-2 rounded-lg text-center sm:text-left">
                                <span class="text-xs sm:text-sm text-gray-600">Published:</span>
                                <span class="font-semibold text-green-600 ml-1 sm:ml-2">{{ $publishedCount }}</span>
                            </div>
                            <div class="bg-yellow-50 px-3 py-2 rounded-lg text-center sm:text-left">
                                <span class="text-xs sm:text-sm text-gray-600">Draft:</span>
                                <span class="font-semibold text-yellow-600 ml-1 sm:ml-2">{{ $draftCount }}</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.berita.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                            Tambah Berita
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penulis</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            @forelse ($beritas as $berita)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($berita->gambar)
                                                <div class="flex-shrink-0 h-10 w-10 mr-4">
                                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}">
                                                </div>
                                            @endif
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    {{ Str::limit($berita->judul, 50) }}
                                                </p>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    {{ Str::limit(strip_tags($berita->konten), 80) }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $berita->kategori_color }}">
                                            {{ $berita->kategori_icon }} {{ $berita->kategori_label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('admin.berita.toggle', $berita->slug) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            @if($berita->status === 'published')
                                                <button type="submit" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 hover:bg-green-200 transition">Published</button>
                                            @else
                                                <button type="submit" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 hover:bg-yellow-200 transition">Draft</button>
                                            @endif
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $berita->penulis ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $berita->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <x-action-buttons
                                            view-url="{{ route('admin.berita.show', $berita->slug) }}"
                                            edit-url="{{ route('admin.berita.edit', $berita->slug) }}"
                                            delete-url="{{ route('admin.berita.destroy', $berita->slug) }}"
                                        />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada berita yang cocok dengan pencarian Anda.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $beritas->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
