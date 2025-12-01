<?php
$servername = "localhost";
$username = "root";       // User default XAMPP
$password = "";           // Password default XAMPP (KOSONG)
$db = "ecomm";       // Nama database yang barusan dibuat

$conn = mysqli_connect($servername, $username, $password, $db);

if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

define('BASE_URL', 'http://localhost/pindahand/');
?>