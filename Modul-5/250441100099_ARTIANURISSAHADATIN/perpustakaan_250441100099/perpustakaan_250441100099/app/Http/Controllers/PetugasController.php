<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;

class PetugasController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();

        $totalPeminjaman = Peminjaman::count();

        $belumKembali = Peminjaman::whereNull('tanggal_kembali')->count();

        $menunggu = Peminjaman::where('status', 'menunggu')->count();
        $sedangDipinjam = Peminjaman::where('status', 'dipinjam')->count();

        $peminjamanTerbaru = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->take(5)
            ->get();

        return view('petugas.dashboard', compact(
            'totalBuku',
            'totalPeminjaman',
            'belumKembali',
            'menunggu',
            'sedangDipinjam',
            'peminjamanTerbaru'
        ));
    }
}