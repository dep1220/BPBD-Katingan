<x-app-layout>
    <x-slot name="header">
        <x-page-title>Tambah Item Galeri Baru</x-page-title>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900"
                     x-data="{ 
                         imagePreview: null,
                         tipe: 'gambar',
                         videoUrl: ''
                     }">
                    <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            {{-- Kolom Kiri: Input Data --}}
                            <div class="md:col-span-2 space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Tipe Media <span class="text-red-500">*</span></label>
                                    <div class="flex gap-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="tipe" value="gambar" x-model="tipe" checked
                                                   class="rounded-full border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500">
                                            <span class="ml-2 text-sm text-gray-600">📷 Gambar</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="tipe" value="video" x-model="tipe"
                                                   class="rounded-full border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500">
                                            <span class="ml-2 text-sm text-gray-600">🎥 Video YouTube</span>
                                        </label>
                                    </div>
                                    @error('tipe')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="judul" class="block text-sm font-medium text-gray-700">Judul (Opsional)</label>
                                    <input type="text" id="judul" name="judul" value="{{ old('judul') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('judul') @enderror">
                                    @error('judul')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
                                    <textarea id="deskripsi" name="deskripsi" rows="8"
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('deskripsi') @enderror">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="pt-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="is_active" value="1" checked
                                               class="rounded border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500">
                                        <span class="ml-2 text-sm text-gray-600">Aktifkan (tampilkan di website publik)</span>
                                    </label>
                                </div>
                            </div>

                            <div class="space-y-4">
                                {{-- Upload Gambar --}}
                                <div x-show="tipe === 'gambar'">
                                    <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar <span class="text-red-500">*</span></label>
                                    <input type="file" id="gambar" name="gambar" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" @change="imagePreview = URL.createObjectURL($event.target.files[0])"
                                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 @error('gambar') border-red-500 @enderror">
                                    @error('gambar')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, JPEG, GIF, WEBP. Max: 2MB.</p>
                                </div>

                                {{-- Input URL Video YouTube --}}
                                <div x-show="tipe === 'video'">
                                    <label for="video_url" class="block text-sm font-medium text-gray-700">URL Video YouTube <span class="text-red-500">*</span></label>
                                    <input type="url" id="video_url" name="video_url" x-model="videoUrl" placeholder="https://www.youtube.com/watch?v=..."
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('video_url') @enderror">
                                    @error('video_url')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-sm text-gray-500">Contoh: https://www.youtube.com/watch?v=xxxxx atau https://youtu.be/xxxxx</p>
                                    <div class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                        <p class="text-xs text-blue-800">
                                            <strong>⚠️ Catatan:</strong> Pastikan video dapat di-embed. Beberapa video YouTube memiliki pembatasan dan tidak dapat ditampilkan di website lain.
                                        </p>
                                    </div>
                                </div>

                                {{-- Preview Area --}}
                                <div class="text-center">
                                    {{-- Preview Gambar --}}
                                    <template x-if="tipe === 'gambar'">
                                        <div>
                                            <template x-if="!imagePreview">
                                                <div class="mx-auto h-48 w-full rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                                                    <div class="text-center">
                                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                                                        <p class="mt-2 text-sm text-gray-500">Pratinjau Gambar</p>
                                                    </div>
                                                </div>
                                            </template>
                                            <template x-if="imagePreview">
                                                <img :src="imagePreview" class="mx-auto h-48 w-auto rounded-lg object-contain shadow-lg" alt="Pratinjau Gambar">
                                            </template>
                                        </div>
                                    </template>

                                    {{-- Preview Video YouTube --}}
                                    <template x-if="tipe === 'video'">
                                        <div>
                                            <template x-if="!videoUrl">
                                                <div class="mx-auto h-48 w-full rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                                                    <div class="text-center">
                                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15.91 11.672a.375.375 0 010 .656l-5.603 3.113a.375.375 0 01-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112z" /></svg>
                                                        <p class="mt-2 text-sm text-gray-500">Pratinjau Video</p>
                                                    </div>
                                                </div>
                                            </template>
                                            <template x-if="videoUrl">
                                                <iframe 
                                                    :src="videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be') ? 'https://www.youtube.com/embed/' + (videoUrl.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^&?\/ ]{11})/)?.[1] || '') : ''"
                                                    class="mx-auto w-full h-48 rounded-lg shadow-lg"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen>
                                                </iframe>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <x-form-buttons
                            cancel-url="{{ route('admin.galeri.index') }}"
                            submit-text="Simpan Galeri" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
