<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan semua transaksi peminjaman
     * untuk admin dan petugas.
     */
    public function index()
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->get();

        return view('peminjaman.index', compact('peminjaman'));
    }

    /**
     * Siswa mengajukan peminjaman buku.
     */
    public function ajukan(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
        ]);

        $anggota = auth()->user()->anggota;

        if (!$anggota) {
            return redirect()->back()->with(
                'error',
                'Akun siswa belum terhubung dengan data anggota.'
            );
        }

        $buku = Buku::findOrFail($request->buku_id);

        Peminjaman::create([
            'anggota_id' => $anggota->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => now()->toDateString(),
            'tanggal_kembali' => null,
            'status' => 'menunggu',
        ]);

        return redirect()->back()->with(
            'success',
            'Pengajuan peminjaman berhasil dikirim. Silakan tunggu persetujuan petugas.'
        );
    }

    /**
     * Menampilkan riwayat peminjaman milik siswa yang login.
     */
    public function riwayatSaya()
    {
        $anggota = auth()->user()->anggota;

        if (!$anggota) {
            abort(403, 'Akun siswa belum terhubung dengan data anggota.');
        }

        $riwayat = Peminjaman::with(['anggota', 'buku'])
            ->where('anggota_id', $anggota->id)
            ->latest()
            ->get();

        return view('peminjaman.saya', compact('riwayat'));
    }

    /**
     * Menampilkan detail peminjaman.
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])
            ->findOrFail($id);

        // Siswa hanya boleh melihat peminjaman miliknya sendiri.
        if (auth()->user()->hasRole('siswa')) {
            $anggota = auth()->user()->anggota;

            if (
                !$anggota ||
                $peminjaman->anggota_id != $anggota->id
            ) {
                abort(403, 'Kamu tidak memiliki akses ke peminjaman ini.');
            }
        }

        return view('peminjaman.show', compact('peminjaman'));
    }

    /**
     * Petugas menyetujui pengajuan peminjaman.
     */
    public function proses(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Samakan format status agar tidak bermasalah
        // karena huruf kapital atau spasi.
        $status = strtolower(trim((string) $peminjaman->status));

        if ($status !== 'menunggu') {
            return redirect()->route('peminjaman.index')->with(
                'error',
                'Peminjaman ini sudah diproses atau statusnya tidak valid.'
            );
        }

        $peminjaman->update([
            'status' => 'dipinjam',
        ]);

        return redirect()->route('peminjaman.index')->with(
            'success',
            'Peminjaman berhasil disetujui.'
        );
    }

    /**
     * Petugas mencatat pengembalian buku.
     */
    public function kembali(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $status = strtolower(trim((string) $peminjaman->status));

        if ($status !== 'dipinjam') {
            return redirect()->route('peminjaman.index')->with(
                'error',
                'Peminjaman ini belum berstatus dipinjam.'
            );
        }

        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => now()->toDateString(),
        ]);

        return redirect()->route('peminjaman.index')->with(
            'success',
            'Buku berhasil dicatat sebagai dikembalikan.'
        );
    }
}