@extends('layouts.public')

@section('title', 'Galeri Kegiatan - BPBD Katingan')

@section('content')

    <section class="bg-orange-500">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 sm:py-16 md:py-20 lg:py-24">
            <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl md:text-4xl lg:text-5xl">Galeri Kegiatan</h1>
            <p class="mt-3 text-sm sm:text-base md:text-lg lg:text-xl text-orange-100 leading-relaxed">
                Dokumentasi visual dari berbagai kegiatan yang telah kami laksanakan.
            </p>
        </div>
    </section>

    <section class="py-16 sm:py-24 bg-white"
             x-data="{
            isOpen: false,
            activeIndex: 0,
            photos: [
                @foreach($galeris as $index => $galeri)
                    {
                        type: '{{ $galeri->tipe }}',
                        src: '{{ $galeri->tipe === 'gambar' ? asset('storage/' . $galeri->gambar) : '' }}',
                        embedUrl: '{{ $galeri->tipe === 'video' ? $galeri->youtube_embed_url : '' }}',
                        thumbnail: '{{ $galeri->tipe === 'video' ? 'https://img.youtube.com/vi/' . (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^&?\/ ]{11})/', $galeri->video_url, $matches) ? $matches[1] : '') . '/maxresdefault.jpg' : '' }}',
                        alt: '{{ $galeri->judul }}',
                        description: '{{ $galeri->deskripsi }}'
                    }@if(!$loop->last),@endif
                @endforeach
            ],
            next() {
                this.activeIndex = (this.activeIndex + 1) % this.photos.length;
            },
            prev() {
                this.activeIndex = (this.activeIndex - 1 + this.photos.length) % this.photos.length;
            },
            touchStartX: 0,
            handleTouchStart(event) {
                this.touchStartX = event.touches[0].clientX;
            },
            handleTouchEnd(event) {
                const touchEndX = event.changedTouches[0].clientX;
                if (this.touchStartX - touchEndX > 50) { // Swipe left
                    this.next();
                }
                if (touchEndX - this.touchStartX > 50) { // Swipe right
                    this.prev();
                }
            }
        }"
             @keydown.escape.window="isOpen = false"
             @keydown.arrow-right.window="next()"
             @keydown.arrow-left.window="prev()">

        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if($galeris->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
                    <template x-for="(photo, index) in photos" :key="index">
                        <div @click="activeIndex = index; isOpen = true" class="cursor-pointer group block overflow-hidden rounded-lg relative">
                            <template x-if="photo.type === 'gambar'">
                                <img :src="photo.src" :alt="photo.alt" loading="lazy" class="w-full h-full aspect-square object-cover transition duration-300 group-hover:scale-110 group-hover:opacity-80">
                            </template>
                            <template x-if="photo.type === 'video'">
                                <div class="relative w-full aspect-square">
                                    <img :src="photo.thumbnail" :alt="photo.alt" loading="lazy" class="w-full h-full object-cover transition duration-300 group-hover:scale-110 group-hover:opacity-80">
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="bg-red-600 rounded-full p-2.5 sm:p-3 md:p-4 group-hover:scale-110 transition-transform shadow-lg">
                                            <svg class="w-5 h-5 sm:w-6 sm:h-6 md:w-8 md:h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>

                <div class="mt-8 sm:mt-10 md:mt-12">
                    {{ $galeris->links() }}
                </div>
            @else
                <div class="text-center py-12 sm:py-14 md:py-16 px-4">
                    <div class="mx-auto w-20 h-20 sm:w-24 sm:h-24 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-2">Belum Ada Galeri</h3>
                    <p class="text-sm sm:text-base text-gray-500 leading-relaxed">Galeri kegiatan belum tersedia saat ini.</p>
                </div>
            @endif
        </div>

        <!-- Modal untuk menampilkan gambar -->
        <div x-show="isOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-80"
             style="display: none;">

            <button @click="isOpen = false" class="absolute top-2 right-2 sm:top-4 sm:right-4 text-white hover:text-gray-300 z-50 p-2 sm:p-0">
                <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <button @click="prev()" class="absolute left-2 sm:left-4 p-2 sm:p-2.5 text-white bg-black bg-opacity-50 rounded-full hover:bg-opacity-75 z-50 transition-all" x-show="photos.length > 1">
                <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button @click="next()" class="absolute right-2 sm:right-4 p-2 sm:p-2.5 text-white bg-black bg-opacity-50 rounded-full hover:bg-opacity-75 z-50 transition-all" x-show="photos.length > 1">
                <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <div class="relative w-full h-full p-4 sm:p-6 md:p-10 lg:p-16 flex items-center justify-center" @touchstart="handleTouchStart" @touchend="handleTouchEnd">
                <template x-for="(photo, index) in photos" :key="index">
                    <div x-show="activeIndex === index" class="w-full h-full flex flex-col items-center justify-center text-center">
                        <template x-if="photo.type === 'gambar'">
                            <img :src="photo.src" class="max-w-full max-h-[60vh] sm:max-h-[65vh] md:max-h-[70vh] object-contain rounded-lg shadow-2xl">
                        </template>
                        <template x-if="photo.type === 'video'">
                            <div class="w-full max-w-4xl px-2 sm:px-0">
                                <iframe 
                                    :src="photo.embedUrl + '?rel=0&modestbranding=1'"
                                    class="w-full aspect-video rounded-lg shadow-2xl"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen
                                    loading="lazy">
                                </iframe>
                                <div class="mt-3 sm:mt-4 text-center">
                                    <a :href="'https://www.youtube.com/watch?v=' + photo.embedUrl.match(/embed\/([^?]+)/)?.[1]" 
                                       target="_blank" 
                                       class="inline-flex items-center px-3 py-2 sm:px-4 text-sm sm:text-base bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Tonton di YouTube
                                    </a>
                                </div>
                            </div>
                        </template>
                        <div class="mt-3 sm:mt-4 max-w-2xl px-4 sm:px-6">
                            <h3 x-text="photo.alt" class="text-base sm:text-lg md:text-xl font-semibold text-white mb-2" x-transition></h3>
                            <p x-text="photo.description" class="text-sm sm:text-base md:text-lg text-gray-200 leading-relaxed" x-transition x-show="photo.description"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>

@endsection
