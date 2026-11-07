<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Models\Buku;
use App\Models\Kategori;

class BukuController extends Controller
{
    // Menampilkan halaman daftar buku
    public function index()
    {
        $kategoris = Kategori::orderBy('nama')->get();

        return view('buku.index', compact('kategoris'));
    }

    // Menampilkan detail satu buku
    public function show($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);

        return view('buku.show', compact('buku'));
    }

    // Form tambah/ubah buku ada di halaman daftar buku.
    public function create()
    {
        return redirect()->route('buku.index');
    }

    public function store(StoreBukuRequest $request)
    {
        Buku::create($request->validated());

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit($id)
    {
        return redirect()->route('buku.index');
    }

    public function update(UpdateBukuRequest $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->update($request->validated());

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Buku::findOrFail($id)->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
