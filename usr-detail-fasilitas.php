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

    
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']); // ambil ID dari URL
        $query = "SELECT * FROM tempat WHERE id = $id";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            // sekarang $row berisi data yang sesuai ID
        } else {
            echo "Data tidak ditemukan.";
            exit;
        }
    } else {
        echo "ID tidak dikirim.";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Fasilitas – SpaceConnect</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="css/usr-detail-fasilitas.css">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="navbar.css">
</head>

<body>

<!-- NAVBAR -->
<?php include 'components/navbar.php'; ?>

<!-- HEADER TITLE -->
<section class="central-container mt-4">
    <h2 class="fw-bold title-green text-center">Detail Fasilitas Ruangan</h2>
</section>

<!-- DETAIL CONTENT -->
<?php if ($row): ?>
<section class="central-container mt-4">
    <div class="row g-4">

        <!-- LEFT: IMAGE -->
        <div class="col-lg-6">
            <div class="detail-img-wrap shadow-sm">
                <img src="php/show-img-tempat.php?id=<?php echo $row['id']; ?>" alt="Foto Tempat">
            </div>
        </div>

        <!-- RIGHT: INFORMATION -->
        <div class="col-lg-6">
            <div class="detail-info p-4 shadow-sm rounded">

                <h3 class="fw-bold mb-2"><?php echo htmlspecialchars($row['namaTempat']); ?></h3>
                <p class="text-muted">
                    <?php echo htmlspecialchars($row['deskripsiTempat']); ?>
                </p>

                <div class="mt-3">
                    <p><strong class="label">Kapasitas:</strong></strong> <?php echo htmlspecialchars($row['kapasitas']); ?></p>
                    <p><strong class="label">Lokasi:</strong> <?php echo htmlspecialchars($row['lokasi']); ?></p>
                    <p>
                        <strong class="label">Jam Operasional:</strong>
                        <?php echo htmlspecialchars($row['jamOperasi']); ?>
                    </p>
                    <p><strong class="label">Status:</strong> 
                        <span class="status-available">Tersedia</span>
                    </p>
                </div>

                <!-- CTA BUTTON -->
                <a href="usr-form-reservasi.php" class="btn btn-green w-100 mt-3 py-2">
                    Reservasi Sekarang
                </a>

            </div>
        </div>
    </div>
</section>
<?php else: ?>
<p>Data fasilitas tidak ditemukan.</p>
<?php endif; ?>

<!-- JADWAL SECTION -->
<section class="central-container mt-5 mb-5">
    <h4 class="fw-semibold title-green mb-3">Jadwal Ketersediaan</h4>

    <div class="schedule-box shadow-sm p-4 rounded">
        <p class="text-muted">Lihat tanggal yang tersedia sebelum melakukan reservasi.</p>

        <a href="/SIM-PEMINJAMAN-TEMPAT/kalender-tempat.php" class="btn btn-green px-4 py-2">
            Lihat Kalender
        </a>
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
