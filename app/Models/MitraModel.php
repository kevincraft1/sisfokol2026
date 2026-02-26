<?php

namespace App\Models;

use CodeIgniter\Model;

class MitraModel extends Model
{
    protected $table            = 'mitra';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama', 'logo', 'url'];
    protected $useTimestamps    = true;
}
