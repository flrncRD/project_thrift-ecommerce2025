<?php
// config/conn.php
$servername = "localhost";
$username = "root";
$password = "";
$db = "dbproyek25";

$conn = mysqli_connect($servername, $username, $password, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// DEFINE BASE URL (Ganti sesuai nama folder di htdocs kamu)
// Pastikan ada tanda slash '/' di belakang
define('BASE_URL', 'http://localhost/pindahand/');
?>