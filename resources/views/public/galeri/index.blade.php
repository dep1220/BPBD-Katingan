@extends('layouts.public')

@section('title', 'Galeri Kegiatan - BPBD Katingan')

@section('content')

    <section class="bg-orange-500">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 md:py-24">
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl">Galeri Kegiatan</h1>
            <p class="mt-3 text-xl text-orange-100">
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
                        src: '{{ asset('storage/' . $galeri->gambar) }}',
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
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                    <template x-for="(photo, index) in photos" :key="index">
                        <div @click="activeIndex = index; isOpen = true" class="cursor-pointer group block overflow-hidden rounded-lg">
                            <img :src="photo.src" :alt="photo.alt" class="w-full h-full aspect-square object-cover transition duration-300 group-hover:scale-110 group-hover:opacity-80">
                        </div>
                    </template>
                </div>

                <div class="mt-12">
                    {{ $galeris->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="mx-auto w-24 h-24 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Galeri</h3>
                    <p class="text-gray-500">Galeri kegiatan belum tersedia saat ini.</p>
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

            <button @click="isOpen = false" class="absolute top-4 right-4 text-white hover:text-gray-300 z-50">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <button @click="prev()" class="absolute left-4 p-2 text-white bg-black bg-opacity-50 rounded-full hover:bg-opacity-75 z-50" x-show="photos.length > 1">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button @click="next()" class="absolute right-4 p-2 text-white bg-black bg-opacity-50 rounded-full hover:bg-opacity-75 z-50" x-show="photos.length > 1">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <div class="relative w-full h-full p-8 md:p-16 flex items-center justify-center" @touchstart="handleTouchStart" @touchend="handleTouchEnd">
                <template x-for="(photo, index) in photos" :key="index">
                    <div x-show="activeIndex === index" class="w-full h-full flex flex-col items-center justify-center text-center">
                        <img :src="photo.src" class="max-w-full max-h-[70vh] object-contain rounded-lg shadow-2xl">
                        <div class="mt-4 max-w-2xl">
                            <h3 x-text="photo.alt" class="text-xl font-semibold text-white mb-2" x-transition></h3>
                            <p x-text="photo.description" class="text-lg text-gray-200" x-transition x-show="photo.description"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>

@endsection
