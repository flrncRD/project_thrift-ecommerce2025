<?php
session_start();
include '../config/conn.php';
include '../classes/products.php';

// Cek Login
if (!isset($_SESSION['user_id'])) {
    die("Akses ditolak. Silakan login.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validasi harga
    $harga = intval($_POST['harga']);
    if ($harga < 1000) {
        echo "<script>alert('Harga minimal adalah Rp 1000.'); window.history.back();</script>";
        exit;
    }

    // Proses Simpan
    $productObj = new Products();
    $result = $productObj->insert($conn, $_POST, $_FILES, $_SESSION['user_id']);

    if ($result) {
        echo "<script>alert('Barang berhasil dijual!'); window.location.href = '" . BASE_URL . "views/store/my_products.php';</script>";
    } else {
        echo "Gagal upload produk: " . mysqli_error($conn);
    }
}
?>