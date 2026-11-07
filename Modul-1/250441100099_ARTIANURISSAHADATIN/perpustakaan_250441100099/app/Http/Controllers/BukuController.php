<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BukuController extends Controller
{
    private function getDataBuku()
    {
        return [
            [
                'id' => 1,
                'judul' => 'Pemrograman Web dengan Laravel',
                'penulis' => 'Budi Santoso',
                'tahun_terbit' => 2023,
                'kategori' => 'Teknologi'
            ],
            [
                'id' => 2,
                'judul' => 'Dasar-Dasar Basis Data Relasional',
                'penulis' => 'Siti Aminah',
                'tahun_terbit' => 2021,
                'kategori' => 'Komputer'
            ],
            [
                'id' => 3,
                'judul' => 'Algoritma dan Struktur Data',
                'penulis' => 'Eko Prasetyo',
                'tahun_terbit' => 2022,
                'kategori' => 'Teknologi'
            ],
            [
                'id' => 4,
                'judul' => 'Manajemen Sistem Informasi',
                'penulis' => 'Rina Wijaya',
                'tahun_terbit' => 2020,
                'kategori' => 'Manajemen'
            ],
            [
                'id' => 5,
                'judul' => 'Jaringan Komputer Modern',
                'penulis' => 'Ahmad Fauzi',
                'tahun_terbit' => 2024,
                'kategori' => 'Jaringan'
            ],
        ];
    }

    public function index()
    {
        $buku = $this->getDataBuku();
        return view('buku.index', compact('buku'));
    }

    public function show($id)
    {
        $semuaBuku = $this->getDataBuku();
        $buku = null;

        foreach ($semuaBuku as $item) {
            if ($item['id'] == $id) {
                $buku = $item;
                break;
            }
        }

        return view('buku.show', compact('buku'));
    }
}