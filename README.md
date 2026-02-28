# Sisfokol 2026 - Sistem Informasi Sekolah & Kampus

![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4.x-EF4223?style=for-the-badge&logo=codeigniter)
![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)

Sisfokol 2026 adalah aplikasi web Sistem Informasi Manajemen terpadu untuk institusi pendidikan (Sekolah/Fakultas). Dibangun menggunakan framework CodeIgniter 4, aplikasi ini dirancang untuk mengelola portal informasi publik dan dilengkapi dengan Panel Administrator yang aman berbasis Role-Based Access Control (RBAC).

## 🚀 Fitur Utama

### Frontend (Portal Publik)
- **Beranda & Profil:** Menampilkan informasi umum dan profil institusi.
- **Berita & Artikel:** Publikasi pengumuman dan berita terbaru.
- **Galeri:** Etalase dokumentasi kegiatan dan fasilitas.
- **Program Studi / Jurusan:** Informasi detail mengenai jurusan yang tersedia.
- **Kontak & Pesan:** Formulir interaktif bagi pengunjung untuk mengirim pesan.

### Backend (Panel Administrator)
- **Autentikasi & Otorisasi:** Sistem login dengan perlindungan CSRF dan manajemen sesi.
- **Manajemen Pengguna & Peran (RBAC):** Mengelola akun pengguna dan mendefinisikan hak akses berdasarkan *role* (Administrator, Editor, dll).
- **Manajemen Konten:**
  - **Berita:** CRUD (Create, Read, Update, Delete) dengan fitur *Soft Delete* (Trash/Restore).
  - **Galeri:** Manajemen foto dengan format WebP teroptimasi.
  - **Jurusan:** Pengelolaan data program studi.
  - **Mitra:** Manajemen logo dan data kemitraan.
- **Manajemen Interaksi:**
  - **Pesan (Inbox):** Membaca dan mengelola pesan masuk dari publik.
- **Pengaturan Sistem:**
  - **Setting Global:** Konfigurasi nama website, logo, favicon, dan identitas aplikasi.
  - **Profil Pengguna (My Profile):** Pembaruan data pribadi akun admin.
- **Keamanan & Audit:**
  - **Log Aktivitas (Audit Trail):** Mencatat setiap perubahan data (siapa, apa, kapan) untuk pelacakan aktivitas sistem.

## 📋 Persyaratan Sistem

Pastikan lingkungan server/lokal Anda memenuhi persyaratan berikut:
* **PHP** versi 7.4 atau lebih baru (Disarankan PHP 8.x)
* **Composer** terinstal
* **Database:** MySQL (versi 5.1+) atau MariaDB
* Ekstensi PHP: `intl`, `mbstring`, `json`, `mysqlnd`, `xml`, `curl`, `gd` (untuk manipulasi gambar)

## 🛠️ Panduan Instalasi

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di komputer lokal:

**1. Clone Repositori**
```bash
git clone [https://github.com/username/sisfokol2026.git](https://github.com/username/sisfokol2026.git)

**2. Install Dependensi**
```bash
composer install

**3. Konfigurasi Environment**

