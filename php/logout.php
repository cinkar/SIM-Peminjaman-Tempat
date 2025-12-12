<?php
session_start();
session_unset();
session_destroy();
header("Location: usr-landing-page.php");
exit;
