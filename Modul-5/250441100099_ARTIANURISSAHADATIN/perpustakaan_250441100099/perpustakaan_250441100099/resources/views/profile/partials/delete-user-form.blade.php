<section class="pp-card pp-danger">
    <div class="pp-card__head">
        <div>
            <h2 class="pp-card__title">Hapus Akun</h2>
            <p class="pp-card__desc">Setelah dihapus, seluruh data akunmu akan hilang permanen.</p>
        </div>
    </div>

    <div class="pp-card__body">
        @if ($canEdit)
            <button type="button" class="pp-btn pp-btn--red" id="ppDeleteOpen">Hapus Akun</button>
        @else
            <p class="pp-hint">Akunmu tidak memiliki izin untuk menghapus akun.</p>
        @endif
    </div>

    @if ($canEdit)
        <dialog class="pp-dialog" id="ppDeleteDialog">
            <form method="post" action="{{ route('profile.destroy') }}" class="pp-dialog__body">
                @csrf
                @method('delete')

                <h3>Yakin ingin menghapus akun?</h3>
                <p>Masukkan password untuk mengonfirmasi bahwa kamu ingin menghapus akun secara permanen.</p>

                <div class="pp-field">
                    <label for="delete_password" class="pp-label" style="position:absolute;left:-9999px;">Password</label>
                    <input id="delete_password" name="password" type="password" class="pp-input" placeholder="Password" autocomplete="current-password">
                    @if ($errors->userDeletion->get('password'))
                        <p class="pp-error">{{ $errors->userDeletion->first('password') }}</p>
                    @endif
                </div>

                <div class="pp-actions" style="margin-top:18px;justify-content:flex-end;">
                    <button type="button" class="pp-btn pp-btn--ghost" id="ppDeleteCancel">Batal</button>
                    <button type="submit" class="pp-btn pp-btn--red">Hapus Akun</button>
                </div>
            </form>
        </dialog>

        <script>
            (function () {
                var dialog = document.getElementById('ppDeleteDialog');
                var open = document.getElementById('ppDeleteOpen');
                var cancel = document.getElementById('ppDeleteCancel');
                if (!dialog || !open) return;

                open.addEventListener('click', function () { dialog.showModal(); });
                cancel.addEventListener('click', function () { dialog.close(); });

                @if ($errors->userDeletion->isNotEmpty())
                    dialog.showModal();
                @endif
            })();
        </script>
    @endif
</section>
