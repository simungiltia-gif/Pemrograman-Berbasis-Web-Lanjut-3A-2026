<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan cache permission
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Daftar seluruh permission
        $permissions = [
            'akses dashboard admin',
            'akses dashboard petugas',

            'lihat daftar buku',
            'kelola data buku',

            'kelola data pengguna',
            'kelola role pengguna',

            'kelola peminjaman',
            'kelola pengembalian',

            'mengajukan peminjaman buku',
            'memproses persetujuan peminjaman',
            'mencatat pengembalian buku',

            'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri',

            'lihat laporan perpustakaan',

            'lihat profil sendiri',
            'ubah profil sendiri',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // 2. Buat role
        $roleAdmin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $rolePetugas = Role::firstOrCreate([
            'name' => 'petugas',
            'guard_name' => 'web',
        ]);

        $roleSiswa = Role::firstOrCreate([
            'name' => 'siswa',
            'guard_name' => 'web',
        ]);

        // 3. Permission untuk Admin
        $roleAdmin->syncPermissions(Permission::all());

        // 4. Permission untuk Petugas
        $rolePetugas->syncPermissions([
            'akses dashboard petugas',
            'lihat daftar buku',
            'kelola data buku',
            'kelola peminjaman',
            'kelola pengembalian',
            'mengajukan peminjaman buku',
            'memproses persetujuan peminjaman',
            'mencatat pengembalian buku',
            'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri',
            'lihat laporan perpustakaan',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ]);

        // 5. Permission untuk Siswa
        $roleSiswa->syncPermissions([
            'lihat daftar buku',
            'mengajukan peminjaman buku',
            'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ]);

        // 6. Buat akun Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Perpustakaan',
                'password' => Hash::make('password123'),
            ]
        );

        $admin->syncRoles([$roleAdmin]);

        // 7. Buat akun Petugas
        $petugas = User::firstOrCreate(
            ['email' => 'petugas@gmail.com'],
            [
                'name' => 'Petugas Perpustakaan',
                'password' => Hash::make('password123'),
            ]
        );

        $petugas->syncRoles([$rolePetugas]);

        // 8. Buat akun Siswa
        $siswa = User::firstOrCreate(
            ['email' => 'siswa@gmail.com'],
            [
                'name' => 'Siswa Perpustakaan',
                'password' => Hash::make('password123'),
            ]
        );

        $siswa->syncRoles([$roleSiswa]);

        // Akun siswa harus terhubung dengan data anggota agar bisa meminjam buku.
        $siswa->anggotaOrCreate();

        // Bersihkan cache kembali
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}