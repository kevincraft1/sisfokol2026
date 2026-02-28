<?php

namespace App\Models;

use CodeIgniter\Model;

class MitraModel extends Model
{
    protected $table            = 'mitra';
    protected $primaryKey       = 'id';

    // REVISI: Tambahkan standar proteksi dan tipe kembalian
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    // REVISI: Aktifkan Soft Deletes
    protected $useSoftDeletes   = true;

    protected $protectFields    = true;
    protected $allowedFields    = ['nama', 'logo', 'url'];

    // Dates
    protected $useTimestamps    = true;

    // REVISI: Tambahkan konfigurasi waktu lengkap
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $deletedField     = 'deleted_at';
}
