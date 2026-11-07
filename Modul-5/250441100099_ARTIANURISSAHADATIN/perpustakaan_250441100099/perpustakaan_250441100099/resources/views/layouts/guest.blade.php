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

        <title>Perpustakaan Digital</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="{{ asset('css/perpus.css') }}?v={{ $ppCssVersion }}">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="pp-body">
        <div class="pp-guest">
            <a href="{{ url('/') }}" class="pp-guest__brand">
                <span class="pp-brand__logo">
                    <x-icon name="book" :size="28" />
                </span>
                <span class="pp-guest__title">Perpustakaan<span>Digital</span></span>
            </a>

            <div class="pp-guest__card">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
