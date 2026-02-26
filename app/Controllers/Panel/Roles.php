<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\RolePermissionModel;
use App\Models\UserModel;

class Roles extends BaseController
{
    protected $roleModel;
    protected $permissionModel;
    protected $userModel;

    // Daftar Semua Modul/Menu di Aplikasi
    protected $availableModules = [
        'dashboard' => 'Dashboard Utama',
        'berita'    => 'Manajemen Berita & Artikel',
        'galeri'    => 'Galeri Foto Kegiatan',
        'profil'    => 'Profil & Visi Misi',
        'jurusan'   => 'Program Keahlian',
        'hero'      => 'Pengaturan Banner Depan',
        'mitra'     => 'Logo Mitra Industri',
        'pesan'     => 'Inbox Pesan Masuk',
        'setting'   => 'Pengaturan Web',
        'users'     => 'Manajemen Akun Pengguna',
        'roles'     => 'Manajemen Hak Akses',
        'log'       => 'Log Aktivitas Sistem'
    ];

    public function __construct()
    {
        $this->roleModel = new RoleModel();
        $this->permissionModel = new RolePermissionModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Hak Akses',
            'roles' => $this->roleModel->findAll()
        ];
        return view('panel/roles/index', $data);
    }

    public function create()
    {
        $data = [
            'title'   => 'Tambah Role Baru',
            'modules' => $this->availableModules
        ];
        return view('panel/roles/create', $data);
    }

    public function store()
    {
        $namaRole = $this->request->getPost('nama_role');
        $slugRole = url_title($namaRole, '-', true);

        // Validasi jika Role sudah ada
        if ($this->roleModel->find($slugRole)) {
            return redirect()->back()->withInput()->with('error', 'Nama Role tersebut sudah ada!');
        }

        // 1. Simpan Data Role Utama
        $this->roleModel->insert([
            'slug_role' => $slugRole,
            'nama_role' => $namaRole,
            'deskripsi' => $this->request->getPost('deskripsi')
        ]);

        // 2. Simpan Izin Modul (Checkboxes)
        $permissions = $this->request->getPost('permissions') ?? [];
        $permData = [];
        foreach ($permissions as $modul) {
            $permData[] = [
                'slug_role'  => $slugRole,
                'nama_modul' => $modul
            ];
        }
        if (!empty($permData)) {
            $this->permissionModel->insertBatch($permData);
        }

        audit_log('CREATE', 'Hak Akses', 0, null, ['role' => $namaRole]);
        return redirect()->to('/panel/roles')->with('pesan', 'Role baru berhasil ditambahkan.');
    }

    public function edit($slug)
    {
        $role = $this->roleModel->find($slug);
        if (!$role) return redirect()->to('/panel/roles')->with('error', 'Data Role tidak ditemukan.');

        // Ambil data checklist yang sudah tersimpan
        $perms = $this->permissionModel->where('slug_role', $slug)->findAll();
        $checkedModules = array_column($perms, 'nama_modul');

        $data = [
            'title'   => 'Edit Role',
            'role'    => $role,
            'modules' => $this->availableModules,
            'checked' => $checkedModules
        ];
        return view('panel/roles/edit', $data);
    }

    public function update($slug)
    {
        // Proteksi: Role 'admin' tidak boleh diubah hak aksesnya untuk mencegah sistem terkunci
        if ($slug === 'admin') {
            return redirect()->to('/panel/roles')->with('error', 'Akses Ditolak: Hak akses Administrator Utama tidak boleh dimodifikasi!');
        }

        $this->roleModel->update($slug, [
            'nama_role' => $this->request->getPost('nama_role'),
            'deskripsi' => $this->request->getPost('deskripsi')
        ]);

        // Hapus izin lama, lalu masukkan yang baru dicentang
        $this->permissionModel->where('slug_role', $slug)->delete();

        $permissions = $this->request->getPost('permissions') ?? [];
        $permData = [];
        foreach ($permissions as $modul) {
            $permData[] = [
                'slug_role'  => $slug,
                'nama_modul' => $modul
            ];
        }
        if (!empty($permData)) {
            $this->permissionModel->insertBatch($permData);
        }

        audit_log('UPDATE', 'Hak Akses', 0, ['role_lama' => $slug], ['role_baru' => $this->request->getPost('nama_role')]);
        return redirect()->to('/panel/roles')->with('pesan', 'Data Role berhasil diperbarui.');
    }

    public function delete($slug)
    {
        if ($slug === 'admin') {
            return redirect()->to('/panel/roles')->with('error', 'Akses Ditolak: Role Administrator tidak bisa dihapus!');
        }

        // Cek apakah Role ini sedang dipakai oleh user
        $isUsed = $this->userModel->where('role', $slug)->first();
        if ($isUsed) {
            return redirect()->to('/panel/roles')->with('error', 'Role tidak bisa dihapus karena masih digunakan oleh Pengguna. Ubah dulu role pengguna terkait.');
        }

        $this->roleModel->delete($slug);
        audit_log('DELETE', 'Hak Akses', 0, ['role' => $slug], null);

        return redirect()->to('/panel/roles')->with('pesan', 'Role berhasil dihapus.');
    }
}
