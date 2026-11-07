<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil (bisa diedit).
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $anggota = $user->anggota;

        $stats = [
            'total' => 0,
            'menunggu' => 0,
            'dipinjam' => 0,
            'dikembalikan' => 0,
        ];

        if ($anggota) {
            $peminjaman = Peminjaman::where('anggota_id', $anggota->id)->get();

            $stats['total'] = $peminjaman->count();
            $stats['menunggu'] = $peminjaman->where('status', 'menunggu')->count();
            $stats['dipinjam'] = $peminjaman->where('status', 'dipinjam')->count();
            $stats['dikembalikan'] = $peminjaman->where('status', 'dikembalikan')->count();
        }

        return view('profile.edit', [
            'user' => $user,
            'anggota' => $anggota,
            'stats' => $stats,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name')->sort()->values(),
            'canEdit' => $user->can('ubah profil sendiri'),
        ]);
    }

    /**
     * Perbarui informasi profil (nama, email, nomor telepon).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        DB::transaction(function () use ($user, $data) {
            $user->fill([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            // Sinkronkan data keanggotaan agar peminjaman tetap terhubung.
            $anggota = $user->anggotaOrCreate();
            $anggota->update([
                'nama' => $user->name,
                'email' => $user->email,
                'no_telepon' => $data['no_telepon'] ?? '',
            ]);
        });

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Hapus akun milik sendiri.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Jangan sampai admin terakhir terhapus.
        if ($user->hasRole('admin') && User::role('admin')->count() <= 1) {
            return Redirect::route('profile.edit')->with(
                'error',
                'Akun admin terakhir tidak dapat dihapus.'
            );
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
