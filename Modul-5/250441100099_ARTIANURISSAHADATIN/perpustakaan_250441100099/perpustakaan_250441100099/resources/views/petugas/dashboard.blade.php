@extends('layouts.app')

@section('title', 'Dashboard Petugas - Perpustakaan Digital')

@section('content')
<div class="pp-container">

    <div class="pp-pagehead">
        <p class="pp-eyebrow">Dashboard Petugas</p>
        <h1 class="pp-title">Halo, {{ Auth::user()->name }}!</h1>
        <p class="pp-subtitle">Berikut ringkasan aktivitas perpustakaan.</p>
    </div>

    <x-alerts />

    <div class="pp-stack">

        <div class="pp-grid pp-grid--stats">
            <div class="pp-card pp-stat">
                <span class="pp-stat__icon pp-tone-blue"><x-icon name="book" :size="22" /></span>
                <div><p class="pp-stat__label">Total Buku</p><p class="pp-stat__value">{{ $totalBuku }}</p></div>
            </div>
            <div class="pp-card pp-stat">
                <span class="pp-stat__icon pp-tone-violet"><x-icon name="swap" :size="22" /></span>
                <div><p class="pp-stat__label">Total Peminjaman</p><p class="pp-stat__value">{{ $totalPeminjaman }}</p></div>
            </div>
            <div class="pp-card pp-stat">
                <span class="pp-stat__icon pp-tone-amber"><x-icon name="clock" :size="22" /></span>
                <div><p class="pp-stat__label">Menunggu Persetujuan</p><p class="pp-stat__value">{{ $menunggu }}</p></div>
            </div>
            <div class="pp-card pp-stat">
                <span class="pp-stat__icon pp-tone-green"><x-icon name="check" :size="22" /></span>
                <div><p class="pp-stat__label">Sedang Dipinjam</p><p class="pp-stat__value">{{ $sedangDipinjam }}</p></div>
            </div>
        </div>

        <div class="pp-actions">
            <a href="{{ route('peminjaman.index') }}" class="pp-btn pp-btn--green">Proses Transaksi</a>
            <a href="{{ route('buku.index') }}" class="pp-btn">Kelola Buku</a>
            <a href="{{ route('laporan.index') }}" class="pp-btn pp-btn--ghost">Laporan</a>
        </div>

        <div class="pp-card">
            <div class="pp-card__head"><h2 class="pp-card__title">Peminjaman Terbaru</h2></div>
            <div class="pp-table-wrap">
                <table class="pp-table">
                    <thead>
                        <tr><th>Anggota</th><th>Judul Buku</th><th>Tanggal Pinjam</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjamanTerbaru as $item)
                            <tr>
                                <td class="pp-strong">{{ $item->anggota->nama ?? '-' }}</td>
                                <td>{{ $item->buku->judul ?? '-' }}</td>
                                <td>{{ $item->tanggal_pinjam }}</td>
                                <td><x-status-badge :status="$item->status" /></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="pp-empty">Belum ada data peminjaman.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
