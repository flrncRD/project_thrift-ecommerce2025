<?php
session_start();
include '../config/conn.php';

// Security Gate
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: " . BASE_URL . "index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $report_id = $_POST['report_id'];
    $status = $_POST['status']; // 'Accepted' atau 'Rejected'
    
    $sql = "UPDATE report SET status='$status' WHERE id='$report_id'";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Status laporan diperbarui!'); window.location.href='" . BASE_URL . "views/admin/manage_reports.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>