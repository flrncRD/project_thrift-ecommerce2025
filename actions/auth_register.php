<?php
session_start();
include '../config/conn.php';
include '../classes/users.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validasi sederhana: Cek apakah username/email sudah ada
    $username = $_POST['txtusername'];
    $check = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    if (mysqli_num_rows($check) > 0) {
        echo "<script>
                alert('Username sudah digunakan! Silakan cari yang lain.');
                window.location.href = '" . BASE_URL . "views/auth/register.php';
              </script>";
        exit();
    }

    // Panggil Class Users yang BARU
    $userObj = new Users();

    // Panggil function register() bukan insert()
    // Kita kirim $_POST (data teks) dan $_FILES (data gambar) langsung ke sana
    $result = $userObj->register($conn, $_POST, $_FILES);

    if ($result) {
        echo "<script>
                alert('Registrasi Berhasil! Silakan Login.');
                window.location.href = '" . BASE_URL . "views/auth/login.php';
              </script>";
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($conn);
    }
}
?>