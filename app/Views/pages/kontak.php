<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<section class="hero-section position-relative overflow-hidden pt-5" style="min-height: 40vh;">
    <div class="blob blob-2"></div>
    <div class="container position-relative z-1 text-center mt-5 pt-4">
        <h1 class="display-4 fw-extrabold text-dark mb-2">Hubungi <span class="text-gradient">Kami</span></h1>
        <p class="lead text-secondary mx-auto">Ada pertanyaan tentang pendaftaran atau program sekolah? Kami siap membantu.</p>
    </div>
</section>

<section class="py-5 bg-white mb-5">
    <div class="container">
        <div class="row g-5">

            <div class="col-lg-5" data-aos="fade-right">
                <h3 class="fw-bold mb-4">Informasi Kontak</h3>

                <div class="d-flex align-items-center mb-4 p-3 rounded-4 bg-light shadow-sm">
                    <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center fs-4 shadow-sm" style="width: 50px; height: 50px;">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="fw-bold mb-1">Alamat Lengkap</h6>
                        <p class="text-muted mb-0 small"><?= !empty($setting['alamat']) ? nl2br($setting['alamat']) : 'Alamat belum diatur'; ?></p>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-4 p-3 rounded-4 bg-light shadow-sm">
                    <div class="bg-success text-white rounded-circle d-flex justify-content-center align-items-center fs-4 shadow-sm" style="width: 50px; height: 50px;">
                        <i class="bi bi-whatsapp"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="fw-bold mb-1">Telepon / WhatsApp</h6>
                        <p class="text-muted mb-0 small"><?= !empty($setting['telepon']) ? $setting['telepon'] : 'Belum diatur'; ?></p>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-4 p-3 rounded-4 bg-light shadow-sm">
                    <div class="bg-danger text-white rounded-circle d-flex justify-content-center align-items-center fs-4 shadow-sm" style="width: 50px; height: 50px;">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="fw-bold mb-1">Email</h6>
                        <p class="text-muted mb-0 small"><?= !empty($setting['email']) ? $setting['email'] : 'Belum diatur'; ?></p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7" data-aos="fade-left">
                <div class="glass-card p-4 p-md-5 rounded-4 shadow-sm bg-white border">
                    <h4 class="fw-bold mb-4">Kirim Pesan</h4>

                    <form action="<?= base_url('kirim-pesan'); ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Nama Lengkap</label>
                                <input type="text" name="name" required class="form-control rounded-3 py-2" placeholder="Masukkan nama Anda">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Email</label>
                                <input type="email" name="email" required class="form-control rounded-3 py-2" placeholder="nama@email.com">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-medium">Subjek</label>
                                <input type="text" name="subject" required class="form-control rounded-3 py-2" placeholder="Topik pesan">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-medium">Pesan</label>
                                <textarea name="message" required class="form-control rounded-3" rows="5" placeholder="Tulis pesan Anda di sini..."></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary-custom w-100 py-3 rounded-pill fw-bold">
                                    Kirim Pesan Sekarang <i class="bi bi-send ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <?php if (!empty($setting['maps'])): ?>
                <div class="col-12 mt-5 pt-3" data-aos="fade-up">
                    <h4 class="fw-bold mb-4 text-center">Lokasi Kami</h4>
                    <div class="map-container rounded-4 overflow-hidden shadow-sm border">
                        <?= $setting['maps']; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<style>
    .map-container iframe {
        width: 100% !important;
        height: 450px !important;
        border: 0;
        display: block;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script>
    <?php if (session()->getFlashdata('pesan_sukses')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= session()->getFlashdata('pesan_sukses'); ?>',
            confirmButtonColor: '#4F46E5',
            timer: 4000
        });
    <?php endif; ?>
</script>
<?= $this->endSection(); ?>