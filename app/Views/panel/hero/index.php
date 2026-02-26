<?= $this->extend('panel/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Pengaturan Hero Section</h2>
    <p class="text-sm text-gray-500 mt-1">Sesuaikan teks headline dan gambar latar belakang utama di halaman depan website.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full blur-xl opacity-50 pointer-events-none"></div>

    <form action="<?= base_url('panel/hero/update'); ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-8">

            <div class="md:col-span-3 space-y-6">
                <div>
                    <label for="hero_title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Judul Utama (Headline) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="hero_title" name="hero_title" value="<?= old('hero_title', $setting['hero_title'] ?? ''); ?>" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-gray-800 font-medium"
                        placeholder="Cth: Selamat Datang di SMK Kreatif Nusantara">
                    <p class="text-xs text-gray-500 mt-1.5"><i class="fa-solid fa-circle-info mr-1"></i> Tampil paling besar di tengah gambar banner.</p>
                </div>

                <div>
                    <label for="hero_desc" class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi Singkat (Sub-headline) <span class="text-red-500">*</span>
                    </label>
                    <textarea id="hero_desc" name="hero_desc" rows="4" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-gray-800 leading-relaxed"
                        placeholder="Cth: Mewujudkan generasi unggul, berakhlak mulia, cerdas, dan siap kerja di era industri digital."><?= old('hero_desc', $setting['hero_desc'] ?? ''); ?></textarea>
                    <p class="text-xs text-gray-500 mt-1.5"><i class="fa-solid fa-circle-info mr-1"></i> Disarankan 2-3 kalimat agar proporsi desain tetap rapi.</p>
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Gambar Background (Banner)
                </label>

                <div class="bg-gray-50 border border-gray-200 rounded-xl p-3">
                    <div class="aspect-video w-full rounded-lg bg-gray-200 overflow-hidden mb-4 relative group">
                        <?php if (!empty($setting['hero_image'])): ?>
                            <img id="imgPreview" src="<?= base_url('uploads/setting/' . $setting['hero_image']); ?>" alt="Hero Preview" class="w-full h-full object-cover">
                        <?php else: ?>
                            <img id="imgPreview" src="https://via.placeholder.com/800x450?text=Belum+Ada+Gambar" alt="Hero Preview" class="w-full h-full object-cover grayscale opacity-70">
                        <?php endif; ?>

                        <div class="absolute inset-0 bg-black/40 pointer-events-none"></div>
                    </div>

                    <div class="relative">
                        <input type="file" id="hero_image" name="hero_image" accept="image/png, image/jpeg, image/jpg, image/webp" class="hidden" onchange="previewImage()">
                        <label for="hero_image" class="cursor-pointer flex items-center justify-center w-full px-4 py-2.5 border-2 border-dashed border-indigo-200 rounded-lg hover:bg-indigo-50 hover:border-indigo-500 transition-all group">
                            <i class="fa-solid fa-cloud-arrow-up text-indigo-400 group-hover:text-indigo-600 text-lg mr-2 transition-colors"></i>
                            <span class="text-sm text-indigo-600 font-medium">Pilih Gambar Baru</span>
                        </label>
                    </div>
                    <ul class="text-[11px] text-gray-500 mt-3 space-y-1 list-disc list-inside">
                        <li>Format: JPG, JPEG, PNG, WEBP</li>
                        <li>Maksimal ukuran file: 2 MB</li>
                        <li>Rekomendasi rasio: 16:9 (Landscape)</li>
                    </ul>
                </div>
            </div>

        </div>

        <div class="mt-8 pt-5 border-t border-gray-100 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-semibold text-sm rounded-lg hover:bg-indigo-700 hover:shadow-lg hover:-translate-y-0.5 focus:ring-4 focus:ring-indigo-500/30 transition-all flex items-center">
                <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Perubahan Hero
            </button>
        </div>
    </form>
</div>

<script>
    function previewImage() {
        const image = document.querySelector('#hero_image');
        const imgPreview = document.querySelector('#imgPreview');

        if (image.files && image.files[0]) {
            const fileReader = new window.FileReader();

            fileReader.onload = function(e) {
                imgPreview.src = e.target.result;
                // Hilangkan efek grayscale jika gambar dummy diganti
                imgPreview.classList.remove('grayscale', 'opacity-70');
            }

            fileReader.readAsDataURL(image.files[0]);
        }
    }
</script>
<?= $this->endSection(); ?>