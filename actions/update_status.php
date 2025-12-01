<?php
session_start();
include '../config/conn.php';

// Validasi request
if (!isset($_GET['id']) || !isset($_GET['next'])) {
    die("Invalid request");
}

$transaksi_id = $_GET['id'];
$next_status = $_GET['next'];

// Update status
$sql = "UPDATE transaksi SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $next_status, $transaksi_id);

if ($stmt->execute()) {
    header("Location: ../views/transaction/history.php");
} else {
    echo "Gagal update status";
}
?>