@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 30px auto; padding: 20px;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="font-size: 26px; font-weight: bold; color: #1f2937;">
            Kelola Pengguna
        </h1>

        <a href="{{ route('users.create') }}"
           style="background: #2563eb; color: white; padding: 10px 16px; border-radius: 6px; text-decoration: none;">
            + Tambah Pengguna
        </a>
    </div>

    @if (session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 12px; margin-bottom: 15px; border-radius: 6px;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 12px; margin-bottom: 15px; border-radius: 6px;">
            {{ session('error') }}
        </div>
    @endif

    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px #00000015; overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; color: #1f2937;">
            <thead>
                <tr style="background: #f3f4f6;">
                    <th style="border: 1px solid #d1d5db; padding: 12px;">No</th>
                    <th style="border: 1px solid #d1d5db; padding: 12px;">Nama</th>
                    <th style="border: 1px solid #d1d5db; padding: 12px;">Email</th>
                    <th style="border: 1px solid #d1d5db; padding: 12px;">Role</th>
                    <th style="border: 1px solid #d1d5db; padding: 12px;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td style="border: 1px solid #d1d5db; padding: 12px;">
                            {{ $loop->iteration }}
                        </td>

                        <td style="border: 1px solid #d1d5db; padding: 12px;">
                            {{ $user->name }}
                        </td>

                        <td style="border: 1px solid #d1d5db; padding: 12px;">
                            {{ $user->email }}
                        </td>

                        <td style="border: 1px solid #d1d5db; padding: 12px;">
                            @forelse ($user->roles as $role)
                                <span style="background: #dbeafe; color: #1e40af; padding: 4px 8px; border-radius: 4px;">
                                    {{ ucfirst($role->name) }}
                                </span>
                            @empty
                                Belum ada role
                            @endforelse
                        </td>

                        <td style="border: 1px solid #d1d5db; padding: 12px; white-space: nowrap;">
                            <a href="{{ route('users.edit', $user->id) }}"
                               style="background: #d97706; color: white; padding: 7px 10px; border-radius: 4px; text-decoration: none;">
                                Edit
                            </a>

                            @if ($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user->id) }}"
                                      method="POST"
                                      style="display: inline-block;"
                                      onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            style="background: #dc2626; color: white; padding: 7px 10px; border: none; border-radius: 4px; cursor: pointer;">
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="border: 1px solid #d1d5db; padding: 20px; text-align: center;">
                            Belum ada data pengguna.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        <a href="{{ route('dashboard') }}" style="color: #2563eb; text-decoration: none;">
            ← Kembali ke Dashboard
        </a>
    </div>

</div>
@endsection