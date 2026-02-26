<?= $this->extend('panel/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800"><?= $title; ?></h1>
        <p class="text-sm text-gray-500 mt-1">Kelola foto karya siswa, kegiatan, dan fasilitas sekolah.</p>
    </div>
    <a href="<?= base_url('panel/galeri/create'); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
        <i class="fa-solid fa-plus mr-1"></i> Tambah Foto
    </a>
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
                        <button type="button" onclick="confirmDelete('<?= base_url('panel/galeri/delete/' . $g['id']); ?>')" class="text-red-500 hover:text-red-700 transition" title="Hapus">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
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
    function confirmDelete(deleteUrl) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Foto ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = deleteUrl;
            }
        });
    }
</script>
<?= $this->endSection(); ?>