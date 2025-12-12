<?php
require 'koneksi.php';
$username = $_POST['username'];
$phone = $_POST['phone'];
$password = $_POST['password'];

$query_sql = "INSERT INTO user (username, phone, password) VALUES ('$username', '$phone', '$password')";

if (mysqli_query($conn, $query_sql)) {
    echo "New record created successfully";
    header("Location: ../login.php");
    exit;
} else {
    echo "Error: " . $query_sql . "<br>" . mysqli_error($conn);
}