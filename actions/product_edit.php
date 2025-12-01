<?php
session_start();
include '../config/conn.php';
include '../classes/products.php';
include 'sweet_alert.php';

// Pastikan user login
if (!isset($_SESSION['user_id'])) {
    die("Akses ditolak. Silakan login.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $product_id = $_POST['product_id'];
    $nama = $_POST['nama_product'];
    $kategori = $_POST['kategori_id'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $desc = $_POST['description'];

    // Ambil foto lama
    $getOld = mysqli_query($conn, "SELECT photo FROM product WHERE id = '$product_id'");
    $oldData = mysqli_fetch_assoc($getOld);
    $oldPhoto = $oldData['photo'];

    // Cek apakah user upload foto baru
    if ($_FILES['photo']['name'] != "") {

        // Nama baru
        $newName = time() . "_" . $_FILES['photo']['name'];
        $tmp = $_FILES['photo']['tmp_name'];
        $folder = "../uploads/products/" . $newName;

        // Upload foto baru
        if (move_uploaded_file($tmp, $folder)) {

            // Hapus foto lama
            if (file_exists("../uploads/products/" . $oldPhoto)) {
                unlink("../uploads/products/" . $oldPhoto);
            }

            $finalPhoto = $newName;
        } else {
            die("Upload foto gagal!");
        }

    } else {
        // Jika tidak upload foto → pakai foto lama
        $finalPhoto = $oldPhoto;
    }

    // UPDATE DATABASE
    $sql = "UPDATE product SET 
                nama_product = ?, 
                kategori_id = ?, 
                harga = ?, 
                stok = ?, 
                description = ?, 
                photo = ? 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisdssi", $nama, $kategori, $harga, $stok, $desc, $finalPhoto, $product_id);

    if ($stmt->execute()) {
        showSweetAlert('success', 'Sukses Memperbarui', 'Produk berhasil diperbarui!', BASE_URL . "views/store/my_products.php");
    } else {
        die("Gagal update: " . $stmt->error);
    }
}
