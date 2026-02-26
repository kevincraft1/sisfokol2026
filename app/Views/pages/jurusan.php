<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<section class="hero-section position-relative overflow-hidden d-flex align-items-center" style="min-height: 50vh;">
    <div class="blob blob-1"></div>
    <div class="container position-relative z-1 text-center pt-5">
        <span class="badge bg-soft-primary text-primary-custom mb-3 px-3 py-2 rounded-pill fw-semibold border border-primary-subtle">
            🎓 Program Keahlian Unggulan
        </span>
        <h1 class="display-4 fw-extrabold text-dark mb-3">Pilih Jalan <span class="text-gradient">Suksesmu</span></h1>
        <p class="lead text-secondary mx-auto" style="max-width: 600px;">
            Kurikulum kami dirancang khusus bersama mitra industri agar relevan dengan kebutuhan dunia kerja masa kini.
        </p>
    </div>
</section>

<section class="jurusan-section bg-light pb-6">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <?php if (empty($jurusan)): ?>
                <p class="text-center text-muted">Belum ada data jurusan.</p>
            <?php endif; ?>

            <?php foreach ($jurusan as $j): ?>
                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                    <div class="jurusan-card rounded-4 overflow-hidden position-relative h-100 shadow-sm bg-white">

                        <?php if ($j['image']): ?>
                            <img src="<?= base_url('uploads/jurusan/' . $j['image']); ?>" class="w-100 card-img-custom" alt="<?= $j['name']; ?>">
                        <?php else: ?>
                            <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?q=80&w=600&auto=format&fit=crop" class="w-100 card-img-custom" alt="Default">
                        <?php endif; ?>

                        <div class="jurusan-content p-4 position-relative bg-white">
                            <div class="icon-jurusan bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mb-3 shadow">
                                <?= $j['icon']; ?>
                            </div>
                            <h4 class="fw-bold mb-2"><?= $j['name']; ?></h4>
                            <p class="text-muted small mb-3"><?= character_limiter($j['description'], 80); ?></p>
                            <a href="<?= base_url('jurusan/' . $j['slug']); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-4 fw-semibold">
                                Lihat Detail <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>