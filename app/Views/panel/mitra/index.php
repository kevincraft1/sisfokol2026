<?= $this->extend('panel/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Mitra Industri</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola logo perusahaan yang bekerja sama dengan sekolah.</p>
    </div>
    <button onclick="openModal('modalAdd')" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all flex items-center shadow-sm">
        <i class="fa-solid fa-plus mr-2"></i> Tambah Mitra
    </button>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
    <?php foreach ($mitra as $m) : ?>
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex flex-col items-center group relative hover:border-indigo-300 transition-colors">
            <div class="h-20 w-full flex items-center justify-center mb-3">
                <img src="<?= base_url('uploads/mitra/' . $m['logo']); ?>" alt="<?= $m['nama']; ?>" class="max-h-full max-w-full object-contain grayscale group-hover:grayscale-0 transition-all">
            </div>
            <p class="text-xs font-semibold text-gray-600 text-center truncate w-full"><?= $m['nama']; ?></p>

            <div class="absolute -top-3 -right-3 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                <button onclick="editMitra(<?= $m['id']; ?>, '<?= addslashes($m['nama']); ?>', '<?= addslashes($m['url']); ?>')" class="bg-amber-500 text-white w-8 h-8 rounded-full flex items-center justify-center shadow-lg hover:bg-amber-600">
                    <i class="fa-solid fa-pen text-xs"></i>
                </button>
                <a href="<?= base_url('panel/mitra/delete/' . $m['id']); ?>" onclick="return confirm('Hapus mitra ini?')" class="bg-red-500 text-white w-8 h-8 rounded-full flex items-center justify-center shadow-lg hover:bg-red-600">
                    <i class="fa-solid fa-trash text-xs"></i>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div id="modalAdd" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Tambah Mitra Baru</h3>
            <button type="button" onclick="closeModal('modalAdd')" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-times"></i></button>
        </div>
        <form action="<?= base_url('panel/mitra/store'); ?>" method="post" class="p-6 space-y-4">
            <?= csrf_field(); ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan</label>
                <input type="text" name="nama" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Link Website (Optional)</label>
                <input type="url" name="url" placeholder="https://..." class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Logo (Max 5MB)</label>
                <input type="file" accept="image/*" onchange="compressImage(event, 'logoBase64Add', 'previewAdd')" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <input type="hidden" name="logo_base64" id="logoBase64Add" required>
                <div class="mt-3 h-20 bg-gray-50 rounded border border-dashed flex items-center justify-center p-2 hidden" id="previewContainerAdd">
                    <img id="previewAdd" class="max-h-full max-w-full object-contain">
                </div>
            </div>
            <div class="pt-4 flex gap-3">
                <button type="button" onclick="closeModal('modalAdd')" class="flex-1 px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Simpan WebP</button>
            </div>
        </form>
    </div>
</div>

<div id="modalEdit" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Edit Data Mitra</h3>
            <button type="button" onclick="closeModal('modalEdit')" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-times"></i></button>
        </div>
        <form id="formEdit" method="post" class="p-6 space-y-4">
            <?= csrf_field(); ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan</label>
                <input type="text" name="nama" id="editNama" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Link Website (Optional)</label>
                <input type="url" name="url" id="editUrl" placeholder="https://..." class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Logo (Biarkan kosong jika tidak diubah)</label>
                <input type="file" accept="image/*" onchange="compressImage(event, 'logoBase64Edit', 'previewEdit')" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                <input type="hidden" name="logo_base64" id="logoBase64Edit">
                <div class="mt-3 h-20 bg-gray-50 rounded border border-dashed flex items-center justify-center p-2 hidden" id="previewContainerEdit">
                    <img id="previewEdit" class="max-h-full max-w-full object-contain">
                </div>
            </div>
            <div class="pt-4 flex gap-3">
                <button type="button" onclick="closeModal('modalEdit')" class="flex-1 px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600">Update Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    // Buka modal edit dan isi data lama
    function editMitra(id, nama, url) {
        document.getElementById('formEdit').action = "<?= base_url('panel/mitra/update/'); ?>" + id;
        document.getElementById('editNama').value = nama;
        document.getElementById('editUrl').value = url;

        // Reset preview gambar edit
        document.getElementById('logoBase64Edit').value = '';
        document.getElementById('previewContainerEdit').classList.add('hidden');

        openModal('modalEdit');
    }

    // Engine Kompresi Gambar Client-Side
    function compressImage(event, inputBase64Id, previewImgId) {
        const file = event.target.files[0];
        if (!file) return;

        // 1. Validasi Ukuran File Mentah (Max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'File Terlalu Besar',
                text: 'Ukuran maksimal file sebelum dikompres adalah 5MB!'
            });
            event.target.value = ''; // Reset input
            return;
        }

        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function(e) {
            const img = new Image();
            img.src = e.target.result;

            img.onload = function() {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                // 2. Resize proporsional (Max Width 500px sudah sangat cukup untuk logo)
                const MAX_WIDTH = 500;
                let width = img.width;
                let height = img.height;

                if (width > MAX_WIDTH) {
                    height = Math.round((height * MAX_WIDTH) / width);
                    width = MAX_WIDTH;
                }

                canvas.width = width;
                canvas.height = height;
                ctx.drawImage(img, 0, 0, width, height);

                // 3. Eksekusi Kompresi Paksa ke WebP (Quality 0.7 = Resolusi Bagus, Ukuran Super Kecil < 30KB)
                const compressedBase64 = canvas.toDataURL('image/webp', 0.7);

                // 4. Masukkan hasil Base64 ke input hidden untuk dikirim ke PHP
                document.getElementById(inputBase64Id).value = compressedBase64;

                // 5. Tampilkan Preview
                const previewImg = document.getElementById(previewImgId);
                previewImg.src = compressedBase64;
                previewImg.parentElement.classList.remove('hidden');
            }
        }
    }
</script>
<?= $this->endSection(); ?>