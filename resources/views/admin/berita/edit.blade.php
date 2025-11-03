<x-app-layout>
    <x-slot name="header">
        <x-page-title>Edit Berita</x-page-title>
    </x-slot>

    <div class="pt-6 pb-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.berita.update', $berita) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Judul -->
                            <div>
                                <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">Judul Berita</label>
                                <textarea id="judul"
                                       name="judul"
                                       rows="2"
                                       class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 resize-none {{ $errors->has('judul') ? 'border-red-500' : 'border-gray-300' }}"
                                       placeholder="Masukkan judul berita" required>{{ old('judul', $berita->judul) }}</textarea>
                                @error('judul')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Konten -->
                            <div>
                                <label for="konten" class="block text-sm font-medium text-gray-700 mb-2">Konten Berita</label>
                                <textarea id="konten"
                                          name="konten"
                                          rows="10"
                                          class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 {{ $errors->has('konten') ? 'border-red-500' : 'border-gray-300' }}"
                                          placeholder="Tulis konten berita..." required>{{ old('konten', $berita->konten) }}</textarea>
                                @error('konten')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gambar -->
                            <div>
                                <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2">Gambar</label>

                                <!-- Current Image or Preview -->
                                <div id="image-preview-container" class="mb-4">
                                    @if($berita->gambar)
                                        <img id="current-image" src="{{ asset('storage/' . $berita->gambar) }}" alt="Current image" class="h-48 w-auto rounded-lg border border-gray-300">
                                        <p class="text-sm text-gray-500 mt-1">Gambar saat ini</p>
                                    @endif
                                    <div id="new-image-preview" class="hidden">
                                        <img id="preview-img" src="" alt="Preview" class="h-48 w-auto rounded-lg border border-gray-300">
                                        <p class="text-sm text-gray-500 mt-1">Preview gambar baru yang dipilih</p>
                                    </div>
                                </div>

                                <input type="file"
                                       id="gambar"
                                       name="gambar"
                                       accept="image/jpg,image/png,image/jpeg"
                                       class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 {{ $errors->has('gambar') ? 'border-red-500' : 'border-gray-300' }}">
                                <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, JPEG (Max: 2MB) - Kosongkan jika tidak ingin mengubah</p>
                                @error('gambar')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status dan Kategori -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Status -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <select id="status"
                                            name="status"
                                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 {{ $errors->has('status') ? 'border-red-500' : 'border-gray-300' }}" required>
                                        <option value="draft" {{ old('status', $berita->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status', $berita->status) == 'published' ? 'selected' : '' }}>Published</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Kategori -->
                                <div>
                                    <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                                    <select id="kategori"
                                            name="kategori"
                                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 {{ $errors->has('kategori') ? 'border-red-500' : 'border-gray-300' }}">
                                        <option value="">Pilih Kategori</option>
                                        @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori['value'] }}" 
                                                {{ old('kategori', !$berita->kategori_custom ? $berita->kategori?->value : null) == $kategori['value'] ? 'selected' : '' }}>
                                                {{ $kategori['icon'] }} {{ $kategori['label'] }}
                                            </option>
                                        @endforeach
                                        <option value="custom" 
                                            {{ old('kategori', $berita->kategori_custom ? 'custom' : null) == 'custom' ? 'selected' : '' }}>
                                            ➕ Kategori Custom
                                        </option>
                                    </select>
                                    @error('kategori')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                    <!-- Custom Kategori Input -->
                                    <div id="custom-kategori-input" 
                                         class="mt-2"
                                         :class="{ 'hidden': document.getElementById('kategori').value !== 'custom' }">
                                        <textarea id="kategori_custom"
                                               name="kategori_custom"
                                               rows="2"
                                               class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 resize-none {{ $errors->has('kategori_custom') ? 'border-red-500' : 'border-gray-300' }}"
                                               placeholder="Masukkan nama kategori custom"
                                               maxlength="100">{{ old('kategori_custom', $berita->kategori_custom) }}</textarea>
                                        @error('kategori_custom')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <x-form-buttons
                                cancel-url="{{ route('admin.berita.index') }}"
                                submit-text="Perbarui Berita" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    console.log('Direct script execution...');

    // Toggle Custom Kategori Input
    document.addEventListener('DOMContentLoaded', function() {
        const kategoriSelect = document.getElementById('kategori');
        const customKategoriInput = document.getElementById('custom-kategori-input');
        const kategoriCustomField = document.getElementById('kategori_custom');

        function toggleCustomInput() {
            if (kategoriSelect.value === 'custom') {
                customKategoriInput.classList.remove('hidden');
                kategoriCustomField.required = true;
            } else {
                customKategoriInput.classList.add('hidden');
                kategoriCustomField.required = false;
                kategoriCustomField.value = '';
            }
        }

        // Initial check
        toggleCustomInput();

        // Listen for changes
        kategoriSelect.addEventListener('change', toggleCustomInput);

        // Image Preview
        const gambarInput = document.getElementById('gambar');
        const currentImage = document.getElementById('current-image');
        const newImagePreview = document.getElementById('new-image-preview');
        const previewImg = document.getElementById('preview-img');

        // Load saved image from localStorage if exists (for reload persistence)
        const savedImage = localStorage.getItem('tempImagePreview_{{ $berita->id }}');
        if (savedImage) {
            previewImg.src = savedImage;
            newImagePreview.classList.remove('hidden');
            if (currentImage) {
                currentImage.parentElement.classList.add('hidden');
            }
        }

        gambarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    newImagePreview.classList.remove('hidden');
                    if (currentImage) {
                        currentImage.parentElement.classList.add('hidden');
                    }
                    // Save to localStorage for reload persistence
                    localStorage.setItem('tempImagePreview_{{ $berita->id }}', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });

        // Clear localStorage on successful form submission
        const form = gambarInput.closest('form');
        form.addEventListener('submit', function() {
            localStorage.removeItem('tempImagePreview_{{ $berita->id }}');
        });
    });

    function initEditor() {
        console.log('TinyMCE check:', typeof tinymce !== 'undefined');

        if (typeof tinymce !== 'undefined') {
            console.log('Initializing TinyMCE...');
            tinymce.init({
                selector: '#konten',
                height: 400,
                menubar: false,
                toolbar_mode: 'scrolling',
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks | fontfamily fontsizeinput | ' +
                        'bold italic backcolor | alignleft aligncenter ' +
                        'alignright alignjustify | bullist numlist outdent indent | ' +
                        'uploadfile | removeformat | help',
                font_family_formats: 'Arial=arial,helvetica,sans-serif; ' +
                        'Arial Black=arial black,avant garde; ' +
                        'Calibri=calibri; ' +
                        'Comic Sans MS=comic sans ms,sans-serif; ' +
                        'Courier New=courier new,courier; ' +
                        'Georgia=georgia,palatino; ' +
                        'Helvetica=helvetica; ' +
                        'Impact=impact,chicago; ' +
                        'Times New Roman=times new roman,times; ' +
                        'Trebuchet MS=trebuchet ms,geneva; ' +
                        'Verdana=verdana,geneva',
                font_size_formats: '8pt 10pt 12pt 14pt 16pt 18pt 24pt 36pt 48pt',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px; word-wrap: break-word; overflow-wrap: break-word; }',
                branding: false,
                promotion: false,
                init_instance_callback: function (editor) {
                    console.log('TinyMCE initialized successfully!');
                },
                setup: function (editor) {
                    // Add custom upload button
                    editor.ui.registry.addButton('uploadfile', {
                        icon: 'upload',
                        tooltip: 'Upload Word/PDF/Text',
                        onAction: function () {
                            var input = document.createElement('input');
                            input.setAttribute('type', 'file');
                            input.setAttribute('accept', '.doc,.docx,.pdf,.txt');

                            input.onchange = function() {
                                var file = this.files[0];
                                if (file) {
                                    uploadAndProcessFile(file, function(content) {
                                        editor.insertContent(content);
                                    });
                                }
                            };

                            input.click();
                        }
                    });

                    editor.on('change', function () {
                        editor.save();
                    });
                }
            });
        } else {
            console.log('TinyMCE not loaded yet, retrying...');
            setTimeout(initEditor, 500);
        }
    }

    // Start initialization
    setTimeout(initEditor, 100);

    function uploadAndProcessFile(file, callback) {
        // Show loading indicator
        if (tinymce.activeEditor) {
            tinymce.activeEditor.setProgressState(true);
        }

        var formData = new FormData();
        formData.append('file', file);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("admin.berita.upload-file") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('HTTP ' + response.status + ': ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            if (tinymce.activeEditor) {
                tinymce.activeEditor.setProgressState(false);
            }

            if (data.success) {
                callback(data.content);

                // Show success message
                if (tinymce.activeEditor) {
                    tinymce.activeEditor.notificationManager.open({
                        text: data.message || 'File berhasil diupload dan dikonversi!',
                        type: 'success',
                        timeout: 3000
                    });
                }
            } else {
                // Show error message
                if (tinymce.activeEditor) {
                    tinymce.activeEditor.notificationManager.open({
                        text: data.message || 'Gagal mengupload file.',
                        type: 'error',
                        timeout: 5000
                    });
                }
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            if (tinymce.activeEditor) {
                tinymce.activeEditor.setProgressState(false);
                tinymce.activeEditor.notificationManager.open({
                    text: 'Terjadi kesalahan saat mengupload file: ' + error.message,
                    type: 'error',
                    timeout: 5000
                });
            }
        });
    }
</script>
