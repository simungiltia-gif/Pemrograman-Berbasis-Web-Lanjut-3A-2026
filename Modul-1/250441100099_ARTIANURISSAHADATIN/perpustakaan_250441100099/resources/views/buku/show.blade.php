@extends('layouts.app')

@section('title', 'Detail Buku - Perpustakaan 250441100099')

@section('content')
    @if($buku)
        <div class="detail-box">
            <h2>{{ $buku['judul'] }}</h2>
            <hr>
            <table class="detail-table">
                <tr>
                    <th>ID Buku</th>
                    <td>: {{ $buku['id'] }}</td>
                </tr>
                <tr>
                    <th>Penulis</th>
                    <td>: {{ $buku['penulis'] }}</td>
                </tr>
                <tr>
                    <th>Tahun Terbit</th>
                    <td>: {{ $buku['tahun_terbit'] }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>: <span class="badge">{{ $buku['kategori'] }}</span></td>
                </tr>
            </table>
            
            <div style="margin-top: 20px;">
                <a href="{{ route('buku.index') }}" class="btn btn-secondary">&laquo; Kembali ke Daftar Buku</a>
            </div>
        </div>
    @else
        <div class="error-box">
            <h2>Buku Tidak Ditemukan!</h2>
            <p>Maaf, data buku dengan ID tersebut tidak tersedia di perpustakaan kami.</p>
            <a href="{{ route('buku.index') }}" class="btn btn-primary">&laquo; Kembali ke Daftar Buku</a>
        </div>
    @endif
@endsection