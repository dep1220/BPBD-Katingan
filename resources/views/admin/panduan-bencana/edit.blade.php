<x-app-layout>
    <x-slot name="header">
        <x-page-title> Edit Panduan</x-page-title>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.panduan-bencana.update', $panduan_bencana) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            {{-- Judul --}}
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
                                <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('title', $panduan_bencana->title) }}" required>
                            </div>

                            {{-- Deskripsi --}}
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                                <input type="text" name="description" id="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('description', $panduan_bencana->description) }}" required>
                            </div>

                            {{-- Poin-poin Panduan (Dikelola dengan Alpine.js) --}}
                            <div x-data="{ items: {{ json_encode(old('items', $panduan_bencana->items)) }} }">
                                <label class="block text-sm font-medium text-gray-700">Poin-Poin Panduan</label>
                                <div class="mt-2 space-y-2">
                                    <template x-for="(item, index) in items" :key="index">
                                        <div class="flex items-center space-x-2">
                                            <input type="text" name="items[]" x-model="items[index]" class="block w-full rounded-md border-gray-300 shadow-sm">
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
                            submit-text="Perbarui" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>