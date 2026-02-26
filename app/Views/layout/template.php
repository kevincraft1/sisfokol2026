<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Website'; ?> | <?= $setting['nama_web'] ?? 'Nama Sekolah'; ?></title>

    <?php if (!empty($setting['logo'])): ?>
        <link rel="icon" href="<?= base_url('uploads/setting/' . $setting['logo']); ?>">
    <?php endif; ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
</head>

<body>

    <nav class="navbar navbar-expand-lg fixed-top glass-nav" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand fw-extrabold d-flex align-items-center" href="<?= base_url('/'); ?>">
                <?php if (!empty($setting['logo'])): ?>
                    <img src="<?= base_url('uploads/setting/' . $setting['logo']); ?>" alt="Logo" height="35" class="me-2" style="object-fit: contain;">
                <?php endif; ?>
                <span class="text-primary-custom"><?= $setting['nama_web'] ?? 'Nama Sekolah'; ?></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center fw-medium">
                    <li class="nav-item"><a class="nav-link <?= (isset($active) && $active == 'beranda') ? 'active' : ''; ?>" href="<?= base_url('/'); ?>">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link <?= (isset($active) && $active == 'profil') ? 'active' : ''; ?>" href="<?= base_url('profil'); ?>">Profil</a></li>
                    <li class="nav-item"><a class="nav-link <?= (isset($active) && $active == 'jurusan') ? 'active' : ''; ?>" href="<?= base_url('jurusan'); ?>">Jurusan</a></li>
                    <li class="nav-item"><a class="nav-link <?= (isset($active) && $active == 'berita') ? 'active' : ''; ?>" href="<?= base_url('berita'); ?>">Berita</a></li>
                    <li class="nav-item"><a class="nav-link <?= (isset($active) && $active == 'galeri') ? 'active' : ''; ?>" href="<?= base_url('galeri'); ?>">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link <?= (isset($active) && $active == 'kontak') ? 'active' : ''; ?>" href="<?= base_url('kontak'); ?>">Kontak</a></li>
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        <a class="btn btn-primary-custom px-4 py-2 rounded-pill fw-semibold"
                            href="<?= !empty($setting['link_ppdb']) ? $setting['link_ppdb'] : '#'; ?>"
                            <?= !empty($setting['link_ppdb']) ? 'target="_blank"' : ''; ?>>
                            Daftar PPDB
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main style="min-height: 80vh;">
        <?= $this->renderSection('content'); ?>
    </main>

    <?php
    $waLink = "https://wa.me/6281234567890";
    if (!empty($setting['telepon'])) {
        $waNum = preg_replace('/[^0-9]/', '', $setting['telepon']);
        if (substr($waNum, 0, 1) == '0') $waNum = '62' . substr($waNum, 1);
        $waLink = "https://wa.me/" . $waNum;
    }
    ?>
    <a href="<?= $waLink; ?>" target="_blank" id="btnWhatsApp" title="Hubungi Kami via WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>
    <button id="btnBackToTop" title="Kembali ke atas">
        <i class="fa-solid fa-arrow-up" style="font-size: 20px;"></i>
    </button>

    <footer class="bg-dark text-white pt-6 pb-4 section-padding mt-5">
        <div class="container pt-4">
            <div class="row g-4 mb-5">

                <div class="col-lg-4 col-md-4 mt-5 mt-lg-0">
                    <h4 class="fw-extrabold mb-3 mt-1 d-flex align-items-center">
                        <?php if (!empty($setting['logo'])): ?>
                            <img src="<?= base_url('uploads/setting/' . $setting['logo']); ?>" alt="Logo" height="28" class="me-2" style="object-fit: contain;">
                        <?php endif; ?>
                        <span class="text-accent"><?= $setting['nama_web'] ?? 'Nama Sekolah'; ?></span>
                    </h4>
                    <p class="text-white-50 mb-4"><?= !empty($setting['deskripsi']) ? $setting['deskripsi'] : 'Mencetak generasi unggul yang siap kerja, berkarakter, dan memiliki jiwa wirausaha di era digital.'; ?></p>

                    <div class="d-flex gap-3">
                        <?php if (!empty($setting['facebook'])): ?>
                            <a href="<?= $setting['facebook']; ?>" target="_blank" class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height:40px;"><i class="bi bi-facebook"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($setting['instagram'])): ?>
                            <a href="<?= $setting['instagram']; ?>" target="_blank" class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height:40px;"><i class="bi bi-instagram"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($setting['tiktok'])): ?>
                            <a href="<?= $setting['tiktok']; ?>" target="_blank" class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height:40px;"><i class="bi bi-tiktok"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($setting['youtube'])): ?>
                            <a href="<?= $setting['youtube']; ?>" target="_blank" class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height:40px;"><i class="bi bi-youtube"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($setting['twitter'])): ?>
                            <a href="<?= $setting['twitter']; ?>" target="_blank" class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height:40px;"><i class="bi bi-twitter-x"></i></a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 mt-5 mt-lg-0">
                    <h5 class="fw-bold mb-3">Tautan</h5>
                    <ul class="list-unstyled text-white-50 lh-lg">
                        <li><a href="<?= base_url('/'); ?>" class="text-decoration-none text-white-50 hover-white">Beranda</a></li>
                        <li><a href="<?= base_url('jurusan'); ?>" class="text-decoration-none text-white-50 hover-white">Jurusan</a></li>
                        <li><a href="<?= base_url('galeri'); ?>" class="text-decoration-none text-white-50 hover-white">Galeri</a></li>
                        <li><a href="<?= base_url('berita'); ?>" class="text-decoration-none text-white-50 hover-white">Berita</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-4 mt-5 mt-lg-0">
                    <h5 class="fw-bold mb-3">Kontak</h5>
                    <ul class="list-unstyled text-white-50 lh-lg">
                        <li class="d-flex mb-2"><i class="bi bi-geo-alt-fill me-3 mt-1"></i> <span><?= !empty($setting['alamat']) ? nl2br($setting['alamat']) : 'Alamat belum diatur'; ?></span></li>
                        <li class="d-flex mb-2"><i class="bi bi-telephone-fill me-3 mt-1"></i> <span><?= !empty($setting['telepon']) ? $setting['telepon'] : '-'; ?></span></li>
                        <li class="d-flex mb-2"><i class="bi bi-envelope-fill me-3 mt-1"></i> <span><?= !empty($setting['email']) ? $setting['email'] : '-'; ?></span></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-4 mt-5 mt-lg-0">
                    <h5 class="fw-bold mb-3">Peta Lokasi</h5>
                    <div class="rounded overflow-hidden shadow-sm bg-secondary" style="height: 160px;">
                        <?php if (!empty($setting['maps'])): ?>
                            <?= str_replace(['width="600"', 'height="450"'], ['width="100%"', 'height="160"'], $setting['maps']); ?>
                        <?php else: ?>
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center text-white-50 text-sm">Peta belum diatur</div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
            <div class="border-top border-secondary pt-4 text-center text-white-50 small">
                © <?= date('Y'); ?> <?= $setting['nama_web'] ?? 'Nama Sekolah'; ?>. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            offset: 50,
            duration: 800
        });

        const navbar = document.getElementById('mainNavbar');
        const btnBackToTop = document.getElementById('btnBackToTop');
        const btnWhatsApp = document.getElementById('btnWhatsApp');

        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                if (navbar) {
                    navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                    navbar.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1)';
                }
            } else {
                if (navbar) {
                    navbar.style.background = 'rgba(255, 255, 255, 0.85)';
                    navbar.style.boxShadow = 'none';
                }
            }

            if (window.scrollY > 300) {
                if (btnBackToTop) btnBackToTop.classList.add('show');
                if (btnWhatsApp) btnWhatsApp.classList.add('move-up');
            } else {
                if (btnBackToTop) btnBackToTop.classList.remove('show');
                if (btnWhatsApp) btnWhatsApp.classList.remove('move-up');
            }
        });

        if (btnBackToTop) {
            btnBackToTop.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const counters = document.querySelectorAll('.counter-value');
            const speed = 100; // Percepat sedikit agar animasinya lebih responsif

            const startCounters = () => {
                counters.forEach(counter => {
                    const animate = () => {
                        const target = parseInt(counter.getAttribute('data-target')) || 0;
                        const suffix = counter.getAttribute('data-suffix') || '';

                        // Ambil angka saat ini tanpa mengambil karakter selain angka
                        let currentCount = parseInt(counter.innerText.replace(/[^0-9]/g, '')) || 0;

                        // Hitung langkah kenaikan (increment)
                        const inc = Math.ceil(target / speed);

                        if (currentCount < target) {
                            currentCount += inc;

                            // Pastikan angkanya tidak kebablasan dari target
                            if (currentCount > target) currentCount = target;

                            counter.innerText = currentCount + suffix;
                            setTimeout(animate, 30);
                        } else {
                            // Jika sudah mencapai target, rapikan format angkanya
                            if (target >= 1000) {
                                counter.innerText = (target / 1000).toFixed(1).replace('.0', '') + 'K' + suffix;
                            } else {
                                counter.innerText = target + suffix;
                            }
                        }
                    };
                    animate();
                });
            };

            const statsSection = document.querySelector('.stats-section');

            // Buat observer untuk mendeteksi apakah area statistik terlihat di layar
            if (statsSection) {
                // Turunkan threshold menjadi 0.1 agar lebih cepat bereaksi walau baru di-scroll sedikit
                const observerOptions = {
                    root: null,
                    threshold: 0.1
                };
                const statsObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            startCounters();
                            observer.unobserve(entry.target); // Hentikan observasi agar tidak berulang
                        }
                    });
                }, observerOptions);
                statsObserver.observe(statsSection);
            } else {
                startCounters();
            }
        });
    </script>
</body>

</html>