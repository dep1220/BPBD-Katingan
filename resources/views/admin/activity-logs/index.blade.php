<x-app-layout>
    <x-slot name="header">
            {{-- Judul halaman dikembalikan ke sini --}}
            <h2 class="font-bold text-sm sm:text-base md:text-2xl text-orange-600 tracking-tight flex items-center">
                {{ __('Activity Logs') }}
            </h2>
        </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('info'))
                <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('info') }}</span>
                </div>
            @endif

            <!-- Filter & Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Filters -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-gray-800">Filter</h3>
                            <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="space-y-3">
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">User</label>
                                        <select name="user_id" class="w-full rounded-md border-gray-300">
                                            <option value="">Semua User</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Aksi</label>
                                        <select name="action" class="w-full rounded-md border-gray-300">
                                            <option value="">Semua Aksi</option>
                                            @foreach($actions as $action)
                                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                                    {{ ucfirst($action) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                                        <input type="date" name="date_from" value="{{ request('date_from') }}" 
                                               class="w-full rounded-md border-gray-300">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                                        <input type="date" name="date_to" value="{{ request('date_to') }}" 
                                               class="w-full rounded-md border-gray-300">
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        Filter
                                    </button>
                                    <a href="{{ route('admin.activity-logs.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                        Reset
                                    </a>
                                </div>
                            </form>
                        </div>

                        <!-- Actions -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-gray-800">Aksi</h3>
                            <div class="space-y-3">
                                <!-- Clean Old Logs -->
                                <div x-data="{ showCleanOld: false }" 
                                     @keydown.escape.window="showCleanOld = false"
                                     @keydown.enter.window="if(showCleanOld) { $event.preventDefault(); $event.stopPropagation(); $refs.cleanOldBtn.click(); }">
                                    <button type="button" 
                                            @click="showCleanOld = true"
                                            class="w-full px-4 py-3 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Hapus Log Lebih dari 30 Hari
                                    </button>

                                    <!-- Modal Konfirmasi Clean Old -->
                                    <div x-show="showCleanOld" 
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0"
                                         x-transition:enter-end="opacity-100"
                                         x-transition:leave="transition ease-in duration-200"
                                         x-transition:leave-start="opacity-100"
                                         x-transition:leave-end="opacity-0"
                                         class="fixed inset-0 z-50 overflow-y-auto" 
                                         style="display: none;">
                                        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                            <div x-show="showCleanOld"
                                                 x-transition
                                                 @click="showCleanOld = false" 
                                                 class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                                            <div x-show="showCleanOld"
                                                 x-transition:enter="ease-out duration-300"
                                                 x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                                                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                 x-transition:leave="ease-in duration-200"
                                                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                 x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
                                                 class="inline-block align-bottom bg-slate-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                                                <div class="bg-gradient-to-br from-slate-800 to-slate-900 px-6 pt-6 pb-5 sm:p-8">
                                                    <div class="flex items-start space-x-4">
                                                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                                                            <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                            </svg>
                                                        </div>
                                                        <div class="flex-1">
                                                            <h3 class="text-xl font-bold text-white mb-2">127.0.0.1:8000 menyatakan</h3>
                                                            <p class="text-sm text-slate-300 leading-relaxed">Hapus log aktivitas yang lebih dari 30 hari?</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-slate-800 px-6 py-4 sm:px-8 sm:py-5 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                                                    <button type="button" @click="showCleanOld = false"
                                                            class="w-full sm:w-auto inline-flex justify-center items-center rounded-lg px-5 py-2.5 text-sm font-semibold text-slate-300 bg-slate-700 hover:bg-slate-600">
                                                        Batal
                                                    </button>
                                                    <form method="POST" action="{{ route('admin.activity-logs.clean-old') }}" class="w-full sm:w-auto">
                                                        @csrf
                                                        <input type="hidden" name="days" value="30">
                                                        <button type="submit" x-ref="cleanOldBtn"
                                                                class="w-full inline-flex justify-center items-center rounded-lg px-5 py-2.5 text-sm font-semibold text-white bg-yellow-600 hover:bg-yellow-700">
                                                            Oke
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete All -->
                                <div x-data="{ showDeleteAll: false }" 
                                     @keydown.escape.window="showDeleteAll = false"
                                     @keydown.enter.window="if(showDeleteAll) { $event.preventDefault(); $event.stopPropagation(); $refs.deleteAllBtn.click(); }">
                                    <button type="button" 
                                            @click="showDeleteAll = true"
                                            class="w-full px-4 py-3 bg-red-600 text-white rounded-md hover:bg-red-700 flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus Semua Log
                                    </button>

                                    <!-- Modal Konfirmasi Delete All -->
                                    <div x-show="showDeleteAll" 
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0"
                                         x-transition:enter-end="opacity-100"
                                         x-transition:leave="transition ease-in duration-200"
                                         x-transition:leave-start="opacity-100"
                                         x-transition:leave-end="opacity-0"
                                         class="fixed inset-0 z-50 overflow-y-auto" 
                                         style="display: none;">
                                        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                            <div x-show="showDeleteAll"
                                                 x-transition
                                                 @click="showDeleteAll = false" 
                                                 class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                                            <div x-show="showDeleteAll"
                                                 x-transition:enter="ease-out duration-300"
                                                 x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                                                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                 x-transition:leave="ease-in duration-200"
                                                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                 x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
                                                 class="inline-block align-bottom bg-slate-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                                                <div class="bg-gradient-to-br from-slate-800 to-slate-900 px-6 pt-6 pb-5 sm:p-8">
                                                    <div class="flex items-start space-x-4">
                                                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                                                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                            </svg>
                                                        </div>
                                                        <div class="flex-1">
                                                            <h3 class="text-xl font-bold text-white mb-2">127.0.0.1:8000 menyatakan</h3>
                                                            <p class="text-sm text-slate-300 leading-relaxed">PERHATIAN: Ini akan menghapus SEMUA log aktivitas! Yakin?</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-slate-800 px-6 py-4 sm:px-8 sm:py-5 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                                                    <button type="button" @click="showDeleteAll = false"
                                                            class="w-full sm:w-auto inline-flex justify-center items-center rounded-lg px-5 py-2.5 text-sm font-semibold text-slate-300 bg-slate-700 hover:bg-slate-600">
                                                        Batal
                                                    </button>
                                                    <form method="POST" action="{{ route('admin.activity-logs.delete-all') }}" class="w-full sm:w-auto">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" x-ref="deleteAllBtn"
                                                                class="w-full inline-flex justify-center items-center rounded-lg px-5 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700">
                                                            Oke
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Logs Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($activityLogs as $log)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $log->created_at->format('d M Y H:i') }}
                                            <br>
                                            <span class="text-xs text-gray-500">{{ $log->created_at->diffForHumans() }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $log->user ? $log->user->name : 'System' }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $log->user ? $log->user->email : '-' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($log->action == 'create')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Create
                                                </span>
                                            @elseif($log->action == 'update')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    Update
                                                </span>
                                            @elseif($log->action == 'delete')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Delete
                                                </span>
                                            @elseif($log->action == 'login')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                    Login
                                                </span>
                                            @elseif($log->action == 'logout')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    Logout
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    {{ ucfirst($log->action) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $log->description }}
                                            @if($log->model)
                                                <span class="text-xs text-gray-500">({{ $log->model }})</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $log->ip_address }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div x-data="{ showDelete: false }" 
                                                 @keydown.escape.window="showDelete = false"
                                                 @keydown.enter.window="if(showDelete) { $event.preventDefault(); $event.stopPropagation(); $refs.deleteBtn.click(); }"
                                                 class="inline">
                                                <button type="button" @click="showDelete = true" class="text-red-600 hover:text-red-900">
                                                    Hapus
                                                </button>

                                                <!-- Modal Konfirmasi Delete Single -->
                                                <div x-show="showDelete" 
                                                     x-transition:enter="transition ease-out duration-300"
                                                     x-transition:enter-start="opacity-0"
                                                     x-transition:enter-end="opacity-100"
                                                     x-transition:leave="transition ease-in duration-200"
                                                     x-transition:leave-start="opacity-100"
                                                     x-transition:leave-end="opacity-0"
                                                     class="fixed inset-0 z-50 overflow-y-auto" 
                                                     style="display: none;">
                                                    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                        <div x-show="showDelete" x-transition @click="showDelete = false" class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
                                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                                                        <div x-show="showDelete"
                                                             x-transition:enter="ease-out duration-300"
                                                             x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                                                             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                             x-transition:leave="ease-in duration-200"
                                                             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                             x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
                                                             class="inline-block align-bottom bg-slate-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                                                            <div class="bg-gradient-to-br from-slate-800 to-slate-900 px-6 pt-6 pb-5 sm:p-8">
                                                                <div class="flex items-start space-x-4">
                                                                    <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-orange-100">
                                                                        <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                                        </svg>
                                                                    </div>
                                                                    <div class="flex-1">
                                                                        <h3 class="text-xl font-bold text-white mb-2">127.0.0.1:8000 menyatakan</h3>
                                                                        <p class="text-sm text-slate-300 leading-relaxed">Hapus log ini?</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="bg-slate-800 px-6 py-4 sm:px-8 sm:py-5 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                                                                <button type="button" @click="showDelete = false"
                                                                        class="w-full sm:w-auto inline-flex justify-center items-center rounded-lg px-5 py-2.5 text-sm font-semibold text-slate-300 bg-slate-700 hover:bg-slate-600">
                                                                    Batal
                                                                </button>
                                                                <form method="POST" action="{{ route('admin.activity-logs.destroy', $log) }}" class="w-full sm:w-auto">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" x-ref="deleteBtn"
                                                                            class="w-full inline-flex justify-center items-center rounded-lg px-5 py-2.5 text-sm font-semibold text-white bg-orange-600 hover:bg-orange-700">
                                                                        Oke
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p class="mt-2">Tidak ada log aktivitas</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $activityLogs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
