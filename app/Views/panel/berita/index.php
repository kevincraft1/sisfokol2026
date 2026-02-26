<?= $this->extend('panel/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800"><?= $title; ?></h1>
        <p class="text-sm text-gray-500 mt-1">Kelola semua artikel dan berita sekolah di sini.</p>
    </div>
    <a href="<?= base_url('panel/berita/create'); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
        <i class="fa-solid fa-plus mr-1"></i> Tambah Berita
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 overflow-x-auto">
    <table class="w-full text-left text-sm whitespace-nowrap">
        <thead>
            <tr class="border-b border-gray-100 text-gray-500">
                <th class="py-3 px-4 font-semibold">No</th>
                <th class="py-3 px-4 font-semibold">Thumbnail</th>
                <th class="py-3 px-4 font-semibold">Judul Berita</th>
                <th class="py-3 px-4 font-semibold">Kategori</th>
                <th class="py-3 px-4 font-semibold">Status</th>
                <th class="py-3 px-4 font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($berita as $b): ?>
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="py-3 px-4 text-gray-600"><?= $no++; ?></td>
                    <td class="py-3 px-4">
                        <?php if ($b['image']): ?>
                            <img src="<?= base_url('uploads/berita/' . $b['image']); ?>" alt="Thumbnail" class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                        <?php else: ?>
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                <i class="fa-solid fa-image"></i>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="py-3 px-4 font-medium text-gray-800"><?= $b['title']; ?></td>
                    <td class="py-3 px-4 text-gray-600"><?= $b['category']; ?></td>
                    <td class="py-3 px-4">
                        <?php if ($b['status'] == 'published'): ?>
                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Dipublikasi</span>
                        <?php else: ?>
                            <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-full">Draft</span>
                        <?php endif; ?>
                    </td>
                    <td class="py-3 px-4 flex space-x-3 items-center mt-2">
                        <a href="<?= base_url('panel/berita/edit/' . $b['id']); ?>" class="text-blue-500 hover:text-blue-700 transition" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>

                        <button type="button" onclick="confirmDelete('<?= base_url('panel/berita/delete/' . $b['id']); ?>')" class="text-red-500 hover:text-red-700 transition" title="Hapus">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>

            <?php if (empty($berita)): ?>
                <tr>
                    <td colspan="6" class="py-6 text-center text-gray-500">Belum ada data berita. Mulai tambahkan berita pertama Anda!</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    function confirmDelete(deleteUrl) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data berita ini akan dihapus permanen!",
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