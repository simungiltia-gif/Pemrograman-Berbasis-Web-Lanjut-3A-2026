
<nav x-data="{ open: false }" class="sticky top-0 z-50 border-b border-indigo-100 bg-white/95 shadow-sm backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-[72px] items-center justify-between">

            {{-- Logo --}}
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 text-white shadow-md">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M4 19.5A2.5 2.5 0 016.5 17H20M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
                    </svg>
                </div>

                <div class="leading-tight">
                    @auth
                        @if(Auth::user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}" class="text-base font-extrabold tracking-tight text-gray-800">
                                Perpustakaan<span class="text-indigo-600">Digital</span>
                            </a>
                        @elseif(Auth::user()->hasRole('petugas'))
                            <a href="{{ route('petugas.dashboard') }}" class="text-base font-extrabold tracking-tight text-gray-800">
                                Perpustakaan<span class="text-indigo-600">Digital</span>
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="text-base font-extrabold tracking-tight text-gray-800">
                                Perpustakaan<span class="text-indigo-600">Digital</span>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-base font-extrabold tracking-tight text-gray-800">
                            Perpustakaan<span class="text-indigo-600">Digital</span>
                        </a>
                    @endauth

                    <p class="mt-1 text-[10px] font-medium uppercase tracking-[0.18em] text-gray-400">
                        Sistem Informasi Perpustakaan
                    </p>
                </div>
            </div>

            {{-- Menu Desktop --}}
            <div class="hidden items-center gap-1 sm:flex">
                @auth
                    @if(Auth::user()->hasRole('admin'))
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            Dashboard
                        </x-nav-link>
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                            Pengguna
                        </x-nav-link>
                        <x-nav-link :href="route('buku.index')" :active="request()->routeIs('buku.*') || request()->routeIs('buku-manage.*')">
                            Buku
                        </x-nav-link>
                        <x-nav-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman.index') || request()->routeIs('peminjaman.proses') || request()->routeIs('pengembalian.proses')">
                            Transaksi
                        </x-nav-link>
                        <x-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.*')">
                            Laporan
                        </x-nav-link>

                    @elseif(Auth::user()->hasRole('petugas'))
                        <x-nav-link :href="route('petugas.dashboard')" :active="request()->routeIs('petugas.dashboard')">
                            Dashboard
                        </x-nav-link>
                        <x-nav-link :href="route('buku.index')" :active="request()->routeIs('buku.*') || request()->routeIs('buku-manage.*')">
                            Buku
                        </x-nav-link>
                        <x-nav-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman.index') || request()->routeIs('peminjaman.proses') || request()->routeIs('pengembalian.proses')">
                            Transaksi
                        </x-nav-link>
                        <x-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.*')">
                            Laporan
                        </x-nav-link>

                    @else
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            Dashboard
                        </x-nav-link>
                        <x-nav-link :href="route('buku.index')" :active="request()->routeIs('buku.index') || request()->routeIs('buku.show')">
                            Daftar Buku
                        </x-nav-link>
                        <x-nav-link :href="route('peminjaman.saya')" :active="request()->routeIs('peminjaman.saya')">
                            Riwayat Saya
                        </x-nav-link>
                    @endif

                    {{-- Akun --}}
                    <div class="ml-3 border-l border-gray-200 pl-3">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-gray-700 transition hover:bg-indigo-50 hover:text-indigo-700">
                                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-700">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </span>
                                    <span class="max-w-[110px] truncate">{{ Auth::user()->name }}</span>
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    Profil Saya
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-gray-700 transition hover:bg-red-50 hover:text-red-600">
                                        Keluar
                                    </button>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                        Masuk
                    </a>
                @endauth
            </div>

            {{-- Tombol Mobile --}}
            <button @click="open = !open"
                    class="inline-flex items-center justify-center rounded-xl p-2 text-gray-600 transition hover:bg-indigo-50 hover:text-indigo-700 sm:hidden"
                    aria-label="Buka menu">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18 18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Menu Mobile --}}
    <div x-show="open" x-transition class="border-t border-indigo-100 bg-white px-4 pb-4 pt-3 sm:hidden">
        @auth
            <div class="space-y-1">
                @if(Auth::user()->hasRole('admin'))
                    <x-responsive-nav-link :href="route('admin.dashboard')">Dashboard Admin</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('users.index')">Kelola Pengguna</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('buku.index')">Kelola Buku</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('peminjaman.index')">Transaksi Peminjaman</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('laporan.index')">Laporan</x-responsive-nav-link>
                @elseif(Auth::user()->hasRole('petugas'))
                    <x-responsive-nav-link :href="route('petugas.dashboard')">Dashboard Petugas</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('buku.index')">Kelola Buku</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('peminjaman.index')">Transaksi Peminjaman</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('laporan.index')">Laporan</x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('dashboard')">Dashboard</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('buku.index')">Daftar Buku</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('peminjaman.saya')">Riwayat Saya</x-responsive-nav-link>
                @endif
            </div>

            <div class="mt-4 border-t border-gray-100 pt-4">
                <div class="px-2">
                    <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">Profil Saya</x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full rounded-lg px-4 py-2 text-left text-sm font-medium text-red-600 transition hover:bg-red-50">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="block rounded-xl bg-indigo-600 px-4 py-2.5 text-center text-sm font-semibold text-white">
                Masuk
            </a>
        @endauth
    </div>
</nav>
