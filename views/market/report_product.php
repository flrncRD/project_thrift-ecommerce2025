<?php
include '../../config/conn.php';
include '../layouts/header.php';

// session_start();

// Cek login
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login dulu!'); window.location.href='../auth/login.php';</script>";
    exit();
}

// Pastikan product_id tersedia
if (!isset($_GET['id'])) {
    echo "<script>alert('Produk tidak ditemukan!'); window.history.back();</script>";
    exit();
}

$product_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Ambil data produk
$q = mysqli_query($conn, "SELECT * FROM product WHERE id='$product_id'");
$product = mysqli_fetch_assoc($q);

if (!$product) {
    echo "<script>alert('Produk tidak ditemukan!'); window.history.back();</script>";
    exit();
}
?>

<div class="max-w-xl mx-auto mt-10 bg-white shadow-lg p-6 rounded-2xl border">
    <h2 class="text-2xl font-bold text-slate-800 mb-6">
        Laporkan Produk
    </h2>

    <div class="flex gap-4 items-center mb-6">
        <img src="<?= BASE_URL ?>uploads/products/<?= $product['photo'] ?>"
            class="w-20 h-20 rounded object-cover border">

        <div>
            <p class="font-bold text-slate-900"><?= $product['nama_product'] ?></p>
        </div>
    </div>

    <form action="../../actions/report_process.php" method="POST">

        <input type="hidden" name="jenis_report" value="product">
        <input type="hidden" name="reference_id" value="<?= $product['id'] ?>">

        <label class="font-semibold">Alasan Laporan</label>
        <textarea name="alasan" required
                  class="w-full border p-3 rounded-xl mt-1 mb-6"
                  rows="4"
                  placeholder="Mengapa produk ini perlu dilaporkan..."></textarea>

        <button class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl">
            Kirim Laporan
        </button>
    </form>
</div>

<?php include '../layouts/footer.php'; ?>
