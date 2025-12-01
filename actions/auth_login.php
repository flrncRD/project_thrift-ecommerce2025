<?php
session_start();
include '../config/conn.php';
include '../classes/users.php';
include 'sweet_alert.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek User
    $userObj = new Users();
    $userData = $userObj->login($conn, $username, $password);

    if ($userData) {
        // Set Session
        $_SESSION['username'] = $userData['username'];
        $_SESSION['role'] = $userData['role'];
        $_SESSION['user_id'] = $userData['id'];

        // Redirect
        if ($userData['role'] == 'admin') {
            header("Location: " . BASE_URL . "views/admin/dashboard.php");
        } else {
            header("Location: " . BASE_URL . "index.php");
        }
        exit();
    } else {
        // Gagal
        showSweetAlert('error', 'Login Gagal!', 'Username atau Password Salah.', BASE_URL . 'views/auth/login.php');
    }
}
?>