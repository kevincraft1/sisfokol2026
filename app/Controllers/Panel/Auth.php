<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        // Jika sudah login, langsung lempar ke dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/panel/dashboard');
        }
        return view('panel/auth/login');
    }

    public function process()
    {
        $session = session();
        $userModel = new UserModel();

        $loginID = $this->request->getPost('login_id'); // bisa email atau username
        $password = $this->request->getPost('password');

        // Cari user berdasarkan email ATAU username
        $user = $userModel->where('email', $loginID)
            ->orWhere('username', $loginID)
            ->first();

        if ($user) {
            // Verifikasi password (asumsi menggunakan password_hash saat insert data nanti)
            if (password_verify($password, $user['password_hash'])) {
                $sessData = [
                    'id'           => $user['id'],
                    'username'     => $user['username'],
                    'nama_lengkap' => $user['nama_lengkap'],
                    'email'        => $user['email'],
                    'role'         => $user['role'],
                    'isLoggedIn'   => true
                ];
                $session->set($sessData);

                // --- CATAT AKTIVITAS LOGIN ---
                audit_log('LOGIN', 'Autentikasi', $user['id'], null, null);

                return redirect()->to('/panel/dashboard');
            } else {
                $session->setFlashdata('error', 'Password salah.');
                return redirect()->to('/panel/login');
            }
        } else {
            $session->setFlashdata('error', 'Username/Email tidak ditemukan.');
            return redirect()->to('/panel/login');
        }
    }

    public function logout()
    {
        $session = session();

        // --- CATAT AKTIVITAS LOGOUT (Harus sebelum destroy) ---
        if ($session->get('isLoggedIn')) {
            audit_log('LOGOUT', 'Autentikasi', $session->get('id'), null, null);
        }

        $session->destroy();
        return redirect()->to('/panel/login');
    }
}
