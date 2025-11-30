<?php
session_start();
include '../config/conn.php';
include 'sweet_alert.php';

// Cek Login
if (!isset($_SESSION['user_id'])) {
    showSweetAlert('info', 'Akses Ditolak', 'Silakan login terlebih dahulu untuk belanja.', BASE_URL . 'views/auth/login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    
    // Ambil Data Produk dari DB untuk memastikan
    $query = mysqli_query($conn, "SELECT * FROM product WHERE id = '$product_id'");
    $product = mysqli_fetch_assoc($query);

    if (!$product) {
        die("Produk tidak valid.");
    }

    // Buat Struktur Session Cart jika belum ada
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Cek apakah produk sudah ada di keranjang?
    if (isset($_SESSION['cart'][$product_id])) {
        // Jika sudah ada, tambah qty
        $_SESSION['cart'][$product_id]['qty'] += 1;
    } else {
        // Jika belum, masukkan data baru
        $_SESSION['cart'][$product_id] = [
            'id' => $product['id'],
            'name' => $product['nama_product'],
            'price' => $product['harga'],
            'photo' => $product['photo'],
            'qty' => 1
        ];
    }

    showSweetAlert('success', 'Berhasil!', 'Barang masuk ke keranjang.', BASE_URL . 'views/transaction/cart.php');
}
?>