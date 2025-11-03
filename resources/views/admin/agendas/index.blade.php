<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-sm sm:text-base md:text-2xl text-orange-600 tracking-tight flex items-center truncate">
                <span class="truncate">{{ __('Agenda Kegiatan') }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="pt-6 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center mb-6 space-y-4 lg:space-y-0">
                        <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                            <div class="bg-blue-50 px-3 py-2 rounded-lg text-center sm:text-left">
                                <span class="text-xs sm:text-sm text-gray-600">Total Agenda:</span>
                                <span class="font-semibold text-blue-600 ml-1 sm:ml-2">{{ $agendas->count() }}</span>
                            </div>
                            <div class="bg-green-50 px-3 py-2 rounded-lg text-center sm:text-left">
                                <span class="text-xs sm:text-sm text-gray-600">Sedang Berlangsung:</span>
                                <span class="font-semibold text-green-600 ml-1 sm:ml-2">{{ $agendas->where('status', 'sedang_berlangsung')->count() }}</span>
                            </div>
                            <div class="bg-yellow-50 px-3 py-2 rounded-lg text-center sm:text-left">
                                <span class="text-xs sm:text-sm text-gray-600">Akan Datang:</span>
                                <span class="font-semibold text-yellow-600 ml-1 sm:ml-2">{{ $agendas->where('status', 'akan_datang')->count() }}</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.agendas.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Agenda
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-80">Judul</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Agenda</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urutan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($agendas as $agenda)
                                    <tr>
                                        <td class="px-6 py-4 w-80">
                                            <div class="text-sm font-medium text-gray-900 truncate">{{ Str::limit($agenda->title, 30) }}</div>
                                            <div class="text-sm text-gray-500 truncate">{{ Str::limit($agenda->description, 50) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $agenda->start_date->format('d M Y') }}
                                            @if($agenda->end_date && $agenda->end_date != $agenda->start_date)
                                                <br><span class="text-gray-500">s/d {{ $agenda->end_date->format('d M Y') }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($agenda->start_time)->format('H:i') }} WIB
                                            @if($agenda->end_time)
                                                - {{ \Carbon\Carbon::parse($agenda->end_time)->format('H:i') }} WIB
                                            @else
                                                - Selesai
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $agenda->location }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $agenda->status_color }}">
                                                {{ $agenda->status_label }}
                                            </span>
                                            @if($agenda->status === 'akan_datang')
                                                @php
                                                    $now = now();
                                                    $startDateTime = $agenda->start_date->copy()->setTimeFromTimeString($agenda->start_time);
                                                    $diff = $now->diff($startDateTime);
                                                @endphp
                                                <div class="text-xs text-gray-500 mt-1">
                                                    {{ $diff->d }}h {{ $diff->h }}j {{ $diff->i }}m lagi
                                                </div>
                                            @elseif($agenda->status === 'sedang_berlangsung')
                                                <div class="text-xs text-green-600 mt-1 flex items-center">
                                                    <div class="w-2 h-2 bg-green-500 rounded-full mr-1 animate-pulse"></div>
                                                    LIVE
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $agenda->sequence }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <x-action-buttons
                                                view-url="{{ route('admin.agendas.show', $agenda) }}"
                                                edit-url="{{ route('admin.agendas.edit', $agenda) }}"
                                                delete-url="{{ route('admin.agendas.destroy', $agenda) }}"
                                                delete-confirm-text="Yakin ingin menghapus agenda ini?"
                                                resource-name="agenda"
                                                size="mb" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            Belum ada agenda yang terdaftar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Legend untuk Status -->
                    <div class="mt-6 bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-4">Keterangan Status Agenda:</h4>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 mr-3">Akan Datang</span>
                                <span class="text-sm text-gray-600">Agenda belum dimulai - Tampil di halaman beranda</span>
                            </div>
                            <div class="flex items-center">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 mr-3">Sedang Berlangsung</span>
                                <span class="text-sm text-gray-600">Agenda sedang berjalan - Tampil di halaman beranda</span>
                            </div>
                            <div class="flex items-center">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 mr-3">Selesai</span>
                                <span class="text-sm text-gray-600">Agenda telah berakhir - Tidak tampil di halaman beranda</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h5 class="text-sm font-medium text-blue-800 mb-1">Catatan Penting:</h5>
                                        <ul class="text-sm text-blue-700 space-y-1">
                                            <li>• Hanya agenda dengan status <strong>"Akan Datang"</strong> dan <strong>"Sedang Berlangsung"</strong> yang akan tampil di halaman beranda</li>
                                            <li>• Maksimal <strong>4 agenda</strong> yang akan ditampilkan di halaman beranda</li>
                                            <li>• Prioritas tampil: <strong>"Sedang Berlangsung"</strong> akan muncul terlebih dahulu</li>
                                            <li>• Status agenda berubah otomatis berdasarkan tanggal dan waktu sistem</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
