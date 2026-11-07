<section class="pp-card">
    <div class="pp-card__head">
        <div>
            <h2 class="pp-card__title">Informasi Profil</h2>
            <p class="pp-card__desc">Perbarui nama, email, dan nomor telepon anggota.</p>
        </div>
    </div>

    <div class="pp-card__body">
        <form method="post" action="{{ route('profile.update') }}" class="pp-form">
            @csrf
            @method('patch')

            <div class="pp-field">
                <label for="name">Nama lengkap</label>
                <input id="name" name="name" type="text" class="pp-input"
                       value="{{ old('name', $user->name) }}"
                       required autocomplete="name" @disabled(! $canEdit)>
                @error('name') <p class="pp-error">{{ $message }}</p> @enderror
            </div>

            <div class="pp-row">
                <div class="pp-field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" class="pp-input"
                           value="{{ old('email', $user->email) }}"
                           required autocomplete="username" @disabled(! $canEdit)>
                    @error('email') <p class="pp-error">{{ $message }}</p> @enderror
                </div>

                <div class="pp-field">
                    <label for="no_telepon">Nomor telepon</label>
                    <input id="no_telepon" name="no_telepon" type="text" class="pp-input"
                           value="{{ old('no_telepon', optional($anggota)->no_telepon) }}"
                           placeholder="08xxxxxxxxxx" autocomplete="tel" @disabled(! $canEdit)>
                    @error('no_telepon') <p class="pp-error">{{ $message }}</p> @enderror
                </div>
            </div>

            @if (! $anggota)
                <p class="pp-hint">Data keanggotaan akan dibuat otomatis saat kamu menyimpan profil ini.</p>
            @endif

            @if ($canEdit)
                <div class="pp-actions">
                    <button type="submit" class="pp-btn">Simpan Perubahan</button>
                </div>
            @endif
        </form>
    </div>
</section>
