@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- Header Halaman --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-[#3B5183]">
                    <span>Admin</span>
                    <span>&bull;</span>
                    <span>Manajemen Akun</span>
                </div>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-900">
                    Kelola Pengguna
                </h1>
                <p class="text-xs text-gray-500">
                    Daftar seluruh pengguna sistem perpustakaan, status peran, dan aksi kelola akun.
                </p>
            </div>

            <div class="flex items-center gap-2.5">
                <a href="{{ route('admin.dashboard') }}"
                   class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-[#3B5183] hover:bg-gray-50 hover:text-[#3B5183]">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('users.create') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-[#833514] px-4 py-2 text-sm font-bold text-[#F5E283] shadow-md ring-1 ring-[#F5E283]/30 transition hover:bg-[#9E3F17] hover:shadow-lg">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Pengguna
                </a>
            </div>
        </div>

        {{-- Alert Notifikasi Sukses --}}
        @if (session('success'))
            <div class="mb-6 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50/90 p-4 text-emerald-800 shadow-sm" role="status">
                <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-emerald-900">Berhasil!</h4>
                    <p class="mt-0.5 text-xs text-emerald-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Alert Notifikasi Error --}}
        @if (session('error'))
            <div class="mb-6 flex items-start gap-3 rounded-2xl border border-rose-200 bg-rose-50/90 p-4 text-rose-800 shadow-sm" role="alert">
                <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-xl bg-rose-100 text-rose-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-rose-900">Perhatian</h4>
                    <p class="mt-0.5 text-xs text-rose-700">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{-- Tabel Pengguna --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-700">
                    <thead class="border-b border-gray-100 bg-[#3B5183]/5 text-[11px] font-bold uppercase tracking-wider text-[#3B5183]">
                        <tr>
                            <th scope="col" class="px-5 py-3.5 text-center w-16">No</th>
                            <th scope="col" class="px-5 py-3.5">Nama Pengguna</th>
                            <th scope="col" class="px-5 py-3.5">Email</th>
                            <th scope="col" class="px-5 py-3.5">Role / Peran</th>
                            <th scope="col" class="px-5 py-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($users as $user)
                            <tr class="transition hover:bg-gray-50/80">
                                <td class="px-5 py-4 text-center font-mono text-xs text-gray-400">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-5 py-4 font-semibold text-gray-900">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#833514] text-xs font-bold text-[#F5E283] shadow-sm">
                                            {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $user->name }}</p>
                                            <p class="text-[11px] text-gray-400">ID: #{{ $user->id }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-xs font-medium text-gray-600">
                                    {{ $user->email }}
                                </td>

                                <td class="px-5 py-4">
                                    @forelse ($user->roles as $role)
                                        @if($role->name === 'admin')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-[#833514] px-2.5 py-0.5 text-xs font-semibold text-[#F5E283] ring-1 ring-[#F5E283]/30">
                                                Administrator
                                            </span>
                                        @elseif($role->name === 'petugas')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-[#3B5183] px-2.5 py-0.5 text-xs font-semibold text-white ring-1 ring-white/20">
                                                Petugas
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-600/20">
                                                Siswa / Anggota
                                            </span>
                                        @endif
                                    @empty
                                        <span class="text-xs text-gray-400 italic">Belum ada role</span>
                                    @endforelse
                                </td>

                                <td class="px-5 py-4 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center gap-2">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('users.edit', $user->id) }}"
                                           class="inline-flex items-center gap-1 rounded-lg border border-[#3B5183]/30 bg-[#3B5183]/10 px-3 py-1.5 text-xs font-semibold text-[#3B5183] transition hover:bg-[#3B5183] hover:text-white shadow-sm">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            Edit
                                        </a>

                                        {{-- Tombol Hapus (Kecuali Diri Sendiri) --}}
                                        @if ($user->id !== auth()->id())
                                            <form action="{{ route('users.destroy', $user->id) }}"
                                                  method="POST"
                                                  class="inline-block"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $user->name }}?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="inline-flex items-center gap-1 rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-600 transition hover:bg-rose-600 hover:text-white shadow-sm">
                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-12 text-center text-gray-400">
                                    <svg class="mx-auto h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <p class="mt-2 text-sm font-semibold text-gray-600">Belum ada data pengguna</p>
                                    <p class="text-xs text-gray-400">Klik tombol "Tambah Pengguna" untuk mendaftarkan akun baru.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
