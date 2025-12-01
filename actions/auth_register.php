<?php
session_start();
include '../config/conn.php';
include '../classes/users.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['txtusername'];
    $email = $_POST['txtemail'];
    $phone = $_POST['txtphone'];

    // === 1. CEK USERNAME ===
    $cekUser = mysqli_query($conn, "SELECT id FROM user WHERE username = '$username'");
    if (mysqli_num_rows($cekUser) > 0) {
        echo "<script>
                alert('Username sudah digunakan! Silakan ganti.');
                window.history.back();
              </script>";
        exit();
    }

    // === 2. CEK EMAIL (Permintaanmu) ===
    $cekEmail = mysqli_query($conn, "SELECT id FROM user WHERE email = '$email'");
    if (mysqli_num_rows($cekEmail) > 0) {
        echo "<script>
                alert('Email ini sudah terdaftar! Gunakan email lain.');
                window.history.back();
              </script>";
        exit();
    }

    // === 3. CEK NO HP (Permintaanmu) ===
    $cekPhone = mysqli_query($conn, "SELECT id FROM user WHERE phone = '$phone'");
    if (mysqli_num_rows($cekPhone) > 0) {
        echo "<script>
                alert('Nomor HP ini sudah terdaftar!');
                window.history.back();
              </script>";
        exit();
    }

    // === 4. JIKA LOLOS SEMUA CEK, BARU REGISTER ===
    $userObj = new Users();
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