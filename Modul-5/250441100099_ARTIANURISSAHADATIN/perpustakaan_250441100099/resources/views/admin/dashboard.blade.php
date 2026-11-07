@extends('layouts.app')

@section('content')
<div style="background:#f8fafc; min-height:100vh; padding:30px 20px;">
    <div style="max-width:1200px; margin:auto;">

        <!-- Header -->
        <div style="margin-bottom:25px;">
            <h1 style="font-size:28px; font-weight:700; color:#1e293b;">
                Dashboard Admin
            </h1>

            <p style="color:#64748b; margin-top:5px;">
                Selamat datang, {{ Auth::user()->name }}!
                Berikut ringkasan aktivitas perpustakaan.
            </p>
        </div>

        <!-- Statistik -->
        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:18px;">

            <div style="background:white; padding:22px; border-radius:12px; border:1px solid #e2e8f0;">
                <p style="color:#64748b; font-size:14px;">Jumlah Buku</p>
                <h2 style="font-size:30px; font-weight:700; color:#2563eb;">
                    {{ $jumlahBuku }}
                </h2>
            </div>

            <div style="background:white; padding:22px; border-radius:12px; border:1px solid #e2e8f0;">
                <p style="color:#64748b; font-size:14px;">Jumlah Pengguna</p>
                <h2 style="font-size:30px; font-weight:700; color:#7c3aed;">
                    {{ $jumlahPengguna }}
                </h2>
            </div>

            <div style="background:white; padding:22px; border-radius:12px; border:1px solid #e2e8f0;">
                <p style="color:#64748b; font-size:14px;">Peminjaman Menunggu</p>
                <h2 style="font-size:30px; font-weight:700; color:#d97706;">
                    {{ $peminjamanMenunggu }}
                </h2>
            </div>

            <div style="background:white; padding:22px; border-radius:12px; border:1px solid #e2e8f0;">
                <p style="color:#64748b; font-size:14px;">Sedang Dipinjam</p>
                <h2 style="font-size:30px; font-weight:700; color:#059669;">
                    {{ $sedangDipinjam }}
                </h2>
            </div>
        </div>

        <!-- Akses Cepat -->
        <div style="margin-top:30px;">
            <h2 style="font-size:20px; font-weight:700; color:#1e293b; margin-bottom:15px;">
                Akses Cepat
            </h2>

            <div style="display:flex; flex-wrap:wrap; gap:12px;">
                <a href="{{ route('buku.index') }}"
                   style="background:#2563eb; color:white; padding:12px 18px; border-radius:8px; text-decoration:none;">
                    Kelola Buku
                </a>

                <a href="{{ route('users.index') }}"
                   style="background:#7c3aed; color:white; padding:12px 18px; border-radius:8px; text-decoration:none;">
                    Kelola Pengguna
                </a>

                <a href="{{ route('peminjaman.index') }}"
                   style="background:#059669; color:white; padding:12px 18px; border-radius:8px; text-decoration:none;">
                    Transaksi Peminjaman
                </a>

                <a href="{{ route('laporan.index') }}"
                   style="background:#475569; color:white; padding:12px 18px; border-radius:8px; text-decoration:none;">
                    Laporan
                </a>
            </div>
        </div>

        <!-- Transaksi Terbaru -->
        <div style="margin-top:30px; background:white; border:1px solid #e2e8f0; border-radius:12px; overflow:hidden;">
            <div style="padding:20px; border-bottom:1px solid #e2e8f0;">
                <h2 style="font-size:20px; font-weight:700; color:#1e293b;">
                    Transaksi Peminjaman Terbaru
                </h2>
            </div>

            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; text-align:left;">
                    <thead style="background:#f1f5f9; color:#475569;">
                        <tr>
                            <th style="padding:13px 18px;">Nama Peminjam</th>
                            <th style="padding:13px 18px;">Judul Buku</th>
                            <th style="padding:13px 18px;">Tanggal</th>
                            <th style="padding:13px 18px;">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($peminjamanTerbaru as $peminjaman)
                            <tr style="border-top:1px solid #e2e8f0;">
                                <td style="padding:13px 18px;">
                                    {{ $peminjaman->anggota->name ?? '-' }}
                                </td>

                                <td style="padding:13px 18px;">
                                    {{ $peminjaman->buku->judul_buku ?? '-' }}
                                </td>

                                <td style="padding:13px 18px;">
                                    {{ $peminjaman->created_at ? $peminjaman->created_at->format('d-m-Y') : '-' }}
                                </td>

                                <td style="padding:13px 18px;">
                                    {{ ucfirst($peminjaman->status ?? '-') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="padding:25px; text-align:center; color:#64748b;">
                                    Belum ada transaksi peminjaman.
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