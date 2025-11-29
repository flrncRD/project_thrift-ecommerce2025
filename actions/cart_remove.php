<?php
session_start();
include '../config/conn.php';

// Cek apakah ada ID yang dikirim?
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Cek apakah barang tersebut ada di keranjang?
    if (isset($_SESSION['cart'][$id])) {
        // Hapus item dari array session
        unset($_SESSION['cart'][$id]);
    }
}

// Redirect kembali ke halaman keranjang
header("Location: " . BASE_URL . "views/transaction/cart.php");
exit();
?>