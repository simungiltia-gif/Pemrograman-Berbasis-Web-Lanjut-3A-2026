
@extends('layouts.app')

@section('content')
<style>
    .report-page {
        background: #f5f7fc;
        min-height: 100vh;
        padding: 32px 20px 48px;
        color: #1e293b;
    }

    .report-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 28px;
    }

    .report-eyebrow {
        color: #6366f1;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .report-title {
        font-size: 28px;
        font-weight: 800;
        margin: 0;
        color: #172033;
    }

    .report-subtitle {
        color: #64748b;
        font-size: 14px;
        margin-top: 8px;
    }

    .report-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: white;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 11px 16px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        box-shadow: 0 2px 5px rgba(15, 23, 42, .03);
    }

    .report-back:hover {
        background: #eef2ff;
        color: #4f46e5;
        border-color: #c7d2fe;
    }

    .report-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 28px;
    }

    .report-card {
        background: white;
        border: 1px solid #e8ecf5;
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 4px 14px rgba(30, 41, 59, .04);
    }

    .report-card-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }

    .report-card-label {
        color: #64748b;
        font-size: 13px;
        font-weight: 600;
        margin: 0;
    }

    .report-card-number {
        font-size: 32px;
        font-weight: 800;
        line-height: 1.2;
        margin: 14px 0 0;
        color: #172033;
    }

    .report-icon {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 20px;
        font-weight: 800;
    }

    .report-icon-indigo { background: #eef2ff; color: #6366f1; }
    .report-icon-amber { background: #fffbeb; color: #d97706; }
    .report-icon-blue { background: #eff6ff; color: #2563eb; }
    .report-icon-green { background: #ecfdf5; color: #059669; }

    .report-table-card {
        background: white;
        border: 1px solid #e8ecf5;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 14px rgba(30, 41, 59, .04);
    }

    .report-table-header {
        padding: 22px 24px;
        border-bottom: 1px solid #edf0f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
    }

    .report-table-title {
        font-size: 17px;
        font-weight: 800;
        margin: 0;
        color: #1e293b;
    }

    .report-table-description {
        color: #94a3b8;
        font-size: 13px;
        margin: 6px 0 0;
    }

    .report-count {
        background: #eef2ff;
        color: #4f46e5;
        padding: 7px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .report-table-wrap {
        overflow-x: auto;
    }

    .report-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
        text-align: left;
    }

    .report-table thead {
        background: #f8fafc;
    }

    .report-table th {
        color: #64748b;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .7px;
        padding: 15px 20px;
        border-bottom: 1px solid #e8ecf5;
    }

    .report-table td {
        padding: 17px 20px;
        font-size: 13px;
        border-bottom: 1px solid #f1f5f9;
        color: #475569;
    }

    .report-table tbody tr:hover {
        background: #f8faff;
    }

    .report-id {
        color: #818cf8;
        font-weight: 800;
    }

    .report-member {
        color: #1e293b !important;
        font-weight: 700;
    }

    .report-status {
        display: inline-block;
        border-radius: 20px;
        padding: 6px 11px;
        font-size: 11px;
        font-weight: 800;
    }

    .status-menunggu { background: #fffbeb; color: #b45309; }
    .status-dipinjam { background: #eff6ff; color: #1d4ed8; }
    .status-dikembalikan { background: #ecfdf5; color: #047857; }
    .status-default { background: #f1f5f9; color: #475569; }

    .report-empty {
        text-align: center;
        padding: 50px 20px !important;
    }

    .report-empty-title {
        color: #334155;
        font-size: 14px;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .report-empty-text {
        color: #94a3b8;
        font-size: 13px;
    }

    .report-footer {
        padding: 14px 24px;
        background: #fafbfe;
        color: #94a3b8;
        font-size: 12px;
    }

    @media (max-width: 900px) {
        .report-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .report-page {
            padding: 22px 12px 35px;
        }

        .report-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .report-title {
            font-size: 23px;
        }

        .report-stats {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .report-card {
            padding: 18px;
        }

        .report-table-header {
            padding: 18px;
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>

<div class="report-page">
    <div class="report-container">

        <div class="report-header">
            <div>
                <div class="report-eyebrow">Administrasi Perpustakaan</div>
                <h1 class="report-title">Laporan Peminjaman</h1>
                <p class="report-subtitle">
                    Ringkasan dan daftar transaksi peminjaman buku.
                </p>
            </div>

            <a href="{{ route('dashboard') }}" class="report-back">
                <span aria-hidden="true">←</span>
                Kembali ke Dashboard
            </a>
        </div>

        <div class="report-stats">
            <div class="report-card">
                <div class="report-card-top">
                    <p class="report-card-label">Total Peminjaman</p>
                    <div class="report-icon report-icon-indigo">▤</div>
                </div>
                <p class="report-card-number">{{ $total }}</p>
            </div>

            <div class="report-card">
                <div class="report-card-top">
                    <p class="report-card-label">Menunggu</p>
                    <div class="report-icon report-icon-amber">◷</div>
                </div>
                <p class="report-card-number">{{ $menunggu }}</p>
            </div>

            <div class="report-card">
                <div class="report-card-top">
                    <p class="report-card-label">Sedang Dipinjam</p>
                    <div class="report-icon report-icon-blue">▣</div>
                </div>
                <p class="report-card-number">{{ $dipinjam }}</p>
            </div>

            <div class="report-card">
                <div class="report-card-top">
                    <p class="report-card-label">Dikembalikan</p>
                    <div class="report-icon report-icon-green">✓</div>
                </div>
                <p class="report-card-number">{{ $dikembalikan }}</p>
            </div>
        </div>

        <div class="report-table-card">
            <div class="report-table-header">
                <div>
                    <h2 class="report-table-title">Data Transaksi</h2>
                    <p class="report-table-description">
                        Daftar seluruh transaksi peminjaman buku.
                    </p>
                </div>

                <span class="report-count">
                    {{ count($peminjaman) }} data
                </span>
            </div>

            <div class="report-table-wrap">
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Anggota</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($peminjaman as $item)
                            @php
                                $status = strtolower($item->status ?? '-');
                                $statusClass = match ($status) {
                                    'menunggu' => 'status-menunggu',
                                    'dipinjam' => 'status-dipinjam',
                                    'dikembalikan' => 'status-dikembalikan',
                                    default => 'status-default',
                                };
                            @endphp

                            <tr>
                                <td class="report-id">#{{ $item->id }}</td>
                                <td class="report-member">{{ $item->anggota->nama ?? '-' }}</td>
                                <td>{{ $item->buku->judul ?? '-' }}</td>
                                <td>{{ $item->tanggal_pinjam ?? '-' }}</td>
                                <td>{{ $item->tanggal_kembali ?? 'Belum dikembalikan' }}</td>
                                <td>
                                    <span class="report-status {{ $statusClass }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="report-empty">
                                    <div class="report-empty-title">Belum ada data peminjaman</div>
                                    <div class="report-empty-text">
                                        Transaksi akan muncul di sini setelah ada peminjaman.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="report-footer">
                Laporan Perpustakaan Digital
            </div>
        </div>

    </div>
</div>
@endsection
