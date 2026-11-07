<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                    Pengaturan Profil
                </h2>
                <p class="text-sm text-gray-500">
                    Kelola informasi akun Anda dan perbarui kata sandi secara aman.
                </p>
            </div>
            <div>
                @php
                    $dashboardRoute = route('dashboard');
                    if (Auth::user()->hasRole('admin')) {
                        $dashboardRoute = route('admin.dashboard');
                    } elseif (Auth::user()->hasRole('petugas')) {
                        $dashboardRoute = route('petugas.dashboard');
                    }
                @endphp
                <a href="{{ $dashboardRoute }}"
                   class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-[#3B5183] hover:bg-gray-50 hover:text-[#3B5183]">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Alert Berhasil --}}
            @if (session('status') === 'profile-updated')
                <div class="mb-6 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50/90 p-4 text-emerald-800 shadow-sm backdrop-blur" role="status">
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-emerald-900">Profil Berhasil Diperbarui</h4>
                        <p class="mt-0.5 text-xs text-emerald-700">Data informasi akun dan/atau password Anda telah berhasil disimpan ke sistem perpustakaan.</p>
                    </div>
                </div>
            @endif

            {{-- Alert Error Sesi --}}
            @if (session('error'))
                <div class="mb-6 flex items-start gap-3 rounded-2xl border border-rose-200 bg-rose-50/90 p-4 text-rose-800 shadow-sm backdrop-blur" role="alert">
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-xl bg-rose-100 text-rose-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-rose-900">Pemberitahuan</h4>
                        <p class="mt-0.5 text-xs text-rose-700">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            {{-- Alert Kesalahan Validasi Umum --}}
            @if (isset($errors) && $errors->any())
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

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

                {{-- Kolom Kiri: Kartu Ringkasan Akun --}}
                <div class="space-y-6 lg:col-span-1">
                    <div class="overflow-hidden rounded-2xl border border-[#3B5183]/15 bg-white p-6 shadow-sm">
                        <div class="flex flex-col items-center text-center">
                            {{-- Avatar Pengguna (Rust & Butter Palette) --}}
                            <div class="relative">
                                <div class="flex h-24 w-24 items-center justify-center rounded-3xl bg-[#833514] text-3xl font-black text-[#F5E283] shadow-lg ring-4 ring-[#F5E283]/40">
                                    {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                                </div>
                                <span class="absolute bottom-0 right-0 flex h-6 w-6 items-center justify-center rounded-full bg-emerald-500 text-white ring-2 ring-white" title="Akun Aktif">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                            </div>

                            <h3 class="mt-4 text-lg font-bold text-gray-900">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>

                            {{-- Role Badge --}}
                            <div class="mt-3">
                                @if($user->hasRole('admin'))
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[#833514] px-3.5 py-1 text-xs font-semibold text-[#F5E283] ring-1 ring-[#F5E283]/30">
                                        <span class="h-1.5 w-1.5 rounded-full bg-[#F5E283]"></span>
                                        Administrator
                                    </span>
                                @elseif($user->hasRole('petugas'))
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[#3B5183] px-3.5 py-1 text-xs font-semibold text-white ring-1 ring-white/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                                        Petugas Perpustakaan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[#28385C] px-3.5 py-1 text-xs font-semibold text-[#F5E283] ring-1 ring-[#F5E283]/30">
                                        <span class="h-1.5 w-1.5 rounded-full bg-[#F5E283]"></span>
                                        Siswa / Anggota
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6 border-t border-gray-100 pt-5">
                            <dl class="space-y-3 text-xs text-gray-600">
                                <div class="flex items-center justify-between">
                                    <dt class="text-gray-400">ID Pengguna</dt>
                                    <dd class="font-mono font-semibold text-gray-800">#{{ $user->id }}</dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-gray-400">Terdaftar Sejak</dt>
                                    <dd class="font-medium text-gray-800">
                                        {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                                    </dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-gray-400">Status Keamanan</dt>
                                    <dd class="inline-flex items-center gap-1 font-medium text-emerald-600">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        Terlindungi
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    {{-- Petunjuk Penggunaan --}}
                    <div class="rounded-2xl border border-[#3B5183]/15 bg-[#3B5183]/5 p-5 text-xs text-[#3B5183]">
                        <div class="flex items-center gap-2 font-bold text-[#3B5183]">
                            <svg class="h-4 w-4 text-[#833514]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Tips Pengisian Form
                        </div>
                        <p class="mt-2 text-gray-700 leading-relaxed">
                            Jika Anda hanya ingin memperbarui <strong>Nama Lengkap</strong> atau <strong>Alamat Email</strong>, Anda cukup membiarkan ketiga kolom password di sebelah kanan tetap kosong.
                        </p>
                    </div>
                </div>

                {{-- Kolom Kanan: Formulir Edit Profil --}}
                <div class="lg:col-span-2">
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                        <form method="POST" action="{{ route('profile.update') }}" class="p-6 sm:p-8 space-y-8">
                            @csrf
                            @method('patch')

                            {{-- Bagian 1: Informasi Dasar --}}
                            <div>
                                <div class="border-b border-gray-100 pb-4">
                                    <div class="flex items-center gap-2.5">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#3B5183]/10 text-[#3B5183]">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-base font-bold text-gray-900">Informasi Pribadi</h3>
                                            <p class="text-xs text-gray-500">Perbarui nama lengkap dan alamat email aktif Anda.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    {{-- a. Nama Lengkap --}}
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
                                                   name="name"
                                                   id="name"
                                                   value="{{ old('name', $user->name) }}"
                                                   required
                                                   class="block w-full rounded-xl border-gray-200 pl-10 text-sm font-medium text-gray-800 transition placeholder:text-gray-400 focus:border-[#3B5183] focus:ring-[#3B5183] @error('name') border-rose-300 ring-rose-200 @enderror"
                                                   placeholder="Masukkan nama lengkap">
                                        </div>
                                        @error('name')
                                            <p class="mt-1.5 flex items-center gap-1 text-xs text-rose-600">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    {{-- b. Alamat Email --}}
                                    <div class="sm:col-span-2">
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
                                                   name="email"
                                                   id="email"
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
                                </div>
                            </div>

                            {{-- Bagian 2: Ubah Password --}}
                            <div>
                                <div class="border-b border-gray-100 pb-4">
                                    <div class="flex items-center gap-2.5">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#833514]/10 text-[#833514]">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-base font-bold text-gray-900">Ubah Kata Sandi</h3>
                                            <p class="text-xs text-gray-500">Biarkan ketiga kolom di bawah kosong jika Anda tidak berencana mengganti kata sandi.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 space-y-5">
                                    {{-- c. Password Saat Ini --}}
                                    <div>
                                        <label for="current_password" class="block text-xs font-bold uppercase tracking-wider text-gray-700">
                                            Password Saat Ini
                                        </label>
                                        <div class="relative mt-2">
                                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                            </div>
                                            <input type="password"
                                                   name="current_password"
                                                   id="current_password"
                                                   autocomplete="current-password"
                                                   class="block w-full rounded-xl border-gray-200 pl-10 text-sm font-medium text-gray-800 transition placeholder:text-gray-400 focus:border-[#3B5183] focus:ring-[#3B5183] @error('current_password') border-rose-300 ring-rose-200 @enderror"
                                                   placeholder="Ketik password lama Anda untuk verifikasi">
                                        </div>
                                        <p class="mt-1 text-[11px] text-gray-400">Wajib diisi jika Anda ingin memasukkan password baru.</p>
                                        @error('current_password')
                                            <p class="mt-1.5 flex items-center gap-1 text-xs text-rose-600">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                                        {{-- d. Password Baru --}}
                                        <div>
                                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-gray-700">
                                                Password Baru
                                            </label>
                                            <div class="relative mt-2">
                                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                                    </svg>
                                                </div>
                                                <input type="password"
                                                       name="password"
                                                       id="password"
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

                                        {{-- e. Konfirmasi Password Baru --}}
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
                                                       name="password_confirmation"
                                                       id="password_confirmation"
                                                       autocomplete="new-password"
                                                       class="block w-full rounded-xl border-gray-200 pl-10 text-sm font-medium text-gray-800 transition placeholder:text-gray-400 focus:border-[#3B5183] focus:ring-[#3B5183] @error('password_confirmation') border-rose-300 ring-rose-200 @enderror"
                                                       placeholder="Ketik ulang password baru">
                                            </div>
                                            @error('password_confirmation')
                                                <p class="mt-1.5 flex items-center gap-1 text-xs text-rose-600">
                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Bagian 3: Tombol Aksi --}}
                            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:items-center sm:justify-end">
                                <a href="{{ $dashboardRoute }}"
                                   class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 hover:border-[#3B5183] hover:text-[#3B5183] focus:outline-none focus:ring-2 focus:ring-gray-300">
                                    Batal
                                </a>

                                {{-- f. Tombol Simpan Perubahan (Rust Accent Button) --}}
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
        </div>
    </div>
</x-app-layout>
