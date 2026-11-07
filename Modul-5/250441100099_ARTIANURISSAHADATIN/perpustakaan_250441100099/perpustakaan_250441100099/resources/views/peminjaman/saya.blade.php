@extends('layouts.app')

@section('title', 'Riwayat Saya - Perpustakaan Digital')

@section('content')
<div class="pp-container">

    <div class="pp-pagehead">
        <p class="pp-eyebrow">Peminjaman</p>
        <h1 class="pp-title">Riwayat Peminjaman Saya</h1>
        <p class="pp-subtitle">Pantau status semua pengajuan peminjamanmu.</p>
    </div>

    <x-alerts />

    <div class="pp-card">
        <div class="pp-table-wrap">
            <table class="pp-table">
                <thead>
                    <tr><th>No</th><th>Judul Buku</th><th>Tanggal Pinjam</th><th>Tanggal Kembali</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse ($riwayat as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="pp-strong">{{ $item->buku->judul ?? 'Buku tidak ditemukan' }}</td>
                            <td>{{ $item->tanggal_pinjam }}</td>
                            <td>{{ $item->tanggal_kembali ?? '-' }}</td>
                            <td><x-status-badge :status="$item->status ?? 'menunggu'" /></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="pp-empty">Belum ada riwayat peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
