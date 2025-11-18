<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-sm sm:text-base md:text-2xl text-orange-600 tracking-tight flex items-center truncate">
            <span class="truncate">{{ __('Manajemen Galeri') }}</span>
        </h2>
    </x-slot>

    <div class="pt-6 pb-12"
         x-data="{
             isOpen: false,
             activeIndex: 0,
             photos: {{ json_encode($galeris->map(function($galeri) {
                 return [
                     'type' => $galeri->tipe,
                     'src' => $galeri->tipe === 'gambar' ? asset('storage/' . $galeri->gambar) : '',
                     'embedUrl' => $galeri->tipe === 'video' ? $galeri->youtube_embed_url : '',
                     'alt' => $galeri->judul
                 ];
             })) }},
             next() {
                 this.activeIndex = (this.activeIndex + 1) % this.photos.length;
             },
             prev() {
                 this.activeIndex = (this.activeIndex - 1 + this.photos.length) % this.photos.length;
             }
         }"
         @keydown.arrow-right.window="if(isOpen) { next() }"
         @keydown.arrow-left.window="if(isOpen) { prev() }">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center mb-6 space-y-4 lg:space-y-0">
                <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-gray-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                        <h2 class="ml-2 sm:ml-3 font-semibold text-xl sm:text-2xl text-gray-800 leading-tight">
                            Daftar Galeri
                        </h2>
                    </div>
                    <span class="ml-0 sm:ml-3 px-2 py-1 text-xs font-semibold text-orange-800 bg-orange-100 rounded-full w-fit">
                        {{ $galeris->total() }} Item
                    </span>
                </div>
                <a href="{{ route('admin.galeri.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition duration-300">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                    Tambah Galeri
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" x-data="{ deleteId: null }">
                @forelse ($galeris as $index => $galeri)
                    <div class="relative group bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="absolute top-2 left-2 z-10 flex gap-2">
                            <span @class(['px-2 py-1 text-xs font-semibold rounded-full', 'bg-green-100 text-green-800' => $galeri->is_active, 'bg-red-100 text-red-800' => !$galeri->is_active])>
                                {{ $galeri->is_active ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                            <span @class(['px-2 py-1 text-xs font-semibold rounded-full', 'bg-blue-100 text-blue-800' => $galeri->tipe === 'gambar', 'bg-red-100 text-red-800' => $galeri->tipe === 'video'])>
                                {{ $galeri->tipe === 'gambar' ? '📷 Gambar' : '🎥 Video' }}
                            </span>
                        </div>

                        <div x-data="{ open: false }" class="absolute top-2 right-2 z-10">
                            <button @click="open = !open" class="p-1 bg-white/70 rounded-full hover:bg-white transition">
                                <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1" style="display: none;">
                                <a href="{{ route('admin.galeri.edit', $galeri) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                                <form action="{{ route('admin.galeri.toggle', $galeri) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ubah Status</button>
                                </form>
                                <button type="button" 
                                        @click="deleteId = {{ $galeri->id }}; open = false" 
                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Hapus
                                </button>
                            </div>
                        </div>

                        <button @click="activeIndex = {{ $index }}; isOpen = true" class="w-full relative">
                            @if($galeri->tipe === 'gambar')
                                <img src="{{ asset('storage/' . $galeri->gambar) }}" alt="{{ $galeri->judul }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="relative w-full h-48 bg-gray-900">
                                    <img src="https://img.youtube.com/vi/{{ preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^&?\/ ]{11})/', $galeri->video_url, $matches) ? $matches[1] : '' }}/maxresdefault.jpg" 
                                         alt="{{ $galeri->judul }}" 
                                         class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="bg-red-600 rounded-full p-4 group-hover:scale-110 transition-transform">
                                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </button>

                        <div class="p-4">
                            <h4 class="font-semibold text-lg text-gray-800 truncate">{{ $galeri->judul }}</h4>
                            <p class="text-sm text-gray-500 mt-1">{{ Str::limit($galeri->deskripsi, 50) }}</p>
                            <p class="text-xs text-gray-400 mt-2">{{ $galeri->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data galeri</h3>
                        <p class="mt-1 text-sm text-gray-500">Silakan tambahkan data galeri baru.</p>
                    </div>
                @endforelse

                <!-- Modal Konfirmasi Hapus - Di Luar Grid -->
                @foreach($galeris as $galeri)
                    <div x-show="deleteId === {{ $galeri->id }}" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         @keydown.escape.window="deleteId = null"
                         class="fixed inset-0 z-[60] overflow-y-auto" 
                         aria-labelledby="modal-title" 
                         role="dialog" 
                         aria-modal="true"
                         style="display: none;">
                        
                        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="deleteId === {{ $galeri->id }}"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 @click="deleteId = null" 
                                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                                 aria-hidden="true"></div>

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                            <div x-show="deleteId === {{ $galeri->id }}"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                 class="inline-block align-bottom bg-slate-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-700">
                                
                                <div class="bg-gradient-to-br from-slate-800 to-slate-900 px-6 pt-6 pb-5 sm:p-8">
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-orange-100">
                                            <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-xl font-bold text-white mb-2" id="modal-title">
                                                127.0.0.1:8000 menyatakan
                                            </h3>
                                            <p class="text-sm text-slate-300 leading-relaxed">
                                                Yakin ingin menghapus Galeri ini?
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-slate-800 px-6 py-4 sm:px-8 sm:py-5 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                                    <button type="button" 
                                            @click="deleteId = null"
                                            class="w-full sm:w-auto inline-flex justify-center items-center rounded-lg px-5 py-2.5 text-sm font-semibold text-slate-300 bg-slate-700 hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-all duration-200 shadow-sm">
                                        Batal
                                    </button>
                                    <form action="{{ route('admin.galeri.destroy', $galeri) }}" method="POST" class="w-full sm:w-auto">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-full inline-flex justify-center items-center rounded-lg px-5 py-2.5 text-sm font-semibold text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 shadow-lg hover:shadow-orange-500/50">
                                            Oke
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $galeris->links() }}
            </div>
        </div>

        <div x-show="isOpen" 
             x-transition 
             @keydown.escape.window="isOpen = false"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-80" 
             style="display: none;">
            <button @click="isOpen = false" class="absolute top-4 right-4 text-white hover:text-gray-300 z-50"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            <button @click="prev()" class="absolute left-4 p-2 text-white bg-black bg-opacity-50 rounded-full hover:bg-opacity-75 z-50"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
            <button @click="next()" class="absolute right-4 p-2 text-white bg-black bg-opacity-50 rounded-full hover:bg-opacity-75 z-50"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
            <div class="relative w-full h-full p-8 md:p-16 flex flex-col items-center justify-center text-center">
                <template x-if="photos[activeIndex]?.type === 'video'">
                    <div class="w-full max-w-4xl">
                        <iframe 
                            :src="photos[activeIndex]?.embedUrl"
                            class="w-full aspect-video rounded-lg shadow-2xl"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen>
                        </iframe>
                        <div class="mt-4 text-center">
                            <a :href="'https://www.youtube.com/watch?v=' + photos[activeIndex]?.embedUrl.match(/embed\/([^?]+)/)?.[1]" 
                               target="_blank" 
                               class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                </svg>
                                Tonton di YouTube
                            </a>
                        </div>
                    </div>
                </template>
                <template x-if="photos[activeIndex]?.type === 'gambar'">
                    <img :src="photos[activeIndex]?.src" class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-2xl">
                </template>
                <p x-text="photos[activeIndex]?.alt" class="mt-4 text-lg text-gray-200" x-transition></p>
            </div>
        </div>
    </div>
</x-app-layout>
