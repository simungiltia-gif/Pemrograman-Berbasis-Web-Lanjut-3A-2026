@extends('layouts.app')

@section('title', 'Daftar Buku - Perpustakaan 250441100099')

@section('content')
    <h2>Daftar Koleksi Buku</h2>
    <p>Berikut adalah koleksi buku yang tersedia saat ini:</p>

    <div class="book-grid">
        @foreach($buku as $item)
            <x-book-card 
                :id="$item['id']" 
                :judul="$item['judul']" 
                :penulis="$item['penulis']" 
                :tahun="$item['tahun_terbit']"
            >
                <x-slot:badge>
                    <span class="badge">{{ $item['kategori'] }}</span>
                </x-slot:badge>
            </x-book-card>
        @endforeach
    </div>
@endsection