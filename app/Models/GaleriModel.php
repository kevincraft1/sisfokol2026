<?php

namespace App\Models;

use CodeIgniter\Model;

class GaleriModel extends Model
{
    protected $table            = 'galeri';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    // REVISI: Aktifkan Soft Deletes
    protected $useSoftDeletes   = true;

    protected $protectFields    = true;

    // REVISI: Tambahkan 'user_id' agar sistem Ownership bisa disimpan
    protected $allowedFields    = ['user_id', 'title', 'image', 'description', 'type'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // REVISI: Tambahkan field untuk Soft Deletes
    protected $deletedField  = 'deleted_at';
}
