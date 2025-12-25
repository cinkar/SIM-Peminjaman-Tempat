<?php
    require 'php/koneksi.php';

    session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: login.html");
        exit;
    }

    // Ambil data mitra dari session
    $namaMitra = $_SESSION['namaMitra'];

    // SETUJUI = Simpan ke tabel reservasi, lalu hapus dari pengajuan
    if (isset($_GET['setujui'])) {
        $id = intval($_GET['setujui']);

        // 1. Ambil data dari tabel pengajuan
        $q = mysqli_query($conn, "SELECT * FROM pengajuanreservasi WHERE id = $id");
        $data = mysqli_fetch_assoc($q);

        if ($data) {
            // 2. Insert ke tabel reservasi
            $insert = mysqli_query($conn, "
                INSERT INTO reservasi 
                (username, namaMitra, namaTempat, deskripsiKeperluan, tanggalMulai, tanggalSelesai, waktuMulai, waktuSelesai, jumlahPeserta, phone, catatanTambahan)
                VALUES 
                (
                    '{$data['username']}',
                    '{$data['namaMitra']}',
                    '{$data['namaTempat']}',
                    '{$data['deskripsiKeperluan']}',
                    '{$data['tanggalMulai']}',
                    '{$data['tanggalSelesai']}',
                    '{$data['waktuMulai']}',
                    '{$data['waktuSelesai']}',
                    '{$data['jumlahPeserta']}',
                    '{$data['phone']}',
                    '{$data['catatanTambahan']}'
                )
            ");

            if ($insert) {
                // 3. Hapus dari pengajuan
                mysqli_query($conn, "DELETE FROM pengajuanreservasi WHERE id = $id");

                echo "<script>alert('Reservasi disetujui!'); window.location='adm-manajemen-reservasi.php';</script>";
                exit;
            }
        }
    }


    if (isset($_GET['op']) && $_GET['op'] == 'hapus' && isset($_GET['id'])) {

    $id = intval($_GET['id']);

    // Query hapus
    $query = "DELETE FROM pengajuanreservasi WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: adm-manajemen-reservasi.php?hapus=berhasil");
        exit;
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }

}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Reservasi</title>

    <link rel="stylesheet" href="css/adm-manajemen-reservasi.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="manajemen-reservasi.css">

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
            <h5 class="m-0">Manajemen Reservasi</h5>
            <a href="SIM-Peminjaman_Tempat/php/logout.php"><button class="btn btn-primary btn-sm">Logout</button></a>
        </nav>

        <div class="container mt-4">

            <!-- TITLE -->
            <h5 class="fw-semibold mb-3">Daftar Reservasi Masuk</h5>

            <!-- TABLE -->
            <div class="card p-3">
                <div class="table-responsive">
                    <?php
                        $namaMitra = $_SESSION['namaMitra'];

                        $query = "SELECT * FROM pengajuanreservasi WHERE namaMitra = '$namaMitra'";
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
                                <th>Fasilitas</th>
                                <th>Waktu & Tanggal Mulai</th>
                                <th>Waktu & Tanggal Selesai</th>
                                <th>Setujui</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td>
                                    <?php echo htmlspecialchars($row['username']); ?>
                                </td>
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
                                <td>
                                    <a href="adm-manajemen-reservasi.php?setujui=<?php echo $row['id']; ?>" 
                                    class="btn btn-success btn-sm">
                                        Setujui
                                    </a>


                                </td>
                                <td>
                                    <a href="adm-manajemen-reservasi.php?op=hapus&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- MODAL DETAIL RESERVASI -->
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Detail Reservasi</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">Nama User</label>
                        <input class="form-control" value="Andi Saputra" disabled>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">Nama Fasilitas</label>
                        <input class="form-control" value="Ruang Rapat 1" disabled>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">Tanggal Mulai</label>
                        <input class="form-control" value="10 Jan 2025" disabled>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">Tanggal Selesai</label>
                        <input class="form-control" value="11 Jan 2025" disabled>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="fw-semibold">Keperluan</label>
                        <textarea class="form-control" rows="3" disabled>Rapat koordinasi bulanan.</textarea>
                    </div>

                    <!-- CATATAN ADMIN -->
                    <div class="col-12 mb-3">
                        <label class="fw-semibold">Catatan Admin (Opsional)</label>
                        <textarea class="form-control" rows="3" placeholder="Tambahkan catatan jika perlu..."></textarea>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-danger">Tolak</button>
                <button class="btn btn-success">Setujui</button>
            </div>

        </div>
    </div>
</div>


    <script>
        fetch("adm-sidebar.php")
            .then(res => res.text())
            .then(data => {
                document.getElementById("sidebar").innerHTML = data;
            });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
