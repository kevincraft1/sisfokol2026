<?= $this->extend('panel/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800"><?= $title; ?></h1>
        <p class="text-sm text-gray-500 mt-1">Pantau statistik dan pembaruan terkini dari website Anda.</p>
    </div>
    <div class="mt-4 md:mt-0 flex space-x-2">
        <button class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition shadow-sm">
            <i class="fa-solid fa-download mr-1"></i> Download Laporan
        </button>
        <a href="<?= base_url('panel/berita/create'); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition shadow-sm shadow-indigo-200">
            <i class="fa-solid fa-plus mr-1"></i> Buat Berita
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-md transition-shadow">
        <div class="p-4 bg-blue-50 text-blue-600 rounded-lg">
            <i class="fa-solid fa-newspaper text-2xl"></i>
        </div>
        <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Total Berita</p>
            <h3 class="text-2xl font-bold text-gray-800"><?= $totalBerita; ?></h3>
            <p class="text-xs text-green-500 flex items-center mt-1">
                <i class="fa-solid fa-arrow-trend-up mr-1"></i> +<?= $beritaBulanIni; ?> bulan ini
            </p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-md transition-shadow">
        <div class="p-4 bg-purple-50 text-purple-600 rounded-lg">
            <i class="fa-solid fa-images text-2xl"></i>
        </div>
        <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Data Galeri</p>
            <h3 class="text-2xl font-bold text-gray-800"><?= $totalGaleri; ?></h3>
            <p class="text-xs text-green-500 flex items-center mt-1">
                <i class="fa-solid fa-arrow-trend-up mr-1"></i> +<?= $galeriBulanIni; ?> bulan ini
            </p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-md transition-shadow">
        <div class="p-4 bg-teal-50 text-teal-600 rounded-lg">
            <i class="fa-solid fa-users text-2xl"></i>
        </div>
        <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Total Users</p>
            <h3 class="text-2xl font-bold text-gray-800"><?= $totalUsers; ?></h3>
            <p class="text-xs text-green-500 flex items-center mt-1">
                <i class="fa-solid fa-user-plus mr-1"></i> +<?= $userBulanIni; ?> pengguna baru
            </p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-md transition-shadow">
        <div class="p-4 bg-red-50 text-red-600 rounded-lg">
            <i class="fa-regular fa-envelope text-2xl"></i>
        </div>
        <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Inbox Masuk</p>
            <h3 class="text-2xl font-bold text-gray-800"><?= $totalPesan; ?></h3>
            <p class="text-xs text-red-500 flex items-center mt-1">
                <i class="fa-solid fa-circle-exclamation mr-1"></i> <?= $pesanBelumBaca; ?> belum dibaca
            </p>
        </div>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-800">Pesan Masuk Terbaru</h2>
            <a href="<?= base_url('panel/pesan'); ?>" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-gray-100 text-gray-500">
                        <th class="py-3 font-semibold">Nama Pengirim</th>
                        <th class="py-3 font-semibold">Subjek</th>
                        <th class="py-3 font-semibold">Status</th>
                        <th class="py-3 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pesanTerbaru as $p): ?>
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                            <td class="py-3 font-medium text-gray-800"><?= $p['name']; ?></td>
                            <td class="py-3 text-gray-600"><?= character_limiter($p['subject'], 30); ?></td>
                            <td class="py-3">
                                <?php if ($p['is_read'] == 0): ?>
                                    <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">Baru</span>
                                <?php else: ?>
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full">Dibaca</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 flex space-x-2">
                                <a href="<?= base_url('panel/pesan/baca/' . $p['id']); ?>" class="text-indigo-600 hover:text-indigo-800 font-medium">Buka</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($pesanTerbaru)): ?>
                        <tr>
                            <td colspan="4" class="py-6 text-center text-gray-500">Tidak ada pesan terbaru.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Akses Cepat</h2>
        <div class="space-y-3">
            <a href="<?= base_url('panel/berita/create'); ?>" class="w-full flex items-center justify-between p-3 border border-gray-100 rounded-lg hover:border-indigo-300 hover:bg-indigo-50 transition group text-left">
                <div class="flex items-center text-gray-700 group-hover:text-indigo-700">
                    <i class="fa-solid fa-pen-to-square mr-3 text-indigo-500"></i> Buat Berita Baru
                </div>
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs group-hover:text-indigo-500"></i>
            </a>
            <a href="<?= base_url('panel/galeri/create'); ?>" class="w-full flex items-center justify-between p-3 border border-gray-100 rounded-lg hover:border-indigo-300 hover:bg-indigo-50 transition group text-left">
                <div class="flex items-center text-gray-700 group-hover:text-indigo-700">
                    <i class="fa-solid fa-image mr-3 text-purple-500"></i> Tambah Foto Galeri
                </div>
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs group-hover:text-indigo-500"></i>
            </a>
            <a href="#" class="w-full flex items-center justify-between p-3 border border-gray-100 rounded-lg hover:border-indigo-300 hover:bg-indigo-50 transition group text-left">
                <div class="flex items-center text-gray-700 group-hover:text-indigo-700">
                    <i class="fa-solid fa-user-plus mr-3 text-teal-500"></i> Tambah Pengguna Baru
                </div>
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs group-hover:text-indigo-500"></i>
            </a>
        </div>
    </div>

</div>
<?= $this->endSection(); ?>