<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\UserModel;

class MyProfile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Ambil ID user yang sedang login dari session 'id' (sesuai Auth.php)
        $idUser = session()->get('id');

        $data = [
            'title' => 'Profil Saya',
            'user'  => $this->userModel->find($idUser)
        ];

        return view('panel/my_profile/index', $data);
    }

    public function update()
    {
        $idUser = session()->get('id');

        // 1. Ambil data lama sebelum diubah (Untuk Audit Log)
        $userLama = $this->userModel->find($idUser);

        $namaLengkap      = $this->request->getPost('nama_lengkap');
        $email            = $this->request->getPost('email');
        $passwordBaru     = $this->request->getPost('password_baru');
        $passwordKonfirm  = $this->request->getPost('password_konfirmasi');

        // 2. Siapkan array data yang akan diperbarui
        $dataUpdate = [
            'nama_lengkap' => $namaLengkap,
            'email'        => $email
        ];

        // Jika form password diisi, berarti user ingin ganti password
        if (!empty($passwordBaru)) {
            // Validasi apakah password konfirmasi cocok
            if ($passwordBaru !== $passwordKonfirm) {
                session()->setFlashdata('error', 'Konfirmasi password tidak cocok! Silakan coba lagi.');
                return redirect()->back();
            }

            // Enkripsi password baru (sesuaikan kolom dengan UserModel -> password_hash)
            $dataUpdate['password_hash'] = password_hash($passwordBaru, PASSWORD_DEFAULT);
        }

        // 3. Simpan ke database
        $this->userModel->update($idUser, $dataUpdate);

        // --- CATAT AKTIVITAS LOG: UPDATE PROFIL ---
        audit_log('UPDATE', 'Profil Akun Saya', $idUser, $userLama, $dataUpdate);

        // Perbarui session agar langsung berubah di pojok kanan atas layar tanpa perlu relogin
        session()->set([
            'nama_lengkap' => $namaLengkap,
            'email'        => $email
        ]);

        session()->setFlashdata('pesan', 'Profil & keamanan akun berhasil diperbarui.');
        return redirect()->to('/panel/my-profile');
    }
}
