<?php
// NYALAKAN ERROR REPORTING
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include '../config/conn.php';
include '../classes/transaksi.php';

// Cek Login & Method
if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
    die("Akses ditolak atau metode salah.");
}

$buyer_id = $_SESSION['user_id'];
$phone = $_POST['phone'];
$kota = $_POST['kota'];
$alamat = $_POST['alamat'];
$payment_method = $_POST['payment_method']; 
$bukti_transfer = $_FILES['bukti_transfer'];

// Ambil Keranjang
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if (empty($cart)) {
    echo "<script>alert('Keranjang kosong!'); window.location.href='../views/transaction/cart.php';</script>";
    exit();
}

// BUAT FOLDER OTOMATIS JIKA BELUM ADA (Anti Error Upload)
$target_dir = "../uploads/transfer/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Mulai Transaksi Database
mysqli_begin_transaction($conn);

try {
    foreach ($cart as $product_id => $item) {
        
        $total_harga_item = $item['price'] * $item['qty'];
        
        // Logika COD
        if ($payment_method === 'cod') {
            $cod_status = 1;
            $status_trx = 'Packing';
        } else {
            $cod_status = 0;
            $status_trx = 'Terbayar';
        }

        // 1. Inisialisasi Class Transaksi (Pastikan urutan sama dengan classes/transaksi.php)
        $trxObj = new Transaksi(
            $buyer_id, 
            $product_id, 
            $item['price'], 
            $item['qty'], 
            $alamat, 
            $kota, 
            $phone, 
            $payment_method, 
            $total_harga_item, 
            $bukti_transfer, 
            $cod_status, 
            $status_trx
        );

        // 2. Simpan Transaksi
        if (!$trxObj->insert($conn)) {
            throw new Exception("Gagal menyimpan transaksi SQL: " . mysqli_error($conn));
        }

        // 3. Kurangi Stok Produk
        $qty = $item['qty'];
        $updateStock = mysqli_query($conn, "UPDATE product SET stok = stok - $qty WHERE id = '$product_id'");
        
        if (!$updateStock) {
            throw new Exception("Gagal update stok produk.");
        }
    }

    // Commit
    mysqli_commit($conn);

    // 4. Kosongkan Keranjang
    unset($_SESSION['cart']);

    // 5. Redirect Sukses
    echo "<script>
            alert('Pesanan berhasil dibuat! Terima kasih.'); 
            window.location.href = '" . BASE_URL . "views/transaction/history.php';
          </script>";

} catch (Exception $e) {
    // Rollback
    mysqli_rollback($conn);
    // Tampilkan Error Jelas
    die("TERJADI ERROR: " . $e->getMessage());
}
?>