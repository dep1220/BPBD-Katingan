<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>
        <meta name="description" content="@yield('description', 'Sistem Manajemen BPBD Kabupaten Katingan')">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="@yield('title', config('app.name', 'Laravel'))">
        <meta property="og:description" content="@yield('description', 'Sistem Manajemen BPBD Kabupaten Katingan')">
        <meta property="og:image" content="@yield('og_image', asset('images/logo-bpbd.png'))">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="@yield('title', config('app.name', 'Laravel'))">
        <meta property="twitter:description" content="@yield('description', 'Sistem Manajemen BPBD Kabupaten Katingan')">
        <meta property="twitter:image" content="@yield('og_image', asset('images/logo-bpbd.png'))">

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('images/logo-bpbd.png') }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo-bpbd.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/logo-bpbd.png') }}">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head-scripts')
    </head>
    <body class="font-sans antialiased">
        <div x-data="{ sidebarOpen: false }" class="relative h-screen flex overflow-hidden bg-gray-100">

            <aside
                class="fixed inset-y-0 left-0 z-30 w-64 flex flex-col transition-transform duration-300 ease-in-out transform lg:relative lg:translate-x-0"
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
                @include('layouts.sidebar')
            </aside>

            <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-gray-600 bg-opacity-75 z-20 lg:hidden" style="display: none;"></div>

            <div class="flex-1 flex flex-col overflow-hidden">
                @include('layouts.navigation')

                <main class="flex-1 overflow-y-auto">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>
