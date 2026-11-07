@extends('layouts.app')

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h2 class="font-semibold text-xl text-gray-800 mb-6">
                    Riwayat Peminjaman Saya
                </h2>

                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-4 py-2">No</th>
                                <th class="border px-4 py-2">Judul Buku</th>
                                <th class="border px-4 py-2">Tanggal Pinjam</th>
                                <th class="border px-4 py-2">Tanggal Kembali</th>
                                <th class="border px-4 py-2">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($riwayat as $item)
                                <tr>
                                    <td class="border px-4 py-2">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $item->buku->judul ?? 'Buku tidak ditemukan' }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $item->tanggal_pinjam }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $item->tanggal_kembali ?? '-' }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ ucfirst($item->status ?? 'menunggu') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border px-4 py-4 text-center">
                                        Belum ada riwayat peminjaman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection