<?= $this->extend('panel/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800"><?= $title; ?></h1>
        <p class="text-sm text-gray-500 mt-1">Kelola jenis peran pengguna dan hak akses modul.</p>
    </div>
    <a href="<?= base_url('panel/roles/create'); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
        <i class="fa-solid fa-plus mr-1"></i> Tambah Role
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-gray-50">
                <tr class="border-b border-gray-200 text-gray-600">
                    <th class="py-3 px-6 font-semibold">Nama Role</th>
                    <th class="py-3 px-6 font-semibold">Deskripsi</th>
                    <th class="py-3 px-6 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($roles as $r): ?>
                    <?php $isAdmin = ($r['slug_role'] == 'admin'); ?>
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                        <td class="py-4 px-6 font-bold text-gray-800">
                            <?= $r['nama_role']; ?>
                            <?php if ($isAdmin): ?><span class="ml-2 px-2 py-0.5 bg-red-100 text-red-600 text-xs rounded-full">Sistem</span><?php endif; ?>
                        </td>
                        <td class="py-4 px-6 text-gray-600 whitespace-normal"><?= $r['deskripsi']; ?></td>
                        <td class="py-4 px-6 flex justify-center space-x-2">
                            <a href="<?= base_url('panel/roles/edit/' . $r['slug_role']); ?>" class="px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded hover:bg-indigo-100 transition text-xs font-medium">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>

                            <?php if (!$isAdmin): ?>
                                <form action="<?= base_url('panel/roles/delete/' . $r['slug_role']); ?>" method="post" class="inline" id="form-delete-<?= $r['slug_role']; ?>">
                                    <?= csrf_field() ?>
                                    <button type="button" onclick="confirmDelete('<?= $r['slug_role']; ?>')" class="px-3 py-1.5 rounded transition text-xs font-medium bg-red-50 text-red-600 hover:bg-red-100">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            <?php else: ?>
                                <button type="button" disabled class="px-3 py-1.5 rounded transition text-xs font-medium bg-gray-100 text-gray-400 cursor-not-allowed">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </button>
                            <?php endif; ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(slug) {
        Swal.fire({
            title: 'Hapus Role?',
            text: "Data tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-delete-' + slug).submit();
            }
        });
    }
</script>
<?= $this->endSection(); ?>