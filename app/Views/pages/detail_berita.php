<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<section class="hero-section position-relative overflow-hidden pt-5" style="min-height: 25vh;">
    <div class="blob blob-2"></div>
    <div class="container position-relative z-1 mt-5 pt-5 text-center">
        <span class="badge bg-soft-primary text-primary-custom mb-3 px-3 py-2 rounded-pill fw-semibold border border-primary-subtle">
            <i class="bi bi-tag-fill me-1"></i> <?= $berita['category']; ?>
        </span>
        <h1 class="display-5 fw-extrabold text-dark mb-3 mx-auto" style="max-width: 800px;"><?= $berita['title']; ?></h1>
        <p class="text-secondary">
            <i class="bi bi-calendar-event me-2"></i> <?= date('d M Y', strtotime($berita['created_at'])); ?>
        </p>
    </div>
</section>

<section class="py-5 bg-white mb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto" data-aos="fade-up">

                <?php if ($berita['image']): ?>
                    <div class="rounded-4 overflow-hidden mb-5 shadow-sm">
                        <img src="<?= base_url('uploads/berita/' . $berita['image']); ?>" class="w-100" alt="<?= $berita['title']; ?>">
                    </div>
                <?php endif; ?>

                <div class="content-berita text-secondary" style="line-height: 1.8; font-size: 1.1rem;">
                    <?= nl2br($berita['content']); ?>
                </div>

                <div class="mt-5 pt-4 border-top">
                    <a href="<?= base_url('berita'); ?>" class="btn btn-outline-dark rounded-pill px-4">
                        <i class="bi bi-arrow-left me-2"></i> Kembali ke Berita
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>