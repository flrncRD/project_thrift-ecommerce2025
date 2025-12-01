<?php
session_start();
include '../config/conn.php';
include '../classes/transaksi.php';

// Cek Login
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "views/auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $buyer_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];

    // Hitung Total (Satuan x Qty)
    $harga_satuan = $_POST['harga'];
    $qty = $_POST['qty'];
    $total_fix = $harga_satuan * $qty;

    $nama_buyer = $_POST['nama_buyer'];
    $alamat_buyer = $_POST['alamat_buyer'];
    $kota_buyer = $_POST['kota_buyer'];
    $phone_buyer = $_POST['phone_buyer'];
    $jenis_pembayaran = $_POST['jenis_pembayaran'];
    $jenis_pengiriman = $_POST['jenis_pengiriman'];

    try {
        $transaksi = new Transaksi(
            $buyer_id,
            $product_id,
            $total_fix,
            $qty,
            $nama_buyer,
            $alamat_buyer,
            $kota_buyer,
            $phone_buyer,
            $jenis_pembayaran,
            $jenis_pengiriman,
            'Terbayar'
        );

        if ($transaksi->insert($conn)) {
            echo "<script>alert('Transaksi Berhasil!'); window.location.href='" . BASE_URL . "views/transaction/history.php';</script>";
            exit;
        } else {
            echo "Terjadi kesalahan saat memproses transaksi.";
        }

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>