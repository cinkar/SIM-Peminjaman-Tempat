<?php
    
    require 'php/koneksi.php';

    session_start();

    if (!isset($_SESSION['namaMitra'])) {
        header("Location: mitra-login.php");
        exit;
    }

    $namaMitra = $_SESSION['namaMitra'];

    $namaTempat = '';
    $deskripsiTempat = '';
    $kapasitas = '';        
    $lokasi = '';
    $jamOperasi = '';
    $foto = '';

    // --- EDIT ---
    if(isset($_GET['op']) && $_GET['op'] == 'edit' && isset($_GET['id'])){
        $id = $_GET['id'];
        $stmt = mysqli_prepare($conn, "SELECT * FROM tempat WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result_edit = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result_edit);

        if($data){
            $namaMitra = $data['namaMitra'] ?? '';
            $namaTempat = $data['namaTempat'] ?? '';
            $deskripsiTempat = $data['deskripsiTempat'] ?? '';    
            $kapasitas = $data['kapasitas'] ?? '';        
            $lokasi = $data['lokasi'] ?? '';
            $jamOperasi = $data['jamOperasi'] ?? '';
        }

        mysqli_stmt_close($stmt);
    }

    // --- DELETE ---
    if(isset($_GET['op']) && $_GET['op'] == 'hapus' && isset($_GET['id'])){
        $id = $_GET['id'];
        $stmt = mysqli_prepare($conn, "DELETE FROM tempat WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);

        if(mysqli_stmt_execute($stmt)){
            $sukses = "Data berhasil dihapus";
        } else {
            $error = "Gagal menghapus data: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    }

    // --- SIMPAN (CREATE &  UPDATE) ---
    if(isset($_POST['simpan'])){
        $namaMitra = $_POST['namaMitra'];
        $namaTempat = $_POST['namaTempat'];
        $deskripsiTempat = $_POST['deskripsiTempat'];    
        $kapasitas = $_POST['kapasitas'];        
        $lokasi = $_POST['lokasi'];
        $jamOperasi = $_POST['jamOperasi'];   

        // Cek apakah mode edit (ada hidden field id)
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $id = $_POST['id'];

            $foto = isset($_FILES['foto']['tmp_name']) ? file_get_contents($_FILES['foto']['tmp_name']) : null;

            // Jika ada foto baru diupload
            if(isset($_FILES['foto']) && $_FILES['foto']['tmp_name'] != ""){
                $foto = file_get_contents($_FILES['foto']['tmp_name']);
                $stmt = mysqli_prepare($conn, "UPDATE tempat SET namaTempat=?, deskripsiTempat=?, kapasitas=?, lokasi=?, jamOperasi=?, foto=? WHERE id=?");
                mysqli_stmt_bind_param($stmt, "sssssbi", $namaTempat, $deskripsiTempat, $kapasitas, $lokasi, $jamOperasi, $foto, $id);
                mysqli_stmt_send_long_data($stmt, 5, $foto);
            } else {
                // Tidak ada foto baru, update tanpa BLOB
                $stmt = mysqli_prepare($conn, "UPDATE tempat SET namaTempat=?, deskripsiTempat=?, kapasitas=?, lokasi=?, jamOperasi=? WHERE id=?");

                mysqli_stmt_bind_param($stmt, "ssssi", $namaTempat, $deskripsiTempat, $kapasitas, $lokasi, $id);
            }

            if(mysqli_stmt_execute($stmt)){
                $sukses = "Data berhasil diupdate";
            } else {
                $error = "Gagal mengupdate data: " . mysqli_stmt_error($stmt);
            }

            mysqli_stmt_close($stmt);

        } else {
            // --- INSERT NEW ---
            $foto = file_get_contents($_FILES['foto']['tmp_name']);
            $stmt = mysqli_prepare($conn, "INSERT INTO tempat (namaMitra, namaTempat, deskripsiTempat, kapasitas, lokasi, jamOperasi, foto) VALUES (?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssssssb", $namaMitra, $namaTempat, $deskripsiTempat, $kapasitas, $lokasi, $jamOperasi, $foto);
            mysqli_stmt_send_long_data($stmt, 6, $foto);

            if(mysqli_stmt_execute($stmt)){
                $sukses = "Berhasil memasukkan data baru";
                $namaMitra = '';
                $namaTempat = '';
                $deskripsiTempat = '';
                $kapasitas = '';        
                $lokasi = '';
                $jamOperasi = '';
                $foto = '';
            } else {
                $error = "Gagal memasukkan data: " . mysqli_stmt_error($stmt);
            }

            mysqli_stmt_close($stmt);
        }
    }

    // Ambil semua data dari tabel tempat
    $query = "SELECT * FROM tempat WHERE namaMitra = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $namaMitra);
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
    <title>Manajemen Fasilitas Publik</title>

    <link rel="stylesheet" href="css/adm-manajemen-fasilitas.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="manajemen-fasilitas.css">

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
            <h5 class="m-0">Manajemen Fasilitas Publik</h5>
            <a href="SIM-Peminjaman_Tempat/php/logout.php"><button class="btn btn-primary btn-sm">Logout</button></a>
        </nav>

        <div class="container mt-4">

            <!-- BUTTON TAMBAH -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-semibold">Daftar Fasilitas</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Fasilitas</button>
            </div>

            <!-- TABLE -->
            <div class="card p-3">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nama Fasilitas</th>
                                <th>Kapasitas</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td>
                                    <img src="php/show-img-tempat.php?id=<?php echo $row['id']; ?>" alt="Foto Tempat" width="150">
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($row['namaTempat']); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($row['kapasitas']); ?>
                                </td>
                                <td><span class="badge bg-success">Tersedia</span></td>
                                <td>
                                    <a href="adm-manajemen-fasilitas.php?op=edit&id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>

                                    <a href="adm-manajemen-fasilitas.php?op=hapus&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data?')">Hapus</a>
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

<!-- MODAL TAMBAH FASILITAS -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Fasilitas Baru</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form id="formTambahTempat" action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Mitra</label>
                            <input type="text" name="namaMitra" class="form-control" id="namaMitra" value="<?php echo $namaMitra ?>" placeholder="Misal: spaceConncetPlace">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Fasilitas</label>
                            <input type="text" name="namaTempat" class="form-control" id="namaTempat" value="<?php echo $namaTempat ?>" placeholder="Misal: Ruang Rapat 2">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kapasitas</label>
                            <input type="text" name="kapasitas" class="form-control" id="kapasitas" value="<?php echo $kapasitas ?>"  placeholder="Misal: 50 orang">
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsiTempat" class="form-control" rows="3" id="deskripsiTempat" placeholder="Deskripsi Tempat"><?php echo $deskripsiTempat ?></textarea>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="lokasi"  class="form-control" id="lokasi" value="<?php echo $lokasi ?>" >
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Jam Operasional</label>
                            <input type="text" name="jamOperasi" class="form-control" id="jamOperasi" value="<?php echo $jamOperasi ?>" >
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Upload Foto</label>
                            <input type="file" name="foto" class="form-control" id="foto" value="<?php echo $foto ?>">
                        </div>

                        <div class="modal-footer">
                            <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button  type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT -->
<?php if(isset($_GET['op']) && $_GET['op']=='edit' && isset($data)): ?>
<div class="modal fade" id="modalEdit" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Edit Tempat</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
          <div class="mb-3">
            <label>Nama Tempat</label>
            <input type="text" name="namaTempat" class="form-control" value="<?php echo $data['namaTempat']; ?>">
          </div>
          <div class="mb-3">
            <label>Lokasi</label>
            <input type="text" name="lokasi" class="form-control" value="<?php echo $data['lokasi']; ?>">
          </div>
          <div class="mb-3">
            <label>Lokasi</label>
            <input type="text" name="kapasitas" class="form-control" value="<?php echo $data['kapasitas']; ?>">
          </div>
          <div class="mb-3">
            <label>Lokasi</label>
            <input type="text" name="jamOperasi" class="form-control" value="<?php echo $data['jamOperasi']; ?>">
          </div>
          <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsiTempat" class="form-control" rows="3"><?php echo $data['deskripsiTempat']; ?></textarea>
          </div>
          <div class="mb-3">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" name="simpan" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function(){
        var modalEditEl = document.getElementById('modalEdit'); // ambil element modal

        var myModal = new bootstrap.Modal(document.getElementById('modalEdit'));
        myModal.show();

        modalEdit.addEventListener('hidden.bs.modal', function () {
            // Hapus query string ?op=edit&id=... dengan redirect
            window.location.href = "adm-manajemen-fasilitas.php";
        });
    });
</script>
<?php endif; ?>

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
