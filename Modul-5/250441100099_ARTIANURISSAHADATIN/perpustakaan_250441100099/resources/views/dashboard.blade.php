<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Siswa
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Sambutan -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800">
                    Selamat datang, {{ Auth::user()->name }}!
                </h3>
                <p class="text-gray-600 mt-2">
                    Selamat datang di Sistem Informasi Perpustakaan.
                    Silakan cari buku dan lihat status peminjamanmu di sini.
                </p>
            </div>

            <!-- Menu Siswa -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Daftar Buku -->
                <a href="{{ route('buku.index') }}"
                   class="bg-white shadow-sm rounded-lg p-6 hover:shadow-md transition">
                    <h4 class="text-lg font-semibold text-blue-700">
                        📚 Daftar Buku
                    </h4>
                    <p class="text-gray-600 mt-2">
                        Lihat koleksi buku yang tersedia dan ajukan peminjaman.
                    </p>
                    <span class="inline-block mt-4 text-blue-700 font-medium">
                        Lihat Buku →
                    </span>
                </a>

                <!-- Riwayat -->
                <a href="{{ route('peminjaman.saya') }}"
                   class="bg-white shadow-sm rounded-lg p-6 hover:shadow-md transition">
                    <h4 class="text-lg font-semibold text-green-700">
                        📖 Riwayat Peminjaman
                    </h4>
                    <p class="text-gray-600 mt-2">
                        Lihat daftar pengajuan dan status peminjaman buku.
                    </p>
                    <span class="inline-block mt-4 text-green-700 font-medium">
                        Lihat Riwayat →
                    </span>
                </a>

            </div>

        </div>
    </div>
</x-app-layout>