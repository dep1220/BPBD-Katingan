<x-app-layout>
    <x-slot name="header">
        <x-page-title>Edit Unduhan</x-page-title>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('admin.unduhan.update', $unduhan) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- Method untuk update --}}

                        <div class="space-y-6">
                            {{-- Judul Dokumen --}}
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Judul Dokumen <span class="text-red-500">*</span></label>
                                <input type="text" name="title" id="title" value="{{ old('title', $unduhan->title) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('title') @enderror">
                                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            {{-- Kategori --}}
                            <div>
                                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                                <select id="kategori" name="kategori" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('kategori') @enderror">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori['value'] }}" @selected(old('kategori', $unduhan->kategori) == $kategori['value'])>
                                            {{ $kategori['icon'] }} {{ $kategori['label'] }}
                                        </option>
                                    @endforeach
                                    <option value="custom" @selected(old('kategori', $unduhan->kategori) == 'custom' || (!in_array(old('kategori', $unduhan->kategori), ['Laporan', 'SOP', 'Peta', 'Formulir', 'Panduan']) && old('kategori', $unduhan->kategori)))>➕ Kategori Custom</option>
                                </select>
                                @error('kategori')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror

                                {{-- Input Custom Kategori --}}
                                <div id="custom-kategori-input" class="mt-2" style="display: none;">
                                    <input type="text" id="kategori_custom" name="kategori_custom" value="{{ old('kategori_custom', !in_array($unduhan->kategori, ['Laporan', 'SOP', 'Peta', 'Formulir', 'Panduan']) ? $unduhan->kategori : '') }}"
                                           placeholder="Masukkan nama kategori custom..."
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('kategori_custom') @enderror">
                                    <p class="mt-1 text-xs text-gray-500">Contoh: Surat Keputusan, Modul, dll.</p>
                                    @error('kategori_custom')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- File Upload --}}
                            <div>
                                <label for="file" class="block text-sm font-medium text-gray-700">Ganti File (Opsional)</label>
                                <div class="mt-2 text-sm text-gray-600">
                                    File saat ini:
                                    <a href="{{ Storage::url($unduhan->file_path) }}" target="_blank" class="font-medium text-blue-600 hover:underline">
                                        Lihat File
                                    </a>
                                </div>
                                <input type="file" name="file" id="file"
                                       accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                                       class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 @error('file') border-red-500 @enderror">
                                @error('file')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ingin mengubah file. Maksimal: 5MB.</p>
                            </div>

                            {{-- Status --}}
                            <div class="pt-2">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_active" value="1"
                                           class="rounded border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500"
                                        @checked(old('is_active', $unduhan->is_active))>
                                    <span class="ml-2 text-sm text-gray-600">Aktifkan (tampilkan di website publik)</span>
                                </label>
                            </div>
                        </div>

                        <x-form-buttons
                            cancel-url="{{ route('admin.unduhan.index') }}"
                            submit-text="Simpan Perubahan"
                        />
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        // Toggle Custom Kategori Input
        document.addEventListener('DOMContentLoaded', function() {
            const kategoriSelect = document.getElementById('kategori');
            const customKategoriInput = document.getElementById('custom-kategori-input');
            const kategoriCustomField = document.getElementById('kategori_custom');

            function toggleCustomInput() {
                if (kategoriSelect.value === 'custom') {
                    customKategoriInput.style.display = 'block';
                    kategoriCustomField.required = true;
                } else {
                    customKategoriInput.style.display = 'none';
                    kategoriCustomField.required = false;
                    if (kategoriSelect.value !== '') {
                        kategoriCustomField.value = '';
                    }
                }
            }

            toggleCustomInput();
            kategoriSelect.addEventListener('change', toggleCustomInput);
        });
    </script>
    @endpush
</x-app-layout>
