<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Petugas Perpustakaan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800">
                    Selamat datang, Petugas!
                </h3>
                <p class="mt-1 text-gray-600">
                    Berikut ringkasan aktivitas perpustakaan.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total Buku</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">
                        {{ $totalBuku }}
                    </p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total Peminjaman</p>
                    <p class="text-3xl font-bold text-indigo-600 mt-2">
                        {{ $totalPeminjaman }}
                    </p>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Belum Dikembalikan</p>
                    <p class="text-3xl font-bold text-orange-600 mt-2">
                        {{ $belumKembali }}
                    </p>
                </div>

            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Peminjaman Terbaru
                </h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-4 py-2 text-left">Anggota</th>
                                <th class="border px-4 py-2 text-left">Judul Buku</th>
                                <th class="border px-4 py-2 text-left">Tanggal Pinjam</th>
                                <th class="border px-4 py-2 text-left">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($peminjamanTerbaru as $item)
                                <tr>
                                    <td class="border px-4 py-2">
                                        {{ $item->anggota->nama ?? '-' }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $item->buku->judul ?? '-' }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $item->tanggal_pinjam }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        @if ($item->tanggal_kembali)
                                            <span class="text-green-700 font-medium">
                                                Dikembalikan
                                            </span>
                                        @else
                                            <span class="text-orange-600 font-medium">
                                                Belum kembali
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="border px-4 py-4 text-center">
                                        Belum ada data peminjaman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>