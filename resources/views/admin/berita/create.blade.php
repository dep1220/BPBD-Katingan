<x-app-layout>
    <x-slot name="header">
        <x-page-title>Tambah Berita</x-page-title>
    </x-slot>

    <div class="pt-6 pb-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Judul -->
                            <div>
                                <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">Judul Berita</label>
                                <textarea id="judul"
                                       name="judul"
                                       rows="2"
                                       class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 resize-none {{ $errors->has('judul') ? 'border-red-500' : 'border-gray-300' }}"
                                       placeholder="Masukkan judul berita" required>{{ old('judul') }}</textarea>
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
                                          placeholder="Tulis konten berita..." required>{{ old('konten') }}</textarea>
                                @error('konten')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gambar -->
                            <div>
                                <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2">
                                    Gambar <span class="text-red-500">*</span>
                                </label>
                                
                                <!-- Image Preview -->
                                <div id="image-preview" class="mb-4 hidden">
                                    <img id="preview-img" src="" alt="Preview" class="h-48 w-auto rounded-lg border border-gray-300">
                                    <p class="text-sm text-gray-500 mt-1">Preview gambar yang dipilih</p>
                                </div>

                                <input type="file"
                                       id="gambar"
                                       name="gambar"
                                       accept="image/jpg,image/png,image/jpeg"
                                       class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 {{ $errors->has('gambar') ? 'border-red-500' : 'border-gray-300' }}"
                                       required>
                                <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, JPEG (Max: 2MB) - <span class="text-red-500 font-medium">Wajib diisi</span></p>
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
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
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
                                            <option value="{{ $kategori['value'] }}" {{ old('kategori') == $kategori['value'] ? 'selected' : '' }}>
                                                {{ $kategori['icon'] }} {{ $kategori['label'] }}
                                            </option>
                                        @endforeach
                                        <option value="custom" {{ old('kategori') == 'custom' ? 'selected' : '' }}>➕ Kategori Custom</option>
                                    </select>
                                    @error('kategori')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    
                                    <!-- Input Custom Category (Hidden by default) -->
                                    <div id="custom-kategori-input" class="mt-2 hidden">
                                        <textarea id="kategori_custom"
                                               name="kategori_custom"
                                               rows="2"
                                               placeholder="Masukkan nama kategori custom..."
                                               class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 resize-none {{ $errors->has('kategori_custom') ? 'border-red-500' : 'border-gray-300' }}">{{ old('kategori_custom') }}</textarea>
                                        <p class="mt-1 text-xs text-gray-500">Contoh: Seminar, Workshop, dll.</p>
                                        @error('kategori_custom')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <x-form-buttons
                                cancel-url="{{ route('admin.berita.index') }}"
                                submit-text="Simpan Berita" />
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
                customKategoriInput.style.display = 'block';
                kategoriCustomField.required = true;
            } else {
                customKategoriInput.style.display = 'none';
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
        const imagePreview = document.getElementById('image-preview');
        const previewImg = document.getElementById('preview-img');

        gambarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                // Clear preview if no file selected
                previewImg.src = '';
                imagePreview.classList.add('hidden');
            }
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

        console.log('Starting upload...', {
            fileName: file.name,
            fileSize: file.size,
            fileType: file.type
        });

        fetch('{{ route("admin.berita.upload-file") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log('Upload response status:', response.status);
            if (!response.ok) {
                throw new Error('HTTP ' + response.status + ': ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            console.log('Upload response data:', data);
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
