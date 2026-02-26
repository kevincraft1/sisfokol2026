<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\PesanModel;

class Pesan extends BaseController
{
    protected $pesanModel;

    public function __construct()
    {
        $this->pesanModel = new PesanModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kotak Masuk (Inbox)',
            'pesan' => $this->pesanModel->orderBy('created_at', 'DESC')->findAll()
        ];
        return view('panel/pesan/index', $data);
    }

    public function baca($id)
    {
        // 1. Ambil data lama sebelum statusnya diubah
        $pesanLama = $this->pesanModel->find($id);

        // 2. Ubah status pesan menjadi sudah dibaca (is_read = 1)
        $this->pesanModel->update($id, ['is_read' => 1]);

        // 3. Ambil data baru setelah diupdate
        $pesanBaru = $this->pesanModel->find($id);

        // --- CATAT AKTIVITAS LOG: UPDATE (Jika status berubah) ---
        if ($pesanLama && $pesanLama['is_read'] == 0) {
            audit_log('UPDATE', 'Inbox Pesan', $id, $pesanLama, $pesanBaru);
        }

        $data = [
            'title' => 'Detail Pesan',
            'pesan' => $pesanBaru
        ];
        return view('panel/pesan/baca', $data);
    }

    public function delete($id)
    {
        // 1. Ambil data pesan sebelum dihapus
        $pesanLama = $this->pesanModel->find($id);

        // 2. Hapus pesan dari database
        $this->pesanModel->delete($id);

        // --- CATAT AKTIVITAS LOG: DELETE ---
        audit_log('DELETE', 'Inbox Pesan', $id, $pesanLama, null);

        session()->setFlashdata('pesan', 'Pesan berhasil dihapus.');
        return redirect()->to('/panel/pesan');
    }
}
