<?php
include '../../config/conn.php';
include '../layouts/header.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login dulu!'); window.location.href='../auth/login.php';</script>";
    exit();
}

// Cek ID transaksi
if (!isset($_GET['id'])) {
    echo "<script>alert('Transaksi tidak ditemukan!'); window.history.back();</script>";
    exit();
}

$transaksi_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Ambil data transaksi + data produk
$q = mysqli_query($conn, "
    SELECT t.*, p.nama_product, p.photo 
    FROM transaksi t
    LEFT JOIN product p ON p.id = t.product_id
    WHERE t.id = '$transaksi_id'
");

$transaksi = mysqli_fetch_assoc($q);

if (!$transaksi) {
    echo "<script>alert('Transaksi tidak ditemukan!'); window.history.back();</script>";
    exit();
}
?>

<div class="max-w-xl mx-auto mt-10 bg-white shadow-lg p-6 rounded-2xl border">
    <h2 class="text-2xl font-bold text-slate-800 mb-6">
        Laporkan Transaksi
    </h2>

    <div class="flex gap-4 items-center mb-6">
        <img src="<?= BASE_URL ?>uploads/products/<?= $transaksi['photo'] ?>" 
             class="w-20 h-20 rounded object-cover border">

        <div>
            <p class="font-bold text-slate-900"><?= $transaksi['nama_product'] ?></p>
            <p class="text-sm text-gray-600">ID Transaksi: #TRX-<?= $transaksi['id'] ?></p>
        </div>
    </div>

    <form action="../../actions/report_process.php" method="POST">

        <input type="hidden" name="jenis_report" value="Transaksi">
        <input type="hidden" name="reference_id" value="<?= $transaksi['id'] ?>">

        <label class="font-semibold">Alasan Laporan</label>
        <textarea name="alasan" required
                  class="w-full border p-3 rounded-xl mt-1 mb-6"
                  rows="4"
                  placeholder="Mengapa transaksi ini perlu dilaporkan..."></textarea>

        <button class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl">
            Kirim Laporan
        </button>
    </form>
</div>

<?php include '../layouts/footer.php'; ?>
