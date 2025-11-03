<x-app-layout>
    <x-slot name="header">
        <x-page-title>Edit Agenda Kegiatan</x-page-title>
    </x-slot>

    <div class="pt-6 pb-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Header dengan Status -->
                    <div class="flex justify-between items-start mb-8">
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $agenda->title }}</h1>
                            <p class="text-lg text-gray-600">{{ $agenda->description }}</p>
                        </div>
                        <div class="ml-6">
                            <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium {{ $agenda->status_color }}">
                                {{ $agenda->status_label }}
                            </span>
                        </div>
                    </div>

                    <!-- Detail Informasi -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <!-- Waktu dan Tanggal -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Jadwal
                            </h3>
                            
                            <div class="space-y-4">
                                <!-- Tanggal -->
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tanggal</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <div class="flex items-center">
                                            <span class="font-medium">{{ $agenda->start_date->format('d M Y') }}</span>
                                            @if($agenda->end_date && $agenda->end_date != $agenda->start_date)
                                                <span class="mx-2">-</span>
                                                <span class="font-medium">{{ $agenda->end_date->format('d M Y') }}</span>
                                                <span class="ml-2 text-gray-500">({{ $agenda->start_date->diffInDays($agenda->end_date) + 1 }} hari)</span>
                                            @else
                                                <span class="ml-2 text-gray-500">(1 hari)</span>
                                            @endif
                                        </div>
                                    </dd>
                                </div>

                                <!-- Waktu -->
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Waktu</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <span class="font-medium">{{ \Carbon\Carbon::parse($agenda->start_time)->format('H:i') }} WIB</span>
                                        @if($agenda->end_time)
                                            <span class="mx-2">-</span>
                                            <span class="font-medium">{{ \Carbon\Carbon::parse($agenda->end_time)->format('H:i') }} WIB</span>
                                        @else
                                            <span class="mx-2">-</span>
                                            <span class="text-gray-500">Selesai</span>
                                        @endif
                                    </dd>
                                </div>

                                <!-- Durasi -->
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Durasi</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if($agenda->end_time)
                                            @php
                                                $start = \Carbon\Carbon::parse($agenda->start_time);
                                                $end = \Carbon\Carbon::parse($agenda->end_time);
                                                $duration = $start->diff($end);
                                            @endphp
                                            {{ $duration->h }} jam {{ $duration->i }} menit
                                        @else
                                            <span class="text-gray-500">Tidak ditentukan</span>
                                        @endif
                                    </dd>
                                </div>
                            </div>
                        </div>

                        <!-- Lokasi dan Detail -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Lokasi & Detail
                            </h3>
                            
                            <div class="space-y-4">
                                <!-- Lokasi -->
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Lokasi</dt>
                                    <dd class="mt-1 text-sm text-gray-900 font-medium">{{ $agenda->location }}</dd>
                                </div>

                                <!-- Urutan -->
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Urutan Tampil</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $agenda->sequence }}</dd>
                                </div>

                                <!-- Dibuat -->
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Dibuat</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $agenda->created_at->format('d M Y, H:i') }} WIB</dd>
                                </div>

                                <!-- Terakhir Diubah -->
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Terakhir Diubah</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $agenda->updated_at->format('d M Y, H:i') }} WIB</dd>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Timeline -->
                    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-blue-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Status Agenda
                        </h3>
                        
                        <div class="text-blue-800">
                            @if($agenda->status === 'akan_datang')
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium">Agenda Akan Datang</p>
                                        <p class="text-sm">Agenda ini akan dimulai pada <strong>{{ $agenda->start_date->format('d M Y') }}</strong> pukul <strong>{{ \Carbon\Carbon::parse($agenda->start_time)->format('H:i') }} WIB</strong></p>
                                        @php
                                            $now = now();
                                            
                                            // Gabungkan tanggal dan waktu dengan benar
                                            $startDateTime = \Carbon\Carbon::parse($agenda->start_date->format('Y-m-d') . ' ' . $agenda->start_time);
                                            
                                            if ($startDateTime->isFuture()) {
                                                // Cara yang lebih sederhana dan akurat
                                                $diff = $now->diff($startDateTime);
                                                $days = $diff->days; // Total hari
                                                $hours = $diff->h;   // Sisa jam
                                                $minutes = $diff->i; // Sisa menit
                                            } else {
                                                $days = 0;
                                                $hours = 0;
                                                $minutes = 0;
                                            }
                                        @endphp
                                        <p class="text-sm mt-1">
                                            <span class="font-medium">Countdown:</span> 
                                            @if($startDateTime->isFuture())
                                                {{ $days }} hari, {{ $hours }} jam, {{ $minutes }} menit lagi
                                            @else
                                                <span class="text-red-600">Waktu sudah lewat</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @elseif($agenda->status === 'sedang_berlangsung')
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 w-6 h-6 bg-green-600 rounded-full flex items-center justify-center">
                                        <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                    </div>
                                    <div>
                                        <p class="font-medium">Agenda Sedang Berlangsung</p>
                                        <p class="text-sm">Agenda ini sedang berlangsung dan akan selesai 
                                            @if($agenda->end_date)
                                                pada <strong>{{ $agenda->end_date->format('d M Y') }}</strong>
                                            @else
                                                hari ini
                                            @endif
                                            @if($agenda->end_time)
                                                pukul <strong>{{ \Carbon\Carbon::parse($agenda->end_time)->format('H:i') }} WIB</strong>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 w-6 h-6 bg-gray-400 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium">Agenda Selesai</p>
                                        <p class="text-sm">Agenda ini telah selesai dilaksanakan</p>
                                        @if($agenda->end_date && $agenda->end_time)
                                            <p class="text-sm mt-1">Selesai pada {{ $agenda->end_date->format('d M Y') }} pukul {{ \Carbon\Carbon::parse($agenda->end_time)->format('H:i') }} WIB</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>


                    <!-- Action Buttons -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <!-- Tombol Kembali -->
                            <a href="{{ route('admin.agendas.index') }}" 
                                class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Kembali ke Daftar
                            </a>
                            
                            <!-- Action Buttons -->
                            <x-action-buttons 
                                edit-url="{{ route('admin.agendas.edit', $agenda) }}"
                                delete-url="{{ route('admin.agendas.destroy', $agenda) }}"
                                delete-confirm-text="Yakin ingin menghapus agenda ini? Aksi ini tidak dapat dibatalkan."
                                resource-name="agenda"
                                size="md" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>