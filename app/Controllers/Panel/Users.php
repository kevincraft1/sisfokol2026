<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
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
        return view('panel/users/create', ['title' => 'Tambah Pengguna Baru']);
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

        // Keamanan: Hapus password_hash dari data yang akan dicatat di log
        $logData = $newData;
        unset($logData['password_hash']);

        // --- CATAT AKTIVITAS LOG: CREATE ---
        audit_log('CREATE', 'Manajemen Pengguna', $insertedId, null, $logData);

        session()->setFlashdata('pesan', 'Pengguna baru berhasil ditambahkan.');
        return redirect()->to('/panel/users');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Pengguna',
            'user'  => $this->userModel->find($id)
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

        // Keamanan: Hapus password_hash dari log
        $logDataUpdate = $dataUpdate;
        $logUserLama = $userLama;
        unset($logDataUpdate['password_hash']);
        unset($logUserLama['password_hash']);

        // --- CATAT AKTIVITAS LOG: UPDATE ---
        audit_log('UPDATE', 'Manajemen Pengguna', $id, $logUserLama, $logDataUpdate);

        session()->setFlashdata('pesan', 'Data pengguna berhasil diperbarui.');
        return redirect()->to('/panel/users');
    }

    public function delete($id)
    {
        // 1. Cegah menghapus akun diri sendiri yang sedang login
        if ($id == session()->get('id')) {
            session()->setFlashdata('error', 'Akses Ditolak: Anda tidak bisa menghapus akun Anda sendiri!');
            return redirect()->to('/panel/users');
        }

        // Cari tahu role user yang akan dihapus
        $userTarget = $this->userModel->find($id);

        // 2. Cegah menghapus akun dengan role 'Admin'
        if ($userTarget['role'] === 'admin') {
            session()->setFlashdata('error', 'Akses Ditolak: Akun dengan hak akses Admin tidak boleh dihapus!');
            return redirect()->to('/panel/users');
        }

        // Jika lolos kedua validasi di atas, hapus user
        $this->userModel->delete($id);

        // Keamanan: Hapus password_hash dari log
        $logUserTarget = $userTarget;
        unset($logUserTarget['password_hash']);

        // --- CATAT AKTIVITAS LOG: DELETE ---
        audit_log('DELETE', 'Manajemen Pengguna', $id, $logUserTarget, null);

        session()->setFlashdata('pesan', 'Pengguna berhasil dihapus.');
        return redirect()->to('/panel/users');
    }
}
