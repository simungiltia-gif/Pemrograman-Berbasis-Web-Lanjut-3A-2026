<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create', [
            'roles' => $this->roleNames(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', Rule::in($this->roleNames())],
        ], $this->messages());

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->syncRoles([$data['role']]);

        if ($data['role'] === 'siswa') {
            $user->anggotaOrCreate();
        }

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function show(string $id): RedirectResponse
    {
        return redirect()->route('users.edit', $id);
    }

    public function edit(string $id)
    {
        $user = User::with('roles')->findOrFail($id);

        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $this->roleNames(),
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role' => ['required', Rule::in($this->roleNames())],
        ], $this->messages());

        // Jangan sampai admin terakhir kehilangan role admin.
        if ($user->hasRole('admin') && $data['role'] !== 'admin' && User::role('admin')->count() <= 1) {
            return back()->withInput()->with('error', 'Admin terakhir tidak boleh diubah rolenya.');
        }

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        if (auth()->user()->can('kelola role pengguna')) {
            $user->syncRoles([$data['role']]);
        }

        // Samakan data anggota bila sudah ada.
        if ($user->anggota) {
            $user->anggota->update(['nama' => $user->name, 'email' => $user->email]);
        } elseif ($data['role'] === 'siswa') {
            $user->anggotaOrCreate();
        }

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Kamu tidak bisa menghapus akunmu sendiri.');
        }

        if ($user->hasRole('admin') && User::role('admin')->count() <= 1) {
            return redirect()->route('users.index')->with('error', 'Admin terakhir tidak dapat dihapus.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    private function roleNames(): array
    {
        return Role::orderBy('name')->pluck('name')->all();
    }

    private function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.in' => 'Role yang dipilih tidak valid.',
        ];
    }
}
