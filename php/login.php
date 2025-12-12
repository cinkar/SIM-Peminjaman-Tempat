<?php
require 'koneksi.php';
$username = $_POST['username'];
$password = $_POST['password'];

$query_sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $query_sql);  

if (mysqli_num_rows($result) === 1) {
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    header("Location: /SIM-PEMINJAMAN-TEMPAT/usr-landing-page.php");
    exit;
} else {
    echo "Invalid username or password.";
}