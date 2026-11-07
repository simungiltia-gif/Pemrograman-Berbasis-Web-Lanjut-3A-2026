{{-- Form bersama untuk tambah & edit pengguna. Variabel: $user (opsional), $roles --}}
@php
    $isEdit = isset($user);
    $currentRole = old('role', $isEdit ? optional($user->roles->first())->name : 'siswa');
@endphp

<div class="pp-field">
    <label for="name">Nama lengkap</label>
    <input id="name" name="name" type="text" class="pp-input" value="{{ old('name', $isEdit ? $user->name : '') }}" required>
    @error('name') <p class="pp-error">{{ $message }}</p> @enderror
</div>

<div class="pp-field">
    <label for="email">Email</label>
    <input id="email" name="email" type="email" class="pp-input" value="{{ old('email', $isEdit ? $user->email : '') }}" required>
    @error('email') <p class="pp-error">{{ $message }}</p> @enderror
</div>

<div class="pp-field">
    <label for="role">Role</label>
    <select id="role" name="role" class="pp-select" required>
        @foreach ($roles as $role)
            <option value="{{ $role }}" @selected($currentRole === $role)>{{ ucfirst($role) }}</option>
        @endforeach
    </select>
    @error('role') <p class="pp-error">{{ $message }}</p> @enderror
</div>

<div class="pp-row">
    <div class="pp-field">
        <label for="password">Password {{ $isEdit ? '(kosongkan bila tidak diubah)' : '' }}</label>
        <input id="password" name="password" type="password" class="pp-input" autocomplete="new-password" @if (! $isEdit) required @endif>
        @error('password') <p class="pp-error">{{ $message }}</p> @enderror
    </div>

    <div class="pp-field">
        <label for="password_confirmation">Konfirmasi password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" class="pp-input" autocomplete="new-password" @if (! $isEdit) required @endif>
    </div>
</div>
