<?php
require 'koneksi.php'

$namaFasilitas = $_POST['namaFasilitas'];
$tanggalMulai = $_POST['tanggalMulai']; 
$tanggalSelesai = $_POST['tanggalSelesai'];
$waktuMulai = $_POST['waktuMulai'];
$waktuSelesai = $_POST['waktuSelesai'];
$jumlahPeserta = $_POST['jumlahPeserta'];
$deskripsiKeperluan = $_POST['deskripsiKeperluan'];
$phone = $_POST['phone'];
$catatanTambahan = $_POST['catatanTambahan'];

$query_sql = "INSERT INTO reservasi (namaFasilitas, tanggalMulai, tanggalSelesai, waktuMulai, waktuSelesai, jumlahPeserta, deskripsiKeperluan, phone, catatanTambahan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"; 

$stmt = mysqli_prepare($conn, $query_sql);
mysqli_stmt_bind_param($stmt, "sssssssss", 
    $namaFasilitas, 
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
    header("Location: ../usr-form-reservasi.php");
    exit;
} else {
    echo "Error: " . $query_sql . "<br>" . mysqli_error($conn);
}


?>