<?php
session_start();
include '../config/conn.php';
include '../classes/users.php';
include 'sweet_alert.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['txtusername'];
    $email = $_POST['txtemail'];
    $phone = $_POST['txtphone'];

    // === 1. CEK USERNAME ===
    $cekUser = mysqli_query($conn, "SELECT id FROM user WHERE username = '$username'");
    if (mysqli_num_rows($cekUser) > 0) {
        showSweetAlert('error', 'Username sudah digunakan', 'Silahkan gunakan yang lain', '../views/auth/register.php');
        exit();
    }

    // === 2. CEK EMAIL (Permintaanmu) ===
    $cekEmail = mysqli_query($conn, "SELECT id FROM user WHERE email = '$email'");
    if (mysqli_num_rows($cekEmail) > 0) {
        showSweetAlert('error', 'Email ini sudah terdaftar', 'Gunakan Email yang lain', '../views/auth/register.php');
        exit();
    }

    // === 3. CEK NO HP (Permintaanmu) ===
    $cekPhone = mysqli_query($conn, "SELECT id FROM user WHERE phone = '$phone'");
    if (mysqli_num_rows($cekPhone) > 0) {
        showSweetAlert('error', 'Nomor HP ini sudah terdaftar', 'Gunakan akun yang lain', '../views/auth/register.php');
        exit();
    }

    // === 4. JIKA LOLOS SEMUA CEK, BARU REGISTER ===
    $userObj = new Users();
    $result = $userObj->register($conn, $_POST, $_FILES);

    if ($result) {
        showSweetAlert('success', 'Login Berhasil!', 'Silahkan masuk ke akun anda!', BASE_URL . 'views/auth/login.php');
    } else {
        echo "Terjadi kesalahan sistem: " . mysqli_error($conn);
    }
}
?>