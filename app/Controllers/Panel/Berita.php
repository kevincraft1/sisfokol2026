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

    // Menampilkan daftar berita sesuai Role (Ownership)
    public function index()
    {
        $role = session()->get('role');
        $userId = session()->get('id');

        // Cek jika yang login adalah admin, tampilkan SEMUA berita
        if ($role === 'admin') {
            $dataBerita = $this->beritaModel->orderBy('id', 'DESC')->findAll();
        } else {
            // Jika bukan admin (misal: guru), tampilkan HANYA milik dia sendiri
            $dataBerita = $this->beritaModel->where('user_id', $userId)->orderBy('id', 'DESC')->findAll();
        }

        $data = [
            'title'  => 'Manajemen Berita',
            'berita' => $dataBerita
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

    // Menampilkan form edit berita (Dengan Proteksi Ownership)
    public function edit($id)
    {
        $berita = $this->beritaModel->find($id);

        // Jika data tidak ditemukan
        if (!$berita) {
            session()->setFlashdata('error', 'Data berita tidak ditemukan.');
            return redirect()->to('/panel/berita');
        }

        // PROTEKSI OWNERSHIP: Tolak jika bukan Admin DAN bukan pemilik berita
        if (session()->get('role') !== 'admin' && $berita['user_id'] != session()->get('id')) {
            session()->setFlashdata('error', 'Akses Ditolak! Anda hanya dapat mengedit berita milik Anda sendiri.');
            return redirect()->to('/panel/berita');
        }

        $data = [
            'title'  => 'Edit Berita',
            'berita' => $berita
        ];
        return view('panel/berita/edit', $data);
    }

    // Memproses update berita (Dengan Proteksi Ownership)
    public function update($id)
    {
        $beritaLama = $this->beritaModel->find($id);

        if (!$beritaLama) {
            return redirect()->to('/panel/berita');
        }

        // PROTEKSI OWNERSHIP: Tolak eksekusi update paksa melalui URL/Postman
        if (session()->get('role') !== 'admin' && $beritaLama['user_id'] != session()->get('id')) {
            session()->setFlashdata('error', 'Akses Ditolak! Anda tidak memiliki izin untuk mengubah berita ini.');
            return redirect()->to('/panel/berita');
        }

        $fileImage = $this->request->getFile('image');
        $namaImage = $beritaLama['image'];

        if ($fileImage && $fileImage->isValid() && ! $fileImage->hasMoved()) {
            $namaImage = $fileImage->getRandomName();
            $fileImage->move('uploads/berita', $namaImage);

            if (!empty($beritaLama['image']) && file_exists('uploads/berita/' . $beritaLama['image'])) {
                unlink('uploads/berita/' . $beritaLama['image']);
            }
        }

        $newData = [
            'title'    => $this->request->getPost('title'),
            'category' => $this->request->getPost('category'),
            'content'  => $this->request->getPost('content'),
            'status'   => $this->request->getPost('status'),
            'image'    => $namaImage
        ];

        $this->beritaModel->update($id, $newData);
        audit_log('UPDATE', 'Berita', $id, $beritaLama, $newData);

        session()->setFlashdata('pesan', 'Berita berhasil diupdate.');
        return redirect()->to('/panel/berita');
    }

    // Menghapus berita (Soft Delete, Rename Slug, Notif 30 Hari, & Proteksi Ownership)
    public function delete($id)
    {
        $berita = $this->beritaModel->find($id);

        if ($berita) {
            // PROTEKSI OWNERSHIP: Tolak penghapusan jika bukan haknya
            if (session()->get('role') !== 'admin' && $berita['user_id'] != session()->get('id')) {
                session()->setFlashdata('error', 'Akses Ditolak! Anda tidak dapat menghapus berita milik orang lain.');
                return redirect()->to('/panel/berita');
            }

            // Rename on delete agar tidak bentrok
            $newSlug = $berita['slug'] . '-deleted-' . time();
            $this->beritaModel->update($id, ['slug' => $newSlug]);

            // Soft delete
            $this->beritaModel->delete($id);

            audit_log('SOFT_DELETE', 'Berita', $id, $berita, null);
        }

        session()->setFlashdata('pesan', 'Berita berhasil dipindahkan ke Tong Sampah. Data akan otomatis terhapus permanen setelah 30 hari.');
        return redirect()->to('/panel/berita');
    }

    // =========================================================================
    // FITUR TONG SAMPAH (TRASH) - BERITA
    // =========================================================================

    // Menampilkan daftar berita yang ada di Tong Sampah
    public function trash()
    {
        $role = session()->get('role');
        $userId = session()->get('id');

        // Gunakan onlyDeleted() untuk memanggil data khusus di Tong Sampah
        if ($role === 'admin') {
            // Admin lihat semua data di tong sampah
            $dataBerita = $this->beritaModel->onlyDeleted()->orderBy('deleted_at', 'DESC')->findAll();
        } else {
            // Guru hanya lihat miliknya di tong sampah
            $dataBerita = $this->beritaModel->onlyDeleted()->where('user_id', $userId)->orderBy('deleted_at', 'DESC')->findAll();
        }

        $data = [
            'title'  => 'Tong Sampah - Berita',
            'berita' => $dataBerita
        ];
        return view('panel/berita/trash', $data);
    }

    // Memulihkan (Restore) berita dari Tong Sampah
    public function restore($id)
    {
        $berita = $this->beritaModel->onlyDeleted()->find($id);

        if ($berita) {
            // PROTEKSI OWNERSHIP
            if (session()->get('role') !== 'admin' && $berita['user_id'] != session()->get('id')) {
                session()->setFlashdata('error', 'Akses Ditolak! Anda tidak dapat memulihkan berita milik orang lain.');
                return redirect()->to('/panel/berita/trash');
            }

            // Restore data (CodeIgniter otomatis mengosongkan kolom deleted_at melalui Query Builder)
            $this->beritaModel->builder()->where('id', $id)->update(['deleted_at' => null]);

            audit_log('RESTORE', 'Berita', $id, null, $berita);
            session()->setFlashdata('pesan', 'Berita berhasil dipulihkan dan kembali tayang.');
        } else {
            session()->setFlashdata('error', 'Data tidak ditemukan di Tong Sampah.');
        }

        return redirect()->to('/panel/berita/trash');
    }

    // Menghapus permanen (Purge) berita beserta file fisiknya
    public function purge($id)
    {
        $berita = $this->beritaModel->onlyDeleted()->find($id);

        if ($berita) {
            // PROTEKSI OWNERSHIP
            if (session()->get('role') !== 'admin' && $berita['user_id'] != session()->get('id')) {
                session()->setFlashdata('error', 'Akses Ditolak! Anda tidak dapat menghapus permanen berita milik orang lain.');
                return redirect()->to('/panel/berita/trash');
            }

            // 1. Hapus file fisik gambar agar hosting tidak penuh (Tugas unlink pindah ke sini)
            if ($berita['image'] != '') {
                $pathFile = 'uploads/berita/' . $berita['image'];
                if (file_exists($pathFile)) {
                    unlink($pathFile);
                }
            }

            // 2. Hapus data permanen dari database (Tambahkan parameter 'true' = Hard Delete)
            $this->beritaModel->delete($id, true);

            audit_log('HARD_DELETE', 'Berita', $id, $berita, null);
            session()->setFlashdata('pesan', 'Berita beserta fotonya berhasil dihapus permanen.');
        }

        return redirect()->to('/panel/berita/trash');
    }
}
