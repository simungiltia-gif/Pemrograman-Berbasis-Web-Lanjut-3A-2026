<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\User;
use App\Models\Peminjaman;

class AdminController extends Controller
{
    public function index()
    {
        $jumlahBuku = Buku::count();
        $jumlahPengguna = User::count();

        $peminjamanMenunggu = Peminjaman::where('status', 'menunggu')->count();
        $sedangDipinjam = Peminjaman::where('status', 'dipinjam')->count();

        $peminjamanTerbaru = Peminjaman::with(['buku', 'anggota'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'jumlahBuku',
            'jumlahPengguna',
            'peminjamanMenunggu',
            'sedangDipinjam',
            'peminjamanTerbaru'
        ));
    }
}