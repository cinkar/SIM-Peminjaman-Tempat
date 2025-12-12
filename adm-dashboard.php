<?php
    require 'php/koneksi.php';

    // Menghitung total reservasi masuk
    $query = "SELECT COUNT(*) AS total FROM pengajuanreservasi";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    $totalReservasi = $data['total'];

    // Menghitung total reservasi yang disetujui
    $queryApproved = "SELECT COUNT(*) AS totalApproved FROM reservasi";
    $resultApproved = mysqli_query($conn, $queryApproved);  
    $dataApproved = mysqli_fetch_assoc($resultApproved);

    $totalApproved = $dataApproved['totalApproved'];

    // Jumlah fasilitas tempat
    $query_fasilitas = "SELECT COUNT(*) AS totalFasilitas FROM tempat";
    $result_fasilitas = mysqli_query($conn, $query_fasilitas);
    $data_fasilitas = mysqli_fetch_assoc($result_fasilitas);
    $totalFasilitas = $data_fasilitas['totalFasilitas'];

    // Jumlah fasilitas disabilitas
    $query_disabilitas = "SELECT COUNT(*) AS totalDisabilitas FROM fasilitasdifabel";
    $result_disabilitas = mysqli_query($conn, $query_disabilitas);  
    $data_disabilitas = mysqli_fetch_assoc($result_disabilitas);
    $totalDisabilitas = $data_disabilitas['totalDisabilitas'];

    // Jumlah user
    $query_user = "SELECT COUNT(*) AS totalUser FROM user";
    $result_user = mysqli_query($conn, $query_user);
    $data_user = mysqli_fetch_assoc($result_user);
    $totalUser = $data_user['totalUser'];

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <link rel="stylesheet" href="css/adm-dashboard.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="admin-dashboard.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>

    <div class="d-flex">

        <div id="sidebar"></div>

        <!-- MAIN CONTENT -->
        <div class="content flex-grow-1">

            <!-- TOP NAVBAR -->
            <nav class="topbar d-flex justify-content-between align-items-center">
                <h5 class="m-0">Dashboard Admin</h5>
                <div class="d-flex align-items-center">
                    <span class="me-3">Admin</span>
                    <a href="SIM-Peminjaman_Tempat/php/logout.php"><button class="btn btn-primary btn-sm">Logout</button></a>
                    
                </div>
            </nav>

            <!-- STATISTICS -->
            <div class="container mt-4">

                <div class="row g-3 mb-4">
                    <div class="col-lg-6 col-md-8">
                        <div class="card stat-card">
                            <h6>Reservasi Menunggu:</h6>
                            <h2>
                                <?php echo $totalReservasi; ?>
                            </h2>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-8">
                        <div class="card stat-card">
                            <h6>Disetujui</h6>
                            <h2><?php echo $totalApproved ?></h2>
                        </div>
                    </div>

                </div>

                <div class="row g-3 mb-4">
                    <div class="col-lg-6 col-md-8">
                        <div class="card stat-card">
                            <h6>Jumlah Fasilitas Tempat:</h6>
                            <h2>
                                <?php echo $totalFasilitas; ?>
                            </h2>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-8">
                        <div class="card stat-card">
                            <h6>Jumlah Fasilitas Disabilitas</h6>
                            <h2><?php echo $totalDisabilitas ?></h2>
                        </div>
                    </div>

                </div>

                <div class="row g-3 mb-4">
                    <div class="col-lg-6 col-md-8">
                        <div class="card stat-card">
                            <h6>Jumlah User:</h6>
                            <h2>
                                <?php echo $totalUser; ?>
                            </h2>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>


    <script>
        fetch("adm-sidebar.html")
            .then(res => res.text())
            .then(data => {
                document.getElementById("sidebar").innerHTML = data;
            });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
