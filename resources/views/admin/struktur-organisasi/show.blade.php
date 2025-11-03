<x-app-layout>
    <x-slot name="header">
        <x-page-title>Detail Struktur Organisasi</x-page-title>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            @if($strukturOrganisasi->foto)
                                <img src="{{ asset('storage/' . $strukturOrganisasi->foto) }}"
                                     alt="{{ $strukturOrganisasi->nama }}"
                                     class="w-full max-w-sm mx-auto rounded-lg border">
                            @else
                                <div class="w-full max-w-sm mx-auto h-64 bg-gray-300 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user fa-5x text-gray-500"></i>
                                </div>
                            @endif

                            <h3 class="mt-4 text-xl font-semibold">{{ $strukturOrganisasi->nama }}</h3>
                            @if($strukturOrganisasi->nip)
                                <p class="text-gray-600">NIP: {{ $strukturOrganisasi->nip }}</p>
                            @endif
                        </div>

                        <div class="md:col-span-2">
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $strukturOrganisasi->nama }}</p>
                                    </div>
                                    @if($strukturOrganisasi->nip)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">NIP</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $strukturOrganisasi->nip }}</p>
                                    </div>
                                    @endif
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Jabatan</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $strukturOrganisasi->jabatan }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Tipe Jabatan</label>
                                        <span class="mt-1 inline-flex px-2 py-1 text-xs leading-5 font-semibold rounded-full {{ $strukturOrganisasi->tipe_jabatan->tailwindColor() }}">
                                            <i class="{{ $strukturOrganisasi->tipe_jabatan->icon() }} mr-1"></i>
                                            {{ $strukturOrganisasi->tipe_jabatan->label() }}
                                        </span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Urutan</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $strukturOrganisasi->urutan ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Status</label>
                                        <span class="mt-1 inline-flex px-2 py-1 text-xs leading-5 font-semibold rounded-full {{ $strukturOrganisasi->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            <i class="fas {{ $strukturOrganisasi->is_active ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                                            {{ $strukturOrganisasi->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Dibuat</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $strukturOrganisasi->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Diperbarui</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $strukturOrganisasi->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($strukturOrganisasi->sambutan_kepala && $strukturOrganisasi->tipe_jabatan->isKepala())
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700">Sambutan Kepala</label>
                            <div class="mt-2 p-4 bg-blue-50 rounded-lg">
                                <div class="text-sm text-gray-900">{!! $strukturOrganisasi->sambutan_kepala !!}</div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t">
                    <div class="flex flex-col sm:flex-row justify-between gap-3">
                        <!-- Left Side: Action Buttons + Kembali -->
                        <div class="flex flex-col sm:flex-row gap-2">
                            <a href="{{ route('admin.struktur-organisasi.index') }}"
                               class="inline-flex items-center justify-center bg-gray-500 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded transition-colors duration-200 text-sm sm:text-base">
                                <i class="fas fa-arrow-left mr-2"></i>
                                <span class="hidden sm:inline">Kembali</span>
                                <span class="sm:hidden">Kembali</span>
                            </a>
                        </div>
                        <!-- Right Side: Toggle Status -->
                        <div class="w-full sm:w-auto">
                            <form action="{{ route('admin.struktur-organisasi.toggle', $strukturOrganisasi) }}" method="POST" class="w-full sm:w-auto">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 rounded font-semibold text-white {{ $strukturOrganisasi->is_active ? 'bg-green-500 hover:bg-green-700' : 'bg-gray-500 hover:bg-gray-700' }} transition-colors duration-200 text-sm sm:text-base">
                                    <i class="fas fa-{{ $strukturOrganisasi->is_active ? 'toggle-on' : 'toggle-off' }} mr-2"></i>
                                    {{ $strukturOrganisasi->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                        </div>
                        <x-action-buttons
                            edit-url="{{ route('admin.struktur-organisasi.edit', $strukturOrganisasi) }}"
                            delete-url="{{ route('admin.struktur-organisasi.destroy', $strukturOrganisasi) }}"
                            delete-confirm-text="Yakin ingin menghapus data struktur organisasi ini?"
                            resource-name="struktur organisasi"
                            size="md" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
