<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    // REVISI: Aktifkan Soft Deletes
    protected $useSoftDeletes   = true;

    protected $protectFields    = true;
    protected $allowedFields    = ['username', 'nama_lengkap', 'email', 'password_hash', 'role', 'avatar'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // REVISI: Tambahkan field untuk Soft Deletes
    protected $deletedField  = 'deleted_at';
}
