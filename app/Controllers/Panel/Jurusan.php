<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\JurusanModel;

class Jurusan extends BaseController
{
    protected $jurusanModel;

    public function __construct()
    {
        $this->jurusanModel = new JurusanModel();
        helper('text');
    }

    public function index()
    {
        $data = [
            'title'   => 'Manajemen Jurusan',
            'jurusan' => $this->jurusanModel->orderBy('id', 'DESC')->findAll()
        ];
        return view('panel/jurusan/index', $data);
    }

    public function create()
    {
        return view('panel/jurusan/create', ['title' => 'Tambah Jurusan Baru']);
    }

    public function store()
    {
        $fileGambar = $this->request->getFile('image');
        $namaGambar = null;

        if ($fileGambar && $fileGambar->isValid() && ! $fileGambar->hasMoved()) {
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('uploads/jurusan', $namaGambar);
        }

        $namaJurusan = $this->request->getPost('name');

        // 1. Siapkan array data baru
        $newData = [
            'name'        => $namaJurusan,
            'slug'        => url_title($namaJurusan, '-', true),
            'icon'        => $this->request->getPost('icon'),
            'description' => $this->request->getPost('description'),
            'image'       => $namaGambar
        ];

        // 2. Simpan ke database
        $this->jurusanModel->save($newData);

        // 3. Ambil ID yang baru dibuat
        $insertedId = $this->jurusanModel->getInsertID();

        // --- CATAT AKTIVITAS LOG: CREATE ---
        audit_log('CREATE', 'Jurusan', $insertedId, null, $newData);

        session()->setFlashdata('pesan', 'Data jurusan berhasil ditambahkan.');
        return redirect()->to('/panel/jurusan');
    }

    public function edit($id)
    {
        $data = [
            'title'   => 'Edit Jurusan',
            'jurusan' => $this->jurusanModel->find($id)
        ];
        return view('panel/jurusan/edit', $data);
    }

    public function update($id)
    {
        // 1. Ambil data lama untuk audit
        $jurusanLama = $this->jurusanModel->find($id);
        $fileImage = $this->request->getFile('image');
        $namaImage = $jurusanLama['image'];
        $namaJurusan = $this->request->getPost('name');

        if ($fileImage && $fileImage->isValid() && ! $fileImage->hasMoved()) {
            $namaImage = $fileImage->getRandomName();
            $fileImage->move('uploads/jurusan', $namaImage);

            // HAPUS GAMBAR LAMA SECARA FISIK (Unlink)
            if (!empty($jurusanLama['image']) && file_exists('uploads/jurusan/' . $jurusanLama['image'])) {
                unlink('uploads/jurusan/' . $jurusanLama['image']);
            }
        }

        // 2. Siapkan array data yang akan diupdate
        $newData = [
            'name'        => $this->request->getPost('name'),
            'slug'        => url_title($namaJurusan, '-', true),
            'description' => $this->request->getPost('description'),
            'icon'        => $this->request->getPost('icon'),
            'image'       => $namaImage
        ];

        // 3. Update database
        $this->jurusanModel->update($id, $newData);

        // --- CATAT AKTIVITAS LOG: UPDATE ---
        audit_log('UPDATE', 'Jurusan', $id, $jurusanLama, $newData);

        session()->setFlashdata('pesan', 'Data jurusan berhasil diupdate.');
        return redirect()->to('/panel/jurusan');
    }

    public function delete($id)
    {
        // 1. Cari data jurusan berdasarkan ID
        $jurusan = $this->jurusanModel->find($id);

        // 2. Jika data ditemukan dan ada file gambarnya
        if ($jurusan && $jurusan['image'] != '') {
            $pathFile = 'uploads/jurusan/' . $jurusan['image'];

            // 3. Cek dan hapus file fisik
            if (file_exists($pathFile)) {
                unlink($pathFile);
            }
        }

        // 4. Hapus data dari database
        $this->jurusanModel->delete($id);

        // --- CATAT AKTIVITAS LOG: DELETE ---
        audit_log('DELETE', 'Jurusan', $id, $jurusan, null);

        session()->setFlashdata('pesan', 'Data jurusan beserta gambarnya berhasil dihapus.');
        return redirect()->to('/panel/jurusan');
    }
}
