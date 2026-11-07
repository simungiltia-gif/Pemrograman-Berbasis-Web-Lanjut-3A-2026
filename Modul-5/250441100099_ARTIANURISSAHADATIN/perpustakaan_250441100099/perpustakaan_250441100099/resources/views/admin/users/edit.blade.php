@extends('layouts.app')

@section('title', 'Edit Pengguna - Perpustakaan Digital')

@section('content')
<div class="pp-container" style="max-width: 760px;">

    <div class="pp-pagehead">
        <p class="pp-eyebrow">Admin</p>
        <h1 class="pp-title">Edit Pengguna</h1>
        <p class="pp-subtitle">{{ $user->email }}</p>
    </div>

    <x-alerts :hide-errors="true" />

    <div class="pp-card">
        <div class="pp-card__body">
            <form method="POST" action="{{ route('users.update', $user->id) }}" class="pp-form">
                @csrf
                @method('PUT')
                @include('admin.users._form')

                <div class="pp-actions">
                    <button type="submit" class="pp-btn">Simpan Perubahan</button>
                    <a href="{{ route('users.index') }}" class="pp-btn pp-btn--ghost">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
