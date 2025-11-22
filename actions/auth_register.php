<?php
session_start();
include '../config/conn.php';
include '../classes/users.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Ambil data dari form
    $username = $_POST['txtusername'];
    $email = $_POST['txtemail'];

    // 2. Cek apakah username sudah dipakai? (Validasi Sederhana)
    $check = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>
                alert('Username sudah digunakan! Ganti yang lain.');
                window.location.href = '" . BASE_URL . "views/auth/register.php';
              </script>";
        exit();
    }

    // 3. Panggil Class Users untuk simpan data
    $userObj = new Users();
    // Kita kirim $_POST (data teks) dan $_FILES (data gambar)
    $result = $userObj->register($conn, $_POST, $_FILES);

    if ($result) {
        echo "<script>
                alert('Registrasi Berhasil! Silakan Login.');
                window.location.href = '" . BASE_URL . "views/auth/login.php';
              </script>";
    } else {
        echo "Terjadi kesalahan sistem: " . mysqli_error($conn);
    }
}
?>