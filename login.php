<?php
session_start();

require 'php/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $query_sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query_sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // Cek apakah username adalah admin
        if ($row['username'] === 'adminSpaceConnect') {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            header("Location: /SIM-PEMINJAMAN-TEMPAT/adm-dashboard.php");
            exit;
        } else {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            header("Location: /SIM-PEMINJAMAN-TEMPAT/usr-landing-page.php");
            exit;
        }
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
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Masukkan Username" required>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukkan Password" required>
                </div>

                <button type="submit" class="btn">Masuk</button>

                <p class="redirect">Belum punya akun? 
                    <a href="register.html">Daftar di sini</a>
                </p>
            </form>
        </div>


</body>
</html>
