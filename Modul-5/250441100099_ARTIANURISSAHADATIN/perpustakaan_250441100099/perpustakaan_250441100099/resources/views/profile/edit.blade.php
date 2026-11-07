@extends('layouts.app')

@section('title', 'Profil Saya - Perpustakaan Digital')

@section('content')
<div class="pp-container">

    <div class="pp-pagehead">
        <p class="pp-eyebrow">Akun</p>
        <h1 class="pp-title">Profil Saya</h1>
        <p class="pp-subtitle">Kelola informasi akun, keamanan, dan data keanggotaan perpustakaanmu.</p>
    </div>

    <div class="pp-alert-wrap">
        @if (session('status') === 'profile-updated')
            <div class="pp-alert pp-alert--success" role="status">
                <x-icon name="check" /> <p>Profil berhasil diperbarui.</p>
            </div>
        @endif

        @if (session('status') === 'password-updated')
            <div class="pp-alert pp-alert--success" role="status">
                <x-icon name="check" /> <p>Password berhasil diubah.</p>
            </div>
        @endif

        @if (session('error'))
            <div class="pp-alert pp-alert--error" role="alert">
                <x-icon name="alert" /> <p>{{ session('error') }}</p>
            </div>
        @endif

        @if (! $canEdit)
            <div class="pp-alert pp-alert--info" role="status">
                <x-icon name="alert" /> <p>Akunmu tidak memiliki izin untuk mengubah profil. Data di bawah hanya bisa dilihat.</p>
            </div>
        @endif
    </div>

    <div class="pp-stack">

        {{-- Ringkasan profil --}}
        <div class="pp-card pp-profile-hero">
            <span class="pp-avatar pp-avatar--lg">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</span>

            <div class="pp-profile-hero__info">
                <h2>{{ $user->name }}</h2>
                <p>{{ $user->email }}</p>
                <div class="pp-chips">
                    @forelse ($roles as $role)
                        <span class="pp-badge pp-badge--role">{{ $role }}</span>
                    @empty
                        <span class="pp-badge pp-badge--role">Belum ada role</span>
                    @endforelse
                    <span class="pp-badge pp-badge--role">Bergabung {{ optional($user->created_at)->format('d M Y') ?? '-' }}</span>
                </div>
            </div>
        </div>

        <div class="pp-grid pp-grid--profile">

            {{-- Kolom kiri: form --}}
            <div class="pp-stack">
                @include('profile.partials.update-profile-information-form')
                @include('profile.partials.update-password-form')
                @include('profile.partials.delete-user-form')
            </div>

            {{-- Kolom kanan: ringkasan --}}
            <div class="pp-stack">

                @can('melihat status peminjaman sendiri')
                    <div class="pp-card">
                        <div class="pp-card__head">
                            <div>
                                <h2 class="pp-card__title">Aktivitas Peminjaman</h2>
                                <p class="pp-card__desc">Ringkasan peminjamanmu.</p>
                            </div>
                        </div>
                        <div class="pp-card__body">
                            <div class="pp-mini-stats">
                                <div class="pp-mini"><strong>{{ $stats['total'] }}</strong><span>Total</span></div>
                                <div class="pp-mini"><strong>{{ $stats['menunggu'] }}</strong><span>Menunggu</span></div>
                                <div class="pp-mini"><strong>{{ $stats['dipinjam'] }}</strong><span>Dipinjam</span></div>
                                <div class="pp-mini"><strong>{{ $stats['dikembalikan'] }}</strong><span>Kembali</span></div>
                            </div>
                        </div>
                    </div>
                @endcan

                <div class="pp-card">
                    <div class="pp-card__head">
                        <h2 class="pp-card__title">Detail Akun</h2>
                    </div>
                    <div class="pp-card__body">
                        <dl class="pp-dl">
                            <div><dt>Nama</dt><dd>{{ $user->name }}</dd></div>
                            <div><dt>Email</dt><dd>{{ $user->email }}</dd></div>
                            <div><dt>Telepon</dt><dd>{{ optional($anggota)->no_telepon ?: '-' }}</dd></div>
                            <div><dt>Peran</dt><dd>{{ $roles->isNotEmpty() ? $roles->implode(', ') : '-' }}</dd></div>
                            <div><dt>Terakhir diperbarui</dt><dd>{{ optional($user->updated_at)->format('d M Y, H:i') ?? '-' }}</dd></div>
                        </dl>
                    </div>
                </div>

                <div class="pp-card">
                    <div class="pp-card__head">
                        <div>
                            <h2 class="pp-card__title">Hak Akses</h2>
                            <p class="pp-card__desc">Izin yang dimiliki akunmu.</p>
                        </div>
                    </div>
                    <div class="pp-card__body">
                        <div class="pp-chips">
                            @forelse ($permissions as $permission)
                                <span class="pp-chip">{{ $permission }}</span>
                            @empty
                                <span class="pp-hint">Belum ada hak akses.</span>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
