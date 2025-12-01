<?php
session_start();
include '../config/conn.php';

if (!isset($_SESSION['user_id'])) {
    die("Akses ditolak.");
}

$id = $_GET['id'] ?? 0;

// soft delete
$sql = "UPDATE product SET status = 'inactive' WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    header("Location: ../views/user/dashboard.php");
    exit;
} else {
    echo "Error: " . mysqli_error($conn);
}
?>