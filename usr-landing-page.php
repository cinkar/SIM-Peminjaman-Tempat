<?php
session_start();

// Koneksi database untuk mengambil data fasilitas
require 'php/koneksi.php';

// Query untuk mengambil 3 fasilitas pertama
$query = "SELECT * FROM tempat LIMIT 3";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}

// Query untuk mengambil 3 fasilitas disabilitas pertama
$query_difabel = "SELECT * FROM fasilitasdifabel LIMIT 3";
$result_difabel = mysqli_query($conn, $query_difabel);

if (!$result_difabel) {
    die("Query gagal: " . mysqli_error($conn));
}
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

        <?php
        // Loop untuk menampilkan data fasilitas dari database
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <!-- CARD FASILITAS DINAMIS -->
        <div class="col-md-4 col-sm-6">
            <div class="place-card shadow-sm">
                <div class="card-img-wrap">
                    <img src="php/show-img-tempat.php?id=<?php echo $row['id']; ?>" alt="<?php echo htmlspecialchars($row['namaTempat']); ?>">
                </div>
                <div class="card-body text-center p-3">
                    <h5 class="fw-semibold"><?php echo htmlspecialchars($row['namaTempat']); ?></h5>
                    <p><?php echo htmlspecialchars($row['deskripsiTempat']); ?></p>
                    <a href="/SIM-PEMINJAMAN-TEMPAT/usr-detail-fasilitas.php?id=<?php echo $row['id']; ?>" class="btn btn-green w-100 mt-auto">Lihat Detail</a>
                </div>
            </div>
        </div>
        <?php
            }
        } else {
            echo '<p class="text-center">Belum ada data fasilitas.</p>';
        }
        ?>


    </div>

    <div class="text-center mt-4">
        <a href="/SIM-PEMINJAMAN-TEMPAT/usr-daftar-fasilitas.php" class="see-more">Lihat Semua Fasilitas</a>
    </div>
</section>

<!-- PREVIEW FASILITAS DISABILITAS -->
<section id="fasilitas-disabilitas" class="central-container mt-4 mb-5">
    <h3 class="text-center fw-bold mb-4 title-green">Daftar Fasilitas Disabilitas</h3>

    <div class="row g-3">

        <?php
        // Loop untuk menampilkan data fasilitas disabilitas dari database
        if (mysqli_num_rows($result_difabel) > 0) {
            while ($row_difabel = mysqli_fetch_assoc($result_difabel)) {
        ?>
        <!-- CARD FASILITAS DISABILITAS DINAMIS -->
        <div class="col-md-4 col-sm-6">
            <div class="dis-card shadow-sm rounded p-3">
                <div class="card-img-wrap">
                    <img src="php/show-img-difabel.php?id=<?php echo $row_difabel['id']; ?>" alt="<?php echo htmlspecialchars($row_difabel['namaFasilitas']); ?>">
                </div>
                <h5 class="fw-bold mt-3"><?php echo htmlspecialchars($row_difabel['namaFasilitas']); ?></h5>
                <p class="desc"><?php echo htmlspecialchars($row_difabel['deskripsiFasilitas']); ?></p>

                <p class="location"><strong>Lokasi:</strong> <?php echo htmlspecialchars($row_difabel['lokasiFasilitas']); ?></p>

                <a href="/SIM-PEMINJAMAN-TEMPAT/usr-detail-fasilitas-disabilitas.php?id=<?php echo $row_difabel['id']; ?>" class="btn btn-green w-100 mt-auto">Lihat Detail</a>
            </div>
        </div>
        <?php
            }
        } else {
            echo '<p class="text-center">Belum ada data fasilitas disabilitas.</p>';
        }
        ?>
    </div>

    <div class="text-center mt-4">
        <a href="/SIM-PEMINJAMAN-TEMPAT/usr-fasilitas-disabilitas.php" class="see-more">Lihat Semua Fasilitas Disabilitas</a>
    </div>
</section>

<section class="mt-5">
    <div class="join-mitra d-flex justify-content-center align-items-center flex-wrap">
        <p style="color: green;">Join sebagai Mitra Kami dan Tingkatkan Visibilitas Fasilitas Anda!</p>
        <a class="btn btn-success ms-3" href="/SIM-Peminjaman-Tempat/mitra-register.html">Daftar Mitra</a>
        <a href="/SIM-Peminjaman-Tempat/mitra-login.php" class="btn btn-success ms-3">Masuk Sebagai Mitra</a>
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
