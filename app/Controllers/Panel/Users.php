<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel; // Tambahkan ini

class Users extends BaseController
{
    protected $userModel;
    protected $roleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel(); // Inisialisasi RoleModel
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Pengguna',
            'users' => $this->userModel->orderBy('id', 'DESC')->findAll()
        ];
        return view('panel/users/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pengguna Baru',
            'roles' => $this->roleModel->findAll() // Kirim daftar role dinamis
        ];
        return view('panel/users/create', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'username' => 'is_unique[users.username]',
            'email'    => 'is_unique[users.email]'
        ])) {
            session()->setFlashdata('error', 'Username atau Email sudah digunakan!');
            return redirect()->to('/panel/users/create')->withInput();
        }

        $newData = [
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'username'      => $this->request->getPost('username'),
            'email'         => $this->request->getPost('email'),
            'role'          => $this->request->getPost('role'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];

        $this->userModel->save($newData);
        $insertedId = $this->userModel->getInsertID();

        $logData = $newData;
        unset($logData['password_hash']);
        audit_log('CREATE', 'Manajemen Pengguna', $insertedId, null, $logData);

        session()->setFlashdata('pesan', 'Pengguna baru berhasil ditambahkan.');
        return redirect()->to('/panel/users');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Pengguna',
            'user'  => $this->userModel->find($id),
            'roles' => $this->roleModel->findAll() // Kirim daftar role dinamis
        ];
        return view('panel/users/edit', $data);
    }

    public function update($id)
    {
        $userLama = $this->userModel->find($id);

        $dataUpdate = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'email'        => $this->request->getPost('email'),
            'role'         => $this->request->getPost('role')
        ];

        $passwordBaru = $this->request->getPost('password');
        if (!empty($passwordBaru)) {
            $dataUpdate['password_hash'] = password_hash($passwordBaru, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $dataUpdate);

        $logDataUpdate = $dataUpdate;
        $logUserLama = $userLama;
        unset($logDataUpdate['password_hash']);
        unset($logUserLama['password_hash']);
        audit_log('UPDATE', 'Manajemen Pengguna', $id, $logUserLama, $logDataUpdate);

        session()->setFlashdata('pesan', 'Data pengguna berhasil diperbarui.');
        return redirect()->to('/panel/users');
    }

    public function delete($id)
    {
        if ($id == session()->get('id')) {
            session()->setFlashdata('error', 'Akses Ditolak: Anda tidak bisa menghapus akun Anda sendiri!');
            return redirect()->to('/panel/users');
        }

        $userTarget = $this->userModel->find($id);

        if ($userTarget['role'] === 'admin') {
            session()->setFlashdata('error', 'Akses Ditolak: Akun dengan hak akses Admin tidak boleh dihapus!');
            return redirect()->to('/panel/users');
        }

        $this->userModel->delete($id);

        $logUserTarget = $userTarget;
        unset($logUserTarget['password_hash']);
        audit_log('DELETE', 'Manajemen Pengguna', $id, $logUserTarget, null);

        session()->setFlashdata('pesan', 'Pengguna berhasil dihapus.');
        return redirect()->to('/panel/users');
    }
}
