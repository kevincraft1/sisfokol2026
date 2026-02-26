<?= $this->extend('panel/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800"><?= $title; ?></h1>
        <p class="text-sm text-gray-500 mt-1">Kelola program keahlian yang ada di sekolah.</p>
    </div>
    <a href="<?= base_url('panel/jurusan/create'); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
        <i class="fa-solid fa-plus mr-1"></i> Tambah Jurusan
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 overflow-x-auto">
    <table class="w-full text-left text-sm whitespace-nowrap">
        <thead>
            <tr class="border-b border-gray-100 text-gray-500">
                <th class="py-3 px-4 font-semibold">No</th>
                <th class="py-3 px-4 font-semibold">Ikon</th>
                <th class="py-3 px-4 font-semibold">Nama Jurusan</th>
                <th class="py-3 px-4 font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($jurusan as $j): ?>
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="py-3 px-4 text-gray-600"><?= $no++; ?></td>
                    <td class="py-3 px-4">
                        <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center text-xl">
                            <?= $j['icon']; ?>
                        </div>
                    </td>
                    <td class="py-3 px-4 font-medium text-gray-800">
                        <?= $j['name']; ?><br>
                        <span class="text-xs text-gray-500 font-normal"><?= character_limiter($j['description'], 50); ?></span>
                    </td>
                    <td class="py-3 px-4 flex space-x-3 items-center mt-2">
                        <a href="<?= base_url('panel/jurusan/edit/' . $j['id']); ?>" class="text-blue-500 hover:text-blue-700 transition" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                        <button type="button" onclick="confirmDelete('<?= base_url('panel/jurusan/delete/' . $j['id']); ?>')" class="text-red-500 hover:text-red-700 transition" title="Hapus">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>

            <?php if (empty($jurusan)): ?>
                <tr>
                    <td colspan="4" class="py-6 text-center text-gray-500">Belum ada data jurusan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    function confirmDelete(deleteUrl) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data jurusan ini akan dihapus permanen!",
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