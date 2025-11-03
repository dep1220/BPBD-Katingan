<x-app-layout>
    <x-slot name="header">
        <x-page-title>Detail Pesan</x-page-title>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                    {{-- Header Pesan --}}
                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-lg sm:text-2xl font-bold text-gray-900">{{ $pesan->subject }}</h3>
                        <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:space-x-6 text-sm text-gray-600">
                            <p><strong>Dari:</strong> {{ $pesan->name }} ({{ $pesan->email }})</p>
                            <p class="mt-2 sm:mt-0"><strong>Telepon:</strong> {{ $pesan->phone ?? '-' }}</p>
                            <p class="mt-2 sm:mt-0"><strong>Kategori:</strong> <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">{{ $pesan->category }}</span></p>
                            <p class="mt-2 sm:mt-0"><strong>Tanggal:</strong> {{ $pesan->created_at->format('d F Y, H:i') }}</p>
                        </div>
                    </div>

                    {{-- Isi Pesan --}}
                    <div class="mt-8 prose max-w-none">
                        <p>{{ $pesan->message }}</p>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                        {{-- Tombol Kembali --}}
                        <a href="{{ route('admin.pesan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
                            Kembali
                        </a>

                        {{-- Tombol Hapus --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <x-action-buttons
                                delete-url="{{ route('admin.pesan.destroy', $pesan) }}"
                                delete-confirm-text="Yakin ingin menghapus Pesan ini?"
                                resource-name="Pesan"
                                size="medium" />
                        </td>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
