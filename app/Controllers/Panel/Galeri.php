<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\GaleriModel;

class Galeri extends BaseController
{
    protected $galeriModel;

    public function __construct()
    {
        $this->galeriModel = new GaleriModel();
    }

    // Menampilkan daftar galeri sesuai Role (Ownership)
    public function index()
    {
        $role = session()->get('role');
        $userId = session()->get('id');

        // Cek jika yang login adalah admin, tampilkan SEMUA foto galeri
        if ($role === 'admin') {
            $dataGaleri = $this->galeriModel->orderBy('id', 'DESC')->findAll();
        } else {
            // Jika bukan admin (misal: guru), tampilkan HANYA foto galeri miliknya
            $dataGaleri = $this->galeriModel->where('user_id', $userId)->orderBy('id', 'DESC')->findAll();
        }

        $data = [
            'title'  => 'Manajemen Galeri',
            'galeri' => $dataGaleri
        ];
        return view('panel/galeri/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Foto Galeri'
        ];
        return view('panel/galeri/create', $data);
    }

    public function store()
    {
        $fileGambar = $this->request->getFile('image');
        $namaGambar = null;

        if ($fileGambar && $fileGambar->isValid() && ! $fileGambar->hasMoved()) {
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('uploads/galeri', $namaGambar);
        }

        // 1. Siapkan array data yang akan disimpan
        // REVISI: Tambahkan user_id dari session untuk mencatat Ownership
        $newData = [
            'user_id'     => session()->get('id'),
            'title'       => $this->request->getPost('title'),
            'type'        => $this->request->getPost('type'),
            'description' => $this->request->getPost('description'),
            'image'       => $namaGambar
        ];

        // 2. Simpan ke database
        $this->galeriModel->save($newData);

        // 3. Ambil ID yang baru saja masuk
        $insertedId = $this->galeriModel->getInsertID();

        // --- CATAT AKTIVITAS LOG: CREATE ---
        audit_log('CREATE', 'Galeri', $insertedId, null, $newData);

        session()->setFlashdata('pesan', 'Foto galeri berhasil ditambahkan.');
        return redirect()->to('/panel/galeri');
    }

    // Menampilkan form edit galeri (Dengan Proteksi Ownership)
    public function edit($id)
    {
        $galeri = $this->galeriModel->find($id);

        if (!$galeri) {
            session()->setFlashdata('error', 'Data galeri tidak ditemukan.');
            return redirect()->to('/panel/galeri');
        }

        // PROTEKSI OWNERSHIP
        if (session()->get('role') !== 'admin' && $galeri['user_id'] != session()->get('id')) {
            session()->setFlashdata('error', 'Akses Ditolak! Anda hanya dapat mengedit foto galeri milik Anda sendiri.');
            return redirect()->to('/panel/galeri');
        }

        $data = [
            'title'  => 'Edit Foto Galeri',
            'galeri' => $galeri
        ];
        return view('panel/galeri/edit', $data);
    }

    // Memproses update galeri (Dengan Proteksi Ownership)
    public function update($id)
    {
        $galeriLama = $this->galeriModel->find($id);

        if (!$galeriLama) {
            return redirect()->to('/panel/galeri');
        }

        // PROTEKSI OWNERSHIP
        if (session()->get('role') !== 'admin' && $galeriLama['user_id'] != session()->get('id')) {
            session()->setFlashdata('error', 'Akses Ditolak! Anda tidak memiliki izin untuk mengubah foto galeri ini.');
            return redirect()->to('/panel/galeri');
        }

        $fileImage = $this->request->getFile('image');
        $namaImage = $galeriLama['image'];

        if ($fileImage && $fileImage->isValid() && ! $fileImage->hasMoved()) {
            $namaImage = $fileImage->getRandomName();
            $fileImage->move('uploads/galeri', $namaImage);

            if (!empty($galeriLama['image']) && file_exists('uploads/galeri/' . $galeriLama['image'])) {
                unlink('uploads/galeri/' . $galeriLama['image']);
            }
        }

        $newData = [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'image'       => $namaImage
        ];

        $this->galeriModel->update($id, $newData);
        audit_log('UPDATE', 'Galeri', $id, $galeriLama, $newData);

        session()->setFlashdata('pesan', 'Foto galeri berhasil diupdate.');
        return redirect()->to('/panel/galeri');
    }

    // Menghapus galeri (Soft Delete, Notif 30 Hari, & Proteksi Ownership)
    public function delete($id)
    {
        $galeri = $this->galeriModel->find($id);

        if ($galeri) {
            // PROTEKSI OWNERSHIP
            if (session()->get('role') !== 'admin' && $galeri['user_id'] != session()->get('id')) {
                session()->setFlashdata('error', 'Akses Ditolak! Anda tidak dapat menghapus foto galeri milik orang lain.');
                return redirect()->to('/panel/galeri');
            }

            // Soft delete
            $this->galeriModel->delete($id);

            audit_log('SOFT_DELETE', 'Galeri', $id, $galeri, null);
        }

        session()->setFlashdata('pesan', 'Foto galeri berhasil dipindahkan ke Tong Sampah. Data akan otomatis terhapus permanen setelah 30 hari.');
        return redirect()->to('/panel/galeri');
    }

    // =========================================================================
    // FITUR TONG SAMPAH (TRASH) - GALERI
    // =========================================================================

    public function trash()
    {
        $role = session()->get('role');
        $userId = session()->get('id');

        if ($role === 'admin') {
            $dataGaleri = $this->galeriModel->onlyDeleted()->orderBy('deleted_at', 'DESC')->findAll();
        } else {
            $dataGaleri = $this->galeriModel->onlyDeleted()->where('user_id', $userId)->orderBy('deleted_at', 'DESC')->findAll();
        }

        $data = [
            'title'  => 'Tong Sampah - Galeri',
            'galeri' => $dataGaleri
        ];
        return view('panel/galeri/trash', $data);
    }

    public function restore($id)
    {
        $galeri = $this->galeriModel->onlyDeleted()->find($id);

        if ($galeri) {
            if (session()->get('role') !== 'admin' && $galeri['user_id'] != session()->get('id')) {
                session()->setFlashdata('error', 'Akses Ditolak! Anda tidak dapat memulihkan galeri milik orang lain.');
                return redirect()->to('/panel/galeri/trash');
            }

            // Restore data (Bypass CI4 protection dengan Query Builder)
            $this->galeriModel->builder()->where('id', $id)->update(['deleted_at' => null]);

            audit_log('RESTORE', 'Galeri', $id, null, $galeri);
            session()->setFlashdata('pesan', 'Foto galeri berhasil dipulihkan.');
        } else {
            session()->setFlashdata('error', 'Data tidak ditemukan di Tong Sampah.');
        }

        return redirect()->to('/panel/galeri/trash');
    }

    public function purge($id)
    {
        $galeri = $this->galeriModel->onlyDeleted()->find($id);

        if ($galeri) {
            if (session()->get('role') !== 'admin' && $galeri['user_id'] != session()->get('id')) {
                session()->setFlashdata('error', 'Akses Ditolak! Anda tidak dapat menghapus permanen galeri milik orang lain.');
                return redirect()->to('/panel/galeri/trash');
            }

            if ($galeri['image'] != '') {
                $pathFile = 'uploads/galeri/' . $galeri['image'];
                if (file_exists($pathFile)) {
                    unlink($pathFile);
                }
            }

            $this->galeriModel->delete($id, true);

            audit_log('HARD_DELETE', 'Galeri', $id, $galeri, null);
            session()->setFlashdata('pesan', 'Foto galeri berhasil dihapus permanen.');
        }

        return redirect()->to('/panel/galeri/trash');
    }
}
