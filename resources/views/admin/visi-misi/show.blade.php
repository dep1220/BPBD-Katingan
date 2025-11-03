<x-app-layout>
    <x-slot name="header">
        <x-page-title>Detail Visi & Misi</x-page-title>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                <!-- Tombol Kembali -->
                <div class="mb-6">
                    <a href="{{ route('admin.visi-misi.index') }}"
                       class="inline-flex items-center justify-center bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 text-sm sm:text-base">
                        <i class="fas fa-arrow-left mr-2"></i>
                        <span class="hidden sm:inline">Kembali</span>
                        <span class="sm:hidden">Kembali</span>
                    </a>
                </div>

                <div class="space-y-8">
                    <!-- Info Card -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Status</h4>
                                <div class="mt-1">
                                    @if($visiMisi->is_active)
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm font-medium">
                                            <i class="fas fa-check-circle mr-1"></i>Aktif
                                        </span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-sm font-medium">
                                            <i class="fas fa-times-circle mr-1"></i>Non-aktif
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Dibuat</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $visiMisi->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Terakhir Diupdate</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $visiMisi->updated_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Visi -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Visi</h3>
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                            <blockquote class="text-lg italic text-gray-700">
                                "{{ $visiMisi->visi }}"
                            </blockquote>
                        </div>
                        @if($visiMisi->deskripsi_visi)
                            <div class="mt-4 text-gray-600">
                                <h4 class="font-medium mb-2">Deskripsi:</h4>
                                <p>{{ $visiMisi->deskripsi_visi }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Misi -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">
                            Misi
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm font-medium ml-2">
                                {{ count($visiMisi->misi) }} Misi
                            </span>
                        </h3>
                        <div class="space-y-4">
                            @foreach($visiMisi->misi as $index => $misi)
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <span class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-600 text-white font-bold text-sm">
                                            {{ $index + 1 }}
                                        </span>
                                    </div>
                                    <div class="flex-1 bg-white border border-gray-200 rounded-lg p-4">
                                        <p class="text-gray-700">{{ $misi }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <x-action-buttons edit-url="{{ route('admin.visi-misi.edit', $visiMisi) }}" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
