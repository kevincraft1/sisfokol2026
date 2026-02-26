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
    $routes->group('', ['filter' => 'auth'], static function ($routes) {

        // 1. SEMUA ROLE BISA AKSES (Admin, Guru, Kepsek)
        $routes->get('/', 'Dashboard::index');
        $routes->get('dashboard', 'Dashboard::index');

        // --- ROUTE PROFIL SAYA (UBAH PASSWORD) ---
        $routes->get('my-profile', 'MyProfile::index');
        $routes->post('my-profile/update', 'MyProfile::update');

        // Kotak Masuk (Pesan)
        $routes->get('pesan', 'Pesan::index');
        $routes->get('pesan/baca/(:num)', 'Pesan::baca/$1');
        $routes->get('pesan/delete/(:num)', 'Pesan::delete/$1');

        // 2. HANYA ADMIN & GURU (Filter: role:admin,guru)
        $routes->group('', ['filter' => 'role:admin,guru'], static function ($routes) {

            // CRUD Berita
            $routes->get('berita', 'Berita::index');
            $routes->get('berita/create', 'Berita::create');
            $routes->post('berita/store', 'Berita::store');
            $routes->get('berita/edit/(:num)', 'Berita::edit/$1');
            $routes->post('berita/update/(:num)', 'Berita::update/$1');
            $routes->get('berita/delete/(:num)', 'Berita::delete/$1');

            // CRUD Galeri
            $routes->get('galeri', 'Galeri::index');
            $routes->get('galeri/create', 'Galeri::create');
            $routes->post('galeri/store', 'Galeri::store');
            $routes->get('galeri/edit/(:num)', 'Galeri::edit/$1');
            $routes->post('galeri/update/(:num)', 'Galeri::update/$1');
            $routes->get('galeri/delete/(:num)', 'Galeri::delete/$1');
        });

        // 3. HANYA ADMIN UTAMA (Filter: role:admin)
        $routes->group('', ['filter' => 'role:admin'], static function ($routes) {

            // --- ROUTE PENGATURAN WEB ---
            $routes->get('setting', 'Setting::index');
            $routes->post('setting/update', 'Setting::update');

            $routes->post('setting/toggle-maintenance', 'Setting::toggleMaintenance');

            // --- ROUTE PROFIL SEKOLAH ---
            $routes->get('profil', 'Profil::index');
            $routes->post('profil/update', 'Profil::update');

            $routes->get('hero', 'Setting::hero');
            $routes->post('hero/update', 'Setting::updateHero');

            // CRUD Jurusan
            $routes->get('jurusan', 'Jurusan::index');
            $routes->get('jurusan/create', 'Jurusan::create');
            $routes->post('jurusan/store', 'Jurusan::store');
            $routes->get('jurusan/edit/(:num)', 'Jurusan::edit/$1');
            $routes->post('jurusan/update/(:num)', 'Jurusan::update/$1');
            $routes->get('jurusan/delete/(:num)', 'Jurusan::delete/$1');

            // CRUD Users (Pengguna)
            $routes->get('users', 'Users::index');
            $routes->get('users/create', 'Users::create');
            $routes->post('users/store', 'Users::store');
            $routes->get('users/edit/(:num)', 'Users::edit/$1');
            $routes->post('users/update/(:num)', 'Users::update/$1');
            $routes->get('users/delete/(:num)', 'Users::delete/$1');

            // --- ROUTE MITRA INDUSTRI ---
            $routes->get('mitra', 'Mitra::index');
            $routes->post('mitra/store', 'Mitra::store');
            $routes->post('mitra/update/(:num)', 'Mitra::update/$1'); // Rute Edit Baru
            $routes->get('mitra/delete/(:num)', 'Mitra::delete/$1');

            $routes->get('log', 'LogActivity::index');
        });
    });
});
