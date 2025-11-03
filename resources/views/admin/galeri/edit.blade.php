<x-app-layout>
    <x-slot name="header">
        <x-page-title>Edit Item Galeri</x-page-title>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900"
                     x-data="{
                         imagePreview: '{{ $galeri->gambar ? Storage::url($galeri->gambar) : '' }}'
                     }">
                    <form action="{{ route('admin.galeri.update', $galeri) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            {{-- Kolom Kiri: Input Data --}}
                            <div class="md:col-span-2 space-y-6">
                                <div>
                                    <label for="judul" class="block text-sm font-medium text-gray-700">Judul (Opsional)</label>
                                    <input type="text" id="judul" name="judul" value="{{ old('judul', $galeri->judul) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('judul') @enderror">
                                    @error('judul')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
                                    <textarea id="deskripsi" name="deskripsi" rows="8"
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('deskripsi') @enderror">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="pt-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="is_active" value="1"
                                               @checked(old('is_active', $galeri->is_active))
                                               class="rounded border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500">
                                        <span class="ml-2 text-sm text-gray-600">Aktifkan (tampilkan di website publik)</span>
                                    </label>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label for="gambar" class="block text-sm font-medium text-gray-700">Ganti Gambar</label>
                                    <input type="file" id="gambar" name="gambar" accept="image/*"
                                           @change="imagePreview = URL.createObjectURL($event.target.files[0])"
                                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 @error('gambar') border-red-500 @enderror">
                                    @error('gambar')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ingin mengubah gambar. Max: 2MB.</p>
                                </div>
                                <div class="text-center">
                                    <template x-if="!imagePreview">
                                        <div class="mx-auto h-48 w-full rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                                            <div class="text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                                                <p class="mt-2 text-sm text-gray-500">Tidak ada gambar</p>
                                            </div>
                                        </div>
                                    </template>
                                    <template x-if="imagePreview">
                                        <img :src="imagePreview" class="mx-auto h-48 w-auto rounded-lg object-contain shadow-lg" alt="Pratinjau Gambar">
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.galeri.index') }}" class="bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-lg mr-4 hover:bg-gray-300">Batal</a>
                            <button type="submit" class="inline-flex items-center bg-orange-600 hover:bg-orange-700 text-white font-medium py-2 px-4 rounded-lg">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.052-.143z" clip-rule="evenodd" /></svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
