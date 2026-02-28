<?= $this->extend('panel/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="mb-6">
    <div class="flex items-center space-x-3">
        <a href="<?= base_url('panel/pesan'); ?>" class="text-gray-400 hover:text-indigo-600 transition text-xl"><i class="fa-solid fa-arrow-left"></i></a>
        <h1 class="text-2xl font-bold text-gray-800">Detail Pesan</h1>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-4xl">
    <div class="flex justify-between items-start border-b border-gray-100 pb-6 mb-6">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-xl font-bold uppercase">
                <?= substr($pesan['name'], 0, 1); ?>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-lg"><?= $pesan['name']; ?></h3>
                <a href="mailto:<?= $pesan['email']; ?>" class="text-sm text-indigo-600 hover:underline"><?= $pesan['email']; ?></a>
            </div>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500"><i class="fa-regular fa-clock mr-1"></i> <?= date('d F Y, H:i', strtotime($pesan['created_at'])); ?></p>
        </div>
    </div>

    <div class="mb-8">
        <h4 class="font-bold text-gray-800 mb-4">Subjek: <?= $pesan['subject']; ?></h4>
        <div class="text-gray-700 bg-gray-50 p-6 rounded-lg leading-relaxed whitespace-pre-wrap border border-gray-100">
            <?= $pesan['message']; ?>
        </div>
    </div>

    <div class="flex space-x-3 pt-4 border-t border-gray-100">
        <a href="mailto:<?= $pesan['email']; ?>?subject=Balasan: <?= $pesan['subject']; ?>" class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-indigo-700 transition flex items-center shadow-sm">
            <i class="fa-solid fa-reply mr-2"></i> Balas via Email
        </a>

        <form action="<?= base_url('panel/pesan/delete/' . $pesan['id']); ?>" method="post" id="form-delete-<?= $pesan['id']; ?>" class="inline">
            <?= csrf_field() ?>
            <button type="button" onclick="confirmDelete(<?= $pesan['id']; ?>)" class="bg-red-50 text-red-600 px-6 py-2.5 rounded-lg font-medium hover:bg-red-100 transition flex items-center border border-red-100">
                <i class="fa-solid fa-trash mr-2"></i> Hapus Pesan
            </button>
        </form>
    </div>
</div>

<script>
    function confirmDelete(id) {
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
                document.getElementById('form-delete-' + id).submit();
            }
        });
    }
</script>
<?= $this->endSection(); ?>