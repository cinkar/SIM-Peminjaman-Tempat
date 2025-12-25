<?php
require_once 'koneksi.php';

if (!isset($_GET['id'])) {
    die("ID tidak dikirim.");
}

$id = intval($_GET['id']);

$query = "SELECT foto FROM tempat WHERE id = $id";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);


if ($row && !empty($row['foto'])) {
    $foto = $row['foto'];

    // deteksi mime otomatis
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_buffer($finfo, $foto);
    finfo_close($finfo);

    header("Content-Type: $mime");
    echo $foto; 
    exit;
}

// fallback kalau tidak ada foto
header("Content-Type: image/png");
readfile("../img/default.png");
exit;
?>
