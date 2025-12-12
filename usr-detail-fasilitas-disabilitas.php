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
        $query = "SELECT * FROM fasilitasdifabel WHERE id = $id";
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
    <title>Detail Fasilitas Disabilitas – SpaceConnect</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/usr-detail-fasilitas-disabilitas.css">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="navbar.css">
</head>

<body>

    <!-- NAVBAR -->
    <?php include 'components/navbar.php'; ?>

    <!-- HEADER -->
    <section class="central-container mt-5 text-center">
        <h2 class="fw-bold title-green">Detail Fasilitas Disabilitas</h2>
        <p class="intro-text mt-2">
            Informasi lengkap mengenai fasilitas ramah disabilitas untuk membantu aksesibilitas di ruang publik.
        </p>
    </section>

    <!-- CONTENT -->
    <?php if ($row): ?>
    <section class="central-container mt-4 mb-5">
        <div class="row g-4 align-items-start">
            <!-- LEFT: IMAGE -->
            <div class="col-lg-6">
                <div class="img-card shadow-sm rounded">
                    <img src="php/show-img-difabel.php?id=<?php echo $row['id']; ?>" alt="Gambar Fasilitas">
                </div>
            </div>

            <!-- RIGHT: DETAIL -->
            <div class="col-lg-6">
                    <div class="detail-card shadow-sm rounded p-4">

                        <h3 class="fw-bold">
                            <?php echo htmlspecialchars($row['namaFasilitas']); ?>
                        </h3>
                        <p class="desc">
                            <?php echo htmlspecialchars($row['deskripsiFasilitas']); ?>
                        </p>

                        <div class="detail-info mt-3">
                            <p><strong class="label">Ketersediaan:</strong><span class="status-available">Tersedia</span>
                            </p>
                            <p><strong class="label">Lokasi Tersedia:</strong></p>
                            <ul>
                                <li>
                                    <?php echo htmlspecialchars($row['lokasiFasilitas']); ?>
                                </li>
                                
                            </ul>
                        </div>

                        <a href="usr-peta-lokasi.html" class="btn btn-green w-100 mt-3 py-2">Lihat Lokasi di Peta</a>

                    </div>
            </div>
        </div>
    </section>
    <?php else: ?>
    <p>Data fasilitas tidak ditemukan.</p>
    <?php endif; ?>

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