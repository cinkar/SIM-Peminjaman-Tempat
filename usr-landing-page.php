<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpaceConnect – Reservasi Fasilitas Publik</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/usr-landing-page.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>

<?php include 'components/navbar.php'; ?>

<!-- <div id="navbar"></div> -->

<!-- ========== HERO SECTION ========== -->
<section class="central-container text-center mt-4">

    <div id="heroCarousel" class="carousel slide carousel-fade hero-carousel mx-auto" data-bs-ride="carousel">

        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner">

            <div class="carousel-item active">
                <img src="img/tebet-eco-park.jpg" class="hero-img" alt="Tebet Eco Park">
                <div class="hero-caption">
                    <h2>Tebet Eco Park</h2>
                    <p>Taman kota dengan ruang hijau luas untuk aktivitas publik.</p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="img/hutan-kota-senayan.jpg" class="hero-img" alt="Hutan Kota Senayan">
                <div class="hero-caption">
                    <h2>Hutan Kota Senayan</h2>
                    <p>Area rekreasi populer untuk olahraga dan kegiatan komunitas.</p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="img/ragunan.jpg" class="hero-img" alt="Ragunan">
                <div class="hero-caption">
                    <h2>Kebun Binatang Ragunan</h2>
                    <p>Destinasi wisata keluarga dan ruang publik terbuka.</p>
                </div>
            </div>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

    </div>

    <!-- CTA BUTTONS BELOW HERO -->
    <div class="cta-buttons mt-4">
        <a href="#fasilitas" class="btn big-btn-green me-3 px-5 py-3">Reservasi Fasilitas</a>
        <a href="#fasilitas-disabilitas" class="btn big-btn-outline-green px-5 py-3">Fasilitas Disabilitas</a>
    </div>

    <!-- TITLE + DESCRIPTION -->
    <h1 class="fw-bold mt-4 title-green">SpaceConnect</h1>

    <p class="intro-text mt-2">
        Sistem reservasi fasilitas publik dan layanan disabilitas yang mempermudah masyarakat 
        dalam melihat ketersediaan tempat, melakukan peminjaman, serta menemukan fasilitas ramah 
        disabilitas secara cepat, transparan, dan real-time.
    </p>
</section>


<!-- ========== PREVIEW FASILITAS ========== -->
<section id="fasilitas" class="central-container mt-5">
    <h3 class="text-center fw-bold mb-4 title-green">Daftar Fasilitas Publik</h3>

    <div class="row g-4 justify-content-center">

        <!-- CARD 1 -->
        <div class="col-md-4 col-sm-6">
            <div class="place-card shadow-sm">
                <div class="card-img-wrap">
                    <img src="img/hutan-kota-senayan.jpg">
                </div>
                <div class="card-body text-center p-3">
                    <h5 class="fw-semibold">Hutan Kota Senayan</h5>
                    <p>Tempat favorit untuk olahraga dan rekreasi publik.</p>
                    <a href="/SIM-PEMINJAMAN-TEMPAT/usr-detail-fasilitas.html" class="btn btn-green w-100 mt-auto">Lihat Detail</a>
                </div>
            </div>
        </div>

        <!-- CARD 2 -->
        <div class="col-md-4 col-sm-6">
            <div class="place-card shadow-sm">
                <div class="card-img-wrap">
                    <img src="img/tebet-eco-park.jpg">
                </div>
                <div class="card-body text-center p-3">
                    <h5 class="fw-semibold">Tebet Eco Park</h5>
                    <p>Ruang publik hijau untuk aktivitas keluarga.</p>
                    <a href="/SIM-PEMINJAMAN-TEMPAT/usr-detail-fasilitas.html" class="btn btn-green w-100 mt-auto">Lihat Detail</a>
                </div>
            </div>
        </div>

        <!-- CARD 3 -->
        <div class="col-md-4 col-sm-6">
            <div class="place-card shadow-sm">
                <div class="card-img-wrap">
                    <img src="img/ragunan.jpg">
                </div>
                <div class="card-body text-center p-3">
                    <h5 class="fw-semibold">Ragunan</h5>
                    <p>Area besar untuk wisata dan kegiatan komunitas.</p>
                    <a href="/SIM-PEMINJAMAN-TEMPAT/usr-detail-fasilitas.html" class="btn btn-green w-100 mt-auto">Lihat Detail</a>
                </div>
            </div>
        </div>

    </div>

    <div class="text-center mt-4">
        <a href="usr-daftar-fasilitas.html" class="see-more">Lihat Semua Fasilitas</a>
    </div>
</section>

<!-- PREVIEW FASILITAS DISABILITAS -->
<section id="fasilitas-disabilitas" class="central-container mt-4 mb-5">
    <h3 class="text-center fw-bold mb-4 title-green">Daftar Fasilitas Disabilitas</h3>

    <div class="row g-3">

        <!-- ITEM 1 -->
        <div class="col-md-4 col-sm-6">
            <div class="dis-card shadow-sm rounded p-3">
                <div class="card-img-wrap">
                    <img src="img/tebet-eco-park.jpg" alt="Jalur Landai">
                </div>
                <h5 class="fw-bold mt-3">Jalur Landai</h5>
                <p class="desc">Akses landai ramah kursi roda untuk memudahkan mobilitas pengguna.</p>

                <p class="location"><strong>Lokasi:</strong> Tebet Eco Park, Hutan Kota Senayan</p>

                <a href="/SIM-Peminjaman-Tempat/usr-detail-fasilitas-disabilitas.html" class="btn btn-green w-100 mt-auto">Lihat Detail</a>
            </div>
        </div>

        <!-- ITEM 2 -->
        <div class="col-md-4 col-sm-6">
            <div class="dis-card shadow-sm rounded p-3">
                <div class="card-img-wrap">
                    <img src="img/hutan-kota-senayan.jpg" alt="Toilet Khusus Disabilitas">
                </div>
                <h5 class="fw-bold mt-3">Toilet Khusus Disabilitas</h5>
                <p class="desc">Dilengkapi pegangan tangan, ruang luas, dan akses mudah.</p>

                <p class="location"><strong>Lokasi:</strong> Area umum & titik utama taman kota</p>

                <a href="/SIM-Peminjaman-Tempat/usr-detail-fasilitas-disabilitas.html" class="btn btn-green w-100 mt-auto">Lihat Detail</a>
            </div>
        </div>

        <!-- ITEM 3 -->
        <div class="col-md-4 col-sm-6">
            <div class="dis-card shadow-sm rounded p-3">
                <div class="card-img-wrap">
                    <img src="img/gbk.jpg" alt="Guiding Block">
                </div>
                <h5 class="fw-bold mt-3">Guiding Block</h5>
                <p class="desc">Jalur pemandu bagi pengguna tunanetra agar lebih mudah bernavigasi.</p>

                <p class="location"><strong>Lokasi:</strong> Jalur pedestrian & ruang publik utama</p>

                <a href="/SIM-Peminjaman-Tempat/usr-detail-fasilitas-disabilitas.html" class="btn btn-green w-100 mt-auto">Lihat Detail</a>
            </div>
        </div>
    </div>
</section>

<footer class="footer-green mt-5">
    <p class="m-0 text-white text-center py-3">© 2025 SpaceConnect</p>
</footer>

    <script>
        fetch("components/navbar.php")
            .then(res => res.text())
            .then(data => {
                document.getElementById("navbar").innerHTML = data;
            });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
