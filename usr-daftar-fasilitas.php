<?php
    session_start();

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: login.html");
        exit;
    }
    
    require 'php/koneksi.php';

    // Ambil semua data dari tabel tempat
    $query = "SELECT * FROM tempat";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query gagal: " . mysqli_error($conn));
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Fasilitas Publik</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/usr-daftar-fasilitas.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="navbar.css">
</head>

<body>

<!-- NAVBAR -->
<?php include 'components/navbar.php'; ?>

<!-- TITLE SECTION -->
<section class="central-container text-center mt-5">
    <h2 class="fw-bold title-green">Daftar Fasilitas Publik</h2>
    <p class="intro-text mt-2 mb-4">
        Temukan fasilitas publik yang dapat digunakan untuk aktivitas Anda. 
        Lihat detail, kapasitas, dan status ketersediaan tempat.
    </p>
</section>

<!-- LIST FASILITAS -->
<section class="central-container">
    <div class="row g-4 justify-content-center">
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <!-- CARD -->
            <div class="col-md-4 col-sm-6">
                    <div class="place-card">
                        <div class="card-img-wrap">
                            <img src="php/show-img-tempat.php?id=<?php echo $row['id']; ?>" alt="Foto Tempat">
                        </div>

                        <div class="place-info">
                            <h5 class="place-title"><?php echo htmlspecialchars($row['namaTempat']); ?></h5>
                            <p class="place-desc"><?php echo htmlspecialchars($row['deskripsiTempat']); ?></p>

                            <p class="place-meta"><strong>Kapasitas:</strong> <?php echo htmlspecialchars($row['kapasitas']); ?></p>
                            <p class="place-meta"><strong>Lokasi:</strong> <?php echo htmlspecialchars($row['lokasi']); ?></p>
                            <p class="place-meta"><strong>Jam Operasional:</strong> <?php echo htmlspecialchars($row['jamOperasi']); ?></p>

                            <!-- contoh status, bisa disesuaikan -->
                            <p class="status-available">Tersedia</p>

                            <a href="usr-detail-fasilitas.php?id=<?php echo $row['id']; ?>" class="btn btn-green w-100 mt-2">Lihat Detail</a>
                        </div>
                    </div>
            </div>
         <?php endwhile; ?>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer-green mt-5">
    <p class="m-0 text-white text-center py-3">© 2025 SpaceConnect</p>
</footer>

<script>
fetch("components/navbar.php")
    .then(res => res.text())
    .then(html => document.getElementById("navbar").innerHTML = html);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
