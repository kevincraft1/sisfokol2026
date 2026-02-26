<?= $this->extend('panel/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800"><?= $title; ?></h1>
    <p class="text-sm text-gray-500 mt-1">Kelola informasi pribadi dan keamanan akun Anda.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center text-center h-fit">
        <div class="w-24 h-24 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-4xl font-bold mb-4 shadow-inner">
            <?= strtoupper(substr($user['nama_lengkap'], 0, 1)); ?>
        </div>
        <h3 class="text-lg font-bold text-gray-800"><?= $user['nama_lengkap']; ?></h3>
        <p class="text-sm text-gray-500 mb-2"><?= $user['email']; ?></p>
        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-semibold capitalize mt-2">
            Role: <?= $user['role']; ?>
        </span>
    </div>

    <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="<?= base_url('panel/my-profile/update'); ?>" method="POST">

            <h4 class="text-md font-bold text-indigo-700 mb-4 border-b pb-2"><i class="fa-solid fa-address-card mr-2"></i> Informasi Dasar</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="<?= $user['nama_lengkap']; ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" value="<?= $user['email']; ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-medium text-gray-700 mb-2">Username (Tidak bisa diubah)</label>
                <input type="text" value="<?= $user['username']; ?>" disabled class="w-full px-4 py-2 border border-gray-200 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed">
            </div>

            <h4 class="text-md font-bold text-indigo-700 mb-4 border-b pb-2"><i class="fa-solid fa-lock mr-2"></i> Ganti Password</h4>
            <p class="text-xs text-gray-500 mb-4 bg-yellow-50 p-3 rounded border border-yellow-100"><i class="fa-solid fa-circle-info mr-1 text-yellow-500"></i> Biarkan kedua kolom di bawah ini kosong jika Anda tidak ingin mengubah password saat ini.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                    <input type="password" name="password_baru" placeholder="Ketik password baru..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_konfirmasi" placeholder="Ulangi password baru..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
            </div>

            <div class="border-t border-gray-100 pt-6 flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-8 py-2.5 rounded-lg font-bold hover:bg-indigo-700 transition shadow-sm">
                    <i class="fa-solid fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

</div>
<?= $this->endSection(); ?>