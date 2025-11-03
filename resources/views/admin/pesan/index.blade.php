<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-sm sm:text-base md:text-2xl text-orange-600 tracking-tight flex items-center truncate">
            <span class="truncate">{{ __('Pesan Masuk') }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center mb-6 space-y-4 lg:space-y-0">
                        <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                            <div class="bg-blue-50 px-3 py-2 rounded-lg text-center sm:text-left">
                                <span class="text-xs sm:text-sm text-gray-600">Total Pesan:</span>
                                <span class="font-semibold text-blue-600 ml-1 sm:ml-2">{{ $pesans->total() }}</span>
                            </div>
                            <div class="bg-orange-50 px-3 py-2 rounded-lg text-center sm:text-left">
                                <span class="text-xs sm:text-sm text-gray-600">Belum Dibaca:</span>
                                <span class="font-semibold text-orange-600 ml-1 sm:ml-2">{{ $pesans->where('is_read', false)->count() }}</span>
                            </div>
                            <div class="bg-green-50 px-3 py-2 rounded-lg text-center sm:text-left">
                                <span class="text-xs sm:text-sm text-gray-600">Sudah Dibaca:</span>
                                <span class="font-semibold text-green-600 ml-1 sm:ml-2">{{ $pesans->where('is_read', true)->count() }}</span>
                            </div>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengirim</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subjek</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            @forelse ($pesans as $pesan)
                                <tr class="{{ !$pesan->is_read ? 'bg-orange-50' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p class="font-semibold text-gray-900">{{ $pesan->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $pesan->email }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-gray-800 line-clamp-2" title="{{ $pesan->subject }}">
                                            {{ Str::limit($pesan->subject, 60) }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pesan->created_at->format('d M Y, H:i') }}</td>
                                    <td>
                                    <x-action-buttons
                                            view-url="{{ route('admin.pesan.show', $pesan) }}"
                                            delete-url="{{ route('admin.pesan.destroy', $pesan) }}"
                                            delete-confirm-text="Yakin ingin menghapus Pesan ini?"
                                            resource-name="Pesan"
                                            size="mb" />
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada pesan masuk.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $pesans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
