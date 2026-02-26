<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolesTables extends Migration
{
    public function up()
    {
        // 1. Modifikasi tabel existing 'users'
        // Mengubah kolom role dari ENUM menjadi VARCHAR agar lebih dinamis
        $fields = [
            'role' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'guru',
            ],
        ];
        $this->forge->modifyColumn('users', $fields);

        // 2. Buat Tabel 'roles'
        $this->forge->addField([
            'slug_role'  => ['type' => 'VARCHAR', 'constraint' => 50],
            'nama_role'  => ['type' => 'VARCHAR', 'constraint' => 100],
            'deskripsi'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('slug_role', true); // Slug sebagai Primary Key
        $this->forge->createTable('roles');

        // 3. Buat Tabel 'role_permissions' (Hak Akses)
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'slug_role'   => ['type' => 'VARCHAR', 'constraint' => 50],
            'nama_modul'  => ['type' => 'VARCHAR', 'constraint' => 100], // cth: 'berita', 'users', 'setting'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('slug_role', 'roles', 'slug_role', 'CASCADE', 'CASCADE');
        $this->forge->createTable('role_permissions');
    }

    public function down()
    {
        $this->forge->dropTable('role_permissions', true);
        $this->forge->dropTable('roles', true);

        // Kembalikan tipe kolom users.role ke ENUM jika di-rollback
        $fields = [
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'kepsek', 'guru'],
                'default'    => 'guru',
            ],
        ];
        $this->forge->modifyColumn('users', $fields);
    }
}
