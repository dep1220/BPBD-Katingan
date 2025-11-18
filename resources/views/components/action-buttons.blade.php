@props([
    'viewUrl' => null,
    'editUrl' => null,
    'deleteUrl' => null,
    'deleteConfirmText' => 'Yakin ingin menghapus data ini? Aksi ini tidak dapat dibatalkan.',
    'resourceName' => 'data',
    'size' => 'md' // sm, md, lg
])

@php
$sizeClasses = [
    'sm' => 'px-2 py-1 text-xs',
    'md' => 'px-3 py-2 text-sm',
    'lg' => 'px-4 py-2 text-base'
];

$iconSizes = [
    'sm' => 'w-3 h-3',
    'md' => 'w-4 h-4',
    'lg' => 'w-5 h-5'
];

$baseClasses = $sizeClasses[$size] ?? $sizeClasses['md'];
$iconSize = $iconSizes[$size] ?? $iconSizes['md'];
@endphp

<div class="flex items-center space-x-2">
    @if($viewUrl)
        <a href="{{ $viewUrl }}" 
           class="inline-flex items-center {{ $baseClasses }} bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition-colors duration-200"
           title="Lihat {{ $resourceName }}">
            <svg class="{{ $iconSize }} mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            Lihat
        </a>
    @endif

    @if($editUrl)
        <a href="{{ $editUrl }}" 
           class="inline-flex items-center {{ $baseClasses }} bg-orange-100 text-orange-700 rounded-md hover:bg-orange-200 transition-colors duration-200"
           title="Edit {{ $resourceName }}">
            <svg class="{{ $iconSize }} mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit
        </a>
    @endif

    @if($deleteUrl)
        <div x-data="{ showConfirm: false }" 
             @keydown.escape.window="showConfirm = false"
             @keydown.enter.window="if(showConfirm) { $event.preventDefault(); $event.stopPropagation(); $refs.confirmBtn.click(); }"
             class="inline">
            <button type="button" 
                    @click="showConfirm = true"
                    class="inline-flex items-center {{ $baseClasses }} bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition-colors duration-200"
                    title="Hapus {{ $resourceName }}">
                <svg class="{{ $iconSize }} mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus
            </button>

            <!-- Modal Konfirmasi -->
            <div x-show="showConfirm" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-50 overflow-y-auto" 
                 aria-labelledby="modal-title" 
                 role="dialog" 
                 aria-modal="true"
                 style="display: none;">
                
                <!-- Background overlay -->
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="showConfirm"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         @click="showConfirm = false" 
                         class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                         aria-hidden="true"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <!-- Modal panel -->
                    <div x-show="showConfirm"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         class="inline-block align-bottom bg-slate-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-700">
                        
                        <div class="bg-gradient-to-br from-slate-800 to-slate-900 px-6 pt-6 pb-5 sm:p-8">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-orange-100">
                                    <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-white mb-2" id="modal-title">
                                        127.0.0.1:8000 menyatakan
                                    </h3>
                                    <p class="text-sm text-slate-300 leading-relaxed">
                                        {{ $deleteConfirmText }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-slate-800 px-6 py-4 sm:px-8 sm:py-5 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                            <button type="button" 
                                    @click="showConfirm = false"
                                    class="w-full sm:w-auto inline-flex justify-center items-center rounded-lg px-5 py-2.5 text-sm font-semibold text-slate-300 bg-slate-700 hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-all duration-200 shadow-sm">
                                Batal
                            </button>
                            <form action="{{ $deleteUrl }}" method="POST" class="w-full sm:w-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        x-ref="confirmBtn"
                                        class="w-full inline-flex justify-center items-center rounded-lg px-5 py-2.5 text-sm font-semibold text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 shadow-lg hover:shadow-orange-500/50">
                                    Oke
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>