@props(['id', 'judul', 'penulis', 'tahun'])

<div class="card">
    <div class="card-header">
        <h3>{{ $judul }}</h3>
    </div>
    <div class="card-body">
        <p><strong>Penulis:</strong> {{ $penulis }}</p>
        <p><strong>Tahun Terbit:</strong> {{ $tahun }}</p>
        
        {{-- Slot untuk informasi tambahan / kategori --}}
        @if(isset($badge))
            <div class="card-slot">
                {{ $badge }}
            </div>
        @endif
    </div>
    <div class="card-footer">
        <a href="{{ route('buku.show', ['id' => $id]) }}" class="btn btn-detail">Detail Buku</a>
    </div>
</div>