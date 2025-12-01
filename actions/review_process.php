<?php
include '../config/conn.php';
include '../classes/reviews.php';
session_start();

// Cek login
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login dulu!'); window.location.href='../views/auth/login.php';</script>";
    showSweetAlert('success', 'Silahkan Login ', 'Kami akan meninjau laporan Anda', BASE_URL . "views/transaction/report_transaction.php");
    exit();
}

$transaksi_id = $_POST['transaksi_id'];
$rating = $_POST['rating'];
$review = $_POST['review'];

$rv = new Reviews($transaksi_id, $rating, $review);
$rv->insert($conn);

showSweetAlert('success', 'Review berhasil dikirim!', 'Terima kasih atas reviewnya!', BASE_URL . "views/transaction/history.php");
?>