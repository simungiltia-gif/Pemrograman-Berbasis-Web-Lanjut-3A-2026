<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users')); // Sesuaikan dengan view kamu
    }

    public function create()
    {
        // Tampilkan form tambah user
    }

    public function store(Request $request)
    {
        // Simpan data user baru
    }

    public function show(string $id)
    {
        // Detail user
    }

    public function edit(string $id)
    {
        // Edit user
    }

    public function update(Request $request, string $id)
    {
        // Update user
    }

    public function destroy(string $id)
    {
        // Hapus user
    }
}