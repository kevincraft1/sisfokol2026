<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<section class="hero-section position-relative overflow-hidden d-flex align-items-center" style="min-height: 50vh;">
    <div class="blob blob-1"></div>
    <div class="container position-relative z-1 pt-5 text-center">
        <span class="badge bg-soft-primary text-primary-custom mb-3 px-3 py-2 rounded-pill fw-semibold border border-primary-subtle">
            <?= $jurusan['icon']; ?> Program Keahlian
        </span>
        <h1 class="display-4 fw-extrabold text-dark mb-3"><?= $jurusan['name']; ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url('/'); ?>" class="text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('jurusan'); ?>" class="text-decoration-none">Jurusan</a></li>
                <li class="breadcrumb-item active text-secondary" aria-current="page">Detail</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5 bg-white mb-5">
    <div class="container pb-5">
        <div class="row g-5 align-items-center">

            <div class="col-lg-6" data-aos="fade-right">
                <?php if ($jurusan['image']): ?>
                    <img src="<?= base_url('uploads/jurusan/' . $jurusan['image']); ?>" class="img-fluid rounded-4 shadow-lg w-100 object-fit-cover" alt="<?= $jurusan['name']; ?>" style="max-height: 500px;">
                <?php else: ?>
                    <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?q=80&w=600&auto=format&fit=crop" class="img-fluid rounded-4 shadow-lg w-100 object-fit-cover" alt="Default" style="max-height: 500px;">
                <?php endif; ?>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <div class="d-flex align-items-center mb-4">
                    <div class="icon-jurusan bg-primary-custom text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow" style="width: 60px; height: 60px; font-size: 1.5rem;">
                        <?= $jurusan['icon']; ?>
                    </div>
                    <h2 class="fw-bold mb-0">Tentang Program Ini</h2>
                </div>

                <p class="text-secondary lh-lg mb-5" style="text-align: justify;">
                    <?= nl2br($jurusan['description']); ?>
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="<?= base_url('jurusan'); ?>" class="btn btn-outline-dark rounded-pill px-4 py-2 fw-semibold">
                        <i class="fa-solid fa-arrow-left me-2"></i> Kembali
                    </a>
                    <a href="<?= !empty($setting['link_ppdb']) ? $setting['link_ppdb'] : '#'; ?>" <?= !empty($setting['link_ppdb']) ? 'target="_blank"' : ''; ?> class="btn btn-primary-custom rounded-pill px-4 py-2 fw-semibold shadow-sm">
                        Daftar PPDB <i class="fa-solid fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
<?= $this->endSection(); ?>