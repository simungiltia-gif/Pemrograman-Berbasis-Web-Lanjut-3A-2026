@extends('layouts.app')

@section('title', 'Dashboard Siswa - Perpustakaan Digital')

@section('content')
<div class="pp-container">

    <div class="pp-pagehead">
        <p class="pp-eyebrow">Dashboard Siswa</p>
        <h1 class="pp-title">Halo, {{ Auth::user()->name }}!</h1>
        <p class="pp-subtitle">Cari buku favoritmu dan pantau status peminjamanmu di sini.</p>
    </div>

    <x-alerts />

    <div class="pp-stack">

        <div class="pp-grid pp-grid--stats">
            <div class="pp-card pp-stat">
                <span class="pp-stat__icon pp-tone-amber"><x-icon name="clock" :size="22" /></span>
                <div><p class="pp-stat__label">Menunggu Persetujuan</p><p class="pp-stat__value">{{ $stats['menunggu'] }}</p></div>
            </div>
            <div class="pp-card pp-stat">
                <span class="pp-stat__icon pp-tone-blue"><x-icon name="book" :size="22" /></span>
                <div><p class="pp-stat__label">Sedang Dipinjam</p><p class="pp-stat__value">{{ $stats['dipinjam'] }}</p></div>
            </div>
            <div class="pp-card pp-stat">
                <span class="pp-stat__icon pp-tone-green"><x-icon name="check" :size="22" /></span>
                <div><p class="pp-stat__label">Sudah Dikembalikan</p><p class="pp-stat__value">{{ $stats['dikembalikan'] }}</p></div>
            </div>
        </div>

        <div class="pp-grid pp-grid--2">
            <a href="{{ route('buku.index') }}" class="pp-card pp-tile">
                <span class="pp-stat__icon pp-tone-blue"><x-icon name="book" :size="22" /></span>
                <h3>Daftar Buku</h3>
                <p>Lihat koleksi buku yang tersedia dan ajukan peminjaman.</p>
                <span class="pp-tile__more">Lihat Buku &rarr;</span>
            </a>

            <a href="{{ route('peminjaman.saya') }}" class="pp-card pp-tile">
                <span class="pp-stat__icon pp-tone-green"><x-icon name="clock" :size="22" /></span>
                <h3>Riwayat Peminjaman</h3>
                <p>Lihat daftar pengajuan dan status peminjaman bukumu.</p>
                <span class="pp-tile__more">Lihat Riwayat &rarr;</span>
            </a>
        </div>

        <div class="pp-card">
            <div class="pp-card__head">
                <h2 class="pp-card__title">Peminjaman Terbaru</h2>
                <a href="{{ route('peminjaman.saya') }}" class="pp-btn pp-btn--ghost pp-btn--sm">Lihat semua</a>
            </div>
            <div class="pp-table-wrap">
                <table class="pp-table">
                    <thead>
                        <tr><th>Judul Buku</th><th>Tanggal Pinjam</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($terbaru as $item)
                            <tr>
                                <td class="pp-strong">{{ $item->buku->judul ?? 'Buku tidak ditemukan' }}</td>
                                <td>{{ $item->tanggal_pinjam }}</td>
                                <td><x-status-badge :status="$item->status" /></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="pp-empty">Belum ada peminjaman. Yuk pinjam buku pertamamu!</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
