<?php
include '../config/conn.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek login
if (!isset($_SESSION['user_id'])) {
    showSweetAlert('error', 'Warning', 'Silakan login dulu!', BASE_URL . "views/auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$jenis_report = $_POST['jenis_report'];
$reference_id = $_POST['reference_id'];
$alasan = mysqli_real_escape_string($conn, $_POST['alasan']);

$sql = "INSERT INTO report (user_id, jenis_report, reference_id, alasan, status, createdAt) 
        VALUES ('$user_id', '$jenis_report', '$reference_id', '$alasan', 'reported', NOW())";

if (mysqli_query($conn, $sql)) {
    showSweetAlert('success', 'Laporan berhasil dikirim!', 'Kami akan meninjau laporan Anda', BASE_URL . "views/transaction/report_transaction.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
