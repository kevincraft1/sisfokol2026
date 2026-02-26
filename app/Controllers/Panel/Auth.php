<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RolePermissionModel;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/panel/dashboard');
        }
        return view('panel/auth/login');
    }

    public function process()
    {
        $session = session();
        $throttler = \Config\Services::throttler();
        $ipAddress = $this->request->getIPAddress();

        $maxAttempts = 5; // Batas maksimal percobaan
        $timeoutSeconds = 60; // Waktu blokir (detik)

        // 1. Cek apakah IP sudah diblokir oleh Throttler
        if ($throttler->check("login_attempts_{$ipAddress}", $maxAttempts, $timeoutSeconds) === false) {
            $session->setFlashdata('error_block', 'Terlalu banyak percobaan! Keamanan sistem aktif. Silakan tunggu 1 menit sebelum mencoba lagi.');
            return redirect()->to('/panel/login');
        }

        $userModel = new UserModel();
        $loginID = $this->request->getPost('login_id');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $loginID)
            ->orWhere('username', $loginID)
            ->first();

        // 2. Validasi Login
        if ($user && password_verify($password, $user['password_hash'])) {

            // --- JIKA SUKSES: Bersihkan riwayat kegagalan ---
            $session->remove('failed_attempts');
            $throttler->remove("login_attempts_{$ipAddress}");

            $permModel = new RolePermissionModel();
            $permissions = $permModel->where('slug_role', $user['role'])->findAll();
            $accessList = array_column($permissions, 'nama_modul');

            $sessData = [
                'id'           => $user['id'],
                'username'     => $user['username'],
                'nama_lengkap' => $user['nama_lengkap'],
                'email'        => $user['email'],
                'role'         => $user['role'],
                'user_access'  => $accessList,
                'isLoggedIn'   => true
            ];
            $session->set($sessData);

            audit_log('LOGIN', 'Autentikasi', $user['id'], null, null);
            return redirect()->to('/panel/dashboard');
        } else {
            // --- JIKA GAGAL: Hitung interaktif ---
            // Ambil data kegagalan sebelumnya (jika belum ada, set 0)
            $attempts = $session->get('failed_attempts') ?? 0;
            $attempts++; // Tambah 1 kegagalan
            $session->set('failed_attempts', $attempts); // Simpan kembali ke session

            // Hitung sisa
            $sisaPercobaan = $maxAttempts - $attempts;

            $session->setFlashdata('error', 'Username/Email atau Password salah.');

            // Tampilkan warning hanya jika masih ada sisa percobaan sebelum diblokir
            if ($sisaPercobaan > 0) {
                $session->setFlashdata('warning', "Peringatan: Sisa percobaan login Anda tinggal <strong>{$sisaPercobaan} kali</strong> lagi.");
            }

            return redirect()->to('/panel/login');
        }
    }

    public function logout()
    {
        $session = session();
        if ($session->get('isLoggedIn')) {
            audit_log('LOGOUT', 'Autentikasi', $session->get('id'), null, null);
        }
        $session->destroy();
        return redirect()->to('/panel/login');
    }
}
