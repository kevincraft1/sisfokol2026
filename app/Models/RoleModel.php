<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table            = 'roles';
    protected $primaryKey       = 'slug_role';
    protected $useAutoIncrement = false; // Karena primary key-nya berupa string teks (slug)
    protected $returnType       = 'array';
    protected $allowedFields    = ['slug_role', 'nama_role', 'deskripsi'];

    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
}
