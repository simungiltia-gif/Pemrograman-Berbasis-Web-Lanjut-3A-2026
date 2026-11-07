<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('petugas')) {
            return redirect()->route('petugas.dashboard');
        }

        // Dashboard siswa
        $anggota = $user->anggota;

        $stats = ['menunggu' => 0, 'dipinjam' => 0, 'dikembalikan' => 0];
        $terbaru = collect();

        if ($anggota) {
            $peminjaman = Peminjaman::with('buku')
                ->where('anggota_id', $anggota->id)
                ->latest()
                ->get();

            $stats['menunggu'] = $peminjaman->where('status', 'menunggu')->count();
            $stats['dipinjam'] = $peminjaman->where('status', 'dipinjam')->count();
            $stats['dikembalikan'] = $peminjaman->where('status', 'dikembalikan')->count();
            $terbaru = $peminjaman->take(3);
        }

        return view('dashboard', compact('stats', 'terbaru'));
    }
}
