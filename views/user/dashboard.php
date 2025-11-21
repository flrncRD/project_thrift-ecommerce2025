<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login_register/login.php");
    exit();
}
?>
<h1>halo, ini dashboard</h1>