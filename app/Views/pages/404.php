<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<section class="hero-section position-relative overflow-hidden d-flex align-items-center" style="min-height: 80vh;">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="container position-relative z-1 text-center" data-aos="zoom-in" data-aos-duration="1000">
        <h1 class="fw-extrabold text-gradient mb-2" style="font-size: 8rem; line-height: 1;">404</h1>
        <h3 class="display-6 fw-bold text-dark mb-3">Waduh! Salah Jalan Nih...</h3>
        <p class="lead text-secondary mb-5 mx-auto" style="max-width: 600px;">
            Halaman yang kamu cari sepertinya tidak ada, sudah dihapus, atau sedang dalam perbaikan. Yuk, kembali ke
            jalan yang benar!
        </p>
        <a href="<?= base_url('/'); ?>" class="btn btn-primary-custom px-5 py-3 rounded-pill fw-semibold shadow-sm">
            <i class="bi bi-house-door-fill me-2"></i> Kembali ke Beranda
        </a>
    </div>
</section>
<?= $this->endSection(); ?>