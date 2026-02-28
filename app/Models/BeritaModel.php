<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table            = 'berita';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    // REVISI: Aktifkan Soft Deletes
    protected $useSoftDeletes   = true;

    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'title', 'slug', 'content', 'image', 'category', 'status'];

    // Dates
    protected $useTimestamps = true;

    // REVISI: Tambahkan konfigurasi waktu lengkap
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
