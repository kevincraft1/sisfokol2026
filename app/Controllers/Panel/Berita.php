<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\BeritaModel;

class Berita extends BaseController
{
    protected $beritaModel;

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
    }

    // Menampilkan daftar berita
    public function index()
    {
        $data = [
            'title'  => 'Manajemen Berita',
            'berita' => $this->beritaModel->orderBy('id', 'DESC')->findAll()
        ];
        return view('panel/berita/index', $data);
    }

    // Menampilkan form tambah berita
    public function create()
    {
        $data = [
            'title' => 'Tambah Berita Baru'
        ];
        return view('panel/berita/create', $data);
    }

    // Memproses penyimpanan berita ke database
    public function store()
    {
        // Fitur upload gambar
        $fileGambar = $this->request->getFile('image');
        $namaGambar = null;

        if ($fileGambar && $fileGambar->isValid() && ! $fileGambar->hasMoved()) {
            // Generate nama acak & pindahkan ke folder public/uploads/berita
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('uploads/berita', $namaGambar);
        }

        $judul = $this->request->getPost('title');

        // Siapkan array data yang akan disimpan
        $newData = [
            'user_id'  => session()->get('id'), // ID Admin yang sedang login
            'title'    => $judul,
            'slug'     => url_title($judul, '-', true), // Otomatis buat slug misal: judul-berita-baru
            'content'  => $this->request->getPost('content'),
            'category' => $this->request->getPost('category'),
            'status'   => $this->request->getPost('status'),
            'image'    => $namaGambar
        ];

        // Simpan ke database
        $this->beritaModel->save($newData);

        // Ambil ID berita yang baru saja berhasil dibuat
        $insertedId = $this->beritaModel->getInsertID();

        // --- CATAT AKTIVITAS LOG: CREATE ---
        audit_log('CREATE', 'Berita', $insertedId, null, $newData);

        session()->setFlashdata('pesan', 'Data berita berhasil ditambahkan.');
        return redirect()->to('/panel/berita');
    }

    // Menampilkan form edit berita
    public function edit($id)
    {
        $data = [
            'title'  => 'Edit Berita',
            'berita' => $this->beritaModel->find($id)
        ];
        return view('panel/berita/edit', $data);
    }

    // Memproses update berita
    public function update($id)
    {
        // 1. Ambil data lama dari database (Untuk old_values di log)
        $beritaLama = $this->beritaModel->find($id);
        $fileImage = $this->request->getFile('image');

        // 2. Default nama file menggunakan yang lama
        $namaImage = $beritaLama['image'];

        // 3. Cek apakah user mengunggah gambar baru
        if ($fileImage && $fileImage->isValid() && ! $fileImage->hasMoved()) {
            // Pindahkan gambar baru ke folder
            $namaImage = $fileImage->getRandomName();
            $fileImage->move('uploads/berita', $namaImage);

            // HAPUS GAMBAR LAMA SECARA FISIK (Unlink)
            if (!empty($beritaLama['image']) && file_exists('uploads/berita/' . $beritaLama['image'])) {
                unlink('uploads/berita/' . $beritaLama['image']);
            }
        }

        // Siapkan array data baru yang akan di-update
        $newData = [
            'title'    => $this->request->getPost('title'),
            // 'slug'     => ... (kalau pakai slug)
            'category' => $this->request->getPost('category'),
            'content'  => $this->request->getPost('content'),
            'status'   => $this->request->getPost('status'),
            'image'    => $namaImage // Masukkan nama file (baru/lama)
        ];

        // 4. Update data ke database
        $this->beritaModel->update($id, $newData);

        // --- CATAT AKTIVITAS LOG: UPDATE ---
        // Kita kirim $beritaLama (sebelum diedit) dan $newData (sesudah diedit)
        audit_log('UPDATE', 'Berita', $id, $beritaLama, $newData);

        session()->setFlashdata('pesan', 'Berita berhasil diupdate.');
        return redirect()->to('/panel/berita');
    }

    // Menghapus berita
    public function delete($id)
    {
        // 1. Cari data berita berdasarkan ID terlebih dahulu (Untuk old_values di log)
        $berita = $this->beritaModel->find($id);

        // 2. Jika data ditemukan dan nama file gambarnya tidak kosong
        if ($berita && $berita['image'] != '') {
            $pathFile = 'uploads/berita/' . $berita['image'];

            // 3. Cek apakah file fisiknya benar-benar ada di folder
            if (file_exists($pathFile)) {
                unlink($pathFile); // Hapus file secara fisik
            }
        }

        // 4. Setelah file fisik terhapus, baru hapus data dari database
        $this->beritaModel->delete($id);

        // --- CATAT AKTIVITAS LOG: DELETE ---
        // Kirim $berita sebagai data yang dihapus, $new_values dikosongkan (null)
        audit_log('DELETE', 'Berita', $id, $berita, null);

        session()->setFlashdata('pesan', 'Berita beserta fotonya berhasil dihapus permanen.');
        return redirect()->to('/panel/berita');
    }
}
