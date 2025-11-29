<?php
session_start();
include '../config/conn.php';

// Security Gate
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: " . BASE_URL . "index.php");
    exit();
}

// 1. LOGIKA GANTI ROLE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['toggle_role'])) {
    $id = $_POST['user_id'];
    $current_role = $_POST['current_role'];
    
    // Cegah ubah diri sendiri
    if ($id == $_SESSION['user_id']) {
        echo "<script>alert('Anda tidak bisa mengubah role sendiri!'); window.location.href='" . BASE_URL . "views/admin/manage_users.php';</script>";
        exit();
    }

    $new_role = ($current_role == 'admin') ? 'user' : 'admin';
    
    mysqli_query($conn, "UPDATE user SET role='$new_role' WHERE id='$id'");
    echo "<script>alert('Role user berhasil diubah menjadi $new_role!'); window.location.href='" . BASE_URL . "views/admin/manage_users.php';</script>";
}

// 2. LOGIKA HAPUS USER
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Cegah hapus diri sendiri
    if ($id == $_SESSION['user_id']) {
        echo "<script>alert('Anda tidak bisa menghapus akun sendiri!'); window.location.href='" . BASE_URL . "views/admin/manage_users.php';</script>";
        exit();
    }

    mysqli_query($conn, "DELETE FROM user WHERE id='$id'");
    echo "<script>alert('User berhasil dihapus!'); window.location.href='" . BASE_URL . "views/admin/manage_users.php';</script>";
}
?>