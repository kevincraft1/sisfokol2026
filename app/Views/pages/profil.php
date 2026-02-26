<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<style>
    .misi-content ul {
        padding-left: 1.5rem;
        list-style-type: disc;
        color: #6c757d;
    }

    .misi-content ol {
        padding-left: 1.5rem;
        list-style-type: decimal;
        color: #6c757d;
    }

    .misi-content li {
        margin-bottom: 0.5rem;
    }
</style>

<section class="hero-section position-relative overflow-hidden d-flex align-items-center" style="min-height: 60vh;">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="container position-relative z-1 text-center pt-5">
        <h1 class="display-4 fw-extrabold text-dark mb-3">
            Mengenal <span class="text-gradient"><?= $setting['nama_web'] ?? 'SMK Kreatif Nusantara'; ?></span>
        </h1>
        <p class="lead text-secondary mx-auto" style="max-width: 700px;">
            <?= !empty($profil['sejarah']) ? nl2br($profil['sejarah']) : 'Belum ada data sejarah/pengantar.'; ?>
        </p>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container pb-5">
        <div class="row g-4 align-items-center">

            <div class="col-lg-6" data-aos="fade-right">
                <?php if (!empty($profil['gambar'])): ?>
                    <img src="<?= base_url('uploads/profil/' . $profil['gambar']); ?>" alt="Gedung Sekolah" class="img-fluid rounded-4 shadow object-fit-cover" style="width: 100%; max-height: 500px;">
                <?php else: ?>
                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=800&auto=format&fit=crop" alt="Gedung Sekolah Default" class="img-fluid rounded-4 shadow">
                <?php endif; ?>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <span class="text-primary-custom fw-bold text-uppercase tracking-wide">Visi & Misi</span>
                <h2 class="display-6 fw-extrabold mt-2 mb-4">Membangun Karakter, Mencetak Inovator.</h2>

                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <div class="bg-soft-primary text-primary-custom rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 1.5rem;">🎯</div>
                    </div>
                    <div class="ms-3">
                        <h5 class="fw-bold">Visi Kami</h5>
                        <p class="text-muted">
                            <?= !empty($profil['visi']) ? nl2br($profil['visi']) : 'Belum ada data visi.'; ?>
                        </p>
                    </div>
                </div>

                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <div class="bg-soft-primary text-primary-custom rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 1.5rem;">🚀</div>
                    </div>
                    <div class="ms-3 w-100">
                        <h5 class="fw-bold mb-2">Misi Kami</h5>
                        <div class="misi-content text-muted">
                            <?= !empty($profil['misi']) ? $profil['misi'] : 'Belum ada data misi.'; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<?= $this->endSection(); ?>