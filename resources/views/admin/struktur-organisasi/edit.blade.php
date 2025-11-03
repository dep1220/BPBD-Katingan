<x-app-layout>
    <x-slot name="header">
        <x-page-title>Edit Struktur Organisasi</x-page-title>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.struktur-organisasi.update', $strukturOrganisasi) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-2">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama <span class="text-red-500">*</span></label>
                                        <input type="text"
                                               id="nama"
                                               name="nama"
                                               value="{{ old('nama', $strukturOrganisasi->nama) }}"
                                               required
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nama') @enderror">
                                        @error('nama')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="nip" class="block text-sm font-medium text-gray-700">NIP <span class="text-red-500">*</span></label>
                                        <input type="text"
                                               id="nip"
                                               name="nip"
                                               value="{{ old('nip', $strukturOrganisasi->nip) }}"
                                               required
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nip') @enderror">
                                        @error('nip')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan <span class="text-red-500">*</span></label>
                                        <input type="text"
                                               id="jabatan"
                                               name="jabatan"
                                               value="{{ old('jabatan', $strukturOrganisasi->jabatan) }}"
                                               required
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('jabatan') @enderror">
                                        @error('jabatan')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="tipe_jabatan" class="block text-sm font-medium text-gray-700">Tipe Jabatan <span class="text-red-500">*</span></label>
                                        <select id="tipe_jabatan"
                                                name="tipe_jabatan"
                                                required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('tipe_jabatan') @enderror">
                                            <option value="">Pilih Tipe Jabatan</option>
                                            @foreach($tipeJabatanOptions as $value => $label)
                                                <option value="{{ $value }}" 
                                                    {{ old('tipe_jabatan', !$strukturOrganisasi->tipe_jabatan_custom ? $strukturOrganisasi->tipe_jabatan?->value : null) == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                            <option value="custom" 
                                                {{ old('tipe_jabatan', $strukturOrganisasi->tipe_jabatan_custom ? 'custom' : null) == 'custom' ? 'selected' : '' }}>
                                                ➕ Tipe Jabatan Custom
                                            </option>
                                        </select>
                                        @error('tipe_jabatan')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror

                                        <!-- Custom Tipe Jabatan Input -->
                                        <div id="custom-tipe-jabatan-input" 
                                             class="mt-2 hidden">
                                            <input type="text"
                                                   id="tipe_jabatan_custom"
                                                   name="tipe_jabatan_custom"
                                                   value="{{ old('tipe_jabatan_custom', $strukturOrganisasi->tipe_jabatan_custom) }}"
                                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('tipe_jabatan_custom') @enderror"
                                                   placeholder="Masukkan tipe jabatan custom"
                                                   maxlength="100">
                                            @error('tipe_jabatan_custom')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <label for="urutan" class="block text-sm font-medium text-gray-700">Urutan</label>
                                        <input type="number"
                                               id="urutan"
                                               name="urutan"
                                               value="{{ old('urutan', $strukturOrganisasi->urutan) }}"
                                               min="0"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('urutan') @enderror">
                                        @error('urutan')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-sm text-gray-500">Urutan tampil (semakin kecil semakin atas)</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Status</label>
                                        <div class="mt-2">
                                            <label class="inline-flex items-center">
                                                <input type="checkbox"
                                                       name="is_active"
                                                       value="1"
                                                       {{ old('is_active', $strukturOrganisasi->is_active) ? 'checked' : '' }}
                                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                <span class="ml-2 text-sm text-gray-600">Aktif</span>
                                            </label>
                                        </div>
                                        @error('is_active')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Sambutan Kepala Section (hanya untuk kepala) -->
                                <div class="mt-4 hidden" id="sambutan-section">
                                    <div class="mb-4">
                                        <label for="sambutan_judul" class="block text-sm font-medium text-gray-700">Judul Sambutan</label>
                                        <input type="text"
                                               id="sambutan_judul"
                                               name="sambutan_judul"
                                               value="{{ old('sambutan_judul', $strukturOrganisasi->sambutan_judul ?? 'Bersama Membangun Ketangguhan') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('sambutan_judul') @enderror">
                                        <p class="mt-1 text-sm text-gray-500">Judul untuk sambutan kepala di halaman depan</p>
                                        @error('sambutan_judul')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <label for="sambutan_kepala" class="block text-sm font-medium text-gray-700">Sambutan Kepala</label>
                                    <textarea id="sambutan_kepala"
                                              name="sambutan_kepala"
                                              rows="6"
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('sambutan_kepala') @enderror">{{ old('sambutan_kepala', $strukturOrganisasi->sambutan_kepala) }}</textarea>
                                    @error('sambutan_kepala')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Foto Upload Section -->
                            <div>
                                <div class="mb-4">
                                    <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                                    <input type="file"
                                           id="foto"
                                           name="foto"
                                           accept="image/*"
                                           class="mt-1 block w-full text-sm text-gray-500
                                                  file:mr-4 file:py-2 file:px-4
                                                  file:rounded-full file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-indigo-50 file:text-indigo-700
                                                  hover:file:bg-indigo-100 @error('foto') border-red-500 @enderror">
                                    @error('foto')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-sm text-gray-500">Format: JPEG, PNG, JPG, GIF. Max: 2MB</p>
                                </div>

                                <!-- Foto Preview -->
                                <div class="text-center">
                                    @if($strukturOrganisasi->foto)
                                        <img src="{{ asset('storage/' . $strukturOrganisasi->foto) }}"
                                             id="foto-preview"
                                             class="mx-auto h-48 w-48 rounded-lg object-cover shadow-lg"
                                             alt="Preview">
                                    @else
                                        <div id="foto-preview" class="mx-auto h-48 w-48 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                                            <div class="text-center">
                                                <i class="fas fa-image text-4xl text-gray-400"></i>
                                                <p class="mt-2 text-sm text-gray-500">Belum ada foto</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <x-form-buttons
                            cancel-url="{{ route('admin.struktur-organisasi.index') }}"
                            submit-text="Simpan Struktur Organisasi" />
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const tipeJabatanSelect = document.getElementById('tipe_jabatan');
        const sambutanSection = document.getElementById('sambutan-section');
        const customTipeJabatanInput = document.getElementById('custom-tipe-jabatan-input');
        const tipeJabatanCustomField = document.getElementById('tipe_jabatan_custom');

        // Toggle Custom Tipe Jabatan Input
        function toggleCustomTipeJabatanInput() {
            if (tipeJabatanSelect.value === 'custom') {
                customTipeJabatanInput.classList.remove('hidden');
                tipeJabatanCustomField.required = true;
            } else {
                customTipeJabatanInput.classList.add('hidden');
                tipeJabatanCustomField.required = false;
                tipeJabatanCustomField.value = '';
            }
        }

        // Show/hide sambutan section based on tipe_jabatan
        function toggleSambutanSection() {
            const tipeJabatan = tipeJabatanSelect.value;

            if (tipeJabatan === 'kepala') {
                sambutanSection.classList.remove('hidden');
            } else {
                sambutanSection.classList.add('hidden');
                document.getElementById('sambutan_kepala').value = '';
                document.getElementById('sambutan_judul').value = '';
            }
        }

        // Combined toggle function
        function handleTipeJabatanChange() {
            toggleCustomTipeJabatanInput();
            toggleSambutanSection();
        }

        // Initial check
        handleTipeJabatanChange();

        // Listen for changes
        tipeJabatanSelect.addEventListener('change', handleTipeJabatanChange);

        // Preview foto
        document.getElementById('foto').addEventListener('change', function() {
            const file = this.files[0];
            const preview = document.getElementById('foto-preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.className = 'mx-auto h-48 w-48 rounded-lg object-cover shadow-lg';
                };
                reader.readAsDataURL(file);
            }
        });
    });
    </script>
    @endpush
</x-app-layout>
