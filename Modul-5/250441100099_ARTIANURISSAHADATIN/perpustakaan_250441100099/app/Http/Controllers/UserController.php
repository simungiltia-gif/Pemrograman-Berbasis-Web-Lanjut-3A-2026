<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Tampilkan daftar seluruh pengguna.
     */
    public function index(): View
    {
        $users = User::with('roles')->orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Tampilkan form untuk menambah pengguna baru.
     */
    public function create(): View
    {
        return view('admin.users.create', [
            'roles' => $this->roleNames(),
        ]);
    }

    /**
     * Simpan pengguna baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role'     => ['required', Rule::in($this->roleNames())],
        ], $this->messages());

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->syncRoles([$data['role']]);

        // Hubungkan ke data anggota jika role adalah siswa
        if ($data['role'] === 'siswa') {
            $user->anggotaOrCreate();
        }

        return redirect()->route('users.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    /**
     * Redirect detail ke form edit.
     */
    public function show(string $id): RedirectResponse
    {
        return redirect()->route('users.edit', $id);
    }

    /**
     * Tampilkan form untuk mengedit pengguna.
     */
    public function edit(string $id): View
    {
        $user = User::with('roles')->findOrFail($id);

        return view('admin.users.edit', [
            'user'  => $user,
            'roles' => $this->roleNames(),
        ]);
    }

    /**
     * Simpan perubahan data pengguna ke database.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'role'     => ['required', Rule::in($this->roleNames())],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ], $this->messages());

        // Pengaman: Jangan sampai admin terakhir kehilangan role admin
        if ($user->hasRole('admin') && $data['role'] !== 'admin' && User::role('admin')->count() <= 1) {
            return back()->withInput()->with('error', 'Role admin terakhir tidak boleh diubah ke peran lain.');
        }

        $user->name = $data['name'];
        $user->email = $data['email'];

        // Update password hanya jika diisi oleh admin
        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        // Perbarui role pengguna
        $user->syncRoles([$data['role']]);

        // Sinkronkan data anggota jika ada
        if ($user->anggota) {
            $user->anggota->update([
                'nama'  => $user->name,
                'email' => $user->email,
            ]);
        } elseif ($data['role'] === 'siswa') {
            $user->anggotaOrCreate();
        }

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Hapus data pengguna.
     */
    public function destroy(string $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        // Jangan izinkan admin menghapus akunnya sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Jangan izinkan menghapus admin terakhir
        if ($user->hasRole('admin') && User::role('admin')->count() <= 1) {
            return redirect()->route('users.index')->with('error', 'Akun admin terakhir tidak dapat dihapus.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    /**
     * Ambil daftar seluruh nama role yang tersedia.
     */
    private function roleNames(): array
    {
        return Role::orderBy('name')->pluck('name')->all();
    }

    /**
     * Pesan kustom validasi dalam bahasa Indonesia.
     */
    private function messages(): array
    {
        return [
            'name.required'       => 'Nama lengkap wajib diisi.',
            'name.string'         => 'Nama lengkap harus berupa teks.',
            'name.max'            => 'Nama lengkap maksimal 255 karakter.',
            'email.required'      => 'Alamat email wajib diisi.',
            'email.email'         => 'Format alamat email tidak valid.',
            'email.unique'        => 'Alamat email sudah terdaftar oleh pengguna lain.',
            'password.required'   => 'Password wajib diisi.',
            'password.confirmed'  => 'Konfirmasi password tidak cocok.',
            'password.min'        => 'Password minimal harus :min karakter.',
            'role.required'       => 'Role pengguna wajib dipilih.',
            'role.in'             => 'Pilihan role yang dipilih tidak valid.',
        ];
    }
}
