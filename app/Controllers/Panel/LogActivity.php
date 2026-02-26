<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\AuditLogModel;

class LogActivity extends BaseController
{
    protected $logModel;

    public function __construct()
    {
        $db = \Config\Database::connect();
        $forge = \Config\Database::forge();

        if (!$db->tableExists('audit_logs')) {
            $forge->addField([
                'id'         => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
                'user_id'    => ['type' => 'INT', 'constraint' => 11, 'null' => true],
                'nama_user'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
                'action'     => ['type' => 'VARCHAR', 'constraint' => 50],
                'module'     => ['type' => 'VARCHAR', 'constraint' => 100],
                'record_id'  => ['type' => 'INT', 'constraint' => 11, 'null' => true],
                'old_values' => ['type' => 'TEXT', 'null' => true],
                'new_values' => ['type' => 'TEXT', 'null' => true],
                'ip_address' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
                'user_agent' => ['type' => 'TEXT', 'null' => true],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
            ]);
            $forge->addKey('id', true);
            $forge->createTable('audit_logs');
        }

        $this->logModel = new AuditLogModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Audit Log Aktivitas',
            // Gunakan Paginasi karena log akan mencapai ribuan baris
            'logs'  => $this->logModel->orderBy('created_at', 'DESC')->paginate(20, 'logs'),
            'pager' => $this->logModel->pager
        ];
        return view('panel/log/index', $data);
    }
}
