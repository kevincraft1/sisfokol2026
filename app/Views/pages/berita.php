<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<section class="hero-section position-relative overflow-hidden pt-5" style="min-height: 40vh;">
    <div class="blob blob-2"></div>
    <div class="container position-relative z-1 text-center mt-5 pt-4">
        <h1 class="display-4 fw-extrabold text-dark mb-2">Portal <span class="text-gradient">Berita</span></h1>
        <p class="lead text-secondary mx-auto">Kabar terbaru, prestasi, dan kegiatan seru di SMK Kreatif Nusantara.</p>
    </div>
</section>

<section class="berita-section py-5 bg-white mb-5">
    <div class="container">
        <div class="row g-4 justify-content-center">

            <?php if (empty($berita)): ?>
                <div class="col-12 text-center py-5">
                    <i class="bi bi-journal-x text-muted" style="font-size: 4rem;"></i>
                    <h4 class="text-muted mt-3">Belum ada berita yang diterbitkan.</h4>
                </div>
            <?php endif; ?>

            <?php foreach ($berita as $b): ?>
                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">

                        <?php if ($b['image']): ?>
                            <img src="<?= base_url('uploads/berita/' . $b['image']); ?>" class="card-img-top object-fit-cover" alt="<?= $b['title']; ?>" style="height: 220px;">
                        <?php else: ?>
                            <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?q=80&w=600&auto=format&fit=crop" class="card-img-top object-fit-cover" alt="Default Image" style="height: 220px;">
                        <?php endif; ?>

                        <div class="card-body p-4">
                            <span class="badge bg-soft-primary text-primary-custom mb-2 px-2 py-1"><?= $b['category']; ?></span>
                            <h5 class="card-title fw-bold">
                                <a href="<?= base_url('berita/' . $b['slug']); ?>" class="text-dark text-decoration-none hover-primary"><?= $b['title']; ?></a>
                            </h5>
                            <p class="card-text text-muted small mb-3">
                                <?= character_limiter(strip_tags($b['content']), 100); ?>
                            </p>
                            <a href="<?= base_url('berita/' . $b['slug']); ?>" class="text-primary-custom fw-semibold text-decoration-none">
                                Baca selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

        <div class="mt-5 d-flex justify-content-center" data-aos="fade-up">
            <?= $pager->links('berita', 'default_full'); ?>
        </div>

    </div>
</section>

<style>
    .hover-primary:hover {
        color: var(--primary-color) !important;
        transition: color 0.3s ease;
    }

    /* Style untuk mempercantik Pagination Bawaan CI4 */
    .pagination li {
        margin: 0 5px;
    }

    .pagination li a,
    .pagination li span {
        padding: 8px 16px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        color: var(--primary-color);
        text-decoration: none;
    }

    .pagination li.active span {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .pagination li a:hover {
        background-color: #f8f9fa;
    }
</style>
<?= $this->endSection(); ?>