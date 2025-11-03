<x-app-layout>
    <x-slot name="header">
        <x-page-title>Edit Slide</x-page-title>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
                                <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('title', $slider->title) }}" required>
                            </div>
                            <div>
                                <label for="subtitle" class="block text-sm font-medium text-gray-700">Subjudul (Opsional)</label>
                                <input type="text" name="subtitle" id="subtitle" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('subtitle', $slider->subtitle) }}">
                            </div>
                            <div>
                                <label for="link" class="block text-sm font-medium text-gray-700">Link (Opsional)</label>
                                <input type="text" name="link" id="link" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('link', $slider->link) }}" placeholder="/berita/judul-berita">
                            </div>
                            <div>
                                <label for="sequence" class="block text-sm font-medium text-gray-700">Urutan</label>
                                <input type="number" name="sequence" id="sequence" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('sequence', $slider->sequence) }}" required>
                            </div>
                            <div x-data="{ imagePreview: '{{ Storage::url($slider->image) }}' }">
                                <label for="image" class="block text-sm font-medium text-gray-700">Gambar</label>
                                <input type="file" name="image" id="image" class="mt-1 block w-full" @change="imagePreview = URL.createObjectURL($event.target.files[0])">
                                <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah gambar.</p>
                                <div x-show="imagePreview" class="mt-4">
                                    <img :src="imagePreview" class="h-48 w-auto object-cover rounded">
                                </div>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" class="h-4 w-4 text-orange-600 border-gray-300 rounded" @checked(old('is_active', $slider->is_active))>
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">Aktifkan Slide</label>
                            </div>
                        </div>
                        <div class="mt-6">
                            <x-form-buttons 
                                cancel-url="{{ route('admin.sliders.index') }}"
                                submit-text="Perbarui" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
