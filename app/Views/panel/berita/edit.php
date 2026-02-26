<?= $this->extend('panel/layout/template'); ?>

<?= $this->section('content'); ?>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .note-editor.note-frame {
        border-color: #d1d5db;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .note-toolbar {
        background-color: #f9fafb;
        border-bottom: 1px border #d1d5db;
    }
</style>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800"><?= $title; ?></h1>
    <a href="<?= base_url('panel/berita'); ?>" class="text-indigo-600 hover:underline text-sm"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke daftar berita</a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
    <form action="<?= base_url('panel/berita/update/' . $berita['id']); ?>" method="POST" enctype="multipart/form-data">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Berita</label>
                <input type="text" name="title" required value="<?= $berita['title']; ?>" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="category" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="Akademik" <?= $berita['category'] == 'Akademik' ? 'selected' : ''; ?>>Akademik</option>
                    <option value="Prestasi" <?= $berita['category'] == 'Prestasi' ? 'selected' : ''; ?>>Prestasi</option>
                    <option value="Kegiatan" <?= $berita['category'] == 'Kegiatan' ? 'selected' : ''; ?>>Kegiatan</option>
                    <option value="Pengumuman" <?= $berita['category'] == 'Pengumuman' ? 'selected' : ''; ?>>Pengumuman</option>
                </select>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Foto Sampul Baru (Opsional)</label>
            <input type="file" name="image" id="imageInput" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none">
            <p id="compressionStatus" class="text-xs text-blue-600 font-medium mt-1"></p>
            <p class="text-xs text-gray-500 mt-1 mb-2">Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG. Gambar akan otomatis dikompresi ke WebP.</p>

            <?php if ($berita['image']): ?>
                <div class="mt-2 p-2 border border-gray-200 rounded-lg inline-block bg-gray-50">
                    <p class="text-xs font-semibold text-gray-500 mb-1">Foto Saat Ini:</p>
                    <img src="<?= base_url('uploads/berita/' . $berita['image']); ?>" class="h-24 object-cover rounded">
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Isi Berita</label>
            <textarea id="summernote" name="content" required><?= $berita['content']; ?></textarea>
        </div>

        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-1">Status Publikasi</label>
            <div class="flex items-center space-x-4 mt-2">
                <label class="inline-flex items-center">
                    <input type="radio" name="status" value="published" <?= $berita['status'] == 'published' ? 'checked' : ''; ?> class="text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                    <span class="ml-2 text-gray-700 text-sm">Published</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="status" value="draft" <?= $berita['status'] == 'draft' ? 'checked' : ''; ?> class="text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                    <span class="ml-2 text-gray-700 text-sm">Draft</span>
                </label>
            </div>
        </div>

        <div class="border-t border-gray-100 pt-6 flex justify-end">
            <button type="submit" id="btnSubmit" class="bg-indigo-600 text-white px-8 py-2.5 rounded-lg font-medium hover:bg-indigo-700 transition shadow-sm">
                <i class="fa-solid fa-save mr-2"></i> Update Berita
            </button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Ketikkan isi berita selengkapnya di sini...',
            tabsize: 2,
            height: 400,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });

    document.getElementById('imageInput').addEventListener('change', async function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const statusText = document.getElementById('compressionStatus');
        const btnSubmit = document.getElementById('btnSubmit');

        statusText.textContent = "Sedang mengompresi gambar...";
        statusText.className = "text-xs font-medium mt-1 text-orange-500";
        btnSubmit.disabled = true;
        btnSubmit.classList.add('opacity-50');

        try {
            const compressedFile = await compressImageToWebP(file, 40);
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(compressedFile);
            e.target.files = dataTransfer.files;

            const finalSize = (compressedFile.size / 1024).toFixed(2);
            statusText.textContent = `Selesai! Gambar dikompresi menjadi WebP (${finalSize} KB)`;
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
            const reader = new window.FileReader();
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
                            if (blob.size <= maxSize || quality <= 0.1) {
                                resolve(new File([blob], file.name.replace(/\.[^/.]+$/, "") + ".webp", {
                                    type: 'image/webp'
                                }));
                            } else {
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