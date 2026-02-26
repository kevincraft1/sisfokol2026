<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\ProfilModel;

class Profil extends BaseController
{
    protected $profilModel;

    public function __construct()
    {
        $db = \Config\Database::connect();
        $forge = \Config\Database::forge();

        // Otomatis buat tabel 'profil' jika belum ada
        if (!$db->tableExists('profil')) {
            $forge->addField([
                'id'      => ['type' => 'INT', 'constraint' => 1, 'auto_increment' => true],
                'sejarah' => ['type' => 'TEXT', 'null' => true],
                'visi'    => ['type' => 'TEXT', 'null' => true],
                'misi'    => ['type' => 'TEXT', 'null' => true],
                'gambar'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            ]);
            $forge->addKey('id', true);
            $forge->createTable('profil');

            // Insert data bawaan pertama kali
            $db->table('profil')->insert([
                'id'      => 1,
                'sejarah' => 'Berdiri sejak 2010, kami berkomitmen mencetak talenta digital dan technopreneur muda yang siap bersaing di kancah global.',
                'visi'    => 'Menjadi sekolah kejuruan rujukan nasional di bidang teknologi dan industri kreatif yang berwawasan global pada tahun 2030.',
                'misi'    => '<ul class="text-muted list-unstyled"><li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Menyelenggarakan pembelajaran berbasis proyek (PBL).</li><li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Membangun kemitraan strategis dengan DUDI.</li><li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Meningkatkan kompetensi guru bersertifikasi industri.</li></ul>'
            ]);
        }

        $this->profilModel = new ProfilModel();
    }

    public function index()
    {
        $data = [
            'title'  => 'Profil & Visi Misi',
            'profil' => $this->profilModel->first()
        ];
        return view('panel/profil/index', $data);
    }

    public function update()
    {
        // 1. Ambil data lama sebelum diperbarui
        $profilLama = $this->profilModel->first();
        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = $profilLama['gambar'];

        // Proses jika ada upload gambar baru
        if ($fileGambar && $fileGambar->isValid() && ! $fileGambar->hasMoved()) {
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('uploads/profil', $namaGambar);

            // Hapus gambar lama agar storage tidak penuh
            if (!empty($profilLama['gambar']) && file_exists('uploads/profil/' . $profilLama['gambar'])) {
                unlink('uploads/profil/' . $profilLama['gambar']);
            }
        }

        // 2. Siapkan array data baru
        $newData = [
            'sejarah' => $this->request->getPost('sejarah'),
            'visi'    => $this->request->getPost('visi'),
            'misi'    => $this->request->getPost('misi'), // Ini nanti pakai Summernote
            'gambar'  => $namaGambar
        ];

        // 3. Update data profil (ID 1)
        $this->profilModel->update(1, $newData);

        // --- CATAT AKTIVITAS LOG: UPDATE ---
        audit_log('UPDATE', 'Profil Sekolah', 1, $profilLama, $newData);

        session()->setFlashdata('pesan', 'Profil sekolah berhasil diperbarui.');
        return redirect()->to('/panel/profil');
    }
}
