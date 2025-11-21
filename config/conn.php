<?php
$servername = "127.0.0.1";  // Ganti dari localhost
$username = "root";
$password = "YOUR_PASSWORD";
$db = "dbproyek25";

$conn = mysqli_connect($servername, $username, $password, $db);

if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

define('BASE_URL', 'http://localhost/pindahand/');
?>