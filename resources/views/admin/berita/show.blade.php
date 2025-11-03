<x-app-layout>
    <x-slot name="header">
        <x-page-title>
            <span class="hidden sm:inline">Detail Berita: <span class="text-orange-600">{{ Str::limit($berita->judul, 60) }}</span></span>
            <span class="sm:hidden">Detail: <span class="text-orange-600">{{ Str::limit($berita->judul, 30) }}</span></span>
        </x-page-title>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Header dengan Status -->
                    <div class="flex justify-between items-start mb-8">
                        <div class="flex-1">
                            <div class="text-sm text-gray-600 space-y-1">
                                <p><strong>Penulis:</strong> {{ $berita->penulis }}</p>
                                <p><strong>Kategori:</strong> 
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $berita->kategori_color }}">
                                        {{ $berita->kategori_icon }} {{ $berita->kategori_label }}
                                    </span>
                                </p>
                                <p><strong>Slug:</strong> {{ $berita->slug }}</p>
                            </div>
                        </div>
                        <div class="ml-6 flex items-center space-x-3">
                            <form action="{{ route('admin.berita.toggle', $berita->slug) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                @if($berita->status === 'published')
                                    <button type="submit" class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800 hover:bg-green-200 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $berita->status_label }}
                                    </button>
                                @else
                                    <button type="submit" class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 hover:bg-yellow-200 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $berita->status_label }}
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>

                    <!-- Gambar -->
                    @if($berita->gambar)
                        <div class="mb-8">
                            <img src="{{ asset('storage/' . $berita->gambar) }}" 
                                 alt="{{ $berita->judul }}" 
                                 class="w-full max-w-2xl h-auto rounded-lg shadow-md">
                        </div>
                    @endif

                    <!-- Konten -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Konten Berita</h3>
                        <div class="prose max-w-none">
                            {!! $berita->konten !!}
                        </div>
                    </div>

                    <!-- Metadata -->
                    <div class="border-t border-gray-200 pt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                            <div>
                                <span class="font-medium">Dibuat:</span>
                                {{ $berita->created_at ? $berita->created_at->format('d M Y, H:i') : '-' }} WIB
                            </div>
                            <div>
                                <span class="font-medium">Terakhir diupdate:</span>
                                {{ $berita->updated_at ? $berita->updated_at->format('d M Y, H:i') : '-' }} WIB
                            </div>
                            @if($berita->published_at)
                                <div>
                                    <span class="font-medium">Dipublikasi:</span>
                                    {{ $berita->published_at->format('d M Y, H:i') }} WIB
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-3">
                            <!-- Tombol Kembali -->
                            <a href="{{ route('admin.berita.index') }}" 
                                class="inline-flex items-center justify-center px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition-colors duration-200 text-sm sm:text-base">
                                <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                <span class="hidden sm:inline ml-2">Kembali ke Daftar</span>
                                <span class="sm:hidden ml-2">Kembali</span>
                            </a>
                            
                            <!-- Action Buttons -->
                            <x-action-buttons 
                                edit-url="{{ route('admin.berita.edit', $berita->slug) }}"
                                delete-url="{{ route('admin.berita.destroy', $berita->slug) }}"
                                delete-confirm-text="Yakin ingin menghapus berita ini? Aksi ini tidak dapat dibatalkan."
                                resource-name="berita"
                                size="md" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>