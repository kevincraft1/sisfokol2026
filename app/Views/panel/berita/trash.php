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
        <h1 class="text-2xl font-bold text-gray-800"><i class="fa-solid fa-trash-can mr-2 text-red-500"></i><?= $title; ?></h1>
        <p class="text-sm text-red-500 mt-1 font-medium">Perhatian: Item di Tong Sampah akan dihapus permanen secara otomatis setelah 30 hari.</p>
    </div>
    <a href="<?= base_url('panel/berita'); ?>" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition border border-gray-300">
        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Berita
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 overflow-x-auto">
    <table class="w-full text-left text-sm whitespace-nowrap">
        <thead>
            <tr class="border-b border-gray-100 text-gray-500">
                <th class="py-3 px-4 font-semibold">No</th>
                <th class="py-3 px-4 font-semibold">Thumbnail</th>
                <th class="py-3 px-4 font-semibold">Judul Berita</th>
                <th class="py-3 px-4 font-semibold">Waktu Dihapus</th>
                <th class="py-3 px-4 font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($berita as $b): ?>
                <tr class="border-b border-gray-50 hover:bg-red-50 transition">
                    <td class="py-3 px-4 text-gray-600"><?= $no++; ?></td>
                    <td class="py-3 px-4">
                        <?php if ($b['image']): ?>
                            <img src="<?= base_url('uploads/berita/' . $b['image']); ?>" alt="Thumbnail" class="w-12 h-12 object-cover rounded-lg border border-gray-200 grayscale opacity-70">
                        <?php else: ?>
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                <i class="fa-solid fa-image"></i>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="py-3 px-4 font-medium text-gray-800 line-through decoration-gray-400"><?= $b['title']; ?></td>
                    <td class="py-3 px-4 text-red-600 font-medium">
                        <?= date('d M Y H:i', strtotime($b['deleted_at'])); ?>
                    </td>
                    <td class="py-3 px-4 flex space-x-3 items-center mt-2">
                        <a href="<?= base_url('panel/berita/restore/' . $b['id']); ?>" class="text-green-600 hover:text-green-800 transition font-medium" title="Pulihkan Data">
                            <i class="fa-solid fa-recycle"></i> Restore
                        </a>

                        <button type="button" onclick="confirmPurge('<?= base_url('panel/berita/purge/' . $b['id']); ?>')" class="text-red-600 hover:text-red-800 transition font-medium ml-3" title="Hapus Selamanya">
                            <i class="fa-solid fa-fire"></i> Hapus Permanen
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>

            <?php if (empty($berita)): ?>
                <tr>
                    <td colspan="5" class="py-8 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fa-solid fa-box-open text-4xl mb-3 text-gray-300"></i>
                            <p>Tong sampah kosong. Tidak ada berita yang dihapus.</p>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    function confirmPurge(deleteUrl) {
        Swal.fire({
            title: 'Hapus Permanen?',
            text: "Tindakan ini tidak dapat dibatalkan! File gambar fisik juga akan dihapus dari server.",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#dc2626', // Merah gelap
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fa-solid fa-triangle-exclamation mr-1"></i> Ya, Musnahkan!',
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