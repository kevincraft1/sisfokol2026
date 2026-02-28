<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeletedAtToTables extends Migration
{
    public function up()
    {
        // Mendefinisikan kolom deleted_at
        $fields = [
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ];

        // Menambahkan kolom ke tabel users, berita, dan mitra
        $this->forge->addColumn('users', $fields);
        $this->forge->addColumn('berita', $fields);
        $this->forge->addColumn('mitra', $fields);
    }

    public function down()
    {
        // Menghapus kolom jika kita melakukan rollback (php spark migrate:rollback)
        $this->forge->dropColumn('users', 'deleted_at');
        $this->forge->dropColumn('berita', 'deleted_at');
        $this->forge->dropColumn('mitra', 'deleted_at');
    }
}
