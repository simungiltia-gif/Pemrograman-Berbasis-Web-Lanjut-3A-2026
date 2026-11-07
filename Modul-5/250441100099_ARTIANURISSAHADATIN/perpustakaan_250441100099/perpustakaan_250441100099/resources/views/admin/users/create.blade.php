@extends('layouts.app')

@section('title', 'Tambah Pengguna - Perpustakaan Digital')

@section('content')
<div class="pp-container" style="max-width: 760px;">

    <div class="pp-pagehead">
        <p class="pp-eyebrow">Admin</p>
        <h1 class="pp-title">Tambah Pengguna</h1>
    </div>

    <x-alerts :hide-errors="true" />

    <div class="pp-card">
        <div class="pp-card__body">
            <form method="POST" action="{{ route('users.store') }}" class="pp-form">
                @csrf
                @include('admin.users._form')

                <div class="pp-actions">
                    <button type="submit" class="pp-btn">Simpan</button>
                    <a href="{{ route('users.index') }}" class="pp-btn pp-btn--ghost">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
