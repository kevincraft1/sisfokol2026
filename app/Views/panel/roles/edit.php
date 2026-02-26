<?= $this->extend('panel/layout/template'); ?>
<?= $this->section('content'); ?>
<?php $isAdmin = ($role['slug_role'] == 'admin'); ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800"><?= $title; ?></h1>
    <a href="<?= base_url('panel/roles'); ?>" class="text-indigo-600 hover:underline text-sm"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke daftar</a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-4xl">
    <form action="<?= base_url('panel/roles/update/' . $role['slug_role']); ?>" method="POST">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Role</label>
                <input type="text" name="nama_role" required value="<?= $role['nama_role']; ?>" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" <?= $isAdmin ? 'readonly class="bg-gray-100"' : ''; ?>>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                <input type="text" name="deskripsi" required value="<?= $role['deskripsi']; ?>" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
        </div>

        <div class="mb-8 border-t border-gray-100 pt-6">
            <h3 class="text-lg font-bold text-indigo-700 mb-2">Hak Akses Modul</h3>
            <?php if ($isAdmin): ?>
                <p class="text-xs text-red-500 mb-4 bg-red-50 p-2 rounded border border-red-200"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Peringatan: Akses untuk Administrator Utama tidak dapat dicabut (Selalu Full Access).</p>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                <?php foreach ($modules as $key => $label): ?>
                    <label class="flex items-center space-x-3 p-3 border <?= in_array($key, $checked) ? 'border-indigo-300 bg-indigo-50' : 'border-gray-200'; ?> rounded-lg hover:bg-indigo-50 cursor-pointer transition">
                        <input type="checkbox" name="permissions[]" value="<?= $key; ?>" <?= in_array($key, $checked) ? 'checked' : ''; ?> <?= $isAdmin ? 'disabled checked' : ''; ?> class="w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500">
                        <span class="text-sm font-medium text-gray-700"><?= $label; ?></span>
                        <?php if ($isAdmin): ?><input type="hidden" name="permissions[]" value="<?= $key; ?>"><?php endif; ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-8 py-2.5 rounded-lg font-medium hover:bg-indigo-700 transition">Update Role</button>
    </form>
</div>
<?= $this->endSection(); ?>