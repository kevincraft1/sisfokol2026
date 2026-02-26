<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<section class="hero-section position-relative overflow-hidden">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="container position-relative z-1 pt-1 pt-lg-0">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6 mb-5 mb-lg-0 pt-2 pt-lg-0" data-aos="fade-up" data-aos-duration="1000">
                <span
                    class="badge bg-soft-primary text-primary-custom mb-3 px-3 py-2 rounded-pill border border-primary-subtle fw-semibold">
                    ✨ Penerimaan Siswa Baru <?= date('Y'); ?>/<?= date('Y') + 1; ?>
                </span>

                <?php if (!empty($setting['hero_title'])): ?>
                    <?php
                    // 1. Amankan teks dari karakter berbahaya
                    $heroTitle = esc($setting['hero_title']);

                    // 2. Ubah teks di dalam [...] menjadi span gradient
                    $heroTitle = preg_replace('/\[(.*?)\]/', '<span class="text-gradient">$1</span>', $heroTitle);

                    // 3. Ubah tanda | menjadi garis baru (<br>)
                    $heroTitle = str_replace('|', '<br>', $heroTitle);
                    ?>
                    <h1 class="display-4 fw-extrabold mb-4 text-dark lh-sm">
                        <?= $heroTitle; ?>
                    </h1>
                <?php else: ?>
                    <h1 class="display-4 fw-extrabold mb-4 text-dark lh-sm">
                        Mulai Karier Hebatmu, <br>
                        Ciptakan <span class="text-gradient">Karya Nyata.</span>
                    </h1>
                <?php endif; ?>

                <p class="lead text-secondary mb-5 pe-lg-5">
                    <?= !empty($setting['hero_desc']) ? nl2br(esc($setting['hero_desc'])) : 'Kami tidak hanya mengajarkan teori. Di sini, kamu dididik untuk menjadi ahli, praktisi kreatif, dan technopreneur masa depan. Siap melangkah maju?'; ?>
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="<?= base_url('jurusan'); ?>"
                        class="btn btn-primary-custom px-4 py-3 rounded-pill fw-semibold shadow-sm">Jelajahi
                        Jurusan</a>
                    <a href="<?= base_url('galeri'); ?>" class="btn btn-outline-dark px-4 py-3 rounded-pill fw-semibold">Lihat Karya
                        Siswa</a>
                </div>
            </div>

            <div class="col-lg-6 position-relative" data-aos="zoom-in-up" data-aos-duration="1200"
                data-aos-delay="200">

                <?php if (!empty($setting['hero_image'])): ?>
                    <img src="<?= base_url('uploads/setting/' . $setting['hero_image']); ?>"
                        alt="Hero Website" class="img-fluid rounded-4 shadow-lg hero-img" style="object-fit: cover; width: 100%; height: auto;">
                <?php else: ?>
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=800&auto=format&fit=crop"
                        alt="Siswa SMK" class="img-fluid rounded-4 shadow-lg hero-img">
                <?php endif; ?>

                <div class="floating-card glass-card p-3 rounded-4 shadow-sm position-absolute top-50 start-0 translate-middle ms-4 d-none d-md-block"
                    data-aos="fade-right" data-aos-delay="600">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-box bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold fs-5"
                            style="width: 45px; height: 45px;">✓</div>
                        <div>
                            <h6 class="mb-0 fw-bold">Siap Kerja</h6>
                            <small class="text-muted">Kurikulum Standar Industri</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 text-white position-relative stats-section bg-gradient-stats">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
                <h2 class="display-5 fw-extrabold text-accent mb-0"><span class="counter-value" data-target="<?= !empty($setting['stat_mitra']) ? $setting['stat_mitra'] : 50; ?>" data-suffix="+">0</span></h2>
                <p class="mb-0 text-white-50">Mitra Industri</p>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                <h2 class="display-5 fw-extrabold text-accent mb-0"><span class="counter-value" data-target="<?= !empty($setting['stat_fasilitas']) ? $setting['stat_fasilitas'] : 100; ?>" data-suffix="%">0</span></h2>
                <p class="mb-0 text-white-50">Fasilitas Praktik</p>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                <h2 class="display-5 fw-extrabold text-accent mb-0"><span class="counter-value" data-target="<?= !empty($jurusan) ? count($jurusan) : 6; ?>" data-suffix="">0</span></h2>
                <p class="mb-0 text-white-50">Program Keahlian</p>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="400">
                <h2 class="display-5 fw-extrabold text-accent mb-0"><span class="counter-value" data-target="<?= !empty($setting['stat_alumni']) ? $setting['stat_alumni'] : 2000; ?>" data-suffix="+">0</span></h2>
                <p class="mb-0 text-white-50">Alumni Sukses</p>
            </div>
        </div>
    </div>
</section>
<section class="jurusan-section bg-light">
    <div class="container">
        <div class="text-center mb-4" data-aos="fade-up">
            <span class="text-primary-custom fw-bold text-uppercase tracking-wide">Program Keahlian</span>
            <h2 class="display-6 fw-extrabold mt-2">Pilih Jalan Suksesmu</h2>
            <p class="text-secondary mx-auto" style="max-width: 600px;">Setiap jurusan didesain bersama praktisi industri untuk memastikan lulusan kami relevan dengan kebutuhan pasar kerja.</p>
        </div>

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
                            <p class="text-muted small mb-0"><?= $j['description']; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="<?= base_url('jurusan'); ?>" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-semibold">Lihat Semua Jurusan</a>
        </div>
    </div>
</section>

<section class="py-6 section-padding">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5" data-aos="fade-up">
            <div>
                <span class="text-primary-custom fw-bold text-uppercase tracking-wide">Galeri</span>
                <h2 class="display-6 fw-extrabold mt-2 mb-0">Karya Nyata Siswa</h2>
            </div>
            <a href="<?= base_url('galeri'); ?>" class="btn btn-outline-dark rounded-pill d-none d-md-block">Lihat Semua Galeri</a>
        </div>

        <div class="row g-4 justify-content-center">
            <?php if (empty($galeri)): ?>
                <p class="text-center text-muted">Belum ada foto galeri.</p>
            <?php endif; ?>

            <?php foreach ($galeri as $g): ?>
                <div class="col-md-6 col-lg-4" data-aos="zoom-in">
                    <div class="karya-item rounded-4 overflow-hidden position-relative shadow-sm">
                        <?php if ($g['image']): ?>
                            <img src="<?= base_url('uploads/galeri/' . $g['image']); ?>" alt="<?= $g['title']; ?>" class="w-100 h-100 object-fit-cover">
                        <?php else: ?>
                            <img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?q=80&w=600&auto=format&fit=crop" class="w-100 h-100 object-fit-cover">
                        <?php endif; ?>

                        <div class="karya-overlay d-flex flex-column justify-content-end p-4 text-white">
                            <h5 class="fw-bold mb-1"><?= $g['title']; ?></h5>
                            <small><?= $g['description']; ?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-4 d-md-none">
            <a href="<?= base_url('galeri'); ?>" class="btn btn-outline-dark rounded-pill">Lihat Semua Galeri</a>
        </div>
    </div>
</section>

<section class="berita-section py-5 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5" data-aos="fade-up">
            <div>
                <span class="text-primary-custom fw-bold text-uppercase tracking-wide">Berita Terkini</span>
                <h2 class="display-6 fw-extrabold mt-2 mb-0">Kabar Terbaru Sekolah</h2>
            </div>
            <a href="<?= base_url('berita'); ?>" class="btn btn-outline-primary rounded-pill d-none d-md-block">Lihat Semua Berita</a>
        </div>

        <div class="row g-4 justify-content-center">
            <?php if (empty($berita)): ?>
                <p class="text-center text-muted">Belum ada berita terbaru.</p>
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

        <div class="text-center mt-4 d-md-none">
            <a href="<?= base_url('berita'); ?>" class="btn btn-outline-primary rounded-pill">Lihat Semua Berita</a>
        </div>
    </div>
</section>

<section class="py-5 bg-light overflow-hidden border-top border-bottom">
    <div class="container text-center mb-4" data-aos="fade-up">
        <h6 class="text-muted fw-bold text-uppercase tracking-wide">Dipercaya oleh Perusahaan Terkemuka</h6>
    </div>
    <div class="marquee-container">
        <div class="marquee-content d-flex align-items-center">
            <?php if (empty($mitra)): ?>
                <h4 class="mx-5 text-muted fw-bold">Gojek</h4>
                <h4 class="mx-5 text-muted fw-bold">Tokopedia</h4>
                <h4 class="mx-5 text-muted fw-bold">Telkom Indonesia</h4>
            <?php else: ?>
                <?php for ($i = 0; $i < 2; $i++): ?>
                    <?php foreach ($mitra as $m): ?>
                        <div class="mx-5 flex items-center">
                            <img src="<?= base_url('uploads/mitra/' . $m['logo']); ?>" alt="<?= $m['nama']; ?>" style="height: 45px; width: auto; filter: grayscale(100%); opacity: 0.6;">
                        </div>
                    <?php endforeach; ?>
                <?php endfor; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>