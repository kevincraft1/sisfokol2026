<?= $this->extend('panel/layout/template'); ?>

<?= $this->section('content'); ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg shadow-sm">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fa-solid fa-circle-exclamation text-red-500"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700 font-medium">
                    <?= session()->getFlashdata('error') ?>
                </p>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg shadow-sm">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fa-solid fa-circle-check text-green-500"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700 font-medium">
                    <?= session()->getFlashdata('pesan') ?>
                </p>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800"><?= $title; ?></h1>
        <p class="text-sm text-gray-500 mt-1">Kelola foto karya siswa, kegiatan, dan fasilitas sekolah.</p>
    </div>

    <div class="flex space-x-2">
        <a href="<?= base_url('panel/galeri/trash'); ?>" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition">
            <i class="fa-solid fa-trash-can mr-1 text-red-500"></i> Tong Sampah
        </a>
        <a href="<?= base_url('panel/galeri/create'); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
            <i class="fa-solid fa-plus mr-1"></i> Tambah Foto
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 overflow-x-auto">
    <table class="w-full text-left text-sm whitespace-nowrap">
        <thead>
            <tr class="border-b border-gray-100 text-gray-500">
                <th class="py-3 px-4 font-semibold">No</th>
                <th class="py-3 px-4 font-semibold">Foto</th>
                <th class="py-3 px-4 font-semibold">Judul Foto</th>
                <th class="py-3 px-4 font-semibold">Kategori</th>
                <th class="py-3 px-4 font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($galeri as $g): ?>
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="py-3 px-4 text-gray-600"><?= $no++; ?></td>
                    <td class="py-3 px-4">
                        <?php if ($g['image']): ?>
                            <img src="<?= base_url('uploads/galeri/' . $g['image']); ?>" alt="Galeri" class="w-16 h-12 object-cover rounded-lg border border-gray-200 shadow-sm">
                        <?php else: ?>
                            <div class="w-16 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                <i class="fa-solid fa-image"></i>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="py-3 px-4 font-medium text-gray-800">
                        <?= $g['title']; ?><br>
                        <span class="text-xs text-gray-500 font-normal"><?= $g['description']; ?></span>
                    </td>
                    <td class="py-3 px-4 text-gray-600 capitalize">
                        <span class="px-2 py-1 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-full border border-indigo-100"><?= $g['type']; ?></span>
                    </td>
                    <td class="py-3 px-4 flex space-x-3 items-center mt-2">
                        <a href="<?= base_url('panel/galeri/edit/' . $g['id']); ?>" class="text-blue-500 hover:text-blue-700 transition" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>

                        <form action="<?= base_url('panel/galeri/delete/' . $g['id']); ?>" method="post" class="inline" id="form-delete-<?= $g['id']; ?>">
                            <?= csrf_field() ?>
                            <button type="button" onclick="confirmDelete(<?= $g['id']; ?>)" class="text-red-500 hover:text-red-700 transition" title="Hapus">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>

            <?php if (empty($galeri)): ?>
                <tr>
                    <td colspan="5" class="py-6 text-center text-gray-500">Belum ada data galeri.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Pindahkan ke Tong Sampah?',
            text: "Foto galeri ini akan dipindahkan ke Tong Sampah dan otomatis terhapus permanen setelah 30 hari.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fa-solid fa-trash-arrow-up mr-1"></i> Ya, Pindahkan!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-delete-' + id).submit();
            }
        });
    }
</script>
<?= $this->endSection(); ?>