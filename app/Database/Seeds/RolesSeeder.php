<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // 1. Masukkan Daftar Role Default
        $rolesData = [
            [
                'slug_role'  => 'admin',
                'nama_role'  => 'Administrator Utama',
                'deskripsi'  => 'Memiliki akses penuh ke seluruh sistem aplikasi.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'slug_role'  => 'guru',
                'nama_role'  => 'Guru / Jurnalis',
                'deskripsi'  => 'Hanya dapat mempublikasikan Berita dan Galeri.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'slug_role'  => 'kepsek',
                'nama_role'  => 'Kepala Sekolah',
                'deskripsi'  => 'Akses pemantauan dan melihat statistik sistem.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('roles')->insertBatch($rolesData);

        // 2. Berikan Izin Full Modul kepada 'admin'
        $permissionsAdmin = [];
        $modulAdmin = ['dashboard', 'berita', 'galeri', 'jurusan', 'mitra', 'profil', 'setting', 'pesan', 'users', 'roles', 'log'];

        foreach ($modulAdmin as $modul) {
            $permissionsAdmin[] = [
                'slug_role'  => 'admin',
                'nama_modul' => $modul
            ];
        }
        $this->db->table('role_permissions')->insertBatch($permissionsAdmin);

        // 3. Berikan Izin Terbatas kepada 'guru'
        $permissionsGuru = [
            ['slug_role' => 'guru', 'nama_modul' => 'dashboard'],
            ['slug_role' => 'guru', 'nama_modul' => 'berita'],
            ['slug_role' => 'guru', 'nama_modul' => 'galeri']
        ];
        $this->db->table('role_permissions')->insertBatch($permissionsGuru);
    }
}
