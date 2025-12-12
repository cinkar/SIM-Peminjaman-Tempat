<?php
require 'koneksi.php';
$namaTempat = $_POST['namaTempat'];
$deskripsiTempat = $_POST['deskripsiTempat'];
$kapasitas = $_POST['kapasitas'];
$lokasi = $_POST['lokasi'];
$jamOperasi = $_POST['jamOperasi'];
$foto = file_get_contents($_FILES['foto']['tmp_name']);

$query_sql = "INSERT INTO tempat (namaTempat, deskripsiTempat, kapasitas, lokasi, jamOperasi, foto) VALUES (?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $query_sql);
mysqli_stmt_bind_param($stmt, "ssssss", 
    $namaTempat, 
    $deskripsiTempat, 
    $kapasitas, 
    $lokasi,
    $jamOperasi,
    $foto
);

mysqli_stmt_send_long_data($stmt, 5, $foto);


if (mysqli_stmt_execute($stmt)) {
    header("Location: ../adm-manajemen-fasilitas.php");
    exit;
} else {
    echo "Error: " . $query_sql . "<br>" . mysqli_error($conn);
}
