@php
    $navUser = Auth::user();
    $brandRoute = route('login');

    if ($navUser) {
        if ($navUser->hasRole('admin')) {
            $brandRoute = route('admin.dashboard');
            $roleLabel = 'Administrator';
        } elseif ($navUser->hasRole('petugas')) {
            $brandRoute = route('petugas.dashboard');
            $roleLabel = 'Petugas';
        } else {
            $brandRoute = route('dashboard');
            $roleLabel = 'Siswa';
        }
        $userInitial = strtoupper(mb_substr($navUser->name, 0, 1));
    }
@endphp

<nav x-data="{ mobileOpen: false, userDropdownOpen: false }"
     class="sticky top-0 z-50 border-b border-[#2C3F69] bg-[#3B5183] text-white shadow-md backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-[72px] items-center justify-between">

            {{-- 1. Logo & Brand --}}
            <div class="flex items-center gap-3">
                <a href="{{ $brandRoute }}" class="group flex items-center gap-3 transition">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#833514] text-[#F5E283] shadow-md ring-2 ring-[#F5E283]/30 transition group-hover:scale-105 group-hover:ring-[#F5E283]/70">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>

                    <div class="leading-tight">
                        <span class="text-lg font-extrabold tracking-tight text-white transition group-hover:text-[#F5E283]">
                            Perpustakaan<span class="text-[#F5E283]">Digital</span>
                        </span>
                        <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-[#CBD5E1]">
                            Sistem Informasi Perpustakaan
                        </p>
                    </div>
                </a>
            </div>

            {{-- 2. Menu Navigasi Desktop --}}
            <div class="hidden items-center gap-1.5 md:flex">
                @auth
                    @if($navUser->hasRole('admin'))
                        {{-- Menu Admin --}}
                        <a href="{{ route('admin.dashboard') }}"
                           class="inline-flex items-center gap-1.5 rounded-xl px-3.5 py-2 text-sm font-semibold transition-all duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-[#833514] text-[#F5E283] shadow-sm ring-1 ring-[#F5E283]/30' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Dashboard
                        </a>

                        <a href="{{ route('users.index') }}"
                           class="inline-flex items-center gap-1.5 rounded-xl px-3.5 py-2 text-sm font-semibold transition-all duration-150 {{ request()->routeIs('users.*') ? 'bg-[#833514] text-[#F5E283] shadow-sm ring-1 ring-[#F5E283]/30' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            Pengguna
                        </a>

                        <a href="{{ route('buku.index') }}"
                           class="inline-flex items-center gap-1.5 rounded-xl px-3.5 py-2 text-sm font-semibold transition-all duration-150 {{ request()->routeIs('buku.*') || request()->routeIs('buku-manage.*') ? 'bg-[#833514] text-[#F5E283] shadow-sm ring-1 ring-[#F5E283]/30' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            Buku
                        </a>

                        <a href="{{ route('peminjaman.index') }}"
                           class="inline-flex items-center gap-1.5 rounded-xl px-3.5 py-2 text-sm font-semibold transition-all duration-150 {{ request()->routeIs('peminjaman.index') || request()->routeIs('peminjaman.proses') || request()->routeIs('pengembalian.proses') ? 'bg-[#833514] text-[#F5E283] shadow-sm ring-1 ring-[#F5E283]/30' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                            Transaksi
                        </a>

                        <a href="{{ route('laporan.index') }}"
                           class="inline-flex items-center gap-1.5 rounded-xl px-3.5 py-2 text-sm font-semibold transition-all duration-150 {{ request()->routeIs('laporan.*') ? 'bg-[#833514] text-[#F5E283] shadow-sm ring-1 ring-[#F5E283]/30' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Laporan
                        </a>

                    @elseif($navUser->hasRole('petugas'))
                        {{-- Menu Petugas --}}
                        <a href="{{ route('petugas.dashboard') }}"
                           class="inline-flex items-center gap-1.5 rounded-xl px-3.5 py-2 text-sm font-semibold transition-all duration-150 {{ request()->routeIs('petugas.dashboard') ? 'bg-[#833514] text-[#F5E283] shadow-sm ring-1 ring-[#F5E283]/30' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Dashboard
                        </a>

                        <a href="{{ route('buku.index') }}"
                           class="inline-flex items-center gap-1.5 rounded-xl px-3.5 py-2 text-sm font-semibold transition-all duration-150 {{ request()->routeIs('buku.*') || request()->routeIs('buku-manage.*') ? 'bg-[#833514] text-[#F5E283] shadow-sm ring-1 ring-[#F5E283]/30' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            Buku
                        </a>

                        <a href="{{ route('peminjaman.index') }}"
                           class="inline-flex items-center gap-1.5 rounded-xl px-3.5 py-2 text-sm font-semibold transition-all duration-150 {{ request()->routeIs('peminjaman.index') || request()->routeIs('peminjaman.proses') || request()->routeIs('pengembalian.proses') ? 'bg-[#833514] text-[#F5E283] shadow-sm ring-1 ring-[#F5E283]/30' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                            Transaksi
                        </a>

                        <a href="{{ route('laporan.index') }}"
                           class="inline-flex items-center gap-1.5 rounded-xl px-3.5 py-2 text-sm font-semibold transition-all duration-150 {{ request()->routeIs('laporan.*') ? 'bg-[#833514] text-[#F5E283] shadow-sm ring-1 ring-[#F5E283]/30' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Laporan
                        </a>

                    @else
                        {{-- Menu Siswa --}}
                        <a href="{{ route('dashboard') }}"
                           class="inline-flex items-center gap-1.5 rounded-xl px-3.5 py-2 text-sm font-semibold transition-all duration-150 {{ request()->routeIs('dashboard') ? 'bg-[#833514] text-[#F5E283] shadow-sm ring-1 ring-[#F5E283]/30' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Dashboard
                        </a>

                        <a href="{{ route('buku.index') }}"
                           class="inline-flex items-center gap-1.5 rounded-xl px-3.5 py-2 text-sm font-semibold transition-all duration-150 {{ request()->routeIs('buku.index') || request()->routeIs('buku.show') ? 'bg-[#833514] text-[#F5E283] shadow-sm ring-1 ring-[#F5E283]/30' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            Daftar Buku
                        </a>

                        <a href="{{ route('peminjaman.saya') }}"
                           class="inline-flex items-center gap-1.5 rounded-xl px-3.5 py-2 text-sm font-semibold transition-all duration-150 {{ request()->routeIs('peminjaman.saya') ? 'bg-[#833514] text-[#F5E283] shadow-sm ring-1 ring-[#F5E283]/30' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Riwayat Saya
                        </a>
                    @endif

                    {{-- 3. Akun Pengguna Dropdown (Desktop) --}}
                    <div class="relative ml-2 border-l border-white/20 pl-3">
                        <div @click.outside="userDropdownOpen = false" class="relative">
                            <button @click="userDropdownOpen = !userDropdownOpen"
                                    type="button"
                                    class="group inline-flex items-center gap-2.5 rounded-xl border border-white/10 bg-white/5 px-3 py-1.5 text-sm font-semibold text-white shadow-sm transition hover:border-[#F5E283]/40 hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-[#F5E283]/50">
                                
                                {{-- Inisial Dinamis (Rust Background + Butter Text) --}}
                                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#833514] text-xs font-black text-[#F5E283] shadow-inner ring-1 ring-[#F5E283]/40 transition group-hover:scale-105">
                                    {{ $userInitial }}
                                </span>

                                <div class="hidden text-left lg:block">
                                    <p class="max-w-[120px] truncate text-xs font-bold leading-tight text-white group-hover:text-[#F5E283]">
                                        {{ $navUser->name }}
                                    </p>
                                    <p class="text-[10px] font-medium leading-none text-[#F5E283]">
                                        {{ $roleLabel }}
                                    </p>
                                </div>

                                <svg class="h-4 w-4 text-[#CBD5E1] transition duration-200 group-hover:text-[#F5E283]"
                                     :class="{ 'rotate-180 text-[#F5E283]': userDropdownOpen }"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
                                </svg>
                            </button>

                            {{-- Menu Dropdown --}}
                            <div x-show="userDropdownOpen"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-60 origin-top-right rounded-2xl border border-[#833514]/40 bg-[#28385C] p-1.5 shadow-2xl ring-1 ring-black/10 focus:outline-none"
                                 style="display: none;">
                                
                                <div class="border-b border-white/10 px-3.5 py-3">
                                    <p class="truncate text-xs font-bold text-white">{{ $navUser->name }}</p>
                                    <p class="truncate text-[11px] text-[#CBD5E1]">{{ $navUser->email }}</p>
                                    <span class="mt-2 inline-flex items-center gap-1 rounded-md bg-[#833514] px-2 py-0.5 text-[10px] font-semibold text-[#F5E283] ring-1 ring-[#F5E283]/30">
                                        {{ $roleLabel }}
                                    </span>
                                </div>

                                <div class="mt-1 space-y-0.5">
                                    <a href="{{ route('profile.edit') }}"
                                       class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-semibold text-[#E2E8F0] transition hover:bg-white/10 hover:text-[#F5E283]">
                                        <svg class="h-4 w-4 text-[#F5E283]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profil Saya
                                    </a>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                                class="flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-left text-xs font-semibold text-rose-300 transition hover:bg-rose-950/40 hover:text-rose-200">
                                            <svg class="h-4 w-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Tombol Masuk Guest --}}
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-[#833514] px-5 py-2 text-sm font-bold text-[#F5E283] shadow-md ring-1 ring-[#F5E283]/30 transition hover:bg-[#9E3F17] hover:shadow-lg">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        Masuk
                    </a>
                @endauth
            </div>

            {{-- 4. Tombol Hamburger Mobile --}}
            <button @click="mobileOpen = !mobileOpen"
                    type="button"
                    class="inline-flex items-center justify-center rounded-xl border border-white/10 bg-white/5 p-2.5 text-[#F5E283] transition hover:bg-[#833514] hover:text-[#F5E283] focus:outline-none focus:ring-2 focus:ring-[#F5E283] md:hidden"
                    aria-label="Buka menu navigasi">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- 5. Panel Navigasi Mobile --}}
    <div x-show="mobileOpen"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="border-t-2 border-[#833514] bg-[#28385C] px-4 pb-5 pt-3 md:hidden shadow-2xl"
         style="display: none;">

        @auth
            <div class="space-y-1">
                @if($navUser->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-2.5 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'border-l-4 border-[#F5E283] bg-[#833514] text-[#F5E283]' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard Admin
                    </a>
                    <a href="{{ route('users.index') }}"
                       class="flex items-center gap-2.5 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition {{ request()->routeIs('users.*') ? 'border-l-4 border-[#F5E283] bg-[#833514] text-[#F5E283]' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Kelola Pengguna
                    </a>
                    <a href="{{ route('buku.index') }}"
                       class="flex items-center gap-2.5 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition {{ request()->routeIs('buku.*') || request()->routeIs('buku-manage.*') ? 'border-l-4 border-[#F5E283] bg-[#833514] text-[#F5E283]' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Kelola Buku
                    </a>
                    <a href="{{ route('peminjaman.index') }}"
                       class="flex items-center gap-2.5 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition {{ request()->routeIs('peminjaman.index') || request()->routeIs('peminjaman.proses') || request()->routeIs('pengembalian.proses') ? 'border-l-4 border-[#F5E283] bg-[#833514] text-[#F5E283]' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        Transaksi Peminjaman
                    </a>
                    <a href="{{ route('laporan.index') }}"
                       class="flex items-center gap-2.5 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition {{ request()->routeIs('laporan.*') ? 'border-l-4 border-[#F5E283] bg-[#833514] text-[#F5E283]' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Laporan
                    </a>
                @elseif($navUser->hasRole('petugas'))
                    <a href="{{ route('petugas.dashboard') }}"
                       class="flex items-center gap-2.5 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition {{ request()->routeIs('petugas.dashboard') ? 'border-l-4 border-[#F5E283] bg-[#833514] text-[#F5E283]' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard Petugas
                    </a>
                    <a href="{{ route('buku.index') }}"
                       class="flex items-center gap-2.5 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition {{ request()->routeIs('buku.*') || request()->routeIs('buku-manage.*') ? 'border-l-4 border-[#F5E283] bg-[#833514] text-[#F5E283]' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Kelola Buku
                    </a>
                    <a href="{{ route('peminjaman.index') }}"
                       class="flex items-center gap-2.5 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition {{ request()->routeIs('peminjaman.index') || request()->routeIs('peminjaman.proses') || request()->routeIs('pengembalian.proses') ? 'border-l-4 border-[#F5E283] bg-[#833514] text-[#F5E283]' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        Transaksi Peminjaman
                    </a>
                    <a href="{{ route('laporan.index') }}"
                       class="flex items-center gap-2.5 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition {{ request()->routeIs('laporan.*') ? 'border-l-4 border-[#F5E283] bg-[#833514] text-[#F5E283]' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Laporan
                    </a>
                @else
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-2.5 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition {{ request()->routeIs('dashboard') ? 'border-l-4 border-[#F5E283] bg-[#833514] text-[#F5E283]' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('buku.index') }}"
                       class="flex items-center gap-2.5 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition {{ request()->routeIs('buku.index') || request()->routeIs('buku.show') ? 'border-l-4 border-[#F5E283] bg-[#833514] text-[#F5E283]' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Daftar Buku
                    </a>
                    <a href="{{ route('peminjaman.saya') }}"
                       class="flex items-center gap-2.5 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition {{ request()->routeIs('peminjaman.saya') ? 'border-l-4 border-[#F5E283] bg-[#833514] text-[#F5E283]' : 'text-[#E2E8F0] hover:bg-white/10 hover:text-[#F5E283]' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Riwayat Saya
                    </a>
                @endif
            </div>

            {{-- Info User Mobile --}}
            <div class="mt-4 border-t border-white/15 pt-4">
                <div class="flex items-center gap-3 px-1">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#833514] text-sm font-black text-[#F5E283] shadow-md ring-2 ring-[#F5E283]/40">
                        {{ $userInitial }}
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="truncate font-bold text-white">{{ $navUser->name }}</p>
                        <p class="truncate text-xs text-[#CBD5E1]">{{ $navUser->email }}</p>
                    </div>
                    <span class="rounded-md bg-[#833514] px-2 py-0.5 text-[10px] font-semibold text-[#F5E283] ring-1 ring-[#F5E283]/30">
                        {{ $roleLabel }}
                    </span>
                </div>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center gap-2 rounded-xl bg-white/5 px-3.5 py-2 text-xs font-semibold text-[#E2E8F0] transition hover:bg-white/10 hover:text-[#F5E283]">
                        <svg class="h-4 w-4 text-[#F5E283]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profil Saya
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="flex w-full items-center gap-2 rounded-xl px-3.5 py-2 text-left text-xs font-semibold text-rose-300 transition hover:bg-rose-950/40 hover:text-rose-200">
                            <svg class="h-4 w-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}"
               class="block rounded-xl bg-[#833514] px-4 py-2.5 text-center text-sm font-bold text-[#F5E283] shadow-md ring-1 ring-[#F5E283]/40">
                Masuk
            </a>
        @endauth
    </div>
</nav>
