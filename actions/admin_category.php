<?php
session_start();
include '../config/conn.php';

// Security Gate: Cek Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: " . BASE_URL . "index.php");
    exit();
}

// 1. LOGIKA TAMBAH
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_kategori'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
    
    if (!empty($nama)) {
        $sql = "INSERT INTO kategori (nama_kategori) VALUES ('$nama')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Kategori berhasil ditambahkan!'); window.location.href='" . BASE_URL . "views/admin/manage_kategori.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        header("Location: " . BASE_URL . "views/admin/manage_kategori.php");
    }
}

// 2. LOGIKA HAPUS
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM kategori WHERE id='$id'";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Kategori berhasil dihapus!'); window.location.href='" . BASE_URL . "views/admin/manage_kategori.php';</script>";
    } else {
        echo "<script>alert('Gagal hapus! Kategori ini mungkin sedang dipakai oleh produk.'); window.location.href='" . BASE_URL . "views/admin/manage_kategori.php';</script>";
    }
}
?>