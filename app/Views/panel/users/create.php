<?= $this->extend('panel/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800"><?= $title; ?></h1>
    <a href="<?= base_url('panel/users'); ?>" class="text-indigo-600 hover:underline text-sm"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke daftar</a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl">
    <form action="<?= base_url('panel/users/store'); ?>" method="POST">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" required value="<?= old('nama_lengkap'); ?>" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" name="username" required value="<?= old('username'); ?>" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Aktif</label>
                <input type="email" name="email" required value="<?= old('email'); ?>" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hak Akses (Role)</label>
                <select name="role" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="guru">Guru (Hanya nulis berita & galeri)</option>
                    <option value="kepsek">Kepsek (Hanya memantau/Viewer)</option>
                    <option value="admin">Admin Utama (Akses penuh)</option>
                </select>
            </div>
        </div>

        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" required minlength="6" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="Minimal 6 karakter">
        </div>

        <div class="border-t border-gray-100 pt-6">
            <button type="submit" class="bg-indigo-600 text-white px-8 py-2.5 rounded-lg font-medium hover:bg-indigo-700 transition shadow-sm">
                Simpan Pengguna
            </button>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>