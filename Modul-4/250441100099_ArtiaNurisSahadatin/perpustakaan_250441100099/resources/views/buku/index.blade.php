
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Daftar Buku - Perpustakaan Digital</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

@php
    $bolehKelolaBuku = auth()->user()->hasAnyRole(['admin', 'petugas']);
@endphp

<div class="container py-5">

    {{-- NOTIFIKASI BERHASIL / GAGAL --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ✓ {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    {{-- JUDUL DAN TOMBOL KEMBALI --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <h1 class="h3 mb-0">Data Buku Perpustakaan Digital</h1>

        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            ← Kembali ke Dashboard
        </a>
    </div>

    <div id="alert-container" aria-live="polite"></div>

    {{-- FORM TAMBAH DAN EDIT KHUSUS ADMIN/PETUGAS --}}
    @if ($bolehKelolaBuku)
        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <h2 id="form-title" class="h5 mb-3">Tambah Buku Baru</h2>

                <form id="buku-form">
                    <input type="hidden" id="buku-id">

                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori_id" required>
                            <option value="">-- Pilih kategori --</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="judul" maxlength="255" required>
                    </div>

                    <div class="mb-3">
                        <label for="penulis" class="form-label">Penulis</label>
                        <input type="text" class="form-control" id="penulis" maxlength="255" required>
                    </div>

                    <div class="mb-3">
                        <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                        <input type="number" class="form-control" id="tahun_terbit"
                               min="1000" max="9999" required>
                    </div>

                    <button type="submit" class="btn btn-primary" id="submit-btn">
                        Simpan Buku
                    </button>

                    <button type="button" class="btn btn-secondary d-none" id="cancel-btn">
                        Batal
                    </button>
                </form>

            </div>
        </div>
    @endif

    {{-- DAFTAR BUKU --}}
    <div class="card shadow-sm">
        <div class="card-body">

            <h2 class="h5 mb-3">Daftar Buku</h2>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Tahun Terbit</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="buku-table-body">
                        <tr>
                            <td colspan="5" class="text-center">Memuat data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<script>
const API_URL = '/api/buku';
const BOLEH_KELOLA_BUKU = @json($bolehKelolaBuku);

const form = document.getElementById('buku-form');
const tableBody = document.getElementById('buku-table-body');
const alertContainer = document.getElementById('alert-container');

const kategoriInput = document.getElementById('kategori_id');
const judulInput = document.getElementById('judul');
const penulisInput = document.getElementById('penulis');
const tahunInput = document.getElementById('tahun_terbit');
const idInput = document.getElementById('buku-id');

function showMessage(message, type = 'success') {
    alertContainer.innerHTML = '';

    const div = document.createElement('div');
    div.className = `alert alert-${type} alert-dismissible fade show`;
    div.setAttribute('role', 'alert');
    div.textContent = message;

    const close = document.createElement('button');
    close.type = 'button';
    close.className = 'btn-close';
    close.setAttribute('aria-label', 'Tutup');
    close.addEventListener('click', () => div.remove());

    div.appendChild(close);
    alertContainer.appendChild(div);
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

        throw new Error(
            validation || result.message || `Permintaan gagal (${response.status}).`
        );
    }

    return result;
}

async function loadBuku() {
    tableBody.innerHTML = `
        <tr>
            <td colspan="5" class="text-center">Memuat data...</td>
        </tr>
    `;

    try {
        const response = await fetch(API_URL, {
            headers: {
                'Accept': 'application/json'
            }
        });

        const result = await readResponse(response);
        const bukus = result.data || [];

        tableBody.innerHTML = '';

        if (bukus.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center">Belum ada data buku.</td>
                </tr>
            `;
            return;
        }

        bukus.forEach(buku => {
            const tr = document.createElement('tr');

            const namaKategori =
                typeof buku.kategori === 'object'
                    ? buku.kategori?.nama
                    : buku.kategori;

            [
                namaKategori || '-',
                buku.judul || '-',
                buku.penulis || '-',
                buku.tahun_terbit || '-'
            ].forEach(value => {
                const td = document.createElement('td');
                td.textContent = value;
                tr.appendChild(td);
            });

            const actionTd = document.createElement('td');

            // Tombol Detail
            const detailBtn = document.createElement('a');
            detailBtn.href = `/buku/${buku.id}`;
            detailBtn.className = 'btn btn-sm btn-info me-2';
            detailBtn.textContent = 'Detail';
            actionTd.appendChild(detailBtn);

            // Tombol Pinjam khusus siswa
            if (!BOLEH_KELOLA_BUKU) {
                const pinjamForm = document.createElement('form');
                pinjamForm.action = '/peminjaman/ajukan';
                pinjamForm.method = 'POST';
                pinjamForm.className = 'd-inline';

                const csrfToken = document.querySelector('meta[name="csrf-token"]');

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken ? csrfToken.content : '';

                const bukuInput = document.createElement('input');
                bukuInput.type = 'hidden';
                bukuInput.name = 'buku_id';
                bukuInput.value = buku.id;

                const pinjamBtn = document.createElement('button');
                pinjamBtn.type = 'submit';
                pinjamBtn.className = 'btn btn-sm btn-success';
                pinjamBtn.textContent = 'Pinjam';

                pinjamForm.append(csrfInput, bukuInput, pinjamBtn);
                actionTd.appendChild(pinjamForm);
            }

            // Tombol Ubah dan Hapus khusus admin/petugas
            if (BOLEH_KELOLA_BUKU) {
                const editBtn = document.createElement('button');
                editBtn.type = 'button';
                editBtn.className = 'btn btn-sm btn-warning me-2';
                editBtn.textContent = 'Ubah';
                editBtn.addEventListener('click', () => editBuku(buku));

                const deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.className = 'btn btn-sm btn-danger';
                deleteBtn.textContent = 'Hapus';
                deleteBtn.addEventListener('click', () => hapusBuku(buku.id));

                actionTd.append(editBtn, deleteBtn);
            }

            tr.appendChild(actionTd);
            tableBody.appendChild(tr);
        });

    } catch (error) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center text-danger">
                    Data gagal dimuat.
                </td>
            </tr>
        `;

        showMessage(error.message || 'API tidak dapat diakses.', 'danger');
        console.error('Kesalahan memuat buku:', error);
    }
}

// Fungsi form hanya untuk admin/petugas
function resetForm() {
    if (!BOLEH_KELOLA_BUKU || !form) return;

    form.reset();
    idInput.value = '';

    document.getElementById('form-title').textContent = 'Tambah Buku Baru';
    document.getElementById('submit-btn').textContent = 'Simpan Buku';
    document.getElementById('cancel-btn').classList.add('d-none');
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
    document.getElementById('cancel-btn').classList.remove('d-none');

    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
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
            const response = await fetch(
                id ? `${API_URL}/${id}` : API_URL,
                {
                    method: id ? 'PUT' : 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(payload)
                }
            );

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
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
