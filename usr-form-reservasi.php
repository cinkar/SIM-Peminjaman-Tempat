<?php
    require 'php/koneksi.php';

    session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: login.php");
        exit;
    }

    // Ambil data user dari session
    $username = $_SESSION['username'];

    $username = $_SESSION['username'];
    $namaMitra = "";
    $namaTempat = "";
    $deskripsiKeperluan = "";
    $tanggalMulai = "";
    $tanggalSelesai = "";
    $waktuMulai = "";
    $waktuSelesai = "";
    $jumlahPeserta = "";
    $phone = "";
    $catatanTambahan = "";

    $username = $_SESSION['username'];

    // --- SIMPAN DATA RESERVASI ---
    if(isset($_POST['simpan'])){
        $idTempat = $_POST['idTempat'];

        // Ambil namaTempat & namaMitra otomatis
        $qTempat = mysqli_prepare($conn, "SELECT namaTempat, namaMitra FROM tempat WHERE id = ?");
        mysqli_stmt_bind_param($qTempat, "i", $idTempat);
        mysqli_stmt_execute($qTempat);
        $resultTempat = mysqli_stmt_get_result($qTempat);
        $dataTempat = mysqli_fetch_assoc($resultTempat);

        if (!$dataTempat) {
            die("Tempat tidak ditemukan");
        }

        $namaTempat = $dataTempat['namaTempat'];
        $namaMitra  = $dataTempat['namaMitra'];
        $deskripsiKeperluan = $_POST['deskripsiKeperluan'];
        $tanggalMulai = $_POST['tanggalMulai']; 
        $tanggalSelesai = $_POST['tanggalSelesai'];
        $waktuMulai = $_POST['waktuMulai'];
        $waktuSelesai = $_POST['waktuSelesai'];
        $jumlahPeserta = $_POST['jumlahPeserta'];
        $phone = $_POST['phone'];
        $catatanTambahan = $_POST['catatanTambahan'];

        $query_sql = "INSERT INTO pengajuanreservasi (username, namaTempat, namaMitra, tanggalMulai, tanggalSelesai, waktuMulai, waktuSelesai, jumlahPeserta, deskripsiKeperluan, phone, catatanTambahan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; 

        $stmt = mysqli_prepare($conn, $query_sql);
        mysqli_stmt_bind_param($stmt, "sssssssssss", 
            $username,
            $namaTempat,
            $namaMitra,
            $tanggalMulai, 
            $tanggalSelesai,
            $waktuMulai,
            $waktuSelesai,
            $jumlahPeserta,
            $deskripsiKeperluan,
            $phone,
            $catatanTambahan
        );

        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../SIM-Peminjaman-Tempat/profile-user.php");
            exit;
        } else {
            echo "Error: " . $query_sql . "<br>" . mysqli_error($conn);
        }
    }

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Reservasi – SpaceConnect</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="css/usr-form-reservasi.css">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="navbar.css">
</head>

<body>

<!-- NAVBAR -->
<?php include 'components/navbar.php'; ?>

<!-- TITLE -->
<section class="central-container text-center mt-5">
    <h2 class="fw-bold title-green">Form Reservasi Fasilitas</h2>
    <p class="intro-text mt-2">
        Isi data reservasi Anda dengan lengkap agar proses peminjaman dapat diproses oleh admin.
    </p>
</section>

<!-- FORM RESERVASI -->
<section class="central-container mt-4 mb-5">
    <div class="reservation-card p-4 shadow-sm rounded">

        <form id="formReservasi" action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">


            <div class="row g-4">

                <!-- Nama Fasilitas -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Tempat</label>
                    <select name="idTempat" class="form-control" required>
                        <option value="">-- Pilih Tempat --</option>
                        <?php
                        $q = mysqli_query($conn, "SELECT id, namaTempat FROM tempat");
                        while ($t = mysqli_fetch_assoc($q)) {
                            echo "<option value='{$t['id']}'>{$t['namaTempat']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Keperluan -->
                <div class="col-md-6">
                    <label class="form-label label-green fw-semibold">Keperluan Kegiatan</label>
                    <input type="text" name="deskripsiKeperluan" class="form-control" id="deskripsiKeperluan" value="<?php echo $deskripsiKeperluan?>" placeholder="Contoh: Event Komunitas" required>
                </div>

                <!-- Tanggal Mulai -->
                <div class="col-md-6">
                    <label class="form-label label-green fw-semibold">Tanggal Mulai</label>
                    <input type="date" name="tanggalMulai" class="form-control" id="tanggalMulai" value="<?php echo $tanggalMulai ?>" required>
                </div>

                <!-- Tanggal Selesai -->
                <div class="col-md-6">
                    <label class="form-label label-green fw-semibold">Tanggal Selesai</label>
                    <input type="date" name="tanggalSelesai" class="form-control" id="tanggalSelesai" value="<?php echo $tanggalSelesai ?>" required>
                </div>

                <!-- Waktu Mulai -->
                <div class="col-md-6">
                    <label class="form-label label-green fw-semibold">Waktu Mulai</label>
                    <input type="time" name="waktuMulai" class="form-control" id="waktuMulai" value="<?php echo $waktuMulai ?>" required>
                </div>

                <!-- Waktu Selesai -->
                <div class="col-md-6">
                    <label class="form-label label-green fw-semibold">Waktu Selesai</label>
                    <input type="time" name="waktuSelesai" class="form-control" id="waktuSelesai" value="<?php echo $waktuSelesai ?>" required>
                </div>

                <!-- Jumlah Peserta -->
                <div class="col-md-6">
                    <label class="form-label label-green fw-semibold">Jumlah Peserta</label>
                    <input type="text" name="jumlahPeserta" class="form-control" id="jumlahPeserta" value="<?php echo $jumlahPeserta ?>" placeholder="Masukkan jumlah peserta" required>
                </div>

                <!-- Kontak (WA) -->
                <div class="col-md-6">
                    <label class="form-label label-green fw-semibold">Nomor WhatsApp</label>
                    <input type="text" name="phone" class="form-control" id="phone" value="<?php echo $phone ?>" placeholder="0812xxxxxx" required>
                </div>

                <!-- Catatan Tambahan -->
                <div class="col-12">
                    <label class="form-label label-green fw-semibold">Catatan Tambahan</label>
                    <textarea name="catatanTambahan" class="form-control" rows="3" id="catatanTambahan" placeholder="Catatan tambahan"><?php echo $catatanTambahan ?></textarea>
                </div>

                <!-- BUTTON -->
                <div class="col-12">
                    <button  type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">Ajukan Reservasi</button>
                </div>

            </div>

        </form>

    </div>
</section>

<!-- FOOTER -->
<footer class="footer-green mt-5">
    <p class="text-center text-white m-0 py-3">© 2025 SpaceConnect</p>
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
