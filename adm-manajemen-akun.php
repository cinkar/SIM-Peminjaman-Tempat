<?php
    require 'php/koneksi.php';

    session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: login.html");
        exit;
    }

    // Ambil data user dari session
    $username = $_SESSION['username'];

    $query = "SELECT * FROM user";
    $stmt = mysqli_prepare($conn, $query);
                        
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Query gagal: " . mysqli_error($conn));
    }
?>
    
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Akun User</title>
    
    <link rel="stylesheet" href="css/adm-manajemen-akun.css">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="manajemen-akun-user.css">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>

<div class="d-flex">

    <!-- SIDEBAR -->
    <div id="sidebar"></div>

    <!-- MAIN CONTENT -->
    <div class="content flex-grow-1">

        <!-- TOPBAR -->
        <nav class="topbar d-flex justify-content-between align-items-center">
            <h5 class="m-0">Manajemen Akun User</h5>
            <a href="SIM-Peminjaman_Tempat/php/logout.php"><button class="btn btn-primary btn-sm">Logout</button></a>
        </nav>

        <div class="container mt-4">

        <!-- TITLE -->
        <h5 class="fw-semibold mb-3">Daftar User</h5>

        <!-- TABLE -->
         <div class="card p-3">
                <div class="table-responsive">
                    <?php
                        $username = $_SESSION['username'];

                        $query = "SELECT * FROM reservasi";
                        $stmt = mysqli_prepare($conn, $query);
                        
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        if (!$result) {
                            die("Query gagal: " . mysqli_error($conn));
                        }
                    ?>
                    <table class="table align-middle text-center">
                        <thead>
                            <tr>
                                <th>Nama User</th>
                                <th>Nomor Ponsel</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td>
                                    <?php echo htmlspecialchars($row['username']); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($row['phone']); ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>

                    </table>
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
