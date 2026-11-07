<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Models\Buku;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::with('kategori')->orderBy('judul')->get();

        return response()->json([
            'success' => true,
            'data' => $bukus,
        ], 200);
    }

    public function store(StoreBukuRequest $request)
    {
        $buku = Buku::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil ditambahkan.',
            'data' => $buku->load('kategori'),
        ], 201);
    }

    public function update(UpdateBukuRequest $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil diperbarui.',
            'data' => $buku->load('kategori'),
        ], 200);
    }

    public function destroy($id)
    {
        Buku::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dihapus.',
        ], 200);
    }
}
