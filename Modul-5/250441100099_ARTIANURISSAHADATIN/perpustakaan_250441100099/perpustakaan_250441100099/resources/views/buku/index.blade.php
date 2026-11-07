@extends('layouts.app')

@section('title', 'Daftar Buku - Perpustakaan Digital')

@section('content')
@php
    $bolehKelolaBuku = auth()->user()->hasAnyRole(['admin', 'petugas']);
@endphp

<div class="pp-container">

    <div class="pp-pagehead">
        <p class="pp-eyebrow">Koleksi</p>
        <h1 class="pp-title">{{ $bolehKelolaBuku ? 'Kelola Buku' : 'Daftar Buku' }}</h1>
        <p class="pp-subtitle">
            {{ $bolehKelolaBuku ? 'Tambah, ubah, dan hapus data buku perpustakaan.' : 'Temukan buku yang kamu butuhkan lalu ajukan peminjaman.' }}
        </p>
    </div>

    <x-alerts />
    <div id="alert-container" aria-live="polite"></div>

    <div class="pp-stack">

        {{-- Form tambah / ubah: khusus admin & petugas --}}
        @if ($bolehKelolaBuku)
            <div class="pp-card">
                <div class="pp-card__head">
                    <h2 class="pp-card__title" id="form-title">Tambah Buku Baru</h2>
                </div>
                <div class="pp-card__body">
                    <form id="buku-form" class="pp-form">
                        <input type="hidden" id="buku-id">

                        <div class="pp-row">
                            <div class="pp-field">
                                <label for="kategori_id">Kategori</label>
                                <select class="pp-select" id="kategori_id" required>
                                    <option value="">-- Pilih kategori --</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="pp-field">
                                <label for="tahun_terbit">Tahun Terbit</label>
                                <input type="number" class="pp-input" id="tahun_terbit" min="1900" max="{{ date('Y') }}" required>
                            </div>
                        </div>

                        <div class="pp-row">
                            <div class="pp-field">
                                <label for="judul">Judul</label>
                                <input type="text" class="pp-input" id="judul" maxlength="150" required>
                            </div>

                            <div class="pp-field">
                                <label for="penulis">Penulis</label>
                                <input type="text" class="pp-input" id="penulis" maxlength="100" required>
                            </div>
                        </div>

                        <div class="pp-actions">
                            <button type="submit" class="pp-btn" id="submit-btn">Simpan Buku</button>
                            <button type="button" class="pp-btn pp-btn--ghost" id="cancel-btn" hidden>Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        {{-- Daftar buku --}}
        <div class="pp-card">
            <div class="pp-card__head">
                <h2 class="pp-card__title">Daftar Buku</h2>
                <input type="search" id="cari-buku" class="pp-input" style="max-width: 280px;" placeholder="Cari judul, penulis, kategori...">
            </div>

            <div class="pp-table-wrap">
                <table class="pp-table">
                    <thead>
                        <tr><th>Kategori</th><th>Judul</th><th>Penulis</th><th>Tahun Terbit</th><th>Aksi</th></tr>
                    </thead>
                    <tbody id="buku-table-body">
                        <tr><td colspan="5" class="pp-empty">Memuat data...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
const API_URL = @json(url('/api/buku'));
const BUKU_URL = @json(url('/buku'));
const AJUKAN_URL = @json(route('peminjaman.ajukan'));
const BOLEH_KELOLA_BUKU = @json($bolehKelolaBuku);

const form = document.getElementById('buku-form');
const tableBody = document.getElementById('buku-table-body');
const alertContainer = document.getElementById('alert-container');
const cariInput = document.getElementById('cari-buku');

const kategoriInput = document.getElementById('kategori_id');
const judulInput = document.getElementById('judul');
const penulisInput = document.getElementById('penulis');
const tahunInput = document.getElementById('tahun_terbit');
const idInput = document.getElementById('buku-id');

let semuaBuku = [];

function csrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.content : '';
}

function showMessage(message, type = 'success') {
    alertContainer.innerHTML = '';

    const div = document.createElement('div');
    div.className = 'pp-alert pp-alert--' + (type === 'danger' ? 'error' : 'success');
    div.setAttribute('role', 'alert');

    const p = document.createElement('p');
    p.textContent = message;
    div.appendChild(p);

    alertContainer.appendChild(div);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

async function readResponse(response) {
    let result = {};

    try {
        result = await response.json();
    } catch (error) {
        // Respons bukan JSON
    }

    if (!response.ok) {
        const validation = result.errors
            ? Object.values(result.errors).flat().join(' ')
            : '';

        throw new Error(validation || result.message || `Permintaan gagal (${response.status}).`);
    }

    return result;
}

function namaKategori(buku) {
    return (typeof buku.kategori === 'object' && buku.kategori !== null)
        ? (buku.kategori.nama || '-')
        : (buku.kategori || '-');
}

function renderBuku() {
    const kata = (cariInput.value || '').trim().toLowerCase();

    const daftar = semuaBuku.filter(buku => {
        if (!kata) return true;
        return [namaKategori(buku), buku.judul, buku.penulis, String(buku.tahun_terbit)]
            .join(' ').toLowerCase().includes(kata);
    });

    tableBody.innerHTML = '';

    if (daftar.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="5" class="pp-empty">' +
            (semuaBuku.length === 0 ? 'Belum ada data buku.' : 'Tidak ada buku yang cocok dengan pencarian.') +
            '</td></tr>';
        return;
    }

    daftar.forEach(buku => {
        const tr = document.createElement('tr');

        const kategoriTd = document.createElement('td');
        const badge = document.createElement('span');
        badge.className = 'pp-badge pp-badge--violet';
        badge.textContent = namaKategori(buku);
        kategoriTd.appendChild(badge);
        tr.appendChild(kategoriTd);

        [buku.judul || '-', buku.penulis || '-', buku.tahun_terbit || '-'].forEach((value, i) => {
            const td = document.createElement('td');
            if (i === 0) td.className = 'pp-strong';
            td.textContent = value;
            tr.appendChild(td);
        });

        const actionTd = document.createElement('td');
        actionTd.className = 'pp-nowrap';
        const actions = document.createElement('div');
        actions.className = 'pp-actions';

        // Tombol Detail
        const detailBtn = document.createElement('a');
        detailBtn.href = `${BUKU_URL}/${buku.id}`;
        detailBtn.className = 'pp-btn pp-btn--ghost pp-btn--sm';
        detailBtn.textContent = 'Detail';
        actions.appendChild(detailBtn);

        // Tombol Pinjam (khusus siswa)
        if (!BOLEH_KELOLA_BUKU) {
            const pinjamForm = document.createElement('form');
            pinjamForm.action = AJUKAN_URL;
            pinjamForm.method = 'POST';

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken();

            const bukuInput = document.createElement('input');
            bukuInput.type = 'hidden';
            bukuInput.name = 'buku_id';
            bukuInput.value = buku.id;

            const pinjamBtn = document.createElement('button');
            pinjamBtn.type = 'submit';
            pinjamBtn.className = 'pp-btn pp-btn--green pp-btn--sm';
            pinjamBtn.textContent = 'Pinjam';

            pinjamForm.append(csrfInput, bukuInput, pinjamBtn);
            actions.appendChild(pinjamForm);
        }

        // Tombol Ubah & Hapus (khusus admin/petugas)
        if (BOLEH_KELOLA_BUKU) {
            const editBtn = document.createElement('button');
            editBtn.type = 'button';
            editBtn.className = 'pp-btn pp-btn--amber pp-btn--sm';
            editBtn.textContent = 'Ubah';
            editBtn.addEventListener('click', () => editBuku(buku));

            const deleteBtn = document.createElement('button');
            deleteBtn.type = 'button';
            deleteBtn.className = 'pp-btn pp-btn--red pp-btn--sm';
            deleteBtn.textContent = 'Hapus';
            deleteBtn.addEventListener('click', () => hapusBuku(buku.id));

            actions.append(editBtn, deleteBtn);
        }

        actionTd.appendChild(actions);
        tr.appendChild(actionTd);
        tableBody.appendChild(tr);
    });
}

async function loadBuku() {
    tableBody.innerHTML = '<tr><td colspan="5" class="pp-empty">Memuat data...</td></tr>';

    try {
        const response = await fetch(API_URL, { headers: { 'Accept': 'application/json' } });
        const result = await readResponse(response);

        semuaBuku = result.data || [];
        renderBuku();
    } catch (error) {
        tableBody.innerHTML = '<tr><td colspan="5" class="pp-empty" style="color: var(--pp-red);">Data gagal dimuat.</td></tr>';
        showMessage(error.message || 'API tidak dapat diakses.', 'danger');
        console.error('Kesalahan memuat buku:', error);
    }
}

cariInput.addEventListener('input', renderBuku);

// Form hanya untuk admin/petugas
function resetForm() {
    if (!BOLEH_KELOLA_BUKU || !form) return;

    form.reset();
    idInput.value = '';

    document.getElementById('form-title').textContent = 'Tambah Buku Baru';
    document.getElementById('submit-btn').textContent = 'Simpan Buku';
    document.getElementById('cancel-btn').hidden = true;
}

function editBuku(buku) {
    if (!BOLEH_KELOLA_BUKU) return;

    idInput.value = buku.id;
    kategoriInput.value = buku.kategori_id;
    judulInput.value = buku.judul;
    penulisInput.value = buku.penulis;
    tahunInput.value = buku.tahun_terbit;

    document.getElementById('form-title').textContent = 'Ubah Data Buku';
    document.getElementById('submit-btn').textContent = 'Simpan Perubahan';
    document.getElementById('cancel-btn').hidden = false;

    window.scrollTo({ top: 0, behavior: 'smooth' });
}

if (BOLEH_KELOLA_BUKU && form) {
    form.addEventListener('submit', async event => {
        event.preventDefault();

        const id = idInput.value;

        const payload = {
            kategori_id: kategoriInput.value,
            judul: judulInput.value.trim(),
            penulis: penulisInput.value.trim(),
            tahun_terbit: tahunInput.value
        };

        try {
            const response = await fetch(id ? `${API_URL}/${id}` : API_URL, {
                method: id ? 'PUT' : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken()
                },
                body: JSON.stringify(payload)
            });

            const result = await readResponse(response);

            showMessage(result.message || 'Data berhasil disimpan.', 'success');

            resetForm();
            await loadBuku();
        } catch (error) {
            showMessage(error.message || 'Data gagal disimpan.', 'danger');
        }
    });

    document.getElementById('cancel-btn').addEventListener('click', resetForm);
}

async function hapusBuku(id) {
    if (!BOLEH_KELOLA_BUKU) return;
    if (!confirm('Yakin ingin menghapus buku ini?')) return;

    try {
        const response = await fetch(`${API_URL}/${id}`, {
            method: 'DELETE',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken() }
        });

        const result = await readResponse(response);

        showMessage(result.message || 'Buku berhasil dihapus.', 'success');
        await loadBuku();
    } catch (error) {
        showMessage(error.message || 'Buku gagal dihapus.', 'danger');
    }
}

loadBuku();
</script>
@endsection
