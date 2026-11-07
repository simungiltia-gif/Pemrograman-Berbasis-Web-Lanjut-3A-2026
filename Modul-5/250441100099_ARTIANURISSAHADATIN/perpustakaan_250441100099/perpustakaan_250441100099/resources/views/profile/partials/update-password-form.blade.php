<section class="pp-card">
    <div class="pp-card__head">
        <div>
            <h2 class="pp-card__title">Ubah Password</h2>
            <p class="pp-card__desc">Gunakan password yang panjang dan acak agar akunmu aman.</p>
        </div>
    </div>

    <div class="pp-card__body">
        <form method="post" action="{{ route('password.update') }}" class="pp-form">
            @csrf
            @method('put')

            <div class="pp-field">
                <label for="update_password_current_password">Password saat ini</label>
                <input id="update_password_current_password" name="current_password" type="password" class="pp-input" autocomplete="current-password">
                @if ($errors->updatePassword->get('current_password'))
                    <p class="pp-error">{{ $errors->updatePassword->first('current_password') }}</p>
                @endif
            </div>

            <div class="pp-row">
                <div class="pp-field">
                    <label for="update_password_password">Password baru</label>
                    <input id="update_password_password" name="password" type="password" class="pp-input" autocomplete="new-password">
                    @if ($errors->updatePassword->get('password'))
                        <p class="pp-error">{{ $errors->updatePassword->first('password') }}</p>
                    @endif
                </div>

                <div class="pp-field">
                    <label for="update_password_password_confirmation">Konfirmasi password</label>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="pp-input" autocomplete="new-password">
                    @if ($errors->updatePassword->get('password_confirmation'))
                        <p class="pp-error">{{ $errors->updatePassword->first('password_confirmation') }}</p>
                    @endif
                </div>
            </div>

            <div class="pp-actions">
                <button type="submit" class="pp-btn pp-btn--violet">Ubah Password</button>
            </div>
        </form>
    </div>
</section>
