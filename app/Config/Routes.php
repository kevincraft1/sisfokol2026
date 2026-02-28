<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ========================================================================
// ROUTE FRONTEND (HALAMAN DEPAN WEBSITE)
// ========================================================================
$routes->get('/', 'Pages::index');
$routes->set404Override('App\Controllers\Pages::error404');
$routes->get('profil', 'Pages::profil');
$routes->get('jurusan', 'Pages::jurusan');
$routes->get('jurusan/(:segment)', 'Pages::detailJurusan/$1');

$routes->get('berita', 'Pages::berita');
$routes->get('berita/(:segment)', 'Pages::detailBerita/$1'); // Detail Berita

$routes->get('galeri', 'Pages::galeri');

$routes->get('kontak', 'Pages::kontak');
$routes->post('kirim-pesan', 'Pages::kirimPesan'); // Proses form kontak

$routes->get('maintenance', 'Pages::maintenance');


// ========================================================================
// ROUTE BACKEND (ADMIN PANEL)
// ========================================================================
$routes->group('panel', ['namespace' => 'App\Controllers\Panel'], static function ($routes) {

    // --- ROUTE AUTENTIKASI (Tanpa Filter / Bebas Akses) ---
    $routes->get('login', 'Auth::index');
    $routes->post('auth/process', 'Auth::process');
    $routes->get('logout', 'Auth::logout');

    // --- ROUTE WAJIB LOGIN (Filter: auth) ---
    // Semua rute di dalam grup ini wajib login terlebih dahulu
    $routes->group('', ['filter' => 'auth'], static function ($routes) {

        // 1. AKSES UMUM (Semua user yang berhasil login pasti bisa mengakses ini)
        $routes->get('/', 'Dashboard::index');
        $routes->get('dashboard', 'Dashboard::index');

        $routes->get('my-profile', 'MyProfile::index');
        $routes->post('my-profile/update', 'MyProfile::update');


        // ====================================================================
        // 2. AKSES MODUL DINAMIS (Dibatasi berdasarkan checklist Role di Database)
        // ====================================================================

        // MODUL KOTAK MASUK (PESAN)
        $routes->group('pesan', ['filter' => 'role:pesan'], static function ($routes) {
            $routes->get('/', 'Pesan::index');
            $routes->get('baca/(:num)', 'Pesan::baca/$1');
            $routes->get('delete/(:num)', 'Pesan::delete/$1');
        });

        // MODUL BERITA
        $routes->group('berita', ['filter' => 'role:berita'], static function ($routes) {
            $routes->get('/', 'Berita::index');
            $routes->get('create', 'Berita::create');
            $routes->post('store', 'Berita::store');
            $routes->get('edit/(:num)', 'Berita::edit/$1');
            $routes->post('update/(:num)', 'Berita::update/$1');
            $routes->get('delete/(:num)', 'Berita::delete/$1');

            // --- TAMBAHAN TAHAP 3: TONG SAMPAH BERITA ---
            $routes->get('trash', 'Berita::trash');
            $routes->get('restore/(:num)', 'Berita::restore/$1');
            $routes->get('purge/(:num)', 'Berita::purge/$1');
        });

        // MODUL GALERI
        $routes->group('galeri', ['filter' => 'role:galeri'], static function ($routes) {
            $routes->get('/', 'Galeri::index');
            $routes->get('create', 'Galeri::create');
            $routes->post('store', 'Galeri::store');
            $routes->get('edit/(:num)', 'Galeri::edit/$1');
            $routes->post('update/(:num)', 'Galeri::update/$1');
            $routes->get('delete/(:num)', 'Galeri::delete/$1');

            // --- TAMBAHAN TAHAP 3: TONG SAMPAH GALERI ---
            $routes->get('trash', 'Galeri::trash');
            $routes->get('restore/(:num)', 'Galeri::restore/$1');
            $routes->get('purge/(:num)', 'Galeri::purge/$1');
        });

        // MODUL PENGATURAN WEB
        $routes->group('setting', ['filter' => 'role:setting'], static function ($routes) {
            $routes->get('/', 'Setting::index');
            $routes->post('update', 'Setting::update');
            $routes->post('toggle-maintenance', 'Setting::toggleMaintenance');
        });

        // MODUL PROFIL SEKOLAH
        $routes->group('profil', ['filter' => 'role:profil'], static function ($routes) {
            $routes->get('/', 'Profil::index');
            $routes->post('update', 'Profil::update');
        });

        // MODUL HERO SECTION (Banner)
        $routes->group('hero', ['filter' => 'role:hero'], static function ($routes) {
            $routes->get('/', 'Setting::hero');
            $routes->post('update', 'Setting::updateHero');
        });

        // MODUL JURUSAN
        $routes->group('jurusan', ['filter' => 'role:jurusan'], static function ($routes) {
            $routes->get('/', 'Jurusan::index');
            $routes->get('create', 'Jurusan::create');
            $routes->post('store', 'Jurusan::store');
            $routes->get('edit/(:num)', 'Jurusan::edit/$1');
            $routes->post('update/(:num)', 'Jurusan::update/$1');
            $routes->get('delete/(:num)', 'Jurusan::delete/$1');
        });

        // MODUL MITRA INDUSTRI
        $routes->group('mitra', ['filter' => 'role:mitra'], static function ($routes) {
            $routes->get('/', 'Mitra::index');
            $routes->post('store', 'Mitra::store');
            $routes->post('update/(:num)', 'Mitra::update/$1');
            $routes->get('delete/(:num)', 'Mitra::delete/$1');
        });

        // MODUL MANAJEMEN PENGGUNA (USERS)
        $routes->group('users', ['filter' => 'role:users'], static function ($routes) {
            $routes->get('/', 'Users::index');
            $routes->get('create', 'Users::create');
            $routes->post('store', 'Users::store');
            $routes->get('edit/(:num)', 'Users::edit/$1');
            $routes->post('update/(:num)', 'Users::update/$1');
            $routes->get('delete/(:num)', 'Users::delete/$1');
        });

        // MODUL HAK AKSES (ROLES) -> Fitur baru
        $routes->group('roles', ['filter' => 'role:roles'], static function ($routes) {
            $routes->get('/', 'Roles::index');
            $routes->get('create', 'Roles::create');
            $routes->post('store', 'Roles::store');
            $routes->get('edit/(:segment)', 'Roles::edit/$1');
            $routes->post('update/(:segment)', 'Roles::update/$1');
            $routes->get('delete/(:segment)', 'Roles::delete/$1');
        });

        // MODUL LOG AKTIVITAS
        $routes->group('log', ['filter' => 'role:log'], static function ($routes) {
            $routes->get('/', 'LogActivity::index');
        });
    });
});
