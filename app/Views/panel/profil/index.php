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
    <p class="text-sm text-gray-500 mt-1">Kelola sejarah, visi, misi, dan foto utama sekolah.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
    <form action="<?= base_url('panel/profil/update'); ?>" method="POST" enctype="multipart/form-data">

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Sejarah Singkat / Pengantar</label>
            <textarea name="sejarah" rows="3" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"><?= $profil['sejarah']; ?></textarea>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Visi Sekolah</label>
            <textarea name="visi" rows="2" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"><?= $profil['visi']; ?></textarea>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Misi Sekolah (Gunakan Bullet Points)</label>
            <textarea id="summernote" name="misi" required><?= $profil['misi']; ?></textarea>
        </div>

        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Gedung / Aktivitas Sekolah</label>
            <input type="file" name="gambar" id="imageInput" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 mb-1 focus:outline-none">

            <p id="compressionStatus" class="text-xs text-blue-600 font-medium mb-3"></p>

            <?php if ($profil['gambar']): ?>
                <div class="p-2 border border-gray-200 rounded-lg inline-block bg-gray-50 mt-2">
                    <p class="text-xs font-semibold text-gray-500 mb-2">Foto Saat Ini:</p>
                    <img src="<?= base_url('uploads/profil/' . $profil['gambar']); ?>" class="h-32 object-cover rounded shadow-sm">
                </div>
            <?php else: ?>
                <p class="text-sm text-red-500 italic mt-2">Belum ada foto yang diunggah.</p>
            <?php endif; ?>
        </div>

        <div class="border-t border-gray-100 pt-6">
            <button type="submit" id="btnSubmit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-indigo-700 transition shadow-sm">
                <i class="fa-solid fa-save mr-2"></i> Simpan Profil
            </button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Gunakan fitur Bullet/Numbering untuk menuliskan Misi sekolah...',
            tabsize: 2,
            height: 200,
            toolbar: [
                ['para', ['ul', 'ol', 'paragraph']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['view', ['codeview', 'help']]
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

        // Nonaktifkan tombol simpan selama kompresi
        btnSubmit.disabled = true;
        btnSubmit.classList.add('opacity-50', 'cursor-not-allowed');

        try {
            // Target kompresi maksimal 30 KB
            const compressedFile = await compressImageToWebP(file, 30);

            // Ganti file asli di dalam input form dengan file hasil kompresi WebP
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(compressedFile);
            e.target.files = dataTransfer.files;

            statusText.textContent = `Selesai! Gambar dikompresi menjadi WebP (${(compressedFile.size / 1024).toFixed(2)} KB)`;
            statusText.className = "text-xs font-medium mt-1 text-green-600";
        } catch (error) {
            statusText.textContent = "Gagal mengompresi gambar. Coba gambar lain.";
            statusText.className = "text-xs font-medium mt-1 text-red-600";
            console.error(error);
        } finally {
            // Aktifkan kembali tombol simpan
            btnSubmit.disabled = false;
            btnSubmit.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    });

    function compressImageToWebP(file, maxKB) {
        return new Promise((resolve, reject) => {
            const maxSize = maxKB * 1024; // Konversi KB ke Byte
            const reader = new FileReader();
            reader.readAsDataURL(file);

            reader.onload = (event) => {
                const img = new Image();
                img.src = event.target.result;

                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    let width = img.width;
                    let height = img.height;

                    // Batasi resolusi maksimal lebar 800px agar mudah dikompresi di bawah 30KB
                    const MAX_WIDTH = 800;
                    if (width > MAX_WIDTH) {
                        height = Math.round((height * MAX_WIDTH) / width);
                        width = MAX_WIDTH;
                    }

                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);

                    let quality = 0.9; // Kualitas awal

                    const attemptCompress = () => {
                        canvas.toBlob((blob) => {
                            // Jika ukuran sudah di bawah target, atau kualitas sudah sangat rendah, hentikan kompresi
                            if (blob.size <= maxSize || quality <= 0.1) {
                                // Buat file baru dengan ekstensi .webp
                                const newFileName = file.name.replace(/\.[^/.]+$/, "") + ".webp";
                                resolve(new File([blob], newFileName, {
                                    type: 'image/webp'
                                }));
                            } else {
                                // Turunkan kualitas dan coba lagi
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