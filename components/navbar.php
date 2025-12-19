   
        <table class="nav" style="width: 100%; background-color: rgb(37, 132, 37);">
            <tr style="height:60px;">
                <td style="width: 60px; padding-left: 20px; padding-right: 10px;"><img src="../img/logo.png" alt="logo" style="width: 30px; border-radius: 25px;"></td>
                <td style="flex: 1; width: 1000px;">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/SIM-PEMINJAMAN-TEMPAT/usr-landing-page.php" style="color: #fff !important;">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/SIM-PEMINJAMAN-TEMPAT/usr-daftar-fasilitas.php" style="color: #fff !important;">Daftar Tempat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/SIM-PEMINJAMAN-TEMPAT/kalender-tempat.php" style="color: #fff !important;">Kalender Tempat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/SIM-PEMINJAMAN-TEMPAT/usr-fasilitas-disabilitas.php" style="color: #fff !important;">Fasilitas Disabilitas</a>
                        </li>
                    </ul>
                </td>

                <!-- Login, register & Profile -->
                <td style="text-align: right; min-width: 300px; color: #fff !important; ">
                    <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                        <a class="nav-link d-inline" href="/SIM-Peminjaman-Tempat/profile-user.php" style="color: #fff;">Profile</a>
                        <a class="btn btn-light ms-3" href="/SIM-Peminjaman-Tempat/php/logout.php">Logout</a>
                    <?php else: ?>
                        <a class="btn btn-light me-2" href="/SIM-Peminjaman-Tempat/login.php">Login</a>
                        <a class="btn btn-light me-3" href="/SIM-Peminjaman-Tempat/register.html">Register</a>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
        