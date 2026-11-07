<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;

class BukuController extends Controller
{
    // Menampilkan halaman daftar buku
    public function index()
    {
        $kategoris = Kategori::all();

        return view('buku.index', compact('kategoris'));
    }

    // Menampilkan detail satu buku
    public function show($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);

        return view('buku.show', compact('buku'));
    }
}