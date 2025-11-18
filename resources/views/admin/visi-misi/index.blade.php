<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-sm sm:text-base md:text-2xl text-orange-600 tracking-tight flex items-center truncate">
                <span class="truncate">{{ __('Visi & Misi') }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if($visiMisi->isEmpty())
                            <div class="flex justify-end mb-6">
                                <a href="{{ route('admin.visi-misi.create') }}"
                                   class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                                    <i class="fas fa-plus"></i> Tambah Visi & Misi
                                </a>
                            </div>
                        @endif

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-600"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        <strong>Informasi:</strong> Hanya satu visi & misi yang dapat aktif pada satu waktu.
                                        Mengaktifkan visi & misi baru akan otomatis menonaktifkan yang lain.
                                    </p>
                                </div>
                            </div>
                        </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Misi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($visiMisi as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ Str::limit($item->visi, 100) }}
                                            </div>
                                            @if($item->deskripsi_visi)
                                                <div class="text-sm text-gray-500 mt-1">
                                                    {{ Str::limit($item->deskripsi_visi, 80) }}
                                                </div>
                                            @endif
                                            @if($item->is_active)
                                                <div class="mt-1">
                                                    <span class="inline-flex items-center text-xs text-green-600">
                                                        <i class="fas fa-eye mr-1"></i>
                                                        Sedang Ditampilkan di Publik
                                                    </span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                                                {{ count($item->misi) }} Misi
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <form action="{{ route('admin.visi-misi.toggle', $item) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                @if($item->is_active)
                                                    <button type="submit"
                                                            class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 hover:bg-green-200 transition-colors duration-200 whitespace-nowrap"
                                                            title="Klik untuk menonaktifkan">
                                                        <i class="fas fa-check-circle mr-1"></i>
                                                        Aktif
                                                    </button>
                                                @else
                                                    <button type="submit"
                                                            class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 hover:bg-gray-200 transition-colors duration-200 whitespace-nowrap"
                                                            title="Klik untuk mengaktifkan">
                                                        <i class="fas fa-times-circle mr-1"></i>
                                                        Non-aktif
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $item->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <x-action-buttons
                                                view-url="{{ route('admin.visi-misi.show', $item) }}"
                                                edit-url="{{ route('admin.visi-misi.edit', $item) }}"
                                                delete-url="{{ route('admin.visi-misi.destroy', $item) }}"
                                                delete-confirm-text="Yakin ingin menghapus visi & misi ini?"
                                                resource-name="visi & misi"
                                                size="md" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada data visi & misi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $visiMisi->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Konfirmasi toggle status
    const toggleForms = document.querySelectorAll('form[action*="toggle"]');

    toggleForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const button = form.querySelector('button');
            const isActive = button.textContent.trim().includes('Aktif');
            const action = isActive ? 'menonaktifkan' : 'mengaktifkan';
            const warning = isActive ? '' : '\n\nPerhatian: Mengaktifkan visi & misi ini akan menonaktifkan visi & misi lain yang sedang aktif.';

            if (confirm(`Apakah Anda yakin ingin ${action} visi & misi ini?${warning}`)) {
                // Show loading state
                const originalContent = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Proses...';
                button.disabled = true;

                // Submit form
                form.submit();
            }
        });
    });

    // Auto hide success message after 5 seconds
    const successAlert = document.querySelector('.bg-green-100');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.transition = 'opacity 0.5s ease-out';
            successAlert.style.opacity = '0';
            setTimeout(() => {
                successAlert.remove();
            }, 500);
        }, 5000);
    }
});
</script>
@endpush
