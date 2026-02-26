<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfilModel extends Model
{
    protected $table            = 'profil';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['sejarah', 'visi', 'misi', 'gambar'];
    protected $useTimestamps    = false;
}
