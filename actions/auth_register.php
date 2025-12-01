<?php
session_start();
include '../config/conn.php';
include '../classes/users.php';
include 'sweet_alert.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['txtusername'];
    $email = $_POST['txtemail'];
    $phone = $_POST['txtphone'];

    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);
    $phone = mysqli_real_escape_string($conn, $phone);


    $cekUser = mysqli_query($conn, "SELECT id FROM user WHERE username = '$username'");
    if (mysqli_num_rows($cekUser) > 0) {
        showSweetAlert('error', 'Username Terpakai', 'Username ini sudah terdaftar (mungkin pada akun non-aktif). Silahkan gunakan yang lain.', '../views/auth/register.php');
        exit();
    }

    $cekEmail = mysqli_query($conn, "SELECT id FROM user WHERE email = '$email'");
    if (mysqli_num_rows($cekEmail) > 0) {
        showSweetAlert('error', 'Email Terpakai', 'Email ini sudah terdaftar. Gunakan Email yang lain.', '../views/auth/register.php');
        exit();
    }

    $cekPhone = mysqli_query($conn, "SELECT id FROM user WHERE phone = '$phone'");
    if (mysqli_num_rows($cekPhone) > 0) {
        showSweetAlert('error', 'Nomor HP Terpakai', 'Nomor HP ini sudah terdaftar. Gunakan nomor yang lain.', '../views/auth/register.php');
        exit();
    }

    $userObj = new Users();


    $result = $userObj->register($conn, $_POST, $_FILES);

    if ($result) {
        showSweetAlert('success', 'Registrasi Berhasil!', 'Akun berhasil dibuat. Silahkan login!', BASE_URL . 'views/auth/login.php');
    } else {

        showSweetAlert('error', 'Gagal!', 'Terjadi kesalahan sistem saat mendaftar.', '../views/auth/register.php');
    }
}
?>