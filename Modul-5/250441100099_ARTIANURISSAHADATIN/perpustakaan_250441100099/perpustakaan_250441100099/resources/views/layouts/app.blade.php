@php
    $ppCss = public_path('css/perpus.css');
    $ppCssVersion = file_exists($ppCss) ? filemtime($ppCss) : 1;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Perpustakaan Digital')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Tampilan utama (tidak perlu npm build) -->
        <link rel="stylesheet" href="{{ asset('css/perpus.css') }}?v={{ $ppCssVersion }}">

        <!-- Aset Vite (opsional: hanya dimuat bila sudah di-build / npm run dev) -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="pp-body">
        @include('layouts.navigation')

        {{-- Judul halaman (gaya <x-app-layout> dengan slot "header") --}}
        @isset($header)
            <header class="pp-pagehead">
                <div class="pp-container">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="pp-main">
            {{-- Konten untuk <x-app-layout> --}}
            @isset($slot)
                {{ $slot }}
            @endisset

            {{-- Konten untuk @extends('layouts.app') --}}
            @yield('content')
        </main>

        <footer class="pp-footer">
            &copy; {{ date('Y') }} Perpustakaan Digital &middot; Sistem Informasi Perpustakaan
        </footer>
    </body>
</html>
