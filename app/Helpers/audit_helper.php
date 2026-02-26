<?php

if (!function_exists('audit_log')) {
    /**
     * Fungsi untuk mencatat aktivitas user ke tabel audit_logs
     * * @param string $action (Contoh: CREATE, UPDATE, DELETE, LOGIN)
     * @param string $module (Contoh: Mitra, Berita, Setting)
     * @param int|null $record_id (ID data yang diubah/dihapus)
     * @param array|null $old_values (Data sebelum diubah - array)
     * @param array|null $new_values (Data setelah diubah - array)
     */
    function audit_log($action, $module, $record_id = null, $old_values = null, $new_values = null)
    {
        $db      = \Config\Database::connect();
        $request = \Config\Services::request();
        $session = session();

        // Antisipasi jika session ID bernama 'id' atau 'id_user'
        $userId   = $session->get('id') ?? $session->get('id_user') ?? 0;
        $userName = $session->get('nama_lengkap') ?? $session->get('username') ?? 'Sistem / Guest';

        $data = [
            'user_id'    => $userId,
            'nama_user'  => $userName,
            'action'     => strtoupper($action),
            'module'     => $module,
            'record_id'  => $record_id,
            'old_values' => $old_values ? json_encode($old_values) : null,
            'new_values' => $new_values ? json_encode($new_values) : null,
            'ip_address' => $request->getIPAddress(),
            'user_agent' => $request->getUserAgent()->getAgentString(),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($db->tableExists('audit_logs')) {
            $db->table('audit_logs')->insert($data);
        }
    }
}
