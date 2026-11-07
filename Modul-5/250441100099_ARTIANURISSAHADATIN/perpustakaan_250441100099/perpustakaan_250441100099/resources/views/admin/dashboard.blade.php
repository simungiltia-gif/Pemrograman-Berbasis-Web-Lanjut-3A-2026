@extends('layouts.app')

@section('title', 'Dashboard Admin - Perpustakaan Digital')

@section('content')
<div class="pp-container">

    <div class="pp-pagehead">
        <p class="pp-eyebrow">Dashboard Admin</p>
        <h1 class="pp-title">Halo, {{ Auth::user()->name }}!</h1>
        <p class="pp-subtitle">Berikut ringkasan aktivitas perpustakaan.</p>
    </div>

    <x-alerts />

    <div class="pp-stack">

        <div class="pp-grid pp-grid--stats">
            <div class="pp-card pp-stat">
                <span class="pp-stat__icon pp-tone-blue"><x-icon name="book" :size="22" /></span>
                <div><p class="pp-stat__label">Jumlah Buku</p><p class="pp-stat__value">{{ $jumlahBuku }}</p></div>
            </div>
            <div class="pp-card pp-stat">
                <span class="pp-stat__icon pp-tone-violet"><x-icon name="users" :size="22" /></span>
                <div><p class="pp-stat__label">Jumlah Pengguna</p><p class="pp-stat__value">{{ $jumlahPengguna }}</p></div>
            </div>
            <div class="pp-card pp-stat">
                <span class="pp-stat__icon pp-tone-amber"><x-icon name="clock" :size="22" /></span>
                <div><p class="pp-stat__label">Peminjaman Menunggu</p><p class="pp-stat__value">{{ $peminjamanMenunggu }}</p></div>
            </div>
            <div class="pp-card pp-stat">
                <span class="pp-stat__icon pp-tone-green"><x-icon name="check" :size="22" /></span>
                <div><p class="pp-stat__label">Sedang Dipinjam</p><p class="pp-stat__value">{{ $sedangDipinjam }}</p></div>
            </div>
        </div>

        <div>
            <h2 class="pp-card__title" style="margin-bottom: 12px;">Akses Cepat</h2>
            <div class="pp-actions">
                <a href="{{ route('buku.index') }}" class="pp-btn pp-btn--blue">Kelola Buku</a>
                <a href="{{ route('users.index') }}" class="pp-btn pp-btn--violet">Kelola Pengguna</a>
                <a href="{{ route('peminjaman.index') }}" class="pp-btn pp-btn--green">Transaksi Peminjaman</a>
                <a href="{{ route('laporan.index') }}" class="pp-btn pp-btn--ghost">Laporan</a>
            </div>
        </div>

        <div class="pp-card">
            <div class="pp-card__head"><h2 class="pp-card__title">Transaksi Peminjaman Terbaru</h2></div>
            <div class="pp-table-wrap">
                <table class="pp-table">
                    <thead>
                        <tr><th>Nama Peminjam</th><th>Judul Buku</th><th>Tanggal</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjamanTerbaru as $peminjaman)
                            <tr>
                                <td class="pp-strong">{{ $peminjaman->anggota->nama ?? '-' }}</td>
                                <td>{{ $peminjaman->buku->judul ?? '-' }}</td>
                                <td>{{ $peminjaman->created_at ? $peminjaman->created_at->format('d-m-Y') : '-' }}</td>
                                <td><x-status-badge :status="$peminjaman->status" /></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="pp-empty">Belum ada transaksi peminjaman.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
