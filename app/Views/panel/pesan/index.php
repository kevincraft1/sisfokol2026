<?= $this->extend('panel/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800"><?= $title; ?></h1>
    <p class="text-sm text-gray-500 mt-1">Kelola semua pesan yang dikirim pengunjung lewat halaman Kontak.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-gray-50">
                <tr class="border-b border-gray-200 text-gray-600">
                    <th class="py-3 px-6 font-semibold">Status</th>
                    <th class="py-3 px-6 font-semibold">Pengirim</th>
                    <th class="py-3 px-6 font-semibold">Subjek</th>
                    <th class="py-3 px-6 font-semibold">Tanggal</th>
                    <th class="py-3 px-6 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pesan as $p): ?>
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition <?= $p['is_read'] == 0 ? 'bg-indigo-50/30' : ''; ?>">
                        <td class="py-4 px-6">
                            <?php if ($p['is_read'] == 0): ?>
                                <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full"><i class="fa-solid fa-envelope mr-1"></i> Baru</span>
                            <?php else: ?>
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full"><i class="fa-solid fa-envelope-open mr-1"></i> Dibaca</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 px-6">
                            <p class="font-medium text-gray-800 <?= $p['is_read'] == 0 ? 'font-bold' : ''; ?>"><?= $p['name']; ?></p>
                            <p class="text-xs text-gray-500"><?= $p['email']; ?></p>
                        </td>
                        <td class="py-4 px-6 text-gray-700 <?= $p['is_read'] == 0 ? 'font-bold' : ''; ?>">
                            <?= $p['subject']; ?>
                        </td>
                        <td class="py-4 px-6 text-gray-500 text-xs">
                            <?= date('d M Y, H:i', strtotime($p['created_at'])); ?>
                        </td>
                        <td class="py-4 px-6 flex justify-center space-x-2">
                            <a href="<?= base_url('panel/pesan/baca/' . $p['id']); ?>" class="px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded hover:bg-indigo-200 transition text-xs font-medium">
                                Baca Pesan
                            </a>
                            <button type="button" onclick="confirmDelete('<?= base_url('panel/pesan/delete/' . $p['id']); ?>')" class="px-3 py-1.5 bg-red-100 text-red-700 rounded hover:bg-red-200 transition text-xs font-medium">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($pesan)): ?>
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500">Belum ada pesan masuk di kotak masuk Anda.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(deleteUrl) {
        Swal.fire({
            title: 'Hapus Pesan?',
            text: "Pesan ini akan dihapus permanen!",
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