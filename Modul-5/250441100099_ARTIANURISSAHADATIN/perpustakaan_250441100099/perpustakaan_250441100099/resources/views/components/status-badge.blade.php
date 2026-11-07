@props(['status' => null])

@php
    $key = strtolower(trim((string) $status));

    $map = [
        'menunggu'     => ['Menunggu', 'pp-badge--amber'],
        'dipinjam'     => ['Dipinjam', 'pp-badge--blue'],
        'dikembalikan' => ['Dikembalikan', 'pp-badge--green'],
    ];

    $label = $map[$key][0] ?? ($status ?: 'Tidak diketahui');
    $class = $map[$key][1] ?? 'pp-badge--gray';
@endphp

<span class="pp-badge {{ $class }}">{{ $label }}</span>
