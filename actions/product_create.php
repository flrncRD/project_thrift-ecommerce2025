<?php
session_start();
include '../config/conn.php';
include '../classes/products.php';
include 'sweet_alert.php';

// Cek Login
if (!isset($_SESSION['user_id'])) {
    die("Akses ditolak. Silakan login.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Validasi harga
    $harga = intval($_POST['harga']);
    
    if ($harga < 1000) {
        echo "<script>
                alert('Harga minimal adalah Rp 1000.');
                window.history.back();
            </script>";
        exit;
    }

    
    $productObj = new Products();

    // Kirim Data, File, dan ID User yang sedang login
    $result = $productObj->insert($conn, $_POST, $_FILES, $_SESSION['user_id']);

    if ($result) {
        showSweetAlert('success', 'Sukses Membuat', 'Barang berhasil dijual!', BASE_URL . "views/store/my_products.php");
    } else {
        showSweetAlert('error', 'Error', mysqli_error($conn), BASE_URL . "views/store/my_products.php?id=$id");
        mysqli_error($conn);
    }
}
?>