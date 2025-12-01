<?php
session_start();
include '../config/conn.php';

// Cek ID produk
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus dari session cart
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
}

// Balik ke keranjang
header("Location: " . BASE_URL . "views/transaction/cart.php");
exit();
?>