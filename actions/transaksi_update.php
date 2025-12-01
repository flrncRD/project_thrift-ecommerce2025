<?php
session_start();
include '../config/conn.php';
include 'sweet_alert.php';

// Cek Login
if (!isset($_SESSION['user_id'])) {
    die("Akses ditolak");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $trx_id = $_POST['trx_id'];
    $action = $_POST['action']; // 'kirim' atau 'selesai'

    $status_baru = '';

    if ($action == 'kirim') {
        $status_baru = 'Kirim';
    } elseif ($action == 'selesai') {
        $status_baru = 'Selesai';
    }

    if ($status_baru) {
        $sql = "UPDATE transaksi SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status_baru, $trx_id);

        if ($stmt->execute()) {
            showSweetAlert('success', 'Status Diperbarui', 'Status pesanan berhasil diubah.', BASE_URL . "views/transaction/detail_transaksi.php?id=$id");
        } else {
            showSweetAlert('error', 'Error', mysqli_error($conn), BASE_URL . "views/transaction/detail_transaksi.php?id=$id");
        }
    } else {
        echo "Aksi tidak valid.";
    }
}
?>