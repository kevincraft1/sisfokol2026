<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpgradeGaleriTable extends Migration
{
    public function up()
    {
        $fields = [
            // Tambahkan kolom user_id untuk sistem Ownership
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true, // Null true agar data lama tidak error
            ],
            // Tambahkan kolom deleted_at untuk Soft Delete
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ];

        $this->forge->addColumn('galeri', $fields);

        // Menambahkan Foreign Key (Opsional tapi sangat direkomendasikan untuk integritas data)
        // Menghubungkan user_id di tabel galeri dengan id di tabel users
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->processIndexes('galeri');
    }

    public function down()
    {
        $this->forge->dropForeignKey('galeri', 'galeri_user_id_foreign');
        $this->forge->dropColumn('galeri', 'user_id');
        $this->forge->dropColumn('galeri', 'deleted_at');
    }
}
