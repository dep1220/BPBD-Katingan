<x-app-layout>
    <x-slot name="header">
        <x-page-title>Edit Agenda Kegiatan</x-page-title>
    </x-slot>

    <div class="pt-6 pb-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.agendas.update', $agenda) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Judul -->
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Kegiatan</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $agenda->title) }}" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500" 
                                    placeholder="Masukkan judul kegiatan" required>
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                                <textarea name="description" id="description" rows="4" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500" 
                                    placeholder="Masukkan deskripsi kegiatan" required>{{ old('description', $agenda->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lokasi -->
                            <div class="md:col-span-2">
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                                <input type="text" name="location" id="location" value="{{ old('location', $agenda->location) }}" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500" 
                                    placeholder="Masukkan lokasi kegiatan" required>
                                @error('location')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Mulai -->
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $agenda->start_date->format('Y-m-d')) }}" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500" required>
                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Selesai -->
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai (Opsional)</label>
                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $agenda->end_date?->format('Y-m-d')) }}" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
                                <p class="mt-1 text-xs text-gray-500">Kosongkan jika kegiatan hanya satu hari</p>
                                @error('end_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Waktu Mulai -->
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">Waktu Mulai</label>
                                <input type="time" name="start_time" id="start_time" value="{{ old('start_time', \Carbon\Carbon::parse($agenda->start_time)->format('H:i')) }}" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500" required>
                                @error('start_time')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Waktu Selesai -->
                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">Waktu Selesai (Opsional)</label>
                                <input type="time" name="end_time" id="end_time" value="{{ old('end_time', $agenda->end_time ? \Carbon\Carbon::parse($agenda->end_time)->format('H:i') : '') }}" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
                                <p class="mt-1 text-xs text-gray-500">Kosongkan jika waktu selesai tidak pasti</p>
                                @error('end_time')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Urutan -->
                            <div>
                                <label for="sequence" class="block text-sm font-medium text-gray-700 mb-2">Urutan Tampil</label>
                                <input type="number" name="sequence" id="sequence" value="{{ old('sequence', $agenda->sequence) }}" min="0"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500" required>
                                <p class="mt-1 text-xs text-gray-500">Urutan tampil di halaman depan (0 = paling atas)</p>
                                @error('sequence')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Status Agenda Saat Ini -->
                        <div class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-gray-800">
                                        Status Agenda Saat Ini
                                    </h3>
                                    <div class="mt-1 text-sm text-gray-600">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $agenda->status_color }}">
                                            {{ $agenda->status_label }}
                                        </span>
                                        <span class="ml-2">
                                            @if($agenda->status === 'akan_datang')
                                                Agenda ini akan dimulai pada {{ $agenda->start_date->format('d M Y') }} pukul {{ \Carbon\Carbon::parse($agenda->start_time)->format('H:i') }} WIB
                                            @elseif($agenda->status === 'sedang_berlangsung')
                                                Agenda ini sedang berlangsung dan akan selesai 
                                                @if($agenda->end_date)
                                                    pada {{ $agenda->end_date->format('d M Y') }}
                                                @else
                                                    hari ini
                                                @endif
                                                @if($agenda->end_time)
                                                    pukul {{ \Carbon\Carbon::parse($agenda->end_time)->format('H:i') }} WIB
                                                @endif
                                            @else
                                                Agenda ini telah selesai
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Status Otomatis -->
                        <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">
                                        Catatan Penting
                                    </h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            <li>Status agenda akan otomatis berubah berdasarkan tanggal dan waktu sistem</li>
                                            <li>Hanya agenda dengan status "Akan Datang" dan "Sedang Berlangsung" yang tampil di halaman publik</li>
                                            <li>Agenda dengan status "Selesai" otomatis tidak tampil di halaman publik</li>
                                            <li>Maksimal 4 agenda yang akan tampil dengan prioritas "Sedang Berlangsung" terlebih dahulu</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <x-form-buttons 
                            cancel-url="{{ route('admin.agendas.index') }}"
                            submit-text="Perbarui" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Validasi tanggal akhir tidak boleh lebih kecil dari tanggal mulai
        document.getElementById('start_date').addEventListener('change', function() {
            const startDate = this.value;
            const endDateInput = document.getElementById('end_date');
            
            if (startDate) {
                endDateInput.setAttribute('min', startDate);
                
                // Reset end_date jika lebih kecil dari start_date
                if (endDateInput.value && endDateInput.value < startDate) {
                    endDateInput.value = '';
                }
            }
        });

        // Validasi waktu akhir tidak boleh lebih kecil dari waktu mulai (jika tanggal sama)
        function validateEndTime() {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            const startTime = document.getElementById('start_time').value;
            const endTime = document.getElementById('end_time').value;
            
            // Jika tanggal sama atau end_date kosong (agenda sehari), validasi waktu
            if (startTime && endTime && (!endDate || startDate === endDate)) {
                if (endTime <= startTime) {
                    alert('Waktu selesai harus lebih besar dari waktu mulai');
                    document.getElementById('end_time').value = '';
                }
            }
        }

        document.getElementById('start_time').addEventListener('change', validateEndTime);
        document.getElementById('end_time').addEventListener('change', validateEndTime);
        document.getElementById('end_date').addEventListener('change', validateEndTime);

        // Set minimum date pada load
        window.addEventListener('load', function() {
            const startDate = document.getElementById('start_date').value;
            if (startDate) {
                document.getElementById('end_date').setAttribute('min', startDate);
            }
        });
    </script>
</x-app-layout>