<?php
  require 'php/koneksi.php';

  session_start();
  if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
      header("Location: login.html");
      exit;
  }

  // Ambil data user dari session
  $username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="navbar.css">
</head>
<body>

    <!-- Navbar -->
    <?php include 'components/navbar.php'; ?>

    <!-- Profile Header -->
    <div class="container mt-4">
        <div class="card mb-4 shadow-sm">
        <div class="card-body d-flex align-items-center">
            <img src="img/logo.png" alt="logo" class="rounded-circle me-3" style="width: 50px; height: 50px;">
            <div>
            <h4 class="card-title mb-1"><?php echo htmlspecialchars($username); ?></h4>
            </div>
        </div>
    </div>

    <!-- Tab Menu -->
    <ul class="nav nav-tabs mb-3" id="profileTab" role="tablist">

      <li class="nav-item" role="presentation">
        <button class="nav-link " id="statusReservasi-tab" data-bs-toggle="tab" data-bs-target="#statusReservasi" type="button" role="tab">
          Status Reservasi
        </button>
      </li>
    
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="riwayatReservasi-tab" data-bs-toggle="tab" data-bs-target="#riwayatReservasi" type="button" role="tab">Riwayat Reservasi</button>
      </li>
      
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="profileTabContent">

        <!-- Status Reservasi -->
         <div class="tab-pane fade " id="statusReservasi" role="tabpanel">
          <?php
            $username = $_SESSION['username'];

            $query = "SELECT * FROM pengajuanreservasi WHERE username = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (!$result) {
                die("Query gagal: " . mysqli_error($conn));
            }
          ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th>Fasilitas</th>
                    <th>Waktu & Tanggal Mulai</th>
                    <th>Waktu & Tanggal Selesai</th>
                    <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                  <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                      <td>
                        <?php echo htmlspecialchars($row['namaTempat']); ?>
                      </td>
                    <td>
                      <?php echo htmlspecialchars($row['waktuMulai']); ?> <?php echo htmlspecialchars($row['tanggalMulai']); ?>
                    </td>
                    <td>
                      <?php echo htmlspecialchars($row['waktuSelesai']); ?>
                      <?php echo htmlspecialchars($row['tanggalSelesai']); ?>
                    </td>
                    <td><span class="badge bg-warning">Menunggu</span></td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
            </table>
        </div>


        <!-- Riwayat Reservasi -->
        <div class="tab-pane fade" id="riwayatReservasi" role="tabpanel">
          <?php
            $username = $_SESSION['username'];
            // Ambil semua data dari tabel tempat
            $query = "SELECT * FROM reservasi WHERE username = '$username'";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                die("Query gagal: " . mysqli_error($conn));
            }
          ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th>Fasilitas</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                      <td>
                        <?php echo htmlspecialchars($row['namaTempat']); ?>
                      </td>
                    <td>
                      <?php echo htmlspecialchars($row['waktuMulai']); ?> <?php echo htmlspecialchars($row['tanggalMulai']); ?>
                    </td>
                    <td>
                      <?php echo htmlspecialchars($row['waktuSelesai']); ?>
                      <?php echo htmlspecialchars($row['tanggalSelesai']); ?>
                    </td>
                    <td><span class="badge bg-warning">Menunggu</span></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    </div>
  </div>

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
