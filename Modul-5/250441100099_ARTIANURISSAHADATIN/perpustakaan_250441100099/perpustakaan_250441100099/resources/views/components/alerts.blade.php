@props(['hideErrors' => false])

{{-- Menampilkan pesan sukses / error / validasi dari session --}}
@if (session('success'))
    <div class="pp-alert pp-alert--success" role="status">
        <x-icon name="check" /> <p>{{ session('success') }}</p>
    </div>
@endif

@if (session('error'))
    <div class="pp-alert pp-alert--error" role="alert">
        <x-icon name="alert" /> <p>{{ session('error') }}</p>
    </div>
@endif

@if ($errors->any() && ! $hideErrors)
    <div class="pp-alert pp-alert--error" role="alert">
        <x-icon name="alert" />
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    </div>
@endif
