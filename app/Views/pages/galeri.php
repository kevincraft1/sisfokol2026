<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

<section class="hero-section position-relative overflow-hidden pt-5" style="min-height: 40vh;">
    <div class="blob blob-1"></div>
    <div class="container position-relative z-1 text-center mt-5 pt-4">
        <h1 class="display-4 fw-extrabold text-dark mb-2"><span class="text-gradient">Galeri</span> Kami</h1>
        <p class="lead text-secondary mx-auto">Momen kegiatan belajar dan hasil karya nyata siswa-siswi.</p>
    </div>
</section>

<section class="py-5 bg-light mb-5">
    <div class="container">
        <div class="d-flex justify-content-center gap-2 mb-5 flex-wrap" id="filter-buttons" data-aos="fade-up">
            <button class="filter-btn btn btn-primary-custom rounded-pill px-4" data-filter="semua">Semua</button>
            <button class="filter-btn btn btn-outline-dark rounded-pill px-4" data-filter="karya">Karya Siswa</button>
            <button class="filter-btn btn btn-outline-dark rounded-pill px-4" data-filter="kegiatan">Kegiatan</button>
            <button class="filter-btn btn btn-outline-dark rounded-pill px-4" data-filter="fasilitas">Fasilitas</button>
        </div>

        <div class="row g-4 justify-content-center" id="gallery-container">
            <?php if (empty($galeri)): ?>
                <div class="col-12 text-center py-5">
                    <i class="bi bi-images text-muted" style="font-size: 4rem;"></i>
                    <h4 class="text-muted mt-3">Belum ada foto galeri.</h4>
                </div>
            <?php endif; ?>

            <?php foreach ($galeri as $g): ?>
                <div class="col-md-6 col-lg-4 gallery-item" data-category="<?= $g['type']; ?>" data-aos="zoom-in">
                    <div class="karya-item rounded-4 overflow-hidden position-relative shadow-sm" style="cursor: pointer;">

                        <?php $imgUrl = $g['image'] ? base_url('uploads/galeri/' . $g['image']) : 'https://images.unsplash.com/photo-1561070791-2526d30994b5?q=80&w=600&auto=format&fit=crop'; ?>

                        <a href="<?= $imgUrl; ?>" class="glightbox d-block w-100 h-100" data-title="<?= $g['title']; ?>" data-description="<?= $g['description']; ?>">

                            <img src="<?= $imgUrl; ?>" alt="<?= $g['title']; ?>" class="w-100 h-100 object-fit-cover">

                            <div class="karya-overlay d-flex flex-column justify-content-end p-4 text-white">
                                <h5 class="fw-bold mb-1"><?= $g['title']; ?></h5>
                                <small><?= $g['description']; ?></small>
                            </div>

                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Inisialisasi GLightbox
        const lightbox = GLightbox({
            selector: '.glightbox',
            touchNavigation: true, // Mendukung swipe di layar sentuh
            loop: true, // Berputar terus saat di-next
            zoomable: true // Bisa di-zoom
        });

        // Script Filter Kategorimu (Tetap Dipertahankan)
        const filterBtns = document.querySelectorAll('.filter-btn');
        const galleryItems = document.querySelectorAll('.gallery-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => {
                    b.classList.remove('btn-primary-custom');
                    b.classList.add('btn-outline-dark');
                });

                btn.classList.add('btn-primary-custom');
                btn.classList.remove('btn-outline-dark');

                const filterValue = btn.getAttribute('data-filter');

                galleryItems.forEach(item => {
                    if (filterValue === 'semua' || item.getAttribute('data-category') === filterValue) {
                        item.style.display = 'block';
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'scale(1)';
                        }, 50);
                    } else {
                        item.style.opacity = '0';
                        item.style.transform = 'scale(0.8)';
                        setTimeout(() => {
                            item.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });
    });
</script>

<style>
    .gallery-item {
        transition: all 0.3s ease-in-out;
    }

    /* Memastikan link tidak merusak desain overlay */
    a.glightbox {
        text-decoration: none;
        color: inherit;
    }

    /* Tambahan efek hover pada gambar (opsional agar lebih hidup) */
    .karya-item img {
        transition: transform 0.4s ease;
    }

    .karya-item:hover img {
        transform: scale(1.08);
    }
</style>
<?= $this->endSection(); ?>