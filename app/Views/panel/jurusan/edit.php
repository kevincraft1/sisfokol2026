<?= $this->extend('panel/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800"><?= $title; ?></h1>
    <a href="<?= base_url('panel/jurusan'); ?>" class="text-indigo-600 hover:underline text-sm"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke daftar</a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-3xl">
    <form action="<?= base_url('panel/jurusan/update/' . $jurusan['id']); ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Jurusan</label>
                <input type="text" name="name" value="<?= $jurusan['name']; ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ikon (Emoji / Teks)</label>
                <input type="text" name="icon" value="<?= $jurusan['icon']; ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
            <textarea name="description" rows="3" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"><?= $jurusan['description']; ?></textarea>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Gambar (Opsional)</label>
            <input type="file" name="image" id="imageInput" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
            <p id="compressionStatus" class="text-xs text-blue-600 font-medium mt-1"></p>
            <?php if ($jurusan['image']): ?>
                <div class="mt-3">
                    <p class="text-xs text-gray-500 mb-1">Gambar saat ini:</p>
                    <img src="<?= base_url('uploads/jurusan/' . $jurusan['image']); ?>" class="w-32 rounded-lg border shadow-sm">
                </div>
            <?php endif; ?>
        </div>

        <button type="submit" id="btnSubmit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-indigo-700 transition">
            Update Jurusan
        </button>
    </form>
</div>

<script>
    document.getElementById('imageInput').addEventListener('change', async function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const statusText = document.getElementById('compressionStatus');
        const btnSubmit = document.getElementById('btnSubmit');
        statusText.textContent = "Sedang mengompresi...";
        statusText.className = "text-xs font-medium mt-1 text-orange-500";
        btnSubmit.disabled = true;
        btnSubmit.classList.add('opacity-50');
        try {
            const compressedFile = await compressImageToWebP(file, 30);
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(compressedFile);
            e.target.files = dataTransfer.files;
            statusText.textContent = `Selesai! WebP (${(compressedFile.size / 1024).toFixed(2)} KB)`;
            statusText.className = "text-xs font-medium mt-1 text-green-600";
        } catch (error) {
            statusText.textContent = "Gagal mengompresi gambar.";
            statusText.className = "text-xs font-medium mt-1 text-red-600";
        } finally {
            btnSubmit.disabled = false;
            btnSubmit.classList.remove('opacity-50');
        }
    });

    function compressImageToWebP(file, maxKB) {
        return new Promise((resolve, reject) => {
            const maxSize = maxKB * 1024;
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = (event) => {
                const img = new Image();
                img.src = event.target.result;
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    let width = img.width;
                    let height = img.height;
                    const MAX_WIDTH = 800;
                    if (width > MAX_WIDTH) {
                        height = Math.round((height * MAX_WIDTH) / width);
                        width = MAX_WIDTH;
                    }
                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);
                    let quality = 0.9;
                    const attemptCompress = () => {
                        canvas.toBlob((blob) => {
                            if (blob.size <= maxSize || quality <= 0.1) resolve(new File([blob], file.name.replace(/\.[^/.]+$/, "") + ".webp", {
                                type: 'image/webp'
                            }));
                            else {
                                quality -= 0.1;
                                attemptCompress();
                            }
                        }, 'image/webp', quality);
                    };
                    attemptCompress();
                };
                img.onerror = reject;
            };
            reader.onerror = reject;
        });
    }
</script>
<?= $this->endSection(); ?>