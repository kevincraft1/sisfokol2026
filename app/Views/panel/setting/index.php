<?= $this->extend('panel/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800"><?= $title; ?></h1>
    <p class="text-sm text-gray-500 mt-1">Ubah identitas sekolah, kontak, dan tautan sosial media secara dinamis.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8">
    <form action="<?= base_url('panel/setting/update'); ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <h3 class="text-lg font-bold text-indigo-700 mb-4 border-b pb-2"><i class="fa-solid fa-school mr-2"></i> Identitas Utama</h3>
        <div class="mb-8 p-4 bg-orange-50 border border-orange-200 rounded-lg">
            <label class="block text-sm font-bold text-orange-800 mb-2"><i class="fa-solid fa-person-digging mr-2"></i> Mode Maintenance (Perbaikan)</label>

            <select id="maintenanceToggle" class="w-full md:w-1/3 px-4 py-2 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none bg-white font-semibold cursor-pointer shadow-sm">
                <option value="0" <?= (isset($setting['is_maintenance']) && $setting['is_maintenance'] == 0) ? 'selected' : ''; ?>>🟢 OFF - Website Berjalan Normal</option>
                <option value="1" <?= (isset($setting['is_maintenance']) && $setting['is_maintenance'] == 1) ? 'selected' : ''; ?>>🔴 ON - Aktifkan Mode Perbaikan</option>
            </select>

            <p class="text-xs text-orange-600 mt-2">Perubahan otomatis tersimpan layaknya saklar. Saat ON, pengunjung melihat halaman perbaikan, tapi Anda tetap bisa melihat website secara normal.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Website / Sekolah</label>
                <input type="text" name="nama_web" value="<?= $setting['nama_web'] ?? ''; ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <label class="block text-sm font-medium text-gray-700 mt-4 mb-1">Link Pendaftaran PPDB Eksternal</label>
                <input type="url" name="link_ppdb" value="<?= $setting['link_ppdb'] ?? ''; ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-blue-600" placeholder="https://forms.gle/... atau https://ppdb.sekolah.com">
                <label class="block text-sm font-medium text-gray-700 mt-4 mb-1">Deskripsi Singkat (Footer)</label>
                <textarea name="deskripsi" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"><?= $setting['deskripsi'] ?? ''; ?></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Logo Sekolah (Opsional)</label>
                <input type="file" name="logo" id="imageInput" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 mb-2">
                <p id="compressionStatus" class="text-xs text-blue-600 font-medium mb-3"></p>

                <?php if (!empty($setting['logo'])): ?>
                    <div class="p-4 bg-gray-50 rounded-lg inline-block border border-gray-200">
                        <img src="<?= base_url('uploads/setting/' . $setting['logo']); ?>" alt="Logo" class="h-16 object-contain">
                    </div>
                <?php else: ?>
                    <div class="p-4 bg-gray-50 rounded-lg inline-block border border-gray-200 text-sm text-gray-400">
                        Belum ada logo terpasang.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <h3 class="text-lg font-bold text-indigo-700 mb-4 border-b pb-2"><i class="fa-solid fa-address-book mr-2"></i> Kontak & Lokasi</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                <textarea name="alamat" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"><?= $setting['alamat'] ?? ''; ?></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Telepon / WhatsApp</label>
                <input type="text" name="telepon" value="<?= $setting['telepon'] ?? ''; ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none mb-4" placeholder="Misal: 0812-3456-7890">

                <label class="block text-sm font-medium text-gray-700 mb-1">Email Resmi</label>
                <input type="email" name="email" value="<?= $setting['email'] ?? ''; ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="info@sekolah.com">
            </div>
        </div>

        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-1">Kode Embed Google Maps (Iframe)</label>
            <textarea name="maps" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none font-mono text-sm" placeholder='<iframe src="https://www.google.com/maps/embed?..." width="600" height="450" ...></iframe>'><?= $setting['maps'] ?? ''; ?></textarea>
            <p class="text-xs text-gray-500 mt-1"><i class="fa-solid fa-circle-info mr-1"></i> Buka Google Maps -> Cari Lokasi -> Klik "Bagikan" -> Pilih "Sematkan peta" -> Salin HTML.</p>
        </div>

        <h3 class="text-lg font-bold text-indigo-700 mb-4 border-b pb-2"><i class="fa-solid fa-hashtag mr-2"></i> Sosial Media</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"><i class="fa-brands fa-facebook text-blue-600"></i> Facebook (URL)</label>
                <input type="text" name="facebook" value="<?= $setting['facebook'] ?? ''; ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="https://facebook.com/sekolah">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"><i class="fa-brands fa-instagram text-pink-600"></i> Instagram (URL)</label>
                <input type="text" name="instagram" value="<?= $setting['instagram'] ?? ''; ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="https://instagram.com/sekolah">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"><i class="fa-brands fa-youtube text-red-600"></i> YouTube (URL)</label>
                <input type="text" name="youtube" value="<?= $setting['youtube'] ?? ''; ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="https://youtube.com/c/sekolah">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"><i class="fa-brands fa-tiktok text-black"></i> TikTok (URL)</label>
                <input type="text" name="tiktok" value="<?= $setting['tiktok'] ?? ''; ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="https://tiktok.com/@sekolah">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"><i class="fa-brands fa-x-twitter text-black"></i> Twitter / X (URL)</label>
                <input type="text" name="twitter" value="<?= $setting['twitter'] ?? ''; ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="https://x.com/sekolah">
            </div>
        </div>

        <h3 class="text-lg font-bold text-indigo-700 mb-4 border-b pb-2"><i class="fa-solid fa-chart-line mr-2"></i> Statistik Beranda (Angka Counter)</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Mitra Industri</label>
                <div class="relative">
                    <input type="number" name="stat_mitra" value="<?= $setting['stat_mitra'] ?? '50'; ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">+</div>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fasilitas Praktik (%)</label>
                <div class="relative">
                    <input type="number" name="stat_fasilitas" value="<?= $setting['stat_fasilitas'] ?? '100'; ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">%</div>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Total Alumni Sukses</label>
                <div class="relative">
                    <input type="number" name="stat_alumni" value="<?= $setting['stat_alumni'] ?? '2000'; ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">+</div>
                </div>
            </div>
            <div class="col-span-1 md:col-span-3">
                <p class="text-xs text-gray-500"><i class="fa-solid fa-circle-info mr-1"></i> Catatan: Angka "Program Keahlian" pada halaman depan otomatis dihitung dari total data Jurusan yang Anda inputkan.</p>
            </div>
        </div>

        <div class="border-t border-gray-100 pt-6">
            <button type="submit" id="btnSubmit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-indigo-700 transition shadow-sm w-full md:w-auto">
                <i class="fa-solid fa-save mr-2"></i> Simpan Pengaturan
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('imageInput').addEventListener('change', async function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const statusText = document.getElementById('compressionStatus');
        const btnSubmit = document.getElementById('btnSubmit');
        statusText.textContent = "Sedang mengompresi logo...";
        statusText.className = "text-xs font-medium mt-1 text-orange-500";
        btnSubmit.disabled = true;
        btnSubmit.classList.add('opacity-50');
        try {
            const compressedFile = await compressImageToWebP(file, 20);
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(compressedFile);
            e.target.files = dataTransfer.files;
            statusText.textContent = `Selesai! Logo WebP (${(compressedFile.size / 1024).toFixed(2)} KB)`;
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
                    const MAX_WIDTH = 400;
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
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleBtn = document.getElementById('maintenanceToggle');

        toggleBtn.addEventListener('change', function() {
            const statusVal = this.value;
            const formData = new FormData();
            formData.append('status', statusVal);
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
            // Ganti warna background select box agar terlihat interaktif
            this.style.opacity = '0.5';

            fetch('<?= base_url('panel/setting/toggle-maintenance'); ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.style.opacity = '1'; // Kembalikan opacity

                        // Munculkan notifikasi pop-up kecil di pojok kanan bawah
                        const toast = document.createElement('div');
                        toast.className = 'fixed bottom-5 right-5 bg-gray-800 text-white px-5 py-3 rounded-lg shadow-lg z-50 transition-opacity duration-300';
                        toast.innerHTML = `<i class="fa-solid fa-check-circle text-green-400 mr-2"></i> Mode Maintenance: <b>${statusVal == 1 ? 'ON' : 'OFF'}</b>`;
                        document.body.appendChild(toast);

                        // Hilangkan toast setelah 3 detik
                        setTimeout(() => {
                            toast.style.opacity = '0';
                            setTimeout(() => toast.remove(), 300);
                        }, 3000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal mengubah status maintenance. Periksa koneksi internet.');
                    this.style.opacity = '1';
                });
        });
    });
</script>
<?= $this->endSection(); ?>