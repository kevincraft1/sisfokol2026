<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\BeritaModel;
use App\Models\GaleriModel;
use App\Models\JurusanModel;

class AutoPurge extends BaseCommand
{
    // Nama grup dan perintah saat dijalankan di terminal
    protected $group       = 'Sisfokol';
    protected $name        = 'sisfokol:autopurge';
    protected $description = 'Menghapus permanen data di Tong Sampah yang usianya lebih dari 30 hari.';

    public function run(array $params)
    {
        CLI::write('Mulai menjalankan Auto-Purge 30 Hari...', 'yellow');

        $beritaModel = new BeritaModel();
        $galeriModel = new GaleriModel();

        // Hitung tanggal 30 hari yang lalu dari waktu sekarang
        $batasWaktu = date('Y-m-d H:i:s', strtotime('-30 days'));

        // ==========================================
        // 1. BERSIHKAN BERITA USANG
        // ==========================================
        // Cari berita di tong sampah yang tanggal deleted_at-nya lebih lama atau sama dengan 30 hari yang lalu
        $beritaUsang = $beritaModel->onlyDeleted()->where('deleted_at <=', $batasWaktu)->findAll();
        $countBerita = 0;

        foreach ($beritaUsang as $b) {
            // Hapus file fisik (menggunakan FCPATH agar jalurnya akurat di server)
            if ($b['image'] != '') {
                $pathFile = FCPATH . 'uploads/berita/' . $b['image'];
                if (file_exists($pathFile)) {
                    unlink($pathFile);
                }
            }
            // Hapus dari database (Hard Delete)
            $beritaModel->delete($b['id'], true);
            $countBerita++;
        }
        CLI::write("-> Berhasil menghapus permanen $countBerita Berita usang.", 'green');


        // ==========================================
        // 2. BERSIHKAN GALERI USANG
        // ==========================================
        $galeriUsang = $galeriModel->onlyDeleted()->where('deleted_at <=', $batasWaktu)->findAll();
        $countGaleri = 0;

        foreach ($galeriUsang as $g) {
            // Hapus file fisik
            if ($g['image'] != '') {
                $pathFile = FCPATH . 'uploads/galeri/' . $g['image'];
                if (file_exists($pathFile)) {
                    unlink($pathFile);
                }
            }
            // Hapus dari database (Hard Delete)
            $galeriModel->delete($g['id'], true);
            $countGaleri++;
        }
        CLI::write("-> Berhasil menghapus permanen $countGaleri Foto Galeri usang.", 'green');

        // Jika nanti Anda ingin menambahkan Jurusan, bisa tambahkan blok kode yang sama di sini

        CLI::write('Proses Auto-Purge selesai dengan sukses!', 'black', 'green');
    }
}
