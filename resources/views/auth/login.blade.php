<x-guest-layout>
    <div class="flex flex-wrap w-full h-screen">
        <!-- <div class="w-full md:w-1/2 h-64 md:h-full flex flex-col bg-cover bg-center" style="background-image: url('{{ asset('images/bpbd-foto-bersama.jpg') }}')"> -->
        <div class="w-full md:w-1/2 h-64 md:h-full flex flex-col bg-cover bg-center" style="--bg-url: url('{{ asset('images/bpbd-foto-bersama.jpg') }}'); background-image: var(--bg-url);">
            {{-- Ganti URL dengan gambar yang relevan untuk BPBD --}}
            <div class="flex flex-col justify-between h-full p-8 bg-black bg-opacity-30">
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-3">
                        <img src="{{ asset('images/logo-bpbd.png') }}" alt="Logo BPBD" class="w-12 h-auto">
                        <span class="text-white font-bold text-xl">BPBD KATINGAN</span>
                    </a>
                </div>
                <div>
                    <h1 class="text-white font-bold text-4xl leading-tight mb-2">Panel Administrasi</h1>
                    <p class="text-gray-200">Sistem Manajemen Konten Website.</p>
                </div>
            </div>
        </div>

        <div class="w-full md:w-1/2 flex flex-col justify-center items-center bg-white p-8">
            <div class="w-full max-w-md">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Selamat Datang Kembali</h2>
                    <p class="text-gray-500 mt-2">Silakan masuk ke akun admin Anda.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Alamat Email')" class="font-semibold" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="contoh@email.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-6" x-data="{ show: false }">
                        <x-input-label for="password" :value="__('Password')" class="font-semibold" />
                        <div class="relative">
                            <x-text-input id="password"
                                class="block mt-1 w-full pr-10"
                                x-bind:type="show ? 'text' : 'password'"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••" />
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500">
                                <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg x-show="show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.243 4.243l-4.243-4.243" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="block mt-6">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
                        </label>
                    </div>

                    <div class="mt-8">
                        {{-- Tombol diubah menjadi oranye --}}
                        <button type="submit" class="w-full justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                            Log In
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
