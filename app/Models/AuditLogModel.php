<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditLogModel extends Model
{
    protected $table            = 'audit_logs';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'user_id',
        'nama_user',
        'action',
        'module',
        'record_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'created_at'
    ];
    protected $useTimestamps    = false; // Waktu sudah ditangani helper
}
