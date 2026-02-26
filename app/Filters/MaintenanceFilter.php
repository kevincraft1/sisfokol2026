<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;


class MaintenanceFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $settingModel = new \App\Models\SettingModel();
        $setting = $settingModel->first();

        // Cek jika Maintenance Mode sedang ON (bernilai 1)
        if (isset($setting['is_maintenance']) && $setting['is_maintenance'] == 1) {

            // BYPASS KETAT: HANYA Admin Utama yang boleh melihat website!
            // Guru, Kepsek, dan pengunjung biasa akan diblokir.
            if (session()->get('role') === 'admin') {
                return;
            }

            return redirect()->to('/maintenance');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu aksi setelah respon
    }
}
