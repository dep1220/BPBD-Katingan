<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-sm sm:text-base md:text-2xl text-orange-600 tracking-tight flex items-center truncate">
                <span class="truncate">{{ __('Manajemen User') }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="pt-6 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center mb-6 space-y-4 lg:space-y-0">
                        <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                            <div class="bg-blue-50 px-3 py-2 rounded-lg text-center sm:text-left">
                                <span class="text-xs sm:text-sm text-gray-600">Total User:</span>
                                <span class="font-semibold text-blue-600 ml-1 sm:ml-2">{{ $users->count() }}</span>
                            </div>
                            <div class="bg-purple-50 px-3 py-2 rounded-lg text-center sm:text-left">
                                <span class="text-xs sm:text-sm text-gray-600">Super Admin:</span>
                                <span class="font-semibold text-purple-600 ml-1 sm:ml-2">{{ $users->where('role', 'super_admin')->count() }}</span>
                            </div>
                            <div class="bg-green-50 px-3 py-2 rounded-lg text-center sm:text-left">
                                <span class="text-xs sm:text-sm text-gray-600">Admin:</span>
                                <span class="font-semibold text-green-600 ml-1 sm:ml-2">{{ $users->where('role', 'admin')->count() }}</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition duration-300">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                            Tambah User Baru
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $user->name }}
                                                @if($user->id === auth()->id())
                                                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Anda</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($user->role === 'super_admin')
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                    👑 Super Admin
                                                </span>
                                            @else
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    👤 Admin
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-3">
                                                <a href="{{ route('admin.users.edit', $user) }}" 
                                                   class="text-blue-600 hover:text-blue-900 transition">
                                                    Edit
                                                </a>
                                                
                                                @if($user->id !== auth()->id() && !$user->isSuperAdmin())
                                                    <div x-data="{ showConfirm: false }" @keydown.escape.window="showConfirm = false" class="inline">
                                                        <button type="button" 
                                                                @click="showConfirm = true"
                                                                class="text-red-600 hover:text-red-900 transition">
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
                                                                                    Apakah Anda yakin ingin menghapus user ini?
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
                                                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="w-full sm:w-auto">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" 
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
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada user yang ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
