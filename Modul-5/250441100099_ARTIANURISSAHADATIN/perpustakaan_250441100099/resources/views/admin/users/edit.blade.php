@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

        {{-- Header Halaman --}}
        <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-[#3B5183]">
                    <span>Admin</span>
                    <span>&bull;</span>
                    <span>Kelola Pengguna</span>
                </div>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-900">
                    Edit Data Pengguna
                </h1>
                <p class="text-xs text-gray-500">
                    Memperbarui data akun untuk: <strong class="text-gray-800">{{ $user->name }}</strong> ({{ $user->email }})
                </p>
            </div>

            <div>
                <a href="{{ route('users.index') }}"
                   class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-[#3B5183] hover:bg-gray-50 hover:text-[#3B5183]">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        {{-- Alert Notifikasi Error Sesi --}}
        @if (session('error'))
            <div class="mb-6 flex items-start gap-3 rounded-2xl border border-rose-200 bg-rose-50/90 p-4 text-rose-800 shadow-sm" role="alert">
                <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-xl bg-rose-100 text-rose-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-rose-900">Terjadi Kesalahan</h4>
                    <p class="mt-0.5 text-xs text-rose-700">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{-- Alert Kesalahan Validasi --}}
        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50/90 p-4 text-amber-900 shadow-sm" role="alert">
                <div class="flex items-center gap-2 font-bold text-sm text-amber-900">
                    <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Mohon periksa kembali formulir di bawah ini:
                </div>
                <ul class="mt-2 list-inside list-disc text-xs text-amber-800 space-y-0.5 pl-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulir Edit Pengguna --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <form method="POST" action="{{ route('users.update', $user->id) }}" class="p-6 sm:p-8 space-y-7">
                @csrf
                @method('PUT')

                {{-- Bagian 1: Data Identitas Pengguna --}}
                <div>
                    <div class="border-b border-gray-100 pb-3">
                        <h3 class="text-base font-bold text-gray-900">Informasi Pengguna</h3>
                        <p class="text-xs text-gray-500">Ubah data nama lengkap, alamat email, serta hak akses peran pengguna.</p>
                    </div>

                    <div class="mt-5 grid grid-cols-1 gap-6 sm:grid-cols-2">
                        {{-- 1. Nama Lengkap --}}
                        <div class="sm:col-span-2">
                            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-gray-700">
                                Nama Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative mt-2">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $user->name) }}"
                                       required
                                       class="block w-full rounded-xl border-gray-200 pl-10 text-sm font-medium text-gray-800 transition placeholder:text-gray-400 focus:border-[#3B5183] focus:ring-[#3B5183] @error('name') border-rose-300 ring-rose-200 @enderror"
                                       placeholder="Masukkan nama lengkap pengguna">
                            </div>
                            @error('name')
                                <p class="mt-1.5 flex items-center gap-1 text-xs text-rose-600">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- 2. Alamat Email --}}
                        <div>
                            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-gray-700">
                                Alamat Email <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative mt-2">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', $user->email) }}"
                                       required
                                       class="block w-full rounded-xl border-gray-200 pl-10 text-sm font-medium text-gray-800 transition placeholder:text-gray-400 focus:border-[#3B5183] focus:ring-[#3B5183] @error('email') border-rose-300 ring-rose-200 @enderror"
                                       placeholder="contoh@domain.com">
                            </div>
                            @error('email')
                                <p class="mt-1.5 flex items-center gap-1 text-xs text-rose-600">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- 3. Role / Peran Pengguna --}}
                        <div>
                            <label for="role" class="block text-xs font-bold uppercase tracking-wider text-gray-700">
                                Role / Peran <span class="text-rose-500">*</span>
                            </label>
                            @php
                                $selectedRole = old('role', $user->roles->first()?->name ?? 'siswa');
                            @endphp
                            <div class="relative mt-2">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <select id="role"
                                        name="role"
                                        required
                                        class="block w-full rounded-xl border-gray-200 pl-10 text-sm font-medium text-gray-800 transition focus:border-[#3B5183] focus:ring-[#3B5183] @error('role') border-rose-300 ring-rose-200 @enderror">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}" @selected($selectedRole === $role)>
                                            {{ ucfirst($role) }}
                                            @if($role === 'admin') (Akses Penuh Administrator)
                                            @elseif($role === 'petugas') (Pengelola Buku & Peminjaman)
                                            @elseif($role === 'siswa') (Anggota Peminjam Buku)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('role')
                                <p class="mt-1.5 flex items-center gap-1 text-xs text-rose-600">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Bagian 2: Password Pengguna (Opsional) --}}
                <div>
                    <div class="border-b border-gray-100 pb-3">
                        <div class="flex items-center gap-2">
                            <h3 class="text-base font-bold text-gray-900">Ubah Password</h3>
                            <span class="rounded-full bg-amber-50 px-2 py-0.5 text-[10px] font-semibold text-amber-700 ring-1 ring-inset ring-amber-600/20">Opsional</span>
                        </div>
                        <p class="text-xs text-gray-500">Biarkan kolom password ini kosong jika Anda tidak bermaksud mengganti password pengguna.</p>
                    </div>

                    <div class="mt-5 grid grid-cols-1 gap-6 sm:grid-cols-2">
                        {{-- 4. Password Baru --}}
                        <div>
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-gray-700">
                                Password Baru (Opsional)
                            </label>
                            <div class="relative mt-2">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input type="password"
                                       id="password"
                                       name="password"
                                       autocomplete="new-password"
                                       class="block w-full rounded-xl border-gray-200 pl-10 text-sm font-medium text-gray-800 transition placeholder:text-gray-400 focus:border-[#3B5183] focus:ring-[#3B5183] @error('password') border-rose-300 ring-rose-200 @enderror"
                                       placeholder="Minimal 8 karakter">
                            </div>
                            @error('password')
                                <p class="mt-1.5 flex items-center gap-1 text-xs text-rose-600">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- 5. Konfirmasi Password Baru --}}
                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-gray-700">
                                Konfirmasi Password Baru
                            </label>
                            <div class="relative mt-2">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <input type="password"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       autocomplete="new-password"
                                       class="block w-full rounded-xl border-gray-200 pl-10 text-sm font-medium text-gray-800 transition placeholder:text-gray-400 focus:border-[#3B5183] focus:ring-[#3B5183]"
                                       placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bagian 3: Tombol Aksi --}}
                <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:items-center sm:justify-end">
                    <a href="{{ route('users.index') }}"
                       class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-[#3B5183] hover:bg-gray-50 hover:text-[#3B5183]">
                        Batal
                    </a>

                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#833514] px-6 py-2.5 text-sm font-bold text-[#F5E283] shadow-md ring-1 ring-[#F5E283]/30 transition hover:bg-[#9E3F17] hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#833514] focus:ring-offset-2">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection

