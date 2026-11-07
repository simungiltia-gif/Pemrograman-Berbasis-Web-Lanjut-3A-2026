@extends('layouts.app')

@section('title', 'Transaksi Peminjaman - Perpustakaan Digital')

@section('content')
<div class="pp-container">

    <div class="pp-pagehead">
        <p class="pp-eyebrow">Transaksi</p>
        <h1 class="pp-title">Data Peminjaman Buku</h1>
        <p class="pp-subtitle">Setujui pengajuan dan catat pengembalian buku.</p>
    </div>

    <x-alerts />

    <div class="pp-card">
        <div class="pp-table-wrap">
            <table class="pp-table">
                <thead>
                    <tr>
                        <th>ID</th><th>Nama Anggota</th><th>Judul Buku</th>
                        <th>Tanggal Pinjam</th><th>Tanggal Kembali</th><th>Status</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjaman as $item)
                        @php $status = strtolower(trim((string) $item->status)); @endphp
                        <tr>
                            <td>#{{ $item->id }}</td>
                            <td class="pp-strong">{{ $item->anggota->nama ?? '-' }}</td>
                            <td>{{ $item->buku->judul ?? '-' }}</td>
                            <td>{{ $item->tanggal_pinjam ?? '-' }}</td>
                            <td>{{ $item->tanggal_kembali ?? 'Belum dikembalikan' }}</td>
                            <td><x-status-badge :status="$item->status" /></td>
                            <td class="pp-nowrap">
                                @if ($status === 'menunggu')
                                    <form action="{{ route('peminjaman.proses', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="pp-btn pp-btn--blue pp-btn--sm">Setujui</button>
                                    </form>
                                @elseif ($status === 'dipinjam')
                                    <form action="{{ route('pengembalian.proses', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="pp-btn pp-btn--green pp-btn--sm">Catat Pengembalian</button>
                                    </form>
                                @elseif ($status === 'dikembalikan')
                                    <span class="pp-strong" style="color: var(--pp-green);">Selesai</span>
                                @else
                                    <span style="color: var(--pp-red); font-weight: 600;">Status tidak dikenali</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="pp-empty">Belum ada data peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
