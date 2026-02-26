<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class Setting extends BaseController
{
    protected $settingModel;

    public function __construct()
    {
        $db = \Config\Database::connect();
        $forge = \Config\Database::forge();

        // JIKA TABEL BELUM ADA SAMA SEKALI
        if (!$db->tableExists('setting')) {
            $forge->addField([
                'id'             => ['type' => 'INT', 'constraint' => 1, 'auto_increment' => true],
                'nama_web'       => ['type' => 'VARCHAR', 'constraint' => 100, 'default' => 'SMK Kreatif Nusantara'],
                'deskripsi'      => ['type' => 'TEXT', 'null' => true],
                'logo'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'alamat'         => ['type' => 'TEXT', 'null' => true],
                'telepon'        => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
                'email'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
                'facebook'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
                'instagram'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
                'youtube'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
                'tiktok'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
                'twitter'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
                'maps'           => ['type' => 'TEXT', 'null' => true],
                'link_ppdb'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'stat_mitra'     => ['type' => 'INT', 'constraint' => 11, 'default' => 50],
                'stat_fasilitas' => ['type' => 'INT', 'constraint' => 11, 'default' => 100],
                'stat_alumni'    => ['type' => 'INT', 'constraint' => 11, 'default' => 2000],
                'hero_title'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'hero_desc'      => ['type' => 'TEXT', 'null' => true],
                'hero_image'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            ]);
            $forge->addKey('id', true);
            $forge->createTable('setting');

            $db->table('setting')->insert([
                'id'       => 1,
                'nama_web' => 'SMK Kreatif Nusantara',
                'email'    => 'info@smkkreatif.sch.id'
            ]);
        } else {
            // JIKA TABEL SUDAH ADA, NAMUN ADA KOLOM BARU YANG BELUM DIBUAT
            if (!$db->fieldExists('link_ppdb', 'setting')) {
                $forge->addColumn('setting', ['link_ppdb' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true]]);
            }
            if (!$db->fieldExists('stat_mitra', 'setting')) {
                $forge->addColumn('setting', ['stat_mitra' => ['type' => 'INT', 'constraint' => 11, 'default' => 50]]);
            }
            if (!$db->fieldExists('stat_fasilitas', 'setting')) {
                $forge->addColumn('setting', ['stat_fasilitas' => ['type' => 'INT', 'constraint' => 11, 'default' => 100]]);
            }
            if (!$db->fieldExists('stat_alumni', 'setting')) {
                $forge->addColumn('setting', ['stat_alumni' => ['type' => 'INT', 'constraint' => 11, 'default' => 2000]]);
            }
            if (!$db->fieldExists('is_maintenance', 'setting')) {
                $forge->addColumn('setting', ['is_maintenance' => ['type' => 'INT', 'constraint' => 1, 'default' => 0]]);
            }
            // TAMBAHAN KOLOM HERO
            if (!$db->fieldExists('hero_title', 'setting')) {
                $forge->addColumn('setting', ['hero_title' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true]]);
            }
            if (!$db->fieldExists('hero_desc', 'setting')) {
                $forge->addColumn('setting', ['hero_desc' => ['type' => 'TEXT', 'null' => true]]);
            }
            if (!$db->fieldExists('hero_image', 'setting')) {
                $forge->addColumn('setting', ['hero_image' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true]]);
            }
        }

        $this->settingModel = new SettingModel();
    }

    // --- FUNGSI PENGATURAN IDENTITAS WEB ---
    public function index()
    {
        $data = [
            'title'   => 'Pengaturan Website',
            'setting' => $this->settingModel->first()
        ];
        return view('panel/setting/index', $data);
    }

    public function update()
    {
        $settingLama = $this->settingModel->first();
        $fileLogo    = $this->request->getFile('logo');
        $namaLogo    = $settingLama['logo'];

        if ($fileLogo && $fileLogo->isValid() && ! $fileLogo->hasMoved()) {
            $namaLogo = $fileLogo->getRandomName();
            $fileLogo->move('uploads/setting', $namaLogo);

            if (!empty($settingLama['logo']) && file_exists('uploads/setting/' . $settingLama['logo'])) {
                unlink('uploads/setting/' . $settingLama['logo']);
            }
        }

        $newData = [
            'nama_web'       => $this->request->getPost('nama_web'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'alamat'         => $this->request->getPost('alamat'),
            'telepon'        => $this->request->getPost('telepon'),
            'email'          => $this->request->getPost('email'),
            'facebook'       => $this->request->getPost('facebook'),
            'instagram'      => $this->request->getPost('instagram'),
            'youtube'        => $this->request->getPost('youtube'),
            'tiktok'         => $this->request->getPost('tiktok'),
            'twitter'        => $this->request->getPost('twitter'),
            'maps'           => $this->request->getPost('maps'),
            'link_ppdb'      => $this->request->getPost('link_ppdb'),
            'stat_mitra'     => $this->request->getPost('stat_mitra'),
            'stat_fasilitas' => $this->request->getPost('stat_fasilitas'),
            'stat_alumni'    => $this->request->getPost('stat_alumni'),
            'is_maintenance' => $this->request->getPost('is_maintenance'),
            'logo'           => $namaLogo
        ];

        $this->settingModel->update(1, $newData);

        // --- CATAT AKTIVITAS LOG: UPDATE PENGATURAN WEB ---
        audit_log('UPDATE', 'Pengaturan Website', 1, $settingLama, $newData);

        session()->setFlashdata('pesan', 'Pengaturan website berhasil diperbarui.');
        return redirect()->to('/panel/setting');
    }

    public function toggleMaintenance()
    {
        $settingLama = $this->settingModel->first();
        $status = $this->request->getPost('status');
        $newData = ['is_maintenance' => $status];

        $this->settingModel->update(1, $newData);

        // --- CATAT AKTIVITAS LOG: TOGGLE MAINTENANCE ---
        audit_log('UPDATE', 'Status Maintenance', 1, $settingLama, $newData);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Status maintenance berhasil diubah!'
        ]);
    }

    // --- FUNGSI PENGATURAN HERO SECTION ---
    public function hero()
    {
        $data = [
            'title'   => 'Pengaturan Hero Section',
            'setting' => $this->settingModel->first()
        ];
        return view('panel/hero/index', $data);
    }

    public function updateHero()
    {
        $settingLama = $this->settingModel->first();
        $fileHero    = $this->request->getFile('hero_image');
        $namaHero    = $settingLama['hero_image'];

        if ($fileHero && $fileHero->isValid() && ! $fileHero->hasMoved()) {
            $namaHero = $fileHero->getRandomName();
            // Simpan gambar di dalam folder uploads/setting
            $fileHero->move('uploads/setting', $namaHero);

            // Hapus gambar hero yang lama jika ada
            if (!empty($settingLama['hero_image']) && file_exists('uploads/setting/' . $settingLama['hero_image'])) {
                unlink('uploads/setting/' . $settingLama['hero_image']);
            }
        }

        $newData = [
            'hero_title' => $this->request->getPost('hero_title'),
            'hero_desc'  => $this->request->getPost('hero_desc'),
            'hero_image' => $namaHero
        ];

        $this->settingModel->update(1, $newData);

        // --- CATAT AKTIVITAS LOG: UPDATE HERO SECTION ---
        audit_log('UPDATE', 'Hero Section', 1, $settingLama, $newData);

        session()->setFlashdata('pesan', 'Hero Section berhasil diperbarui.');
        return redirect()->to('/panel/hero');
    }
}
