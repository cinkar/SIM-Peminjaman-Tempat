<?php
require 'php/koneksi.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namaMitra = $_POST['namaMitra'] ?? '';
    $password = $_POST['password'] ?? '';

    $query_sql = "SELECT * FROM mitra WHERE namaMitra='$namaMitra' AND password='$password'";
    $result = mysqli_query($conn, $query_sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
            $_SESSION['loggedin'] = true;
            $_SESSION['namaMitra'] = $namaMitra;
            header("Location: /SIM-PEMINJAMAN-TEMPAT/adm-dashboard.php");
    } else {
        $error = "Invalid username or password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css" />
</head>
<body>

        <div class="background"></div>

        <div class="login-container">
            <h2>Login</h2>

            <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

            <form action="" method="POST">
                <div class="input-group">
                    <label>Nama Mitra</label>
                    <input type="text" name="namaMitra" placeholder="Masukkan Nama Mitra" required>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukkan Password" required>
                </div>

                <button type="submit" class="btn">Masuk</button>

                <p class="redirect">Belum punya akun? 
                    <a href="mitra-register.html">Daftar di sini</a>
                </p>
            </form>
        </div>


</body>
</html>
