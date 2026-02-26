<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Ambil role user yang sedang login
        $role = session()->get('role');

        // Jika route memiliki argument (syarat role), cek apakah role user ada di dalamnya
        if ($arguments && !in_array($role, $arguments)) {
            session()->setFlashdata('error', 'Akses Ditolak: Anda tidak memiliki izin untuk halaman tersebut!');
            return redirect()->to('/panel/dashboard');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu diisi
    }
}
