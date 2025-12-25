<?php
require 'koneksi.php';
$namaMitra = $_POST['namaMitra'];
$phoneMitra = $_POST['phoneMitra'];
$emailMitra = $_POST['emailMitra'];
$password = $_POST['password'];

$query_sql = "INSERT INTO mitra (namaMitra, phoneMitra, emailMitra, password) VALUES ('$namaMitra', '$phoneMitra', '$emailMitra', '$password')";

if (mysqli_query($conn, $query_sql)) {
    echo "New record created successfully";
    header("Location: ../mitra-login.php");
    exit;
} else {
    echo "Error: " . $query_sql . "<br>" . mysqli_error($conn);
}