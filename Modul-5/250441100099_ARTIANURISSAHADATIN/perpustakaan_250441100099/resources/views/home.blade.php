@extends('layouts.app')

@section('title', 'Beranda - Perpustakaan 250441100099')

@section('content')
    <div class="welcome-box">
        <h2>Selamat Datang di Perpustakaan Digital</h2>
        <p>Aplikasi ini dibuat untuk memenuhi Tugas Praktikum Web dengan NIM <strong>250441100099</strong>.</p>
        <p>Silakan akses menu <strong>Daftar Buku</strong> untuk melihat koleksi buku yang tersedia.</p>
        
        <div class="action-btn">
            <a href="{{ route('buku.index') }}" class="btn btn-primary">Lihat Koleksi Buku</a>
        </div>
    </div>
@endsection