<?php
require 'koneksi.php';
$namaFasilitas = $_POST['namaFasilitas'];
$deskripsiFasilitas = $_POST['deskripsiFasilitas'];
$lokasiFasilitas = $_POST['lokasiFasilitas'];
$foto = file_get_contents($_FILES['foto']['tmp_name']);

$query_sql = "INSERT INTO fasilitasdifabel (namaFasilitas, deskripsiFasilitas, lokasiFasilitas, foto) VALUES (?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $query_sql);
mysqli_stmt_bind_param($stmt, "ssss", 
    $namaFasilitas, 
    $deskripsiFasilitas, 
    $lokasiFasilitas,
    $foto
);

if (mysqli_stmt_execute($stmt)) {
    header("Location: ../adm-manajemen-fasilitas-disabilitas.php");
    exit;
} else {
    echo "Error: " . $query_sql . "<br>" . mysqli_error($conn);
}
