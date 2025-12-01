<?php
include '../config/conn.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek session
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login dulu!'); window.location.href='../views/auth/login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$jenis_report = $_POST['jenis_report'];
$reference_id = $_POST['reference_id'];
$alasan = mysqli_real_escape_string($conn, $_POST['alasan']);

// Simpan laporan
$sql = "INSERT INTO report (user_id, jenis_report, reference_id, alasan, status, createdAt) 
        VALUES ('$user_id', '$jenis_report', '$reference_id', '$alasan', 'reported', NOW())";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Laporan berhasil dikirim! Kami akan meninjau laporan Anda'); window.history.back();</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>