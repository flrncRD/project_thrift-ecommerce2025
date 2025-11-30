<?php
session_start();
include '../config/conn.php';
include '../classes/transaksi.php';
include 'sweet_alert.php';

//Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "views/auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $buyer_id        = $_SESSION['user_id'];
    $product_id      = $_POST['product_id'];
    $harga           = $_POST['harga'];
    $qty             = $_POST['qty'];
    $nama_buyer      = $_POST['nama_buyer'];
    $alamat_buyer    = $_POST['alamat_buyer'];
    $kota_buyer      = $_POST['kota_buyer'];
    $phone_buyer     = $_POST['phone_buyer'];
    $jenis_pembayaran = $_POST['jenis_pembayaran'];
    $jenis_pengiriman = $_POST['jenis_pengiriman'];

    try {

        //Validasi stok
        $stmt = $conn->prepare("SELECT stok FROM product WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("Produk tidak ditemukan.");
        }

        $product = $result->fetch_assoc();
        $stokTersedia = $product['stok'];

        if ($qty > $stokTersedia) {
            throw new Exception("Stok tidak mencukupi. Stok tersedia: " . $stokTersedia);
        }

        // Buat objek transaksi
        $transaksi = new Transaksi(
            $buyer_id,
            $product_id,
            $harga,
            $qty,
            $nama_buyer,
            $alamat_buyer,
            $kota_buyer,
            $phone_buyer,
            $jenis_pembayaran,
            $jenis_pengiriman,
            'Terbayar'
        );

        // Insert ke database
        if ($transaksi->insert($conn)) {

            // Kurangi stok produk & ubah status jika habis
            $updateStok = $conn->prepare("UPDATE product SET stok = stok - ?, status = IF(stok - ? <= 0, 'inactive', status)
            WHERE id = ?
            ");

            $updateStok->bind_param("iii", $qty, $qty, $product_id);
            $updateStok->execute();
            
            // GANTI ALERT SUKSES
            showSweetAlert('success', 'Pesanan Dibuat!', 'Terima kasih telah berbelanja.', BASE_URL . 'views/transaction/history.php');
        } 
//       kalau error disini di un comment aja, soalnya tadi conflict
//       else {
//             echo "Terjadi kesalahan saat memproses transaksi.";
//         }
      
    } catch (Exception $e) {
        // echo "Error: " . $e->getMessage();
        mysqli_rollback($conn);
        showSweetAlert('error', 'Gagal Checkout', $e->getMessage(), '../views/transaction/cart.php');
    }
}
