<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->get();

        $total = $peminjaman->count();
        $menunggu = $peminjaman->where('status', 'menunggu')->count();
        $dipinjam = $peminjaman->where('status', 'dipinjam')->count();
        $dikembalikan = $peminjaman->where('status', 'dikembalikan')->count();

        return view('laporan.index', compact(
            'peminjaman',
            'total',
            'menunggu',
            'dipinjam',
            'dikembalikan'
        ));
    }
}