<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-sm sm:text-base md:text-2xl text-orange-600 tracking-tight flex items-center truncate">
                {{ __('Panduan Kesiapsiagaan') }}
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
                                <span class="text-xs sm:text-sm text-gray-600">Total Panduan:</span>
                                <span class="font-semibold text-blue-600 ml-1 sm:ml-2">{{ $guides->count() }}</span>
                            </div>
                            <div class="bg-green-50 px-3 py-2 rounded-lg text-center sm:text-left">
                                <span class="text-xs sm:text-sm text-gray-600">Aktif:</span>
                                <span class="font-semibold text-green-600 ml-1 sm:ml-2">{{ $guides->where('is_active', true)->count() }}</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.panduan-bencana.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition duration-300">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                            Tambah Panduan
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($guides as $guide)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <p class="font-semibold text-gray-800">{{ $guide->title }}</p>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('admin.panduan-bencana.toggle', $guide) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                @if($guide->is_active ?? false)
                                                    <button type="submit" class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 hover:bg-green-200">Aktif</button>
                                                @else
                                                    <button type="submit" class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 hover:bg-gray-200">Tidak Aktif</button>
                                                @endif
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <x-action-buttons
                                                edit-url="{{ route('admin.panduan-bencana.edit', $guide) }}"
                                                delete-url="{{ route('admin.panduan-bencana.destroy', $guide) }}"
                                                delete-confirm-text="Apakah Anda yakin ingin menghapus panduan ini?"
                                                resource-name="panduan"
                                                size="mb" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">Data panduan tidak ditemukan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
