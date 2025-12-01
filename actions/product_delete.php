<?php
session_start();
include '../config/conn.php';

// Cek Login
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login!'); window.location.href='" . BASE_URL . "views/auth/login.php';</script>";
    exit();
}

// Proses Hapus
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Ambil nama file foto
    $query = mysqli_query($conn, "SELECT photo FROM product WHERE id='$id' AND user_id='$user_id'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        // Hapus file fisik
        $file_path = "../uploads/products/" . $data['photo'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Hapus data DB
        $sql = "DELETE FROM product WHERE id='$id' AND user_id='$user_id'";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Produk berhasil dihapus!'); window.location.href='" . BASE_URL . "views/store/my_products.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus produk!'); window.location.href='" . BASE_URL . "views/store/my_products.php';</script>";
        }
    } else {
        echo "<script>alert('Produk tidak ditemukan atau bukan milik Anda!'); window.location.href='" . BASE_URL . "views/store/my_products.php';</script>";
    }
}
?>