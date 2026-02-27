<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RolePermissionModel;
use App\Models\SettingModel; // <-- Tambahkan model setting

class Auth extends BaseController
{
    public function index()
    {
        $session = session();

        // Jika sudah login, lempar ke dashboard
        if ($session->get('isLoggedIn')) {
            return redirect()->to('/panel/dashboard');
        }

        // Cek apakah user sedang dalam masa hukuman/blokir
        $isBlocked = false;
        if ($session->has('locked_until')) {
            if (time() < $session->get('locked_until')) {
                $isBlocked = true;
            } else {
                $session->remove('locked_until');
            }
        }

        // --- AMBIL DATA SETTING UNTUK LOGO & NAMA WEB ---
        $settingModel = new SettingModel();
        $setting = $settingModel->first();

        // Kirim status isBlocked dan setting ke View
        return view('panel/auth/login', [
            'isBlocked' => $isBlocked,
            'setting'   => $setting
        ]);
    }

    public function process()
    {
        $session = session();
        $throttler = \Config\Services::throttler();

        $ipAddress = $this->request->getIPAddress();
        $maxAttempts = 5;
        $timeoutSeconds = 60;

        if ($throttler->check("login_attempts_{$ipAddress}", $maxAttempts, $timeoutSeconds) === false) {
            $session->set('locked_until', time() + $timeoutSeconds);
            return redirect()->to('/panel/login');
        }

        $userModel = new UserModel();
        $loginID = $this->request->getPost('login_id');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $loginID)
            ->orWhere('username', $loginID)
            ->first();

        if ($user && password_verify($password, $user['password_hash'])) {

            $throttler->remove("login_attempts_{$ipAddress}");
            $session->remove('locked_until');

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
            $session->setFlashdata('error', 'Username/Email atau Password salah.');
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
