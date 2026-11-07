@php
    $navUser = auth()->user();
    $navMenus = [];
    $navRole = null;
    $navHome = route('login');

    if ($navUser) {
        $isAdmin = $navUser->hasRole('admin');
        $isPetugas = $navUser->hasRole('petugas');
        $isStaff = $isAdmin || $isPetugas;

        $navRole = $isAdmin ? 'Admin' : ($isPetugas ? 'Petugas' : 'Siswa');
        $homeRoute = $isAdmin ? 'admin.dashboard' : ($isPetugas ? 'petugas.dashboard' : 'dashboard');
        $navHome = route($homeRoute);

        $navMenus[] = ['label' => 'Dashboard', 'route' => $homeRoute, 'icon' => 'home', 'match' => [$homeRoute, 'dashboard']];

        if ($isAdmin) {
            $navMenus[] = ['label' => 'Pengguna', 'route' => 'users.index', 'icon' => 'users', 'match' => ['users.*']];
        }

        $navMenus[] = [
            'label' => $isStaff ? 'Kelola Buku' : 'Daftar Buku',
            'route' => 'buku.index',
            'icon' => 'book',
            'match' => ['buku.*', 'buku-manage.*'],
        ];

        if ($isStaff) {
            $navMenus[] = ['label' => 'Transaksi', 'route' => 'peminjaman.index', 'icon' => 'swap', 'match' => ['peminjaman.index', 'peminjaman.proses', 'pengembalian.proses']];
            $navMenus[] = ['label' => 'Laporan', 'route' => 'laporan.index', 'icon' => 'chart', 'match' => ['laporan.*']];
        } else {
            $navMenus[] = ['label' => 'Riwayat Saya', 'route' => 'peminjaman.saya', 'icon' => 'clock', 'match' => ['peminjaman.saya']];
        }
    }

    $navInitial = $navUser ? strtoupper(mb_substr($navUser->name, 0, 1)) : '';
@endphp

<nav class="pp-nav" id="ppNav" aria-label="Navigasi utama">
    <div class="pp-container">
        <div class="pp-nav__bar">

            {{-- Logo --}}
            <a href="{{ $navHome }}" class="pp-brand">
                <span class="pp-brand__logo"><x-icon name="book" :size="22" /></span>
                <span>
                    <span class="pp-brand__name">Perpustakaan<span>Digital</span></span>
                    <span class="pp-brand__tag">Sistem Informasi Perpustakaan</span>
                </span>
            </a>

            @auth
                {{-- Menu desktop --}}
                <div class="pp-menu pp-menu--desktop">
                    @foreach ($navMenus as $menu)
                        @php $active = request()->routeIs(...$menu['match']); @endphp
                        <a href="{{ route($menu['route']) }}"
                           class="pp-menu__link {{ $active ? 'is-active' : '' }}"
                           @if ($active) aria-current="page" @endif>
                            <x-icon :name="$menu['icon']" :size="17" />
                            {{ $menu['label'] }}
                        </a>
                    @endforeach
                </div>

                {{-- Akun (desktop) --}}
                <div class="pp-user" id="ppUser">
                    <button type="button" class="pp-user__btn" id="ppUserBtn" aria-haspopup="true" aria-expanded="false" aria-controls="ppUserMenu">
                        <span class="pp-avatar">{{ $navInitial }}</span>
                        <span class="pp-user__text">
                            <span class="pp-user__name">{{ $navUser->name }}</span>
                            <span class="pp-user__role">{{ $navRole }}</span>
                        </span>
                        <x-icon name="chevron" :size="16" />
                    </button>

                    <div class="pp-dropdown" id="ppUserMenu" hidden>
                        <div class="pp-dropdown__head">
                            <strong>{{ $navUser->name }}</strong>
                            <small>{{ $navUser->email }}</small>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="pp-dropdown__item">
                            <x-icon name="user" :size="17" /> Profil Saya
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="pp-dropdown__item pp-dropdown__item--danger">
                                <x-icon name="logout" :size="17" /> Keluar
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Tombol menu mobile --}}
                <button type="button" class="pp-nav__toggle" id="ppNavToggle" aria-label="Buka menu" aria-expanded="false" aria-controls="ppMobile">
                    <span data-icon-open><x-icon name="menu" :size="22" /></span>
                    <span data-icon-close hidden><x-icon name="close" :size="22" /></span>
                </button>
            @else
                <a href="{{ route('login') }}" class="pp-login-btn">Masuk</a>
            @endauth
        </div>
    </div>

    {{-- Menu mobile --}}
    @auth
        <div class="pp-mobile" id="ppMobile">
            <div class="pp-container" style="padding: 0;">
                @foreach ($navMenus as $menu)
                    @php $active = request()->routeIs(...$menu['match']); @endphp
                    <a href="{{ route($menu['route']) }}"
                       class="pp-menu__link {{ $active ? 'is-active' : '' }}"
                       @if ($active) aria-current="page" @endif>
                        <x-icon :name="$menu['icon']" :size="18" />
                        {{ $menu['label'] }}
                    </a>
                @endforeach

                <div class="pp-mobile__user">
                    <div class="pp-mobile__who">
                        <span class="pp-avatar">{{ $navInitial }}</span>
                        <span>
                            <strong>{{ $navUser->name }}</strong>
                            <small>{{ $navUser->email }} &middot; {{ $navRole }}</small>
                        </span>
                    </div>

                    <a href="{{ route('profile.edit') }}"
                       class="pp-menu__link {{ request()->routeIs('profile.*') ? 'is-active' : '' }}">
                        <x-icon name="user" :size="18" /> Profil Saya
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="pp-dropdown__item pp-dropdown__item--danger" style="padding: 12px 14px;">
                            <x-icon name="logout" :size="18" /> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endauth
</nav>

@auth
<script>
    // Menu navigasi (dropdown akun & menu mobile) memakai JavaScript biasa,
    // sehingga tetap berfungsi walaupun aset Vite/Alpine belum di-build.
    (function () {
        var userBtn = document.getElementById('ppUserBtn');
        var userMenu = document.getElementById('ppUserMenu');
        var toggle = document.getElementById('ppNavToggle');
        var mobile = document.getElementById('ppMobile');

        function closeUser() {
            if (!userBtn) return;
            userMenu.hidden = true;
            userBtn.setAttribute('aria-expanded', 'false');
        }

        if (userBtn && userMenu) {
            userBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                var open = userMenu.hidden;
                userMenu.hidden = !open;
                userBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
            document.addEventListener('click', function (e) {
                if (!document.getElementById('ppUser').contains(e.target)) closeUser();
            });
        }

        if (toggle && mobile) {
            toggle.addEventListener('click', function () {
                var open = mobile.classList.toggle('is-open');
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                toggle.querySelector('[data-icon-open]').hidden = open;
                toggle.querySelector('[data-icon-close]').hidden = !open;
            });
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeUser();
        });
    })();
</script>
@endauth
