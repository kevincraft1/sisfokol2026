<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Ambil daftar akses modul dari session yang di-set saat login
        $userAccess = session()->get('user_access') ?? [];

        // Jika route memiliki argument (syarat nama modul), cek apakah user punya akses
        if ($arguments) {
            $hasAccess = false;

            foreach ($arguments as $modul) {
                if (in_array($modul, $userAccess)) {
                    $hasAccess = true;
                    break;
                }
            }

            if (!$hasAccess) {
                session()->setFlashdata('error', 'Akses Ditolak: Anda tidak memiliki izin untuk membuka halaman tersebut!');
                return redirect()->to('/panel/dashboard');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu diisi
    }
}
