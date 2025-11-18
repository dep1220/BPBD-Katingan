<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-sm sm:text-base md:text-2xl text-orange-600 tracking-tight flex items-center truncate">
            <span class="truncate">{{ __('Edit Informasi Kontak') }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.informasi-kontak.update', $informasiKontak) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Informasi Kontak Section -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center border-b pb-2">
                                <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Informasi Kontak
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat <span class="text-red-500">*</span></label>
                                    <textarea id="alamat" name="alamat" rows="3" required class="w-full rounded-lg focus:border-orange-500 focus:ring-orange-500 @error('alamat') border-red-500 @enderror">{{ old('alamat', $informasiKontak->alamat) }}</textarea>
                                    @error('alamat')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="maps_url" class="block text-sm font-medium text-gray-700 mb-2">
                                        Link Koordinat Peta (Google Maps)
                                        <span class="text-gray-500 text-xs font-normal">- Opsional</span>
                                    </label>
                                    <textarea id="maps_url" name="maps_url" rows="3" class="w-full rounded-lg focus:border-orange-500 focus:ring-orange-500 @error('maps_url') border-red-500 @enderror font-mono text-sm" placeholder="Link atau kode embed peta">{{ old('maps_url', $informasiKontak->maps_url) }}</textarea>
                                    <p class="mt-1 text-xs text-gray-500">
                                        <strong>Cara 1 - Salin Link:</strong> Buka Google Maps → Klik "Bagikan" → Salin link (contoh: https://maps.app.goo.gl/xxx)<br>
                                        <strong>Cara 2 - Sematkan Peta:</strong> Buka Google Maps → Klik "Bagikan" → Tab "Sematkan peta" → Salin kode iframe lengkap
                                    </p>
                                    @error('maps_url')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="telepon" class="block text-sm font-medium text-gray-700 mb-2">Telepon <span class="text-red-500">*</span></label>
                                    <input type="text" id="telepon" name="telepon" required value="{{ old('telepon', $informasiKontak->telepon) }}" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 @error('telepon') @enderror" placeholder="0123-4567890">
                                    @error('telepon')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                                    <input type="email" id="email" name="email" required value="{{ old('email', $informasiKontak->email) }}" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 @error('email') @enderror" placeholder="email@bpbd.go.id">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Jam Operasional</label>
                                    <div id="jam-operasional-container">
                                        @php
                                            $jamOperasional = is_array(old('jam_operasional')) ? old('jam_operasional') :
                                                             (is_string($informasiKontak->jam_operasional) ? json_decode($informasiKontak->jam_operasional, true) ?? [$informasiKontak->jam_operasional] :
                                                             [$informasiKontak->jam_operasional]);
                                            $jamOperasional = array_filter($jamOperasional ?? ['']);
                                            if (empty($jamOperasional)) $jamOperasional = [''];
                                        @endphp
                                        @foreach($jamOperasional as $index => $jam)
                                            <div class="jam-operasional-item flex gap-2 mb-2">
                                                <input type="text" name="jam_operasional[]" value="{{ $jam }}" class="flex-1 rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500" placeholder="Senin - Jumat: 08:00 - 16:00 WIB">
                                                <button type="button" onclick="removeJamOperasional(this)" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition {{ $loop->first && $loop->count == 1 ? 'hidden' : '' }}">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" onclick="addJamOperasional()" class="mt-2 inline-flex items-center px-3 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Tambah Jam Operasional
                                    </button>
                                    <p class="mt-1 text-xs text-gray-500">Contoh: Senin - Jumat: 08:00 - 16:00 WIB atau Pusdalops (Pusat Pengendalian Operasi): 24 Jam</p>
                                    @error('jam_operasional')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Media Sosial Section -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center border-b pb-2">
                                <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                Link Media Sosial
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="facebook" class="block text-sm font-medium text-gray-700 mb-2">Facebook</label>
                                    <input type="url" id="facebook" name="facebook" value="{{ old('facebook', $informasiKontak->facebook) }}" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 @error('facebook') @enderror" placeholder="https://facebook.com/bpbd">
                                    @error('facebook')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="instagram" class="block text-sm font-medium text-gray-700 mb-2">Instagram</label>
                                    <input type="url" id="instagram" name="instagram" value="{{ old('instagram', $informasiKontak->instagram) }}" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 @error('instagram') @enderror" placeholder="https://instagram.com/bpbd">
                                    @error('instagram')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="twitter" class="block text-sm font-medium text-gray-700 mb-2">Twitter</label>
                                    <input type="url" id="twitter" name="twitter" value="{{ old('twitter', $informasiKontak->twitter) }}" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 @error('twitter') @enderror" placeholder="https://twitter.com/bpbd">
                                    @error('twitter')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="youtube" class="block text-sm font-medium text-gray-700 mb-2">YouTube</label>
                                    <input type="url" id="youtube" name="youtube" value="{{ old('youtube', $informasiKontak->youtube) }}" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 @error('youtube') @enderror" placeholder="https://youtube.com/@bpbd">
                                    @error('youtube')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-2">WhatsApp</label>
                                    <input type="text" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $informasiKontak->whatsapp) }}" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 @error('whatsapp') @enderror" placeholder="628123456789">
                                    <p class="mt-1 text-xs text-gray-500">Format: 628123456789 (tanpa tanda + atau -)</p>
                                    @error('whatsapp')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Footer Text Section -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center border-b pb-2">
                                <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                Teks Footer
                            </h3>

                            <div>
                                <label for="footer_text" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deskripsi Footer
                                    <span class="text-gray-500 text-xs font-normal">- Opsional</span>
                                </label>
                                <textarea id="footer_text" name="footer_text" rows="3" class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 @error('footer_text') @enderror" placeholder="Badan Penanggulangan Bencana Daerah Kabupaten Katingan. Siap melayani dan melindungi masyarakat dari ancaman bencana.">{{ old('footer_text', $informasiKontak->footer_text) }}</textarea>
                                <p class="mt-1 text-xs text-gray-500">Teks ini akan ditampilkan di bagian footer website. Maksimal 500 karakter.</p>
                                @error('footer_text')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <x-form-buttons
                            cancel-url="{{ route('admin.informasi-kontak.index') }}"
                            submit-text="Update"
                        />
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addJamOperasional() {
            const container = document.getElementById('jam-operasional-container');
            const newItem = document.createElement('div');
            newItem.className = 'jam-operasional-item flex gap-2 mb-2';
            newItem.innerHTML = `
                <input type="text" name="jam_operasional[]" class="flex-1 rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500" placeholder="Senin - Jumat: 08:00 - 16:00 WIB">
                <button type="button" onclick="removeJamOperasional(this)" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            `;
            container.appendChild(newItem);
            updateDeleteButtons();
        }

        function removeJamOperasional(button) {
            const item = button.closest('.jam-operasional-item');
            item.remove();
            updateDeleteButtons();
        }

        function updateDeleteButtons() {
            const items = document.querySelectorAll('.jam-operasional-item');
            items.forEach((item, index) => {
                const deleteBtn = item.querySelector('button[onclick*="removeJamOperasional"]');
                if (items.length > 1) {
                    deleteBtn.classList.remove('hidden');
                } else {
                    deleteBtn.classList.add('hidden');
                }
            });
        }

        // Initialize delete buttons visibility on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateDeleteButtons();
        });
    </script>
</x-app-layout>

