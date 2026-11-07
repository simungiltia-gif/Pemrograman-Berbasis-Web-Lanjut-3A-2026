@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- Judul halaman dan tombol kembali --}}
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold text-gray-800">
            Data Peminjaman Buku
        </h1>

        <a href="{{ route('dashboard') }}"
           style="background-color: #4b5563; color: white;"
           class="inline-block rounded px-4 py-2 font-semibold hover:bg-gray-700">
            ← Kembali ke Dashboard
        </a>
    </div>

    {{-- Notifikasi sukses --}}
    @if (session('success'))
        <div class="mb-4 rounded bg-green-100 p-4 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- Notifikasi error --}}
    @if (session('error'))
        <div class="mb-4 rounded bg-red-100 p-4 text-red-800">
            {{ session('error') }}
        </div>
    @endif

    {{-- Notifikasi validasi --}}
    @if ($errors->any())
        <div class="mb-4 rounded bg-red-100 p-4 text-red-800">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- Tabel transaksi --}}
    <div class="overflow-x-auto rounded bg-white p-6 shadow">
        <table class="w-full border-collapse border border-gray-300">
            <thead style="background-color: #f3f4f6;">
                <tr>
                    <th class="border px-4 py-3">ID</th>
                    <th class="border px-4 py-3">Nama Anggota</th>
                    <th class="border px-4 py-3">Judul Buku</th>
                    <th class="border px-4 py-3">Tanggal Pinjam</th>
                    <th class="border px-4 py-3">Tanggal Kembali</th>
                    <th class="border px-4 py-3">Status</th>
                    <th class="border px-4 py-3">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($peminjaman as $item)

                    @php
                        $status = strtolower(trim((string) $item->status));
                    @endphp

                    <tr>
                        {{-- ID --}}
                        <td class="border px-4 py-3">
                            {{ $item->id }}
                        </td>

                        {{-- Nama anggota --}}
                        <td class="border px-4 py-3">
                            {{ $item->anggota->nama ?? '-' }}
                        </td>

                        {{-- Judul buku --}}
                        <td class="border px-4 py-3">
                            {{ $item->buku->judul ?? '-' }}
                        </td>

                        {{-- Tanggal pinjam --}}
                        <td class="border px-4 py-3">
                            {{ $item->tanggal_pinjam ?? '-' }}
                        </td>

                        {{-- Tanggal kembali --}}
                        <td class="border px-4 py-3">
                            {{ $item->tanggal_kembali ?? 'Belum dikembalikan' }}
                        </td>

                        {{-- Status --}}
                        <td class="border px-4 py-3 text-center">
                            @if ($status === 'menunggu')
                                <span style="background-color: #fef3c7; color: #92400e;"
                                      class="inline-block rounded px-3 py-1 font-semibold">
                                    Menunggu
                                </span>

                            @elseif ($status === 'dipinjam')
                                <span style="background-color: #dbeafe; color: #1e40af;"
                                      class="inline-block rounded px-3 py-1 font-semibold">
                                    Dipinjam
                                </span>

                            @elseif ($status === 'dikembalikan')
                                <span style="background-color: #dcfce7; color: #166534;"
                                      class="inline-block rounded px-3 py-1 font-semibold">
                                    Dikembalikan
                                </span>

                            @else
                                <span style="background-color: #f3f4f6; color: #374151;"
                                      class="inline-block rounded px-3 py-1">
                                    {{ $item->status ?? 'Status kosong' }}
                                </span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="border px-4 py-3 text-center">
                            @if ($status === 'menunggu')

                                <form action="{{ route('peminjaman.proses', $item->id) }}"
                                      method="POST"
                                      style="display: inline-block;">
                                    @csrf

                                    <button type="submit"
                                            style="display: inline-block; background-color: #2563eb; color: #ffffff; padding: 8px 14px; border-radius: 6px; font-weight: 600; border: none; cursor: pointer;">
                                        Setujui
                                    </button>
                                </form>

                            @elseif ($status === 'dipinjam')

                                <form action="{{ route('pengembalian.proses', $item->id) }}"
                                      method="POST"
                                      style="display: inline-block;">
                                    @csrf

                                    <button type="submit"
                                            style="display: inline-block; background-color: #16a34a; color: #ffffff; padding: 8px 14px; border-radius: 6px; font-weight: 600; border: none; cursor: pointer;">
                                        Catat Pengembalian
                                    </button>
                                </form>

                            @elseif ($status === 'dikembalikan')

                                <span style="color: #15803d; font-weight: 700;">
                                    Selesai
                                </span>

                            @else

                                <span style="color: #dc2626; font-weight: 600;">
                                    Status tidak dikenali:
                                    {{ $item->status ?? 'kosong' }}
                                </span>

                            @endif
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7"
                            class="border px-4 py-4 text-center text-gray-500">
                            Belum ada data peminjaman.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection