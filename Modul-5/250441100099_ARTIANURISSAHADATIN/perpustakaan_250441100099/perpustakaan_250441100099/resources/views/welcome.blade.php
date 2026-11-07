@php
    $ppCss = public_path('css/perpus.css');
    $ppCssVersion = file_exists($ppCss) ? filemtime($ppCss) : 1;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Perpustakaan Digital</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/perpus.css') }}?v={{ $ppCssVersion }}">
    </head>
    <body class="pp-body">

        <nav class="pp-nav" aria-label="Navigasi utama">
            <div class="pp-container">
                <div class="pp-nav__bar">
                    <a href="{{ url('/') }}" class="pp-brand">
                        <span class="pp-brand__logo"><x-icon name="book" :size="22" /></span>
                        <span>
                            <span class="pp-brand__name">Perpustakaan<span>Digital</span></span>
                            <span class="pp-brand__tag">Sistem Informasi Perpustakaan</span>
                        </span>
                    </a>

                    <div class="pp-actions">
                        @auth
                            <a href="{{ route('dashboard') }}" class="pp-login-btn">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="pp-btn pp-btn--ghost pp-btn--sm">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="pp-login-btn">Daftar</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <main class="pp-main">
            <section class="pp-hero">
                <div class="pp-container">
                    <h1>Kelola dan pinjam buku dengan <span>lebih mudah</span></h1>
                    <p>Cari koleksi buku, ajukan peminjaman, dan pantau statusnya secara online kapan saja.</p>

                    <div class="pp-actions">
                        @auth
                            <a href="{{ route('dashboard') }}" class="pp-btn">Buka Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="pp-btn">Masuk ke Akun</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="pp-btn pp-btn--ghost">Daftar Sekarang</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </section>

            <section class="pp-features">
                <div class="pp-container">
                    <div class="pp-grid">
                        <div class="pp-card pp-feature">
                            <span class="pp-stat__icon pp-tone-blue"><x-icon name="book" :size="22" /></span>
                            <h3>Koleksi Lengkap</h3>
                            <p>Telusuri daftar buku berdasarkan judul, penulis, dan kategori.</p>
                        </div>
                        <div class="pp-card pp-feature">
                            <span class="pp-stat__icon pp-tone-amber"><x-icon name="swap" :size="22" /></span>
                            <h3>Peminjaman Online</h3>
                            <p>Ajukan peminjaman dan tunggu persetujuan petugas tanpa antre.</p>
                        </div>
                        <div class="pp-card pp-feature">
                            <span class="pp-stat__icon pp-tone-green"><x-icon name="chart" :size="22" /></span>
                            <h3>Laporan &amp; Riwayat</h3>
                            <p>Pantau riwayat dan laporan peminjaman secara real-time.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="pp-footer">
            &copy; {{ date('Y') }} Perpustakaan Digital &middot; Sistem Informasi Perpustakaan
        </footer>
    </body>
</html>
