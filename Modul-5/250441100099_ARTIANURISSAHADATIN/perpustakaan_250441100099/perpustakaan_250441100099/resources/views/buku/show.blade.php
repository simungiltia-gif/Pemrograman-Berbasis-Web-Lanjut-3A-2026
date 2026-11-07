@extends('layouts.app')

@section('title', 'Detail Buku - Perpustakaan Digital')

@section('content')
<style>
    .detail-wrapper {
        max-width: 850px;
        margin: 30px auto;
        padding: 0 15px;
    }

    .detail-card {
        background: #fff;
        border-radius: 18px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid #e8eaf0;
    }

    .detail-header {
        background: linear-gradient(135deg, #5E7AC4, #3852B4);
        color: white;
        padding: 25px;
        border-radius: 14px;
        margin-bottom: 25px;
    }

    .detail-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
    }

    .detail-header p {
        margin: 8px 0 0;
        opacity: 0.9;
    }

    .detail-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
    }

    .detail-table th {
        width: 35%;
        color: #64748b;
        font-weight: 600;
        padding: 14px 16px;
        background: #f8fafc;
        border-radius: 8px 0 0 8px;
    }

    .detail-table td {
        padding: 14px 16px;
        color: #334155;
        background: #f8fafc;
        border-radius: 0 8px 8px 0;
    }

    .kategori-badge {
        display: inline-block;
        background: #e8edff;
        color: #3852B4;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    .btn-kembali {
        display: inline-block;
        background: #3852B4;
        color: white;
        text-decoration: none;
        padding: 11px 20px;
        border-radius: 9px;
        transition: 0.2s;
    }

    .btn-kembali:hover {
        background: #2c4195;
        color: white;
        transform: translateY(-2px);
    }

    @media (max-width: 600px) {
        .detail-card {
            padding: 18px;
        }

        .detail-table th {
            width: 40%;
        }
    }
</style>

<div class="detail-wrapper">

    @if($buku)
        <div class="detail-card">

            <div class="detail-header">
                <h2>{{ $buku->judul }}</h2>
                <p>Informasi lengkap buku perpustakaan</p>
            </div>

            <table class="detail-table">
                <tr>
                    <th>ID Buku</th>
                    <td>{{ $buku->id }}</td>
                </tr>

                <tr>
                    <th>Penulis</th>
                    <td>{{ $buku->penulis }}</td>
                </tr>

                <tr>
                    <th>Tahun Terbit</th>
                    <td>{{ $buku->tahun_terbit }}</td>
                </tr>

                <tr>
                    <th>Kategori</th>
                    <td>
                        <span class="kategori-badge">
                            {{ $buku->kategori->nama ?? '-' }}
                        </span>
                    </td>
                </tr>
            </table>

            <div class="mt-4">
                <a href="{{ route('buku.index') }}" class="btn-kembali">
                    ← Kembali ke Daftar Buku
                </a>
            </div>

        </div>
    @else
        <div class="detail-card text-center">
            <h2>Buku Tidak Ditemukan</h2>
            <p class="text-muted">
                Maaf, data buku dengan ID tersebut tidak tersedia.
            </p>

            <a href="{{ route('buku.index') }}" class="btn-kembali">
                ← Kembali ke Daftar Buku
            </a>
        </div>
    @endif

</div>
@endsection