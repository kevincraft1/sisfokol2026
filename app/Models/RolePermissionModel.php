<?php

namespace App\Models;

use CodeIgniter\Model;

class RolePermissionModel extends Model
{
    protected $table            = 'role_permissions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['slug_role', 'nama_modul'];

    // Tabel pivot tidak butuh timestamps
    protected $useTimestamps    = false;
}
