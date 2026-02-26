<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\BeritaModel;
use App\Models\GaleriModel;
use App\Models\UserModel;
use App\Models\PesanModel;

class Dashboard extends BaseController
{
    public function __construct()
    {
        helper('text');
    }

    public function index()
    {
        $beritaModel = new BeritaModel();
        $galeriModel = new GaleriModel();
        $userModel   = new UserModel();
        $pesanModel  = new PesanModel();

        // Ambil bulan dan tahun saat ini untuk statistik "+ bulan ini"
        $bulanIni = date('m');
        $tahunIni = date('Y');

        $data = [
            'title'          => 'Dashboard Overview',

            // Total Keseluruhan
            'totalBerita'    => $beritaModel->countAllResults(),
            'totalGaleri'    => $galeriModel->countAllResults(),
            'totalUsers'     => $userModel->countAllResults(),
            'totalPesan'     => $pesanModel->countAllResults(),

            // Statistik Khusus (Bulan Ini / Belum Dibaca)
            'beritaBulanIni' => $beritaModel->where('MONTH(created_at)', $bulanIni)
                ->where('YEAR(created_at)', $tahunIni)
                ->countAllResults(),
            'galeriBulanIni' => $galeriModel->where('MONTH(created_at)', $bulanIni)
                ->where('YEAR(created_at)', $tahunIni)
                ->countAllResults(),
            'userBulanIni'   => $userModel->where('MONTH(created_at)', $bulanIni)
                ->where('YEAR(created_at)', $tahunIni)
                ->countAllResults(),
            'pesanBelumBaca' => $pesanModel->where('is_read', 0)->countAllResults(),

            // Data Pesan Terbaru untuk Tabel di Dashboard (Maksimal 5 pesan)
            'pesanTerbaru'   => $pesanModel->orderBy('created_at', 'DESC')->findAll(5)
        ];

        return view('panel/dashboard', $data);
    }
}
