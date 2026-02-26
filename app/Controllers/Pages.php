<?php

namespace App\Controllers;

use App\Models\BeritaModel;
use App\Models\GaleriModel;
use App\Models\JurusanModel;
use App\Models\PesanModel;
use App\Models\SettingModel;
use App\Models\ProfilModel;
use App\Models\MitraModel; // <-- 1. Tambahkan MitraModel

class Pages extends BaseController
{
    protected $beritaModel;
    protected $galeriModel;
    protected $jurusanModel;
    protected $pesanModel;
    protected $settingModel;
    protected $profilModel;
    protected $mitraModel; // <-- 2. Tambahkan properti mitraModel
    protected $setting;


    public function __construct()
    {
        $this->beritaModel  = new BeritaModel();
        $this->galeriModel  = new GaleriModel();
        $this->jurusanModel = new JurusanModel();
        $this->pesanModel   = new PesanModel();

        $this->settingModel = new SettingModel();
        $this->setting      = $this->settingModel->first();

        $this->profilModel  = new ProfilModel();
        $this->mitraModel   = new MitraModel(); // <-- 3. Inisialisasi MitraModel

        helper('text');
    }

    public function index()
    {
        $data = [
            'title'   => 'Beranda',
            'active'  => 'beranda',
            'setting' => $this->setting,
            'berita'  => $this->beritaModel->where('status', 'published')->orderBy('created_at', 'DESC')->findAll(3),
            'galeri'  => $this->galeriModel->orderBy('id', 'DESC')->findAll(6),
            'jurusan' => $this->jurusanModel->findAll(),
            'mitra'   => $this->mitraModel->findAll() // <-- 4. Perbaiki cara pemanggilan data mitra
        ];
        return view('pages/home', $data);
    }

    public function profil()
    {
        $data = [
            'title'   => 'Profil',
            'active'  => 'profil',
            'setting' => $this->setting,
            'profil'  => $this->profilModel->first()
        ];
        return view('pages/profil', $data);
    }

    public function jurusan()
    {
        $data = [
            'title'   => 'Jurusan',
            'active'  => 'jurusan',
            'setting' => $this->setting,
            'jurusan' => $this->jurusanModel->findAll()
        ];
        return view('pages/jurusan', $data);
    }

    public function detailJurusan($slug)
    {
        $jurusan = $this->jurusanModel->where('slug', $slug)->first();

        if (!$jurusan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'   => 'Detail ' . $jurusan['name'],
            'active'  => 'jurusan',
            'setting' => $this->setting,
            'jurusan' => $jurusan
        ];
        return view('pages/detail_jurusan', $data);
    }

    public function berita()
    {
        $data = [
            'title'   => 'Berita',
            'active'  => 'berita',
            'setting' => $this->setting,
            'berita'  => $this->beritaModel->where('status', 'published')->orderBy('created_at', 'DESC')->paginate(6, 'berita'),
            'pager'   => $this->beritaModel->pager
        ];
        return view('pages/berita', $data);
    }

    public function detailBerita($slug)
    {
        $berita = $this->beritaModel->where('slug', $slug)->where('status', 'published')->first();
        if (!$berita) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data = [
            'title'   => $berita['title'],
            'active'  => 'berita',
            'setting' => $this->setting,
            'berita'  => $berita
        ];
        return view('pages/detail_berita', $data);
    }

    public function galeri()
    {
        $data = [
            'title'   => 'Galeri',
            'active'  => 'galeri',
            'setting' => $this->setting,
            'galeri'  => $this->galeriModel->orderBy('id', 'DESC')->findAll()
        ];
        return view('pages/galeri', $data);
    }

    public function kontak()
    {
        return view('pages/kontak', ['title' => 'Kontak', 'active' => 'kontak', 'setting' => $this->setting]);
    }

    public function kirimPesan()
    {
        $this->pesanModel->save([
            'name'    => $this->request->getPost('name'),
            'email'   => $this->request->getPost('email'),
            'subject' => $this->request->getPost('subject'),
            'message' => $this->request->getPost('message'),
            'is_read' => 0
        ]);

        session()->setFlashdata('pesan_sukses', 'Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.');
        return redirect()->to('/kontak');
    }

    public function error404()
    {
        if (isset($this->setting['is_maintenance']) && $this->setting['is_maintenance'] == 1) {
            if (session()->get('role') !== 'admin') {
                $this->response->setStatusCode(503);
                return view('pages/maintenance', ['setting' => $this->setting]);
            }
        }

        $this->response->setStatusCode(404);

        $data = [
            'title'   => '404 - Halaman Tidak Ditemukan',
            'active'  => '',
            'setting' => $this->setting
        ];

        return view('pages/404', $data);
    }

    public function maintenance()
    {
        if (isset($this->setting['is_maintenance']) && $this->setting['is_maintenance'] == 0) {
            return redirect()->to('/');
        }

        return view('pages/maintenance', ['setting' => $this->setting]);
    }
}
