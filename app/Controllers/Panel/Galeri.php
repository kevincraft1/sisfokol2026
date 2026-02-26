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

    public function index()
    {
        $data = [
            'title'  => 'Manajemen Galeri',
            'galeri' => $this->galeriModel->orderBy('id', 'DESC')->findAll()
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
        $newData = [
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

    public function edit($id)
    {
        $data = [
            'title'  => 'Edit Foto Galeri',
            'galeri' => $this->galeriModel->find($id)
        ];
        return view('panel/galeri/edit', $data);
    }

    public function update($id)
    {
        // 1. Ambil data lama untuk record audit
        $galeriLama = $this->galeriModel->find($id);
        $fileImage = $this->request->getFile('image');
        $namaImage = $galeriLama['image'];

        if ($fileImage && $fileImage->isValid() && ! $fileImage->hasMoved()) {
            $namaImage = $fileImage->getRandomName();
            $fileImage->move('uploads/galeri', $namaImage);

            // HAPUS GAMBAR LAMA SECARA FISIK (Unlink)
            if (!empty($galeriLama['image']) && file_exists('uploads/galeri/' . $galeriLama['image'])) {
                unlink('uploads/galeri/' . $galeriLama['image']);
            }
        }

        // 2. Siapkan data baru yang akan di-update
        $newData = [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'image'       => $namaImage
        ];

        // 3. Eksekusi update ke database
        $this->galeriModel->update($id, $newData);

        // --- CATAT AKTIVITAS LOG: UPDATE ---
        audit_log('UPDATE', 'Galeri', $id, $galeriLama, $newData);

        session()->setFlashdata('pesan', 'Foto galeri berhasil diupdate.');
        return redirect()->to('/panel/galeri');
    }

    public function delete($id)
    {
        // 1. Cari data galeri berdasarkan ID
        $galeri = $this->galeriModel->find($id);

        // 2. Jika data ditemukan dan ada file gambarnya
        if ($galeri && $galeri['image'] != '') {
            $pathFile = 'uploads/galeri/' . $galeri['image'];

            // 3. Cek dan hapus file fisik
            if (file_exists($pathFile)) {
                unlink($pathFile);
            }
        }

        // 4. Hapus data dari database
        $this->galeriModel->delete($id);

        // --- CATAT AKTIVITAS LOG: DELETE ---
        audit_log('DELETE', 'Galeri', $id, $galeri, null);

        session()->setFlashdata('pesan', 'Foto galeri berhasil dihapus permanen dari server.');
        return redirect()->to('/panel/galeri');
    }
}
