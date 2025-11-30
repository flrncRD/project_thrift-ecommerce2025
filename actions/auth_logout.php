<?php
session_start();
// Include config untuk mendapatkan BASE_URL
include '../config/conn.php';


session_unset();
session_destroy();

// Redirect ke halaman login yang benar menggunakan BASE_URL
// Agar tidak nyasar ke folder yang salah
header("Location: " . BASE_URL . "index.php");
exit();
?>
