<?php
    require 'php/koneksi.php';

    $namaFasilitas = "";
    $deskripsiFasilitas = "";
    $lokasiFasilitas = "";
    $foto = "";
    $sukses = "";
    $error = "";

    // --- EDIT ---
    if(isset($_GET['op']) && $_GET['op'] == 'edit' && isset($_GET['id'])){
        $id = $_GET['id'];
        $stmt = mysqli_prepare($conn, "SELECT * FROM fasilitasdifabel WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result_edit = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result_edit);

        if($data){
            $namaFasilitas = $data['namaFasilitas'];
            $deskripsiFasilitas = $data['deskripsiFasilitas'];
            $lokasiFasilitas = $data['lokasiFasilitas'];
        }

        mysqli_stmt_close($stmt);
    }

    // --- DELETE ---
    if(isset($_GET['op']) && $_GET['op'] == 'hapus' && isset($_GET['id'])){
        $id = $_GET['id'];
        $stmt = mysqli_prepare($conn, "DELETE FROM fasilitasdifabel WHERE id = ?");
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
        $namaFasilitas = $_POST['namaFasilitas'];
        $deskripsiFasilitas = $_POST['deskripsiFasilitas'];
        $lokasiFasilitas = $_POST['lokasiFasilitas'];

        // Cek apakah mode edit (ada hidden field id)
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $id = $_POST['id'];

            // Jika ada foto baru diupload
            if(isset($_FILES['foto']) && $_FILES['foto']['tmp_name'] != ""){
                $foto = file_get_contents($_FILES['foto']['tmp_name']);
                $stmt = mysqli_prepare($conn, "UPDATE fasilitasdifabel SET namaFasilitas=?, deskripsiFasilitas=?, lokasiFasilitas=?, foto=? WHERE id=?");
                mysqli_stmt_bind_param($stmt, "ssssi", $namaFasilitas, $deskripsiFasilitas, $lokasiFasilitas, $foto, $id);
            } else {
                // Tidak ada foto baru, update tanpa BLOB
                $stmt = mysqli_prepare($conn, "UPDATE fasilitasdifabel SET namaFasilitas=?, deskripsiFasilitas=?, lokasiFasilitas=? WHERE id=?");
                mysqli_stmt_bind_param($stmt, "sssi", $namaFasilitas, $deskripsiFasilitas, $lokasiFasilitas, $id);
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
            $stmt = mysqli_prepare($conn, "INSERT INTO fasilitasdifabel (namaFasilitas, deskripsiFasilitas, lokasiFasilitas, foto) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sssb", $namaFasilitas, $deskripsiFasilitas, $lokasiFasilitas, $foto);
            mysqli_stmt_send_long_data($stmt, 3, $foto);

            if(mysqli_stmt_execute($stmt)){
                $sukses = "Berhasil memasukkan data baru";
                $namaFasilitas = "";
                $deskripsiFasilitas = "";
                $lokasiFasilitas = "";
                $foto = "";
            } else {
                $error = "Gagal memasukkan data: " . mysqli_stmt_error($stmt);
            }

            mysqli_stmt_close($stmt);
        }
    }

    // --- AMBIL SEMUA DATA ---
    $query = "SELECT * FROM fasilitasdifabel";
    $result = mysqli_query($conn, $query);
    if(!$result){
        die("Query gagal: " . mysqli_error($conn));
    }
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Fasilitas Disabilitas</title>

    <link rel="stylesheet" href="css/adm-manajemen-fasilitas-disabilitas.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="manajemen-fasilitas-disabilitas.css">

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
            <h5 class="m-0">Manajemen Fasilitas Disabilitas</h5>
            <a href="SIM-Peminjaman_Tempat/php/logout.php"><button class="btn btn-primary btn-sm">Logout</button></a>
        </nav>

        <div class="container mt-4">

            <!-- TITLE + BUTTON TAMBAH -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-semibold">Daftar Fasilitas Disabilitas</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    + Tambah Fasilitas
                </button>
            </div>

            <!-- TABLE -->
            <!-- Menampilkan Data Tersimpan -->
            <div class="card p-3">
                <?php
                    if(isset($sukses)){
                        echo "<div class='alert alert-success'>$sukses</div>";
                    } elseif(isset($error)){
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                ?>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nama Fasilitas</th>
                                <th>Lokasi</th>
                                <th>Ketersediaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($result)): ?>

                            <tr>
                                <td>
                                     <img src="php/show-img-difabel.php?id=<?php echo $row['id']; ?>" alt="Foto Tempat" width="150">
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($row['namaFasilitas']); ?>
                                </td>
                                <td width="250">
                                    <?php echo htmlspecialchars($row['lokasiFasilitas']); ?>
                                </td>
                                <td><span class="badge bg-success">Tersedia</span></td>
                                <td>
                                    <a href="adm-manajemen-fasilitas-disabilitas.php?op=edit&id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>

                                    <a href="adm-manajemen-fasilitas-disabilitas.php?op=hapus&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data?')">Hapus</a>
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


<!-- MODAL TAMBAH FASILITAS DISABILITAS -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Fasilitas Disabilitas</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form id="formTambahFasilitas" action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Fasilitas</label>
                            <input type="text"  name="namaFasilitas" class="form-control" id="namaFasilitas" value="<?php echo $namaFasilitas ?>" placeholder="Nama fasilitas">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Lokasi</label>
                            <input type="text"  name="lokasiFasilitas" class="form-control" id="lokasiFasilitas" value="<?php echo $lokasiFasilitas ?>" placeholder="Lokasi fasilitas">
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsiFasilitas" class="form-control" rows="3" id="deskripsiFasilitas" placeholder="Deskripsi fasilitas"><?php echo $deskripsiFasilitas ?></textarea>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Upload Foto</label>
                            <input type="file" name="foto" class="form-control" id="foto" value="<?php echo $foto ?>">
                        </div>

                    </div>
 
                    <div class="modal-footer">
                        <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button  type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">Simpan</button>
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
          <h5 class="modal-title">Edit Fasilitas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
          <div class="mb-3">
            <label>Nama Fasilitas</label>
            <input type="text" name="namaFasilitas" class="form-control" value="<?php echo $data['namaFasilitas']; ?>">
          </div>
          <div class="mb-3">
            <label>Lokasi</label>
            <input type="text" name="lokasiFasilitas" class="form-control" value="<?php echo $data['lokasiFasilitas']; ?>">
          </div>
          <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsiFasilitas" class="form-control" rows="3"><?php echo $data['deskripsiFasilitas']; ?></textarea>
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
            window.location.href = "adm-manajemen-fasilitas-disabilitas.php";
        });
    });
</script>
<?php endif; ?>

    <script>
        fetch("adm-sidebar.html")
            .then(res => res.text())
            .then(data => {
                document.getElementById("sidebar").innerHTML = data;
            });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
