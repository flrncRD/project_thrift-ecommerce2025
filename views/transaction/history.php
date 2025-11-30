<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<?php
include '../../config/conn.php';
include '../../views/layouts/header.php';
include '../../classes/transaksi.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login terlebih dahulu'); window.location.href='" . BASE_URL . "views/auth/login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$view = isset($_GET['view']) ? $_GET['view'] : 'pembelian';

// Query Data
if ($view == 'pembelian') {
    $sql = "SELECT t.*, p.nama_product, p.photo, u.username AS nama_penjual 
            FROM transaksi t 
            JOIN product p ON t.product_id = p.id 
            JOIN user u ON p.user_id = u.id 
            WHERE t.buyer_id = '$user_id' 
            ORDER BY t.createdAt DESC";
} else {
    $sql = "SELECT t.*, p.nama_product, p.photo, u.username AS nama_pembeli 
            FROM transaksi t 
            JOIN product p ON t.product_id = p.id 
            JOIN user u ON t.buyer_id = u.id 
            WHERE p.user_id = '$user_id'
            ORDER BY t.createdAt DESC";
}

$result = mysqli_query($conn, $sql);
?>

<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <h1 class="text-3xl font-bold text-[#1E3A8A] mb-6">Riwayat Transaksi</h1>

    <div class="flex border-b border-gray-200 mb-6">
        <a href="?view=pembelian"
            class="px-6 py-3 text-sm font-bold <?= $view == 'pembelian' ? 'border-b-4 border-[#1E3A8A] text-[#1E3A8A]' : 'text-gray-500 hover:text-[#1E3A8A]' ?>">
            🛍️ Pembelian Saya
        </a>
        <a href="?view=penjualan"
            class="px-6 py-3 text-sm font-bold <?= $view == 'penjualan' ? 'border-b-4 border-[#1E3A8A] text-[#1E3A8A]' : 'text-gray-500 hover:text-[#1E3A8A]' ?>">
            💰 Penjualan Saya
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-[#1E3A8A] text-white text-sm uppercase">
                <tr>
                    <th class="p-4">No. Transaksi</th>
                    <th class="p-4">Produk</th>
                    <th class="p-4">Total Harga</th>
                    <th class="p-4">Pembayaran</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Tanggal</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-sm text-gray-700">

                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="border-b hover:bg-gray-50 transition">

                            <!-- Nomor TRX -->
                            <td class="p-4">
                                <div class="flex items-center gap-2">

                                    <!-- Nomor Transaksi -->
                                    <span class="font-mono">#TRX-<?= $row['id'] ?></span>

                                    <!-- ICON REPORT -->
                                    <a href="report_transaction.php?id=<?= $row['id'] ?>"
                                        title="Laporkan Transaksi"
                                        class="text-red-500 hover:text-red-700 transition">
                                        <i class="fa-solid fa-flag text-lg"></i>
                                    </a>

                                </div>
                            </td>

                            <!-- Produk -->
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <img src="<?= BASE_URL ?>uploads/products/<?= $row['photo'] ?>"
                                        class="w-12 h-12 rounded object-cover border"
                                        onerror="this.src='https://placehold.co/100x100?text=No+Img'">

                                    <div>
                                        <p class="font-bold"><?= $row['nama_product'] ?></p>
                                        <p class="text-xs text-gray-500">
                                            <?= $view == 'pembelian' ? "Penjual: " . $row['nama_penjual'] : "Pembeli: " . $row['nama_pembeli'] ?>
                                        </p>
                                        <p class="text-xs text-gray-500">Qty: <?= $row['qty'] ?></p>
                                    </div>
                                </div>
                            </td>

                            <!-- Harga -->
                            <td class="p-4 font-bold text-[#059669]">
                                Rp <?= number_format($row['total_harga'] * $row['qty'], 0, ',', '.') ?>
                            </td>

                            <!-- Jenis Pembayaran -->
                            <td class="p-4"><?= strtoupper($row['jenis_pembayaran']) ?></td>

                            <!-- STATUS -->
                            <td class="p-4">
                                <?php if ($view == 'penjualan'): ?>
                                    <!-- Status Penjual -->
                                    <?= ucfirst($row['status']) ?>
                                <?php else: ?>
                                    <!-- Badge Pembeli -->
                                    <?php
                                    $status = $row['status'];
                                    $colors = [
                                        'terbayar' => 'bg-yellow-100 text-yellow-700',
                                        'packing'  => 'bg-blue-100 text-blue-700',
                                        'kirim'  => 'bg-indigo-100 text-indigo-700',
                                        'terima' => 'bg-green-100 text-green-700'
                                    ];
                                    ?>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold <?= $colors[$status] ?? 'bg-gray-100 text-gray-600' ?>">
                                        <?= $status ?>
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Tanggal -->
                            <td class="p-4 text-gray-500">
                                <?= date('d M Y', strtotime($row['createdAt'])) ?>
                            </td>

                            <!-- Aksi -->
                            <td class="p-4 text-center">

                                <?php if ($view == 'penjualan'): ?>

                                    <?php if ($row['status'] == 'terbayar'): ?>
                                        <a href="../../actions/update_status.php?id=<?= $row['id'] ?>&next=packing"
                                            class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">
                                            Packing
                                        </a>

                                    <?php elseif ($row['status'] == 'packing'): ?>
                                        <a href="../../actions/update_status.php?id=<?= $row['id'] ?>&next=kirim"
                                            class="bg-purple-600 text-white px-3 py-1 rounded text-xs hover:bg-purple-700">
                                            Dikirim
                                        </a>

                                    <?php else: ?>
                                        <span class="text-gray-400 italic">Tidak ada aksi</span>
                                    <?php endif; ?>

                                <?php else: ?>

                                    <?php if ($row['status'] == 'kirim'): ?>
                                        <a href="../../actions/update_status.php?id=<?= $row['id'] ?>&next=terima"
                                            class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700">
                                            Terima Barang
                                        </a>

                                    <?php elseif ($row['status'] == 'terima'): ?>
                                        <a href="review.php?id=<?= $row['id'] ?>"
                                            class="bg-yellow-600 text-white px-3 py-1 rounded text-xs hover:bg-yellow-700 mr-2">
                                            Review
                                        </a>
                                        <!-- 
                                        <a href="detail.php?id=<?= $row['id'] ?>"
                                            class="text-blue-700 underline">
                                            Detail
                                        </a> -->

                                    <?php else: ?>

                                        <!-- STATUS LAINNYA → HANYA DETAIL -->
                                        <a href="detail.php?id=<?= $row['id'] ?>" class="text-blue-700 underline">Detail</a>

                                    <?php endif; ?>


                                <?php endif; ?>

                            </td>

                        </tr>
                    <?php endwhile; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="7" class="p-10 text-center text-gray-400">
                            Belum ada riwayat <?= $view ?>.
                        </td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>

<?php include '../../views/layouts/footer.php'; ?>