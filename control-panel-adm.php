<?php
    require 'php/koneksi.php';

    // Jumlah mitra
    $queryMitra = "SELECT COUNT(*) AS totalMitra FROM mitra";
    $resultMitra = mysqli_query($conn, $queryMitra);
    $dataMitra = mysqli_fetch_assoc($resultMitra);
    $totalMitra = $dataMitra['totalMitra'];

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
                            <h6>Jumlah Mitra:</h6>
                            <h2>
                                <?php echo $totalMitra; ?>
                            </h2>
                        </div>
                    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
