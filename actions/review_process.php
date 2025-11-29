<?php
include '../config/conn.php';
include '../classes/reviews.php';
session_start();

// Cek login
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login dulu!'); window.location.href='../views/auth/login.php';</script>";
    exit();
}

$transaksi_id = $_POST['transaksi_id'];
$rating = $_POST['rating'];
$review = $_POST['review'];

$rv = new Reviews($transaksi_id, $rating, $review);
$rv->insert($conn);

echo "<script>alert('Terima kasih atas reviewnya!'); window.location.href='../views/transaction/history.php';</script>";
?>
