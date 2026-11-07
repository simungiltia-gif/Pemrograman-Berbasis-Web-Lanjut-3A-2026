<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information and password.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Perbarui password jika user mengisi password baru
        if ($request->filled('password')) {
            $user->password = Hash::make($request->validated('password'));
        }

        $user->save();

        // Sinkronisasi data anggota jika ada
        if (method_exists($user, 'anggota') && $user->anggota) {
            $user->anggota->update([
                'nama' => $user->name,
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Cegah penghapusan akun admin terakhir
        if ($user->hasRole('admin') && User::role('admin')->count() <= 1) {
            return Redirect::route('profile.edit')->with('error', 'Akun admin terakhir tidak dapat dihapus.');
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
