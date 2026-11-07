<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan 250441100099')</title>
    @vite(['resources/css/app.css'])
</head>
<body>

    <header class="site-header">
        <div class="container">
            <h1>Perpustakaan 250441100099</h1>
            <p>Sistem Informasi Perpustakaan Sederhana</p>
        </div>
    </header>

    <nav class="navbar">
        <div class="container">
            <ul>
                <li><a href="{{ route('home') }}">Beranda</a></li>
                <li><a href="{{ route('buku.index') }}">Daftar Buku</a></li>
            </ul>
        </div>
    </nav>

    <main class="main-content">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="site-footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} Perpustakaan 250441100099 - Praktikum Pemrograman Web</p>
        </div>
    </footer>

</body>
</html>