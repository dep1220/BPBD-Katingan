<x-app-layout>
    <x-slot name="header">
        <x-page-title>Edit Visi & Misi</x-page-title>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.visi-misi.update', $visiMisi) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div>
                                <label for="visi" class="block text-sm font-medium text-gray-700 mb-2">Visi <span class="text-red-500">*</span></label>
                                <textarea name="visi" id="visi" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500" required>{{ old('visi', $visiMisi->visi ?? '') }}</textarea>
                            </div>

                            <div x-data="{ misiItems: {{ json_encode(old('misi', $visiMisi->misi ?? [''])) }} }">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Misi <span class="text-red-500">*</span></label>

                                <div class="space-y-3">
                                    <template x-for="(item, index) in misiItems" :key="index">
                                        <div class="flex items-start space-x-3">
                                            <span class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-medium mt-1" x-text="index + 1"></span>
                                            <div class="flex-1">
                                                <textarea name="misi[]" rows="3" x-model="misiItems[index]" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500" :placeholder="'Masukkan misi ke-' + (index + 1) + '...'" required></textarea>
                                            </div>
                                            <button type="button" @click="misiItems.splice(index, 1)" x-show="misiItems.length > 1" class="flex-shrink-0 text-red-600 hover:text-red-800 p-2">
                                                {{-- Ikon Sampah SVG --}}
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>

                                <button type="button" @click="misiItems.push('')" class="mt-4 inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                                    {{-- Ikon Tambah SVG --}}
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                    Tambah Misi
                                </button>
                                <p class="text-xs text-gray-500 mt-2">Gunakan format: Judul - Deskripsi (opsional). Contoh: "Meningkatkan Pelayanan - Dengan pendekatan terpadu"</p>
                            </div>

                            <x-form-buttons
                                cancel-url="{{ route('admin.visi-misi.index') }}"
                                submit-text="Simpan Visi-Misi" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
