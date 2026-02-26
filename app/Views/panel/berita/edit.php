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
            <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none">
            <p class="text-xs text-gray-500 mt-1 mb-2">Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG. Maksimal 2MB.</p>

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
            <button type="submit" class="bg-indigo-600 text-white px-8 py-2.5 rounded-lg font-medium hover:bg-indigo-700 transition shadow-sm">
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
</script>
<?= $this->endSection(); ?>