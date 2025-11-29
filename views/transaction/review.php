<?php
include '../../config/conn.php';
include '../../classes/transaksi.php';
include '../../classes/reviews.php';
include '../../views/layouts/header.php';

// if (!isset($_SESSION['user_id'])) {
//     echo "<script>alert('Silakan login dulu!'); window.location.href='" . BASE_URL . "views/auth/login.php';</script>";
//     exit();
// }

if (!isset($_GET['id'])) {
    echo "<script>alert('Transaksi tidak ditemukan!'); window.history.back();</script>";
    exit();
}

$transaksi_id = $_GET['id'];

$sql = "SELECT 
            t.*, 
            p.nama_product, 
            p.photo AS product_photo,
            u.username AS penjual,
            u.photo AS penjual_photo
        FROM transaksi t
        JOIN product p ON t.product_id = p.id
        JOIN user u ON p.user_id = u.id
        WHERE t.id = '$transaksi_id'";

$result = mysqli_query($conn, $sql);
$trx = mysqli_fetch_assoc($result);

if (!$trx) {
    echo "<script>alert('Transaksi tidak valid!'); window.history.back();</script>";
    exit();
}
?>

<div class="max-w-xl mx-auto mt-10 bg-white shadow-lg p-6 rounded-2xl border">
    <h2 class="text-2xl font-bold text-slate-800 mb-6">Beri Ulasan pada Penjual</h2>

    <div class="flex gap-4 items-center mb-6">
        <img src="<?= BASE_URL ?>uploads/profile/<?= $trx['penjual_photo'] ?>"
            class="w-20 h-20 rounded object-cover border"
            onerror="this.src='https://placehold.co/100x100?text=No+Img'">

        <div>
            <p class="font-bold text-slate-900"><?= $trx['penjual'] ?></p>
            <p class="text-xs text-gray-500">Produk: <?= $trx['nama_product'] ?></p>
            <p class="text-xs text-gray-500">No Transaksi: #TRX-<?= $trx['id'] ?></p>
        </div>
    </div>

    <form action="../../actions/review_process.php" method="POST">
        <input type="hidden" name="transaksi_id" value="<?= $trx['id'] ?>">

        <label class="font-semibold">Rating</label>
        <select name="rating" class="w-full border p-3 rounded-xl mt-1 mb-4">
            <option value="5">⭐⭐⭐⭐⭐ - Sangat Puas</option>
            <option value="4">⭐⭐⭐⭐ - Puas</option>
            <option value="3">⭐⭐⭐ - Biasa</option>
            <option value="2">⭐⭐ - Kurang</option>
            <option value="1">⭐ - Tidak Puas</option>
        </select>

        <label class="font-semibold">Review</label>
        <textarea name="review" class="w-full border p-3 rounded-xl mt-1 mb-6" rows="4"
                placeholder="Tulis ulasan kamu di sini..."></textarea>

        <button class="w-full bg-[#059669] hover:bg-[#047857] text-white font-bold py-3 rounded-xl">
            Kirim Review
        </button>
    </form>
</div>

<?php include '../../views/layouts/footer.php'; ?>
