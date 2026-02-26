<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\MitraModel;

class Mitra extends BaseController
{
    protected $mitraModel;

    public function __construct()
    {
        $db = \Config\Database::connect();
        $forge = \Config\Database::forge();

        // Auto-create table mitra
        if (!$db->tableExists('mitra')) {
            $forge->addField([
                'id'         => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
                'nama'       => ['type' => 'VARCHAR', 'constraint' => 100],
                'logo'       => ['type' => 'VARCHAR', 'constraint' => 255],
                'url'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
                'updated_at' => ['type' => 'DATETIME', 'null' => true],
            ]);
            $forge->addKey('id', true);
            $forge->createTable('mitra');
        }
        $this->mitraModel = new MitraModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Mitra Industri',
            'mitra' => $this->mitraModel->findAll()
        ];
        return view('panel/mitra/index', $data);
    }

    // Fungsi Private untuk memproses string Base64 menjadi file WebP fisik
    private function saveBase64Image($base64String)
    {
        // Pisahkan header data:image/webp;base64, dari isinya
        $imageParts = explode(";base64,", $base64String);
        $imageBase64 = base64_decode($imageParts[1]);

        // Buat nama acak dan pastikan folder tersedia
        $fileName = uniqid('mitra_') . '.webp';
        $path = FCPATH . 'uploads/mitra/';
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        file_put_contents($path . $fileName, $imageBase64);
        return $fileName;
    }

    public function store()
    {
        $base64Logo = $this->request->getPost('logo_base64');
        $namaLogo = '';

        if (!empty($base64Logo)) {
            $namaLogo = $this->saveBase64Image($base64Logo);
        }

        // 1. Siapkan array data
        $newData = [
            'nama' => $this->request->getPost('nama'),
            'url'  => $this->request->getPost('url'),
            'logo' => $namaLogo
        ];

        // 2. Simpan ke database
        $this->mitraModel->save($newData);

        // 3. Ambil ID yang baru dimasukkan
        $insertedId = $this->mitraModel->getInsertID();

        // --- CATAT AKTIVITAS LOG: CREATE ---
        audit_log('CREATE', 'Mitra Industri', $insertedId, null, $newData);

        session()->setFlashdata('pesan', 'Mitra berhasil ditambahkan.');
        return redirect()->to('/panel/mitra');
    }

    public function update($id)
    {
        // 1. Ambil data lama untuk audit
        $mitraLama = $this->mitraModel->find($id);
        $base64Logo = $this->request->getPost('logo_base64');
        $namaLogo = $mitraLama['logo'];

        // Jika ada gambar baru yang dikirim
        if (!empty($base64Logo)) {
            $namaLogo = $this->saveBase64Image($base64Logo);

            // Hapus gambar lama
            if (!empty($mitraLama['logo']) && file_exists('uploads/mitra/' . $mitraLama['logo'])) {
                unlink('uploads/mitra/' . $mitraLama['logo']);
            }
        }

        // 2. Siapkan data baru
        $newData = [
            'nama' => $this->request->getPost('nama'),
            'url'  => $this->request->getPost('url'),
            'logo' => $namaLogo
        ];

        // 3. Update ke database
        $this->mitraModel->update($id, $newData);

        // --- CATAT AKTIVITAS LOG: UPDATE ---
        audit_log('UPDATE', 'Mitra Industri', $id, $mitraLama, $newData);

        session()->setFlashdata('pesan', 'Data Mitra berhasil diperbarui.');
        return redirect()->to('/panel/mitra');
    }

    public function delete($id)
    {
        $dataLama = $this->mitraModel->find($id); // Ambil data sebelum dihapus

        if ($dataLama && file_exists('uploads/mitra/' . $dataLama['logo'])) {
            unlink('uploads/mitra/' . $dataLama['logo']);
        }
        $this->mitraModel->delete($id);

        // --- CATAT AKTIVITAS LOG: DELETE ---
        audit_log('DELETE', 'Mitra Industri', $id, $dataLama, null);

        session()->setFlashdata('pesan', 'Mitra berhasil dihapus.');
        return redirect()->to('/panel/mitra');
    }
}
