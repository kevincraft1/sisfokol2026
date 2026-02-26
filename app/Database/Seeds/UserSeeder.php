<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username'      => 'admin',
            'nama_lengkap'  => 'Administrator Web',
            'email'         => 'admin@sekolah.com',
            'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
            'role'          => 'admin',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];

        $this->db->table('users')->insert($data);
    }
}
