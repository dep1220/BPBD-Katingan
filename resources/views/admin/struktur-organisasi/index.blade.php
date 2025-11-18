<x-app-layout>
    <x-slot name="header">
        <x-page-title>Struktur Organisasi</x-page-title>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center mb-6 space-y-4 lg:space-y-0">
                        <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                            <div class="bg-blue-50 px-3 py-2 rounded-lg text-center sm:text-left">
                                <span class="text-xs sm:text-sm text-gray-600">Total Anggota:</span>
                                <span class="font-semibold text-blue-600 ml-1 sm:ml-2">{{ $strukturs->total() }}</span>
                            </div>
                            <div class="bg-green-50 px-3 py-2 rounded-lg text-center sm:text-left">
                                <span class="text-xs sm:text-sm text-gray-600">Aktif:</span>
                                <span class="font-semibold text-green-600 ml-1 sm:ml-2">{{ $strukturs->where('is_active', true)->count() }}</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.struktur-organisasi.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition duration-300">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                            Tambah Data
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urutan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($strukturs as $struktur)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($struktur->foto)
                                                <img src="{{ asset('storage/' . $struktur->foto) }}"
                                                     alt="{{ $struktur->nama }}"
                                                     class="h-10 w-10 rounded-full object-cover">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                    <i class="fas fa-user text-gray-500"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ Str::limit($struktur->nama, 10) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $struktur->nip ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div class="flex items-center space-x-2">
                                                @if($struktur->is_ketua)
                                                    <span class="text-lg" title="Ketua/Kepala">👑</span>
                                                @endif
                                                <div class="max-w-xs truncate" title="{{ $struktur->jabatan }}">
                                                    {{ Str::limit($struktur->jabatan, 50) }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $struktur->urutan ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('admin.struktur-organisasi.toggle', $struktur) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                @if($struktur->is_active)
                                                    <button type="submit" class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 hover:bg-green-200 transition-colors duration-200 whitespace-nowrap">
                                                        <i class="fas fa-check-circle mr-1"></i>
                                                        Aktif
                                                    </button>
                                                @else
                                                    <button type="submit" class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 hover:bg-gray-200 transition-colors duration-200 whitespace-nowrap">
                                                        <i class="fas fa-times-circle mr-1"></i>
                                                        Nonaktif
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <x-action-buttons
                                                view-url="{{ route('admin.struktur-organisasi.show', $struktur) }}"
                                                edit-url="{{ route('admin.struktur-organisasi.edit', $struktur) }}"
                                                delete-url="{{ route('admin.struktur-organisasi.destroy', $struktur) }}"
                                                delete-confirm-text="Yakin ingin menghapus data struktur organisasi ini?"
                                                resource-name="struktur organisasi"
                                                size="mb" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada data struktur organisasi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $strukturs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
