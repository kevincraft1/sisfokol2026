<?= $this->extend('panel/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800"><?= $title; ?></h1>
        <p class="text-sm text-gray-500 mt-1">Kelola akun dan hak akses pengguna sistem.</p>
    </div>
    <a href="<?= base_url('panel/users/create'); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
        <i class="fa-solid fa-plus mr-1"></i> Tambah Pengguna
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-gray-50">
                <tr class="border-b border-gray-200 text-gray-600">
                    <th class="py-3 px-6 font-semibold">No</th>
                    <th class="py-3 px-6 font-semibold">Pengguna</th>
                    <th class="py-3 px-6 font-semibold">Username</th>
                    <th class="py-3 px-6 font-semibold">Hak Akses (Role)</th>
                    <th class="py-3 px-6 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($users as $u): ?>
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                        <td class="py-4 px-6 text-gray-600"><?= $no++; ?></td>
                        <td class="py-4 px-6 flex items-center space-x-3">
                            <img src="https://ui-avatars.com/api/?name=<?= $u['nama_lengkap']; ?>&background=random&color=fff" class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-bold text-gray-800"><?= $u['nama_lengkap']; ?></p>
                                <p class="text-xs text-gray-500"><?= $u['email']; ?></p>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-gray-600">@<?= $u['username']; ?></td>
                        <td class="py-4 px-6 capitalize">
                            <?php if ($u['role'] == 'admin'): ?>
                                <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">Admin</span>
                            <?php elseif ($u['role'] == 'kepsek'): ?>
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">Kepsek</span>
                            <?php else: ?>
                                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Guru</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 px-6 flex justify-center space-x-2">
                            <a href="<?= base_url('panel/users/edit/' . $u['id']); ?>" class="px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded hover:bg-indigo-100 transition text-xs font-medium">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            <button type="button" onclick="confirmDelete('<?= base_url('panel/users/delete/' . $u['id']); ?>')" class="px-3 py-1.5 bg-red-50 text-red-600 rounded hover:bg-red-100 transition text-xs font-medium <?= $u['id'] == session()->get('id') ? 'opacity-50 cursor-not-allowed' : ''; ?>" <?= $u['id'] == session()->get('id') ? 'disabled' : ''; ?>>
                                <i class="fa-solid fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(deleteUrl) {
        Swal.fire({
            title: 'Hapus Pengguna?',
            text: "Data pengguna ini tidak bisa dikembalikan!",
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