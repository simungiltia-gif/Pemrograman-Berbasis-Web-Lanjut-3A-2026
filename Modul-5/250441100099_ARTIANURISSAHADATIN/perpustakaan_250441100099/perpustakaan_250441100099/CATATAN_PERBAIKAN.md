# Catatan Perbaikan

## Langkah setelah ekstrak (wajib sekali)
1. `php artisan db:seed --class=RoleAndPermissionSeeder`
   (memastikan izin `lihat profil sendiri`, `ubah profil sendiri`, `kelola data pengguna`, dll. ada di database,
   dan akun siswa demo terhubung ke data anggota. Aman dijalankan berulang.)
2. `php artisan optimize:clear`
3. (Opsional) `npm run build` atau `npm run dev` untuk aset Vite. Tampilan baru memakai `public/css/perpus.css`
   sehingga TIDAK bergantung pada build.

## Perbaikan utama
- Layout `layouts/app.blade.php` kini mendukung `@extends` DAN `<x-app-layout>` (sebelumnya dashboard siswa,
  dashboard petugas, dan profil tampil kosong). Vite hanya dimuat bila sudah di-build (tidak lagi error "manifest not found").
- Navigasi baru: menu per role, status aktif, dropdown akun + Profil Saya, menu mobile (JavaScript biasa, tanpa Alpine).
- Profil bisa diedit: nama, email, nomor telepon anggota, password, hapus akun; ringkasan peminjaman dan hak akses.
  Dilindungi izin `lihat profil sendiri` / `ubah profil sendiri`.
- Daftar Buku kini memakai navigasi; Ubah/Hapus/Tambah buku berfungsi (API `update` & `destroy` ditambahkan,
  kolom `stok`/`penerbit` yang tidak ada di database dihapus dari validasi).
- CRUD Pengguna lengkap (tambah, edit, hapus, atur role) dengan pengaman admin terakhir.
- Model `Anggota`, `Buku`, `Kategori` disesuaikan dengan kolom migrasi; akun otomatis terhubung ke data anggota
  (registrasi, seeder, profil, pengajuan pinjam) sehingga tidak ada lagi error "belum terhubung dengan anggota".
- Tampilan data dashboard admin diperbaiki (`nama`/`judul`), cegah pengajuan pinjam ganda.
- Halaman landing dan halaman login/register dipercantik.

## Catatan
- Endpoint `/api/buku` (tambah/ubah/hapus) tetap terbuka tanpa login seperti aslinya; sebaiknya diberi proteksi bila dipakai di luar tugas.
- File tes bawaan Breeze (`tests/`) belum disesuaikan dengan role/permission.
