@extends('layouts.public')

@section('title', 'Kontak Kami - BPBD Katingan')

@section('content')

    <section class="bg-orange-500">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 md:py-24">
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl">Hubungi Kami</h1>
            <p class="mt-3 text-xl text-orange-100">
                Kami siap menerima laporan, pertanyaan, dan masukan dari Anda.
            </p>
        </div>
    </section>

    {{-- Ganti bg-white menjadi bg-gray-50 untuk latar belakang utama section --}}
    <section class="py-16 sm:py-24 bg-gray-50">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Notifikasi Sukses --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform translate-y-2"
                     class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-lg p-4 shadow-lg">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-green-800">
                                {{ session('success') }}
                            </p>
                        </div>
                        <div class="ml-auto pl-3">
                            <button @click="show = false" class="inline-flex text-green-500 hover:text-green-700 focus:outline-none">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">

                <div
                    {{-- Ganti bg-gray-50 menjadi bg-orange-50 --}}
                    class="p-8 bg-orange-50 rounded-lg border border-orange-200"
                    x-data="{
                        num1: 0, num2: 0, userAnswer: '',
                        get correctAnswer() { return this.num1 + this.num2; },
                        generateCaptcha() {
                            this.num1 = Math.floor(Math.random() * 10) + 1;
                            this.num2 = Math.floor(Math.random() * 10) + 1;
                            this.userAnswer = '';
                        }
                    }"
                    x-init="generateCaptcha()">

                    <h2 class="text-2xl font-bold text-gray-900">Kirim Pesan</h2>
                    <p class="mt-2 text-gray-600">Isi formulir di bawah ini untuk mengirimkan pesan langsung ke tim kami.</p>

                    <form action="{{route('kontak.store')}}" method="POST" class="mt-8 space-y-6">
                        @csrf
                        {{-- ... (Isi form tetap sama) ... --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <div class="mt-1"><input type="text" name="name" id="name" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"></div>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <div class="mt-1"><input id="email" name="email" type="email" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"></div>
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon <span class="text-gray-400">(Opsional)</span></label>
                            <div class="mt-1">
                                <input type="tel" name="phone" id="phone"
                                       pattern="[0-9]*"
                                       inputmode="numeric"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                       placeholder="Contoh: 081234567890"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Hanya angka yang diperbolehkan</p>
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Kategori Pesan</label>
                            <div class="mt-1"><select id="category" name="category" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"><option>Pilih Kategori</option><option value="pengaduan">Pengaduan</option><option value="kritik">Kritik</option><option value="saran">Saran</option></select></div>
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700">Subjek</label>
                            <div class="mt-1"><input type="text" name="subject" id="subject" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"></div>
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Pesan</label>
                            <div class="mt-1"><textarea id="message" name="message" rows="4" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"></textarea></div>
                        </div>
                        <div>
                            <label for="captcha" class="block text-sm font-medium text-gray-700">Verifikasi: Berapa hasil dari <span x-text="num1"></span> + <span x-text="num2"></span>?</label>
                            <div class="mt-1"><input type="number" name="captcha" id="captcha" x-model="userAnswer" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500" placeholder="Jawab di sini..."></div>
                            <p x-show="userAnswer && parseInt(userAnswer) !== correctAnswer" class="mt-1 text-sm text-red-600">Jawaban verifikasi salah.</p>
                        </div>
                        <div>
                            <button type="submit" :disabled="parseInt(userAnswer) !== correctAnswer" class="w-full justify-center rounded-md bg-orange-500 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-orange-600 transition disabled:opacity-50 disabled:cursor-not-allowed">Kirim Pesan</button>
                        </div>
                    </form>
                </div>

                {{-- Tambahkan div pembungkus dengan background biru --}}
                <div class="p-8 bg-blue-50 rounded-lg border border-blue-200">
                    <h2 class="text-2xl font-bold text-gray-900">Informasi Kontak</h2>
                    @if($informasiKontak)
                        <div class="mt-6 space-y-6 text-gray-600">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0"><svg class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg></div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Alamat Kantor</h3>
                                    <p>{{ $informasiKontak->alamat }}</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0"><svg class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg></div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Telepon & Email</h3>
                                    <p>Telepon: {{ $informasiKontak->telepon }}</p>
                                    <p>Email: {{ $informasiKontak->email }}</p>
                                </div>
                            </div>
                            @if($informasiKontak->jam_operasional)
                                @php
                                    $jamOperasional = is_string($informasiKontak->jam_operasional)
                                        ? json_decode($informasiKontak->jam_operasional, true)
                                        : $informasiKontak->jam_operasional;
                                    $jamOperasional = is_array($jamOperasional) ? array_filter($jamOperasional) : [$informasiKontak->jam_operasional];
                                @endphp
                                @if(!empty($jamOperasional))
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0"><svg class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900">Jam Operasional</h3>
                                            @foreach($jamOperasional as $jam)
                                                <p>{{ $jam }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    @else
                        <div class="mt-6 text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-2 text-gray-600">Informasi kontak belum tersedia.</p>
                        </div>
                    @endif

                    <div class="mt-10">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3986.733512345678!2d113.3891113152367!3d-2.05267199854321!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dfcb67bffffffff%3A0x95c27078c182281a!2sKantor%20Bupati%20Katingan!5e0!3m2!1sen!2sid!4v1664182930123!5m2!1sen!2sid"
                            width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade" class="rounded-lg shadow-md">
                        </iframe>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
