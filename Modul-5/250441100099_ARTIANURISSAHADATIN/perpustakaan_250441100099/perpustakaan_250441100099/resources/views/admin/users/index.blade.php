@extends('layouts.app')

@section('title', 'Kelola Pengguna - Perpustakaan Digital')

@section('content')
<div class="pp-container">

    <div class="pp-pagehead">
        <div class="pp-pagehead__row">
            <div>
                <p class="pp-eyebrow">Admin</p>
                <h1 class="pp-title">Kelola Pengguna</h1>
                <p class="pp-subtitle">Tambah, ubah, dan atur role pengguna perpustakaan.</p>
            </div>
            <a href="{{ route('users.create') }}" class="pp-btn"><x-icon name="plus" :size="16" /> Tambah Pengguna</a>
        </div>
    </div>

    <x-alerts />

    <div class="pp-card">
        <div class="pp-table-wrap">
            <table class="pp-table">
                <thead>
                    <tr><th>No</th><th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="pp-strong">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @forelse ($user->roles as $role)
                                    <span class="pp-badge pp-badge--violet">{{ ucfirst($role->name) }}</span>
                                @empty
                                    <span class="pp-badge pp-badge--gray">Belum ada role</span>
                                @endforelse
                            </td>
                            <td class="pp-nowrap">
                                <div class="pp-actions">
                                    <a href="{{ route('users.edit', $user->id) }}" class="pp-btn pp-btn--amber pp-btn--sm">Edit</a>

                                    @if ($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="pp-btn pp-btn--red pp-btn--sm">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="pp-empty">Belum ada data pengguna.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
