@extends('layouts.public')

@section('title', 'Agenda Kegiatan - BPBD Kabupaten Katingan')

@section('content')
    <!-- Header Section -->
    <section class="bg-orange-500">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 md:py-24">
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl">Agenda Kegiatan</h1>
            <p class="mt-3 text-xl text-orange-100">
                Jadwal lengkap kegiatan dan program kerja BPBD Kabupaten Katingan
            </p>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="bg-white border-b border-gray-200 py-6">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('public.agenda.index') }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium {{ !request('status') ? 'bg-orange-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Semua Agenda
                    </a>
                    <a href="{{ route('public.agenda.index', ['status' => 'akan_datang']) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'akan_datang' ? 'bg-orange-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Akan Datang
                    </a>
                    <a href="{{ route('public.agenda.index', ['status' => 'sedang_berlangsung']) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'sedang_berlangsung' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Sedang Berlangsung
                    </a>
                    <a href="{{ route('public.agenda.index', ['status' => 'selesai']) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'selesai' ? 'bg-gray-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Selesai
                    </a>
                </div>
                <div class="text-sm text-gray-600">
                    Total: {{ $agendas->total() }} agenda
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="bg-gray-50 py-12">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if($agendas->isNotEmpty())
                <div class="space-y-6">
                    @foreach($agendas as $agenda)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
                            <div class="p-6">
                                <div class="flex flex-col lg:flex-row lg:items-start lg:space-x-6">
                                    <!-- Date Box -->
                                    <div class="flex-shrink-0 mb-4 lg:mb-0">
                                        <div class="text-center bg-gradient-to-b from-orange-500 to-orange-600 text-white rounded-lg p-4 w-20">
                                            <p class="text-2xl font-bold">{{ $agenda->formatted_date }}</p>
                                            <p class="text-sm font-medium">{{ $agenda->formatted_month }}</p>
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1">
                                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                                            <div class="flex-1">
                                                <div class="flex items-start gap-3 mb-2">
                                                    <h3 class="text-xl font-semibold text-gray-900 leading-tight">{{ $agenda->title }}</h3>
                                                    <span class="px-3 py-1 text-xs font-medium rounded-full {{ $agenda->status_color }} whitespace-nowrap">
                                                        {{ $agenda->status_label }}
                                                    </span>
                                                </div>
                                                
                                                <p class="text-gray-600 mb-4 leading-relaxed">{{ $agenda->description }}</p>

                                                <!-- Details Grid -->
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                                    <div class="flex items-center text-gray-600">
                                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                                        </svg>
                                                        <span class="font-medium">Lokasi:</span>
                                                        <span class="ml-1">{{ $agenda->location }}</span>
                                                    </div>

                                                    <div class="flex items-center text-gray-600">
                                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <span class="font-medium">Waktu:</span>
                                                        <span class="ml-1">{{ $agenda->formatted_time_range }}</span>
                                                    </div>

                                                    @if($agenda->end_date && $agenda->end_date != $agenda->start_date)
                                                        <div class="flex items-center text-gray-600">
                                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                            </svg>
                                                            <span class="font-medium">Berakhir:</span>
                                                            <span class="ml-1">{{ $agenda->end_date->format('d M Y') }}</span>
                                                        </div>
                                                    @endif

                                                    @if($agenda->status === 'akan_datang')
                                                        @php
                                                            $now = now();
                                                            $startDateTime = \Carbon\Carbon::parse($agenda->start_date->format('Y-m-d') . ' ' . $agenda->start_time);
                                                            if ($startDateTime->isFuture()) {
                                                                $diff = $now->diff($startDateTime);
                                                                $days = $diff->days;
                                                                $hours = $diff->h;
                                                                $minutes = $diff->i;
                                                            }
                                                        @endphp
                                                        @if(isset($days))
                                                            <div class="flex items-center text-blue-600 font-medium">
                                                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                </svg>
                                                                <span>{{ $days }} hari, {{ $hours }} jam lagi</span>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $agendas->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="flex items-center justify-center h-16 w-16 bg-orange-100 text-orange-600 rounded-full mx-auto mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">
                        @if(request('status'))
                            Tidak ada agenda dengan status "{{ ucfirst(str_replace('_', ' ', request('status'))) }}"
                        @else
                            Belum Ada Agenda Terjadwal
                        @endif
                    </h3>
                    <p class="text-gray-600 max-w-md mx-auto">
                        @if(request('status'))
                            Silakan pilih filter lain atau kembali ke semua agenda.
                        @else
                            Saat ini belum ada agenda kegiatan yang terjadwal. Pantau terus website ini untuk informasi agenda terbaru.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </section>
@endsection
