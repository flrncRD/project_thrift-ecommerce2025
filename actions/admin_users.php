<?php
session_start();
include '../config/conn.php';

// Cek Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: " . BASE_URL . "index.php");
    exit();
}

// --- Ganti Role User ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['toggle_role'])) {
    $id = $_POST['user_id'];
    $current_role = $_POST['current_role'];

    if ($id == $_SESSION['user_id']) {
        echo "<script>alert('Anda tidak bisa mengubah role sendiri!'); window.location.href='" . BASE_URL . "views/admin/manage_users.php';</script>";
        exit();
    }

    $new_role = ($current_role == 'admin') ? 'user' : 'admin';

    mysqli_query($conn, "UPDATE user SET role='$new_role' WHERE id='$id'");
    echo "<script>alert('Role user berhasil diubah menjadi $new_role!'); window.location.href='" . BASE_URL . "views/admin/manage_users.php';</script>";
}

// --- Hapus User ---
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($id == $_SESSION['user_id']) {
        echo "<script>alert('Anda tidak bisa menghapus akun sendiri!'); window.location.href='" . BASE_URL . "views/admin/manage_users.php';</script>";
        exit();
    }

    mysqli_query($conn, "DELETE FROM user WHERE id='$id'");
    echo "<script>alert('User berhasil dihapus!'); window.location.href='" . BASE_URL . "views/admin/manage_users.php';</script>";
}
?>