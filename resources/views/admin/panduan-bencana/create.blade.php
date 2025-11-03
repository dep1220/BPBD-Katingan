<x-app-layout>
    <x-slot name="header">
        <x-page-title>Tambah Panduan Baru</x-page-title>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.panduan-bencana.store') }}" method="POST">
                        @csrf
                        
                        <div class="space-y-6">
                            {{-- Judul --}}
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
                                <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('title') }}" required>
                            </div>

                            {{-- Deskripsi --}}
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                                <input type="text" name="description" id="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('description') }}" required>
                            </div>
                            
                            {{-- Urutan --}}
                             <div>
                                <label for="sequence" class="block text-sm font-medium text-gray-700">Urutan</label>
                                <input type="number" name="sequence" id="sequence" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('sequence', 0) }}" required>
                            </div>

                            {{-- Poin-poin Panduan (Dikelola dengan Alpine.js) --}}
                            <div x-data="{ items: {{ json_encode(old('items', [''])) }} }">
                                <label class="block text-sm font-medium text-gray-700">Poin-Poin Panduan</label>
                                <div class="mt-2 space-y-2">
                                    <template x-for="(item, index) in items" :key="index">
                                        <div class="flex items-center space-x-2">
                                            <input type="text" name="items[]" x-model="items[index]" class="block w-full rounded-md border-gray-300 shadow-sm" placeholder="Tulis poin di sini...">
                                            <button type="button" @click="items.splice(index, 1)" class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">&times;</button>
                                        </div>
                                    </template>
                                </div>
                                <button type="button" @click="items.push('')" class="mt-2 text-sm font-semibold text-blue-600 hover:text-blue-800">+ Tambah Poin</button>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <x-form-buttons 
                            cancel-url="{{ route('admin.panduan-bencana.index') }}"
                            submit-text="Simpan" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>