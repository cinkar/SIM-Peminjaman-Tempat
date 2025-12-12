<?php
    session_start();

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: login.html");
        exit;
    }
    
    require 'php/koneksi.php';

    // Ambil semua data dari tabel tempat
    $query = "SELECT * FROM fasilitasdifabel";
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
    <title>Fasilitas Ramah Disabilitas – SpaceConnect</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/usr-fasilitas-disabilitas.css">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="navbar.css">
</head>

<body>

<!-- NAVBAR -->
<?php include 'components/navbar.php'; ?>

<!-- HEADER -->
<section class="central-container text-center mt-5">
    <h2 class="fw-bold title-green">Fasilitas Ramah Disabilitas</h2>
    <p class="intro-text mt-2">
        Informasi fasilitas yang mendukung aksesibilitas bagi penyandang disabilitas
        di berbagai ruang publik yang tersedia pada sistem SpaceConnect.
    </p>
</section>

<!-- LIST FASILITAS -->
<section class="central-container mt-4 mb-5">
    <div class="row g-4 justify-content-center">
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <!-- Card -->
            <div class="col-md-4 col-sm-6">
                <div class="place-card shadow-sm rounded p-3">
                    <div class="card img-wrap">
                        <img src="php/show-img-difabel.php?id=<?php echo $row['id']; ?>" alt="Foto Tempat">
                    </div>
                    <div class="place-card">
                        <h5 class="place-title">
                            <?php echo htmlspecialchars($row['namaFasilitas']); ?>
                        </h5>
                        <p class="place-desc">
                            <?php echo htmlspecialchars($row['deskripsiFasilitas']); ?>
                        </p>
                        <p class="place-meta">
                            <strong>Lokasi Fasilitas:</strong> <?php echo htmlspecialchars($row['lokasiFasilitas']); ?>
                        </p>
                        
                        <a href="/SIM-Peminjaman-Tempat/usr-detail-fasilitas-disabilitas.php?id=<?php echo $row['id']; ?>" class="btn btn-green w-100 mt-auto">Lihat Detail</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer-green mt-5">
    <p class="text-center text-white py-3 m-0">© 2025 SpaceConnect</p>
</footer>

<!-- LOAD NAVBAR -->
<script>
fetch("components/navbar.php")
    .then(res => res.text())
    .then(html => document.getElementById("navbar").innerHTML = html);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
